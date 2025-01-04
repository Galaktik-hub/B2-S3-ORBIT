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
        $message = urlencode("Pseudo Invalide");
        $type = urlencode("error");
        header("Location: ../page/account.php?message=$message&type=$type");
        exit();
    }

    $sql = "UPDATE users SET pseudo = :pseudo, email = :email WHERE id = :id";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':pseudo', $pseudo);
    $stmt->bindParam(':email', $email);
    $stmt->bindParam(':id', $id);

    if ($stmt->execute()) {
        $_SESSION['pseudo'] = $pseudo;
        $message = urlencode("Information modifiées avec succès");
        $type = urlencode("success");
        header("Location: ../page/account.php?message=$message&type=$type");
    } else {
        $message = urlencode("Erreur durant la modification");
        $type = urlencode("error");
        header("Location: ../page/account.php?message=$message&type=$type");
    }

    $stmt = null;
    $pdo = null;
}
