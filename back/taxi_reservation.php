<?php
include('back_function.php');
include('cnx.php');
checkLogin();

// Vérifier si le formulaire a été soumis
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Récupérer les données du formulaire
    $userId = $_SESSION['id'];
    $startPlanet = htmlspecialchars($_POST['startPlanet'], ENT_QUOTES, 'UTF-8');
    $endPlanet = htmlspecialchars($_POST['endPlanet'], ENT_QUOTES, 'UTF-8');
    $company = htmlspecialchars($_POST['company'], ENT_QUOTES, 'UTF-8');

    // Valider les champs obligatoires
    if (empty($startPlanet) || empty($endPlanet) || empty($company)) {
        header("Location: ../page/travel_form.php?message=Merci de remplir tout les champs.&type=error");
        exit;
    }

    // Récupérer les IDs des planètes de départ et d'arrivée
    $planetQuery = "SELECT id FROM planets WHERE name = :planet_name";
    $stmt = $pdo->prepare($planetQuery);

    $stmt->execute(['planet_name' => $startPlanet]);
    $startPlanetId = $stmt->fetchColumn();

    $stmt->execute(['planet_name' => $endPlanet]);
    $endPlanetId = $stmt->fetchColumn();

    if (!$startPlanetId || !$endPlanetId) {
        header("Location: ../page/travel_form.php?message=Planète introuvable. Veuillez vérifier les noms des planètes.&type=error");
        exit;
    }

    // Calculer la distance entre les planètes (exemple fictif : générer une distance aléatoire)
    $distance = rand(10, 1000); // Remplacez par un calcul réel si nécessaire

    // Définir l'ID du "vaisseau" basé sur la compagnie
    $shipIdMap = [
        'HyperRide 3000' => 1,
        'VaderLimo' => 2,
        'Millennium Cab' => 3,
        'Tatooine Taxi Co.' => 4,
        'JawaFly Services' => 5,
    ];

    if (!isset($shipIdMap[$company])) {
        header("Location: ../page/travel_form.php?message=Compagnie introuvable.&type=error");
        exit;
    }

    $shipId = $shipIdMap[$company];

    // Insérer la réservation dans la table `orders`
    $insertQuery = "
        INSERT INTO orders (user_id, departure_planet_id, arrival_planet_id, distance, time_of_order, ship_id, number_of_ticket, order_type, taxi)
        VALUES (:user_id, :departure_planet_id, :arrival_planet_id, :distance, NOW(), :ship_id, 1, 1, 1)
    ";
    $stmtInsert = $pdo->prepare($insertQuery);
    $stmtInsert->execute([
        'user_id' => $userId,
        'departure_planet_id' => $startPlanetId,
        'arrival_planet_id' => $endPlanetId,
        'distance' => $distance,
        'ship_id' => $shipId,
    ]);

    // Redirection après la réservation
    header("Location: ../page/cart.php?message=Reservation enregistrée.&type=success");
    exit;
}
