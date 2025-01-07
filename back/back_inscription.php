<?php
include 'cnx.php';
include 'sendmail.php';
include 'back_function.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $pseudo = $_POST['pseudo'];
    $role = $_POST['role'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];

    $sql = "SELECT COUNT(*) FROM users WHERE pseudo = :pseudo";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':pseudo', $pseudo);
    $stmt->execute();
    $pseudo_count = $stmt->fetchColumn();

    if ($pseudo_count > 0) {
        $message = urlencode("Pseudo déjà utilisé");
        $type = urlencode("error");
        header("Location: ../index.html?message=$message&type=$type");
        exit();
    }

    if ($password !== $confirm_password) {
        $message = urlencode("Les mots de passes ne correspondent pas");
        $type = urlencode("error");
        header("Location: ../index.html?message=$message&type=$type");
        exit();
    }

    if (!preg_match('/^(?=.*[A-Za-z])(?=.*\d)[A-Za-z\d&]{8,}$/', $password)) {
        $message = urlencode("Le mot de passe doit comporter au moins 8 caractères et inclure des lettres et des chiffres");
        $type = urlencode("error");
        header("Location: ../index.html?message=$message&type=$type");
        exit();
    }

    if (empty($role)) {
        $role = NULL;
    }

    $default_image = '../assets/images/pp/account.png';
    $image_path = $default_image; 

    if (isset($_FILES['image']) && $_FILES['image']['error'] == UPLOAD_ERR_OK) {
        $upload_dir = '../assets/images/pp/';
        $uploaded_file = $upload_dir . basename($_FILES['image']['name']);
        $filename = $_FILES['image']['tmp_name'] . "_" . $pseudo;

        if (move_uploaded_file($_FILES['image']['tmp_name'], $uploaded_file)) {
            $image_path = $uploaded_file;
        }

        $allowed_types = ['image/jpeg', 'image/jpg', 'image/png', 'image/gif'];
        if (!in_array($_FILES['image']['type'], $allowed_types)) {
            $message = "Type de fichier non autorisé";
            header("Location: ../page/account.php?message=" . urlencode($message) . "&type=error");
            exit();
        }

        if ($_FILES['image']['size'] > 5_000_000) {
            $message = "Fichier trop lourd, le maximum autorisé est de 5 Mo.";
            header("Location: ../page/account.php?message=" . urlencode($message) . "&type=error");
            exit();
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
        $verification_link = "localhost:63342/SAE_StarWars/back/back_verifyToken.php?token=" . $token;

        if (isOnProd()) {
            $verification_link = "https://orbit.julien-synaeve.fr/back/back_verifyToken.php?token=" . $token;

            $emailAdmin = 'julien.synaeve@gmail.com';
            $subjectAdmin = "Email d'information - Un utilisateur a créé un compte";
            $messageAdmin = "
                <html>
                <head>
                <title>Information de création de compte</title>
                </head>
                <body>
                <p>Bonjour Admin,</p>
                <p>\"$pseudo\" vient tout juste de créer son compte sur le site <a href='http://orbit.julien-synaeve.fr/'>O.R.B.I.T.</a></p>
                </body>
                </html>
            ";
            email($emailAdmin, $subjectAdmin, $messageAdmin);
        }

        $subject = "Email de vérification - Activez votre compte";
        $message = "
            <html>
            <head>
            <title>Email de vérification</title>
            </head>
            <body>
            <p>Bonjour $pseudo,</p>
            <p>Merci de vous être inscrit. Veuillez cliquer sur le lien ci-dessous pour vérifier votre adresse mail et activer votre compte :</p>
            <a href='$verification_link'>Vérifiez mon mail</a>
            <p>Ce lien expirera dans 2 heures et 15 minutes.</p>
            </body>
            </html>
        ";
        email($email, $subject, $message);

        $message = urlencode("Inscription terminé, consultez vos mails");
        $type = urlencode("success");
        header("Location: ../index.html?message=$message&type=$type");
    } else {
        $message = urlencode("Erreur lors de l'inscription");
        $type = urlencode("error");
        header("Location: ../index.html?message=$message&type=$type");
    }

    $stmt = null;
    $pdo = null;
}
