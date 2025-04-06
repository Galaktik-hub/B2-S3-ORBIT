<?php
include '../back/cnx.php';
require '../class/shipTab.php';

$filePath = '../data/ships.json';

// Initialising the JSON response
$response = ["success" => false, "message" => ""];

try {
    $spaceShips = ShipTab::loadAllShipFromJson($filePath);

    // Deleting existing ships from the database
    $spaceShips->clearAllShipsFromDatabase();

    // Recording new data
    $spaceShips->saveAllToDatabase();

    // JSON response updated if successful
    $response["success"] = true;
    $response["message"] = "The ships have been successfully imported.";

//    $spaceShips->displayAllShips();

} catch (Exception $e) {
    // Capture errors and return an error message
    $response["success"] = false;
    $response["message"] = "Error when importing ships : " . $e->getMessage();
}

// JSON response sent to client
header('Content-Type: application/json');
echo json_encode($response);