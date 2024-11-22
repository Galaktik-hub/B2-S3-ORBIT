<?php
include('../back/back_function.php');
checkLogin();
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Carte Galactique Étoilée</title>
    <link rel="stylesheet" href="../style/map.css">
    <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
</head>

<body>
    <?php include '../include/navbar.php'; ?>
    <div id="galaxy-map"></div>

    <script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>
    <script src="../js/galaxy.js"></script>
</body>

</html>