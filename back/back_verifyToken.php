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
        $message = urlencode("Compte activer aves succès");
        $type = urlencode("success");
        header("Location: ../index.html?message=$message&type=$type");
        exit();
    } else {
        $message = urlencode("Erreur lors de l'activation du compte");
        $type = urlencode("error");
        header("Location: ../index.html?message=$message&type=$type");
    }
} else {
    $message = urlencode("Token invalide ou expiré");
    $type = urlencode("error");
    header("Location: ../index.html?message=$message&type=$type");
}

$stmt = null;
$pdo = null;
?>
