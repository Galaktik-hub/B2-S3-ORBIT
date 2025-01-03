<?php
include('../back/back_function.php');
checkLogin();
include('../back/back_map.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST' &&
    isset($_POST["startPlanet"]) &&
    isset($_POST["endPlanet"]) &&
    isset($_POST['legion'])) {

    $startPlanet = htmlspecialchars($_POST["startPlanet"], ENT_QUOTES, 'UTF-8');
    $endPlanet = htmlspecialchars($_POST["endPlanet"], ENT_QUOTES, 'UTF-8');
    $legion = htmlspecialchars($_POST['legion'], ENT_QUOTES, 'UTF-8');

    $startPlanetId = null;
    $endPlanetId = null;

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
        exec("java -Dfile.encoding=UTF-8 -jar ../java/target/but2-sae4-orbit-1.0-SNAPSHOT.jar ../c/orbit.exe $startPlanetId $endPlanetId $legion 2>&1", $output, $returnCode);

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
    <link rel="stylesheet" href="../style/main.css">
    <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
</head>

<body>
    <?php include '../include/navbar.php'; ?>
    <div class="container-map">
        <div id="galaxy-map"></div>
        <div class="legend" id="legend"></div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/js-md5"></script>
    <script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>
    <script>
        // Only for php variables
        var bounds = [[<?php echo $minY; ?>, <?php echo $minX; ?>], [<?php echo $maxY; ?>, <?php echo $maxX; ?>]];
        var points = <?php echo json_encode($planetDetails); ?>;
        var startPlanet = <?php echo json_encode(strtolower($startPlanet ?? '')); ?>;
        var endPlanet = <?php echo json_encode(strtolower($endPlanet ?? '')); ?>;

        var routePlanets = <?php echo json_encode($routeNames); ?>;
        console.log('Route Planets:', routePlanets);
    </script>
    <script src="../js/galaxy.js"></script>
</body>

</html>