<?php
session_start();
include 'cnx.php';

$username = $_POST['username'];
$password = $_POST['password'];

$sql = "SELECT * FROM users WHERE username = :username AND is_active = 1";
$stmt = $pdo->prepare($sql);
$stmt->bindParam(':username', $username);
$stmt->execute();
$user = $stmt->fetch(PDO::FETCH_ASSOC);

if ($user) {
    $custom_salt = $user['salt'];
    $hashed_password_input = $custom_salt . $password;

    if (password_verify($hashed_password_input, $user['password'])) {
        $_SESSION['pseudo'] = $user['pseudo'];
        $_SESSION['id'] = $user['id'];
        header("Location: ../page/index.php");
        exit();
    } else {
        header("Location: ../index.html?message=Login ou mot de passe incorect&type=error");
        exit();
    }
} else {
    header("Location: ../index.html?message=Login ou mot de passe incorect&type=error");
    exit();
}

$stmt = null;
$pdo = null;
?>
