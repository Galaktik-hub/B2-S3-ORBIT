<?php
include 'cnx.php';
include 'back_function.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $username = $_POST['username'];
    $pseudo = $_POST['pseudo'];
    $email = $_POST['email'];
    $id = getId();

    $sql = "UPDATE users SET username = :username, pseudo = :pseudo, email = :email WHERE id = :id";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':username', $username);
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
