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
        header("Location: ../index.html?message=Votre compte a bien été activé&type=success");
        exit();
    } else {
        header("Location: ../index.html?message=Erreur lors de l'activation du compte&type=error");
    }
} else {
    header("Location: ../index.html?message=Token invalide ou expiré&type=error");
}

$stmt = null;
$pdo = null;
?>
