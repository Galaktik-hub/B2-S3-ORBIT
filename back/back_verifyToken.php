<?php
include 'cnx.php';

$token = $_GET['token'];

$sql = "SELECT * FROM users WHERE token = :token AND token_expiry > NOW() AND is_active = 0";
$stmt = $pdo->prepare($sql);
$stmt->bindParam(':token', $token);
$stmt->execute();
$user = $stmt->fetch(PDO::FETCH_ASSOC);

if ($user) {
    $update_sql = "UPDATE users SET is_active = 1, token = NULL, token_expiry = NULL WHERE id = :id";
    $update_stmt = $pdo->prepare($update_sql);
    $update_stmt->bindParam(':id', $user['id']);
    
    if ($update_stmt->execute()) {
        header("Location: ../index.html?message=Account successfully activated&type=success");
        exit();
    } else {
        header("Location: ../index.html?message=Error activating account&type=error");
    }
} else {
    header("Location: ../index.html?message=Invalid or expired token&type=error");
}

$stmt = null;
$pdo = null;
?>
