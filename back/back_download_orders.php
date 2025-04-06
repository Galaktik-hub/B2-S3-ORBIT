<?php
header('Content-Type: application/json');
include('cnx.php');
include('back_function.php');

// Requête principale pour récupérer les données des commandes
$query = "SELECT departure_planet_id, arrival_planet_id, distance, time_of_order, ship_id, number_of_ticket, order_type FROM orders";
$stmt = $pdo->prepare($query);
$stmt->execute();
$response = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Initialisation du tableau final
$items = array();

// Parcourir chaque commande pour enrichir les informations
foreach ($response as $item) {
    // Requêtes pour récupérer les noms des planètes et du vaisseau
    $departureQuery = "SELECT name FROM planets WHERE id = :departure_id";
    $arrivalQuery = "SELECT name FROM planets WHERE id = :arrival_id";
    $shipNameQuery = "SELECT name FROM ships WHERE id = :ship_id";

    $stmtDeparture = $pdo->prepare($departureQuery);
    $stmtArrival = $pdo->prepare($arrivalQuery);
    $stmtShip = $pdo->prepare($shipNameQuery);

    $stmtDeparture->execute(['departure_id' => $item['departure_planet_id']]);
    $stmtArrival->execute(['arrival_id' => $item['arrival_planet_id']]);
    $stmtShip->execute(['ship_id' => $item['ship_id']]);

    $departure = $stmtDeparture->fetch(PDO::FETCH_ASSOC);
    $arrival = $stmtArrival->fetch(PDO::FETCH_ASSOC);
    $shipName = $stmtShip->fetch(PDO::FETCH_ASSOC);

    $item['departure'] = $departure['name'];
    $item['arrival'] = $arrival['name'];
    $item['ship'] = $shipName['name'];

    $items[] = $item;
}

// Retourner les données JSON
echo json_encode($items);
