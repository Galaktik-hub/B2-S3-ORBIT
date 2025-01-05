<?php
include('../back/cnx.php');
include('../back/back_function.php');
checkLogin();

// Vérification que les informations nécessaires sont présentes dans le formulaire
if (
    isset($_POST["startPlanet"]) &&
    isset($_POST["endPlanet"]) &&
    isset($_POST['distance']) &&
    isset($_POST['shipId']) &&
    isset($_POST['passengers'])
) {
    $userId = $_SESSION['id'];
    $startPlanet = htmlspecialchars($_POST["startPlanet"], ENT_QUOTES, 'UTF-8');
    $endPlanet = htmlspecialchars($_POST["endPlanet"], ENT_QUOTES, 'UTF-8');
    $passengers = (int) $_POST['passengers']; // Nombre de passagers
    $ship = htmlspecialchars($_POST['shipId'], ENT_QUOTES, 'UTF-8');
    $distance = $_POST['distance'];
    
    // Insérer l'article dans la table "orders"
    $insertOrderQuery = "INSERT INTO orders (user_id, departure_planet_id, arrival_planet_id, distance, time_of_order, ship_id, number_of_ticket, order_type) 
                         VALUES (:user_id, :start_planet_id, :end_planet_id, :distance, NOW(), :ship_id, :nb_tickets, 1)";
    $stmtInsert = $pdo->prepare($insertOrderQuery);
    $stmtInsert->execute([
        'user_id' => $userId,
        'start_planet_id' => $startPlanet,
        'end_planet_id' => $endPlanet,
        'distance' => $distance,
        'ship_id' => $ship,
        'nb_tickets' => $passengers,
    ]);

    // Rediriger l'utilisateur vers la page du panier après avoir ajouté l'article
    header('Location: ../page/cart.php');
    exit;
}

header('Location: ../page/map.php');
exit;