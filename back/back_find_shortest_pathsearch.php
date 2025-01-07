<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Récupération et validation des données
    $startPlanet = htmlspecialchars($_POST["startPlanet"], ENT_QUOTES, 'UTF-8');
    $endPlanet = htmlspecialchars($_POST["endPlanet"], ENT_QUOTES, 'UTF-8');
    $legion = htmlspecialchars($_POST['legion'], ENT_QUOTES, 'UTF-8');
    $passengers = $_POST['passengers'];
    $shipName = $_POST['shipName'];

    // Logique pour calculer l'itinéraire
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

                $routeNames = [];
                foreach ($routeIds as $routeId) {
                    foreach ($planetDetails as $planet) {
                        if ((int)$planet['id'] === (int)$routeId) {
                            $routeNames[] = $planet['name'];
                            break;
                        }
                    }
                }

                echo json_encode([
                    'success' => true,
                    'startPlanetId' => $startPlanetId,
                    'endPlanetId' => $endPlanetId,
                    'shipId' => $shipId,
                    'startPlanet' => $startPlanet,
                    'endPlanet' => $endPlanet,
                    'ship' => $shipName,
                    'legion' => $legion,
                    'passengers' => $passengers,
                    'distance' => $distance,
                    'routeNames' => $routeNames,
                ]);
            } else {
                echo json_encode(['success' => false, 'message' => 'Erreur de parsing des résultats.']);
            }
        } else {
            echo json_encode(['success' => false, 'message' => 'Erreur d\'exécution.', 'output' => $output]);
        }
    } else {
        echo json_encode(['success' => false, 'message' => 'Planètes invalides.']);
    }
    exit;
}