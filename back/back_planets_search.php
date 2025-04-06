<?php
include('../back/cnx.php');

// Query for select all planet names
$stmt = $pdo->prepare("SELECT name FROM planets");
$stmt->execute();
$planetNames = $stmt->fetchAll(PDO::FETCH_COLUMN);

// Passing planet names to JavaScript
echo "<script>const planetNames = " . json_encode($planetNames) . ";</script>";


$stmt = null;
$pdo = null;
?>