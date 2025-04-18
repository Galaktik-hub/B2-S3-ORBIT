<?php
session_start();
include 'cnx.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $pseudo = $_POST['pseudo'];
    $password = $_POST['password'];

    $sql = "SELECT * FROM users WHERE pseudo = :pseudo AND is_active = 1";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':pseudo', $pseudo);
    $stmt->execute();
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user) {
        $custom_salt = $user['salt'];
        $hashed_password_input = $custom_salt . $password;

        if (password_verify($hashed_password_input, $user['password'])) {
            $_SESSION['pseudo'] = $user['pseudo'];
            $_SESSION['email'] = $user['email'];
            $_SESSION['id'] = $user['id'];
            $_SESSION['role'] = $user['role'];
            header("Location: ../page/index.php");
            exit();
        } else {
            $message = urlencode("Login ou mot de passe incorect");
            $type = urlencode("error");
            header("Location: ../index.html?message=$message&type=$type");
            exit();
        }
    } else {
        $message = urlencode("Login ou mot de passe incorect");
        $type = urlencode("error");
        header("Location: ../index.html?message=$message&type=$type");
        exit();
    }

    $stmt = null;
    $pdo = null;
}
