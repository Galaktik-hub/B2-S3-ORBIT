<?php
include 'back_function.php';
include 'cnx.php';


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $old_password = $_POST['password'];
    $new_password = $_POST['password2'];
    $pseudo = $_SESSION['pseudo'];

    if (empty($old_password) || empty($new_password)) {
        $message = urlencode("Tous les champs doivent être remplis");
        $type = urlencode("error");
        header("Location: ../page/account.php?message=$message&type=$type");
        exit();
    }

    if (!preg_match('/^(?=.*[A-Za-z])(?=.*\d)[A-Za-z\d]{8,}$/', $new_password)) {
        $message = urlencode("Le mot de passe doit contenir au moins 8 caractères, avec des lettres et des chiffres");
        $type = urlencode("error");
        header("Location: ../page/account.php?message=$message&type=$type");
        exit();
    }

    try {
        $sql = "SELECT password, salt FROM users WHERE pseudo = :pseudo";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':pseudo', $pseudo);
        $stmt->execute();
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$user) {
            $message = urlencode("Utilisateur introuvable");
            $type = urlencode("error");
            header("Location: ../page/account.php?message=$message&type=$type");
            exit();
        }

        $stored_password = $user['password'];
        $salt = $user['salt'];
        $salted_old_password = $salt . $old_password;

        if (!password_verify($salted_old_password, $stored_password)) {
            $message = urlencode("Ancien mot de passe incorrect");
            $type = urlencode("error");
            header("Location: ../page/account.php?message=$message&type=$type");
            exit();
        }

        $salted_new_password = $salt . $new_password;
        $hashed_new_password = password_hash($salted_new_password, PASSWORD_ARGON2ID);

        $sql = "UPDATE users SET password = :password WHERE pseudo = :pseudo";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':password', $hashed_new_password);
        $stmt->bindParam(':pseudo', $pseudo);

        if ($stmt->execute()) {
            $message = urlencode("Mot de passe mis à jour avec succès");
            $type = urlencode("success");
            header("Location: ../page/account.php?message=$message&type=$type");
        } else {
            $message = urlencode("Erreur lors de la mise à jour");
            $type = urlencode("error");
            header("Location: ../page/account.php?message=$message&type=$type");
        }
    } catch (Exception $e) {
        $message = urlencode("Erreur interne");
        $type = urlencode("error");
        header("Location: ../page/account.php?message=$message&type=$type");
    }
} else {
    $message = urlencode("Requête invalide");
    $type = urlencode("error");
    header("Location: ../page/account.php?message=$message&type=$type");
}
