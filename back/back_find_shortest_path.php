<?php
global $pdo;
include("cnx.php");
include ("back_function.php");

if ($_SERVER['REQUEST_METHOD'] === 'POST' && $_SERVER['CONTENT_TYPE'] === 'application/json') {
    $_POST = json_decode(file_get_contents('php://input'), true);

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
            putenv("LANG=fr_FR.UTF-8");
            exec("./../java/but2-sae4-orbit $exeFile $startPlanetId $endPlanetId $legion 2>&1", $output, $returnCode);
        } else {
            exec("java -Dfile.encoding=UTF-8 -jar ../java/target/{$exePrefix}but2-sae4-orbit-1.0-SNAPSHOT.jar $exeFile $startPlanetId $endPlanetId $legion 2>&1", $output, $returnCode);
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