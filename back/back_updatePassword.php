<?php
include 'back_function.php';
include 'cnx.php';

if (!isset($_SESSION['pseudo'])) {
    header("Location: ../page/account.php?message=Vous devez être connecté&type=error");
    exit();
}

$pseudo = $_SESSION['pseudo'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $old_password = $_POST['password'];
    $new_password = $_POST['password2'];

    if (empty($old_password) || empty($new_password)) {
        header("Location: ../page/account.php?message=Tous les champs doivent être remplis&type=error");
        exit();
    }

    if (!preg_match('/^(?=.*[A-Za-z])(?=.*\d)[A-Za-z\d]{8,}$/', $new_password)) {
        header("Location: ../page/account.php?message=Le mot de passe doit contenir au moins 8 caractères, avec des lettres et des chiffres&type=error");
        exit();
    }

    try {
        $sql = "SELECT password, salt FROM users WHERE pseudo = :pseudo";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':pseudo', $pseudo);
        $stmt->execute();
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$user) {
            header("Location: ../page/account.php?message=Utilisateur introuvable&type=error");
            exit();
        }

        $stored_password = $user['password'];
        $salt = $user['salt'];
        $salted_old_password = $salt . $old_password;

        if (!password_verify($salted_old_password, $stored_password)) {
            header("Location: ../page/account.php?message=Ancien mot de passe incorrect&type=error");
            exit();
        }

        $salted_new_password = $salt . $new_password;
        $hashed_new_password = password_hash($salted_new_password, PASSWORD_ARGON2ID);

        $sql = "UPDATE users SET password = :password WHERE pseudo = :pseudo";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':password', $hashed_new_password);
        $stmt->bindParam(':pseudo', $pseudo);

        if ($stmt->execute()) {
            header("Location: ../page/account.php?message=Mot de passe mis à jour avec succès&type=success");
        } else {
            header("Location: ../page/account.php?message=Erreur lors de la mise à jour&type=error");
        }
    } catch (Exception $e) {
        header("Location: ../page/account.php?message=Erreur interne&type=error");
    }
} else {
    header("Location: ../page/account.php?message=Requête invalide&type=error");
}
