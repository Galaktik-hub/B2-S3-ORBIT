<?php
include '../back/cnx.php';
require '../class/planetTab.php';

$filePath = '../data/planets_details.json';

// Initialising the JSON response
$response = ["success" => false, "message" => ""];

try {
    $planets = PlanetTab::loadAllPlanetFromJson($filePath);

    // Deleting existing planets from the database
    $planets->clearAllPlanetsFromDatabase();

    // Recording new data
    $planets->saveAllToDatabase();

    // JSON response updated if successful
    $response["success"] = true;
    $response["message"] = "The planets have been successfully imported.";

//    $planets->displayAllPlanets();

} catch (Exception $e) {
    // Capture errors and return an error message
    $response["success"] = false;
    $response["message"] = "Error when importing planets : " . $e->getMessage();
}

// JSON response sent to client
header('Content-Type: application/json');
echo json_encode($response);
