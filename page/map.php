<?php
include('../back/back_function.php');
checkLogin();
include('../back/back_map.php');
include('../back/cnx.php');

// Récupération des résultats via GET
$distance = isset($_GET['distance']) ? floatval($_GET['distance']) : null;
$startPlanetId = isset($_GET['startPlanetId']) ? intval($_GET['startPlanetId']) : null;
$endPlanetId = isset($_GET['endPlanetId']) ? intval($_GET['endPlanetId']) : null;
$shipId = isset($_GET['shipId']) ? intval($_GET['shipId']) : null;
$startPlanet = isset($_GET['startPlanet']) ? htmlspecialchars($_GET['startPlanet']) : null;
$endPlanet = isset($_GET['endPlanet']) ? htmlspecialchars($_GET['endPlanet']) : null;
$ship = isset($_GET['ship']) ? htmlspecialchars($_GET['ship']) : null;
$legion = isset($_GET['legion']) ? htmlspecialchars($_GET['legion']) : null;
$passengers = isset($_GET['passengers']) ? intval($_GET['passengers']) : null;
$routeNames = isset($_GET['routeNames']) ? json_decode($_GET['routeNames'], true) : null;
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Carte Galactique Étoilée</title>
    <link href="https://fonts.googleapis.com/css2?family=Orbitron:wght@400;700&family=Montserrat:wght@400;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../style/map.css">
    <link rel="stylesheet" href="../style/starwars.css">
    <link rel="stylesheet" href="../style/main.css">
    <link rel="stylesheet" href="../style/form.css">
    <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
</head>

<body>
    <?php include '../include/navbar.php'; ?>

    <div class="space">
        <div class="stars"></div>
        <div class="planets"></div>
    </div>

    <div class="container-map">
        <div class="legend">
            <?php if (isset($startPlanet) && isset($endPlanet)) { ?>
                <h4><u>Récapilutatif de la réservation:</u></h4><br>
                    <form action="../back/back_add_order.php" method="POST">
                        <label for=""><u><b>Départ:</b></u> <?php echo $startPlanet ?? ''; ?></label><br>
                        <input type="hidden" value="<?php echo $startPlanetId ?? ''; ?>" name="startPlanet" id="startPlanet" readonly>
                        <label for=""><u><b>Arrivée:</b></u> <?php echo $endPlanet ?? ''; ?></label><br>
                        <input type="hidden" value="<?php echo $endPlanetId ?? ''; ?>" name="endPlanet" id="endPlanet" readonly>
                        <label for=""><u><b>Légion:</b></u> <?php echo $legion ?? ''; ?></label><br>
                        <input type="hidden" value="<?php echo $legion ?? ''; ?>" name="legion" id="legion" readonly>
                        <label for=""><u><b>Distance:</b></u> <?php echo $distance ?? ''; ?> Mrd KM</label><br>
                        <input type="hidden" value="<?php echo $distance ?? ''; ?>" name="distance" id="distance" readonly>
                        <label for=""><u><b>Nombre de Voyageur:</b></u> <?php echo $passengers ?? ''; ?></label><br>
                        <input type="hidden" value="<?php echo $passengers ?? ''; ?>" name="passengers" id="passengers" readonly>
                        <label for=""><u><b>Vaisseaux:</b></u> <?php echo $ship ?? ''; ?></label><br>
                        <input type="hidden" value="<?php echo $shipId ?? ''; ?>" name="shipId" id="shipId" readonly>
                        <input type="submit" value="Ajouter au Panier" class="btn">
                    </form>
                    <hr>
                    <a href="travel_form.php" class="btn btn2">Modifier la résevation</a>
                <?php } else { ?>
                    <a href="travel_form.php" class="btn">Réserver un Voyage</a>
                <?php } ?>

        </div>

        <div id="galaxy-map"></div>
        <div class="legend" id="legend"></div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/js-md5"></script>
    <script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>
    <script>
        // Only for php variables
        var bounds = [
            [<?php echo $minY; ?>, <?php echo $minX; ?>],
            [<?php echo $maxY; ?>, <?php echo $maxX; ?>]
        ];
        var points = <?php echo json_encode($planetDetails); ?>;
        var startPlanet = <?php echo json_encode(strtolower($startPlanet ?? '')); ?>;
        var endPlanet = <?php echo json_encode(strtolower($endPlanet ?? '')); ?>;

        var routePlanets = <?php echo json_encode($routeNames ?? ''); ?>;
    </script>
    <script src="../js/starwars.js"></script>
    <script src="../js/galaxy.js"></script>
</body>

</html>