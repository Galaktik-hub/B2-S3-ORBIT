<?php
include('../back/back_function.php');
checkLogin();
include('../back/back_map.php');
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Carte Galactique Étoilée</title>
    <link href="https://fonts.googleapis.com/css2?family=Orbitron:wght@400;700&family=Montserrat:wght@400;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../style/map.css">
    <link rel="stylesheet" href="../style/main.css">
    <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
</head>

<body>
    <?php include '../include/navbar.php'; ?>
    <div class="container-map">
        <div id="galaxy-map"></div>
        <div class="legend" id="legend"></div>
    </div>

    <script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>
    <script>
        // Only for php variables
        var bounds = [[<?php echo $minY; ?>, <?php echo $minX; ?>], [<?php echo $maxY; ?>, <?php echo $maxX; ?>]];
        var points = <?php echo json_encode($planetDetails); ?>;
    </script>
    <script src="../js/galaxy.js"></script>
</body>

</html>