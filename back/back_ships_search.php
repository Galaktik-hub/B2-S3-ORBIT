<?php
include('../back/cnx.php');

// Query for select all ships names
$stmt = $pdo->prepare("SELECT name FROM ships");
$stmt->execute();
$shipNames = $stmt->fetchAll(PDO::FETCH_ASSOC);


$stmt = null;
$pdo = null;
?>