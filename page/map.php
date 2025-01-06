<?php
include('../back/back_function.php');
checkLogin();
include('../back/back_map.php');
include '../back/back_ships_search.php';
include '../back/cnx.php';

if (
    $_SERVER['REQUEST_METHOD'] === 'POST' &&
    isset($_POST["startPlanet"]) &&
    isset($_POST["endPlanet"]) &&
    isset($_POST['legion'])
) {

    $startPlanet = htmlspecialchars($_POST["startPlanet"], ENT_QUOTES, 'UTF-8');
    $endPlanet = htmlspecialchars($_POST["endPlanet"], ENT_QUOTES, 'UTF-8');
    $legion = htmlspecialchars($_POST['legion'], ENT_QUOTES, 'UTF-8');
    $passengers = $_POST['passengers'];
    $shipName = $_POST['shipName'];

    $startPlanetId = null;
    $endPlanetId = null;
    $shipId = null;

    $queryShipId = "SELECT id FROM ships WHERE name = :shipName LIMIT 1";
    $stmtShipId = $pdo->prepare($queryShipId);
    $stmtShipId->execute(['shipName' => $shipName]);
    $resultShip = $stmtShipId->fetch(PDO::FETCH_ASSOC);
    if ($resultShip) {
        $shipId = $resultShip['id'];
    }

    foreach ($planetDetails as $planet) {
        if (strtolower($planet['name']) === strtolower($startPlanet)) {
            $startPlanetId = $planet['id'];
        }
        if (strtolower($planet['name']) === strtolower($endPlanet)) {
            $endPlanetId = $planet['id'];
        }
    }

    if ($startPlanetId !== null && $endPlanetId !== null) {
        // Exécution du fichier .jar
        $output = [];
        $returnCode = 0;
        $exeFile = "../c/orbit.exe";
        $exePrefix = "";

        if (isOnProd()) {
            $exeFile = "../c/orbit";
            $exePrefix = "prod-";
        }

        if (isUsingExe()) {
            $startTime = microtime(true);
            putenv("LANG=fr_FR.UTF-8");
            exec("./../java/but2-sae4-orbit $exeFile $startPlanetId $endPlanetId $legion 2>&1", $output, $returnCode);
            $endTime = microtime(true);
            $executionTime = $endTime - $startTime;
            echo "<script>console.log('Temps d’exécution (exécutable natif) : " . round($executionTime, 2) . " secondes');</script>";
        } else {
            $startTime = microtime(true);
            exec("java -Dfile.encoding=UTF-8 -jar ../java/target/{$exePrefix}but2-sae4-orbit-1.0-SNAPSHOT.jar $exeFile $startPlanetId $endPlanetId $legion 2>&1", $output, $returnCode);
            $endTime = microtime(true);
            $executionTime = $endTime - $startTime;
            echo "<script>console.log('Temps d’exécution (JAR Java) : " . round($executionTime, 2) . " secondes');</script>";
        }

        if ($returnCode === 0) {
            $resultLine = implode("\n", $output);
            preg_match('/Distance:(\d+(\.\d+)?)\|Chemin:(.+)/', $resultLine, $matches);

            if (isset($matches[1], $matches[3])) {
                $distance = floatval($matches[1]);
                $routeIds = array_reverse(explode('<-', $matches[3]));

                // Conversion des IDs en noms de planètes
                foreach ($routeIds as $routeId) {
                    foreach ($planetDetails as $planet) {
                        if ((int)$planet['id'] === (int)$routeId) {
                            $routeNames[] = strtolower($planet['name']);
                            break;
                        }
                    }
                }
            } else {
                echo "<h2>Erreur :</h2>";
                echo "<pre>Impossible de parser les résultats.</pre>";
            }
        } else {
            echo "<h2>Erreur :</h2>";
            echo "<pre>" . implode("\n", $output) . "</pre>";
        }
    }
}

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
                        <label for=""><u><b>Vaisseaux:</b></u> <?php echo $shipName ?? ''; ?></label><br>
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