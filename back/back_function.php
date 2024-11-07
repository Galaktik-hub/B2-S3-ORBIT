<?php
session_start();

function checkLogin() {
    if (!isset($_SESSION['pseudo'])) {
        header("Location: ../index.html?message=You must be logged in to access this page&type=error");
        exit();
    }
}

function getEmail() {
    include 'cnx.php';
    
    $sql = "SELECT email FROM users WHERE pseudo = :pseudo LIMIT 1";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':pseudo', $_SESSION['pseudo'], PDO::PARAM_INT);
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    
    if ($result) {
        return $result['pseudo'];
    } else {
        return null;
    }
}

function getInfo() {
    include 'cnx.php';
    
    $sql = "SELECT * FROM users WHERE pseudo = :pseudo LIMIT 1";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':pseudo', $_SESSION['pseudo'], PDO::PARAM_INT);
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    
    if ($result) {
        return $result;
    } else {
        return null;
    }
}

function getId() {
    include 'cnx.php';
    
    $sql = "SELECT id FROM users WHERE pseudo = :pseudo LIMIT 1";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':pseudo', $_SESSION['pseudo'], PDO::PARAM_INT);
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    
    if ($result) {
        return $result['id'];
    } else {
        return null;
    }
}

?>
