<?php

global $pdo;
include("cnx.php");
include("back_function.php");

if ($_SERVER['REQUEST_METHOD'] === 'POST' && $_SERVER['CONTENT_TYPE'] === 'application/json') {
    $_POST = json_decode(file_get_contents('php://input'), true);

    // Récupération et validation des données
    $startPlanet = htmlspecialchars($_POST["startPlanet"], ENT_QUOTES, 'UTF-8');
    $endPlanet = htmlspecialchars($_POST["endPlanet"], ENT_QUOTES, 'UTF-8');
    $legion = htmlspecialchars($_POST['legion'], ENT_QUOTES, 'UTF-8');
    $passengers = $_POST['passengers'];
    $shipName = $_POST['shipName'];

    $startPlanetId = null;
    $endPlanetId = null;
    $shipId = null;

    // Récupération de l'ID du vaisseau
    $queryShipId = "SELECT id FROM ships WHERE name = :shipName LIMIT 1";
    $stmtShipId = $pdo->prepare($queryShipId);
    $stmtShipId->execute(['shipName' => $shipName]);
    $resultShip = $stmtShipId->fetch(PDO::FETCH_ASSOC);
    if ($resultShip) {
        $shipId = $resultShip['id'];
    }

    // Récupération des détails des planètes
    $stmt = $pdo->prepare("SELECT * FROM planets");
    $stmt->execute();
    $planetDetails = $stmt->fetchAll(PDO::FETCH_ASSOC);

    foreach ($planetDetails as $planet) {
        if (strtolower($planet['name']) === strtolower($startPlanet)) {
            $startPlanetId = $planet['id'];
        }
        if (strtolower($planet['name']) === strtolower($endPlanet)) {
            $endPlanetId = $planet['id'];
        }
    }

    if ($startPlanetId !== null && $endPlanetId !== null) {
        if (cacheUsed()) {
            // Utilisation du cache
            $stmt = $pdo->prepare("SELECT * FROM cache 
                                   WHERE departure_planet_id = :departure 
                                   AND arrival_planet_id = :arrival 
                                   AND legion = :legion 
                                   ORDER BY distance LIMIT 1");
            $stmt->execute([
                'departure' => $startPlanetId,
                'arrival' => $endPlanetId,
                'legion' => $legion,
            ]);
            $cacheResult = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($cacheResult) {
                $routeNames = explode(',', $cacheResult['routeNames']);
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
                    'distance' => $cacheResult['distance'],
                    'routeNames' => $routeNames,
                ]);
                return;
            }
        }

        // Exécution du JAR
        $output = [];
        $returnCode = 0;
        $exeFile = "../c/orbit.exe";
        $jarPrefix = "";

        if (isOnProd()) {
            $exeFile = "../c/orbit";
            $jarPrefix = "prod-";
        }

        if (isUsingGraalVMExe()) {
            putenv("LANG=fr_FR.UTF-8");
            exec("./../java/but2-sae4-orbit $exeFile $startPlanetId $endPlanetId $legion 2>&1", $output, $returnCode);
        } else {
            exec("java -Dfile.encoding=UTF-8 -jar ../java/target/{$jarPrefix}but2-sae4-orbit-1.0-SNAPSHOT.jar $exeFile $startPlanetId $endPlanetId $legion 2>&1", $output, $returnCode);
        }

        if ($returnCode === 0) {
            $resultLine = implode("\n", $output);
            preg_match('/Distance:(\d+(\.\d+)?)\|Chemin:(.+)/', $resultLine, $matches);
            if (isset($matches[1], $matches[3])) {
                $distance = floatval($matches[1]);
                $routeIds = array_reverse(explode('<-', $matches[3]));

                $routeNamesArray = [];
                foreach ($routeIds as $routeId) {
                    foreach ($planetDetails as $planet) {
                        if ((int)$planet['id'] === (int)$routeId) {
                            $routeNamesArray[] = $planet['name'];
                            break;
                        }
                    }
                }

                $routeNames = implode(',', $routeNamesArray);

                if (cacheUsed()) {
                    // Insertion dans le cache
                    $stmtInsert = $pdo->prepare("INSERT INTO cache 
                                         (id, departure_planet_id, arrival_planet_id, distance, legion, routeNames) 
                                         VALUES (NULL, :departure, :arrival, :distance, :legion, :routeNames)");
                    $stmtInsert->execute([
                        'departure' => $startPlanetId,
                        'arrival' => $endPlanetId,
                        'distance' => $distance,
                        'legion' => $legion,
                        'routeNames' => $routeNames,
                    ]);
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
                    'routeNames' => $routeNamesArray,
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
}
