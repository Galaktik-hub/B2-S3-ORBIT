<?php
include 'cnx.php';
include 'back_function.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $pseudo = $_POST['pseudo'];
    $email = $_POST['email'];
    $id = getId();

    $sql = "SELECT COUNT(*) FROM users WHERE pseudo = :pseudo";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':pseudo', $pseudo);
    $stmt->execute();
    $pseudo_count = $stmt->fetchColumn();

    if ($pseudo_count > 0) {
        header("Location: ../page/account.php?message=Pseudo Invalide&type=error");
        exit();
    }

    $sql = "UPDATE users SET pseudo = :pseudo, email = :email WHERE id = :id";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':pseudo', $pseudo);
    $stmt->bindParam(':email', $email);
    $stmt->bindParam(':id', $id);

    if ($stmt->execute()) {
        $_SESSION['pseudo'] = $pseudo;
        header("Location: ../page/account.php?message=Information Modifier !&type=success");
    } else {
        header("Location: ../page/account.php?message=Error during modification&type=error");
    }

    $stmt = null;
    $pdo = null;
}
