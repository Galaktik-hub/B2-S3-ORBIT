<?php
include 'cnx.php';
include 'sendmail.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $pseudo = $_POST['pseudo'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];

    $sql = "SELECT COUNT(*) FROM users WHERE pseudo = :pseudo";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':pseudo', $pseudo);
    $stmt->execute();
    $pseudo_count = $stmt->fetchColumn();

    if ($pseudo_count > 0) {
        header("Location: ../index.html?message=Pseudo already exists&type=error");
        exit();
    }

    if ($password !== $confirm_password) {
        header("Location: ../index.html?message=Passwords do not match&type=error");
        exit();
    }

    if (!preg_match('/^(?=.*[A-Za-z])(?=.*\d)[A-Za-z\d]{8,}$/', $password)) {
        header("Location: ../index.html?message=Le mot de passe doit comporter au moins 8 caractères et inclure des lettres et des chiffres&type=error");
        exit();
    }

    $default_image = '../images/pp/account.png';
    $image_path = $default_image; 

    if (isset($_FILES['image']) && $_FILES['image']['error'] == UPLOAD_ERR_OK) {
        $upload_dir = '../assets/images/pp/';
        $uploaded_file = $upload_dir . basename($_FILES['image']['name']);
        $filename = $_FILES['image']['tmp_name'] . "_" . $pseudo;

        if (move_uploaded_file($_FILES['image']['tmp_name'], $uploaded_file)) {
            $image_path = $uploaded_file;
        }
    }

    $custom_salt = bin2hex(random_bytes(32));
    $salted_password = $custom_salt . $password;
    $hashed_password = password_hash($salted_password, PASSWORD_ARGON2ID);
    $token = bin2hex(random_bytes(32));
    $token_expiry = date("Y-m-d H:i:s", strtotime("+2 hours +15 minutes"));
    $is_active = 0;

    $sql = "INSERT INTO users (pseudo, role, pp, email, password, salt, token, token_expiry, is_active) 
            VALUES (:pseudo, :role, :pp, :email, :password, :salt, :token, :token_expiry, :is_active)";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':pseudo', $pseudo);
    $stmt->bindParam(':email', $email);
    $stmt->bindParam(':password', $hashed_password);
    $stmt->bindParam(':salt', $custom_salt);
    $stmt->bindParam(':token', $token);
    $stmt->bindParam(':token_expiry', $token_expiry);
    $stmt->bindParam(':is_active', $is_active);
    $stmt->bindParam(':role', $role);
    $stmt->bindParam(':pp', $image_path);

    if ($stmt->execute()) {
        $verification_link = "localhost/sae-starwars/back/back_verifyToken.php?token=" . $token;
        $subject = "Email Verification - Activate your account";
        $message = "
        <html>
        <head>
        <title>Email Verification</title>
        </head>
        <body>
        <p>Hello $pseudo,</p>
        <p>Thank you for registering. Please click the link below to verify your email and activate your account:</p>
        <a href='$verification_link'>Verify Email</a>
        <p>This link will expire in 2 hours and 15 minutes.</p>
        </body>
        </html>
    ";
        email($email, $subject, $message);
        header("Location: ../index.html?message=Inscription terminé, consultez vos mails&type=success");
    } else {
        header("Location: ../index.html?message=Erreur lors de l'inscription&type=error");
    }

    $stmt = null;
    $pdo = null;
}
