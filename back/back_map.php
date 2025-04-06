<?php
include('../back/cnx.php');

// Initialize max/min values for bounds
$maxX = $maxY = PHP_INT_MIN;
$minX = $minY = PHP_INT_MAX;

$stmt = $pdo->prepare("SELECT * FROM planets");
$stmt->execute();
$planetDetails = $stmt->fetchAll(PDO::FETCH_ASSOC);

foreach ($planetDetails as $planet) {
    $x = ($planet['x'] + $planet['sub_grid_x']) * 6;
    $y = ($planet['y'] + $planet['sub_grid_y']) * 6;
    $maxX = max($maxX, $x);
    $maxY = max($maxY, $y);
    $minX = min($minX, $x);
    $minY = min($minY, $y);
}

$stmt = null;
$pdo = null;
?>