<?php
$host = '';             // Le nom de votre serveur de base de données, localhost ou URL externe
$dbname = '';           // Le nom de votre base de données
$username = '';         // Le nom d'utilisateur utilisé sur la base de données
$password = '';         // Le mot de passe utilisateur
$mail = '';             // Le nom de l'email
$password_mail = '';    // Le code secret utilisé pour se connecter au mail

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo "Erreur : " . $e->getMessage();
}
