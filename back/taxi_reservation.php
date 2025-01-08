<?php
include('back_function.php');
include('sendmail.php');
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

    $email = $_SESSION['email'];
    $subject = "Confirmation de votre réservation de taxi";
    $message = "
            <html>
            <head>
                <title>Confirmation de votre réservation de taxi</title>
                <style>
                    body {
                        font-family: 'Orbitron', sans-serif;
                        color: #ffffff;
                        background-color: #000000;
                        margin: 0;
                        padding: 20px;
                    }

                    a {
                        font-family: 'Orbitron', sans-serif;
                        color: #00cc99;
                        text-decoration: none;
                    }

                    a:hover {
                        text-decoration: underline;
                    }

                    p {
                        font-family: 'Orbitron', sans-serif;
                        font-size: 1.1rem;
                        line-height: 1.6;
                        color: #ffffff;
                    }

                    .email-container {
                        background-color: rgba(26, 26, 26, 0.85);
                        padding: 20px;
                        border-radius: 10px;
                        box-shadow: 0 0 20px rgba(0, 255, 204, 0.5);
                        margin: 20px auto;
                        max-width: 600px;
                    }

                    .header {
                        font-size: 1.5rem;
                        font-weight: bold;
                        color: #00cc99;
                        text-align: center;
                        margin-bottom: 20px;
                    }

                    .content {
                        text-align: left;
                    }

                    .footer {
                        margin-top: 20px;
                        font-size: 0.9rem;
                        color: #aaaaaa;
                        text-align: center;
                    }
                </style>
            </head>
            <body>
                <div class='email-container'>
                    <div class='header'>
                        Confirmation de votre réservation de taxi
                    </div>
                    <div class='content'>
                        <p>Bonjour,</p>
                        <p>Votre réservation de taxi a été enregistrée avec succès. Voici les détails de votre réservation :</p>
                        <ul>
                            <li><strong>Planète de départ :</strong> {$startPlanet}</li>
                            <li><strong>Planète d'arrivée :</strong> {$endPlanet}</li>
                            <li><strong>Compagnie :</strong> {$company}</li>
                            <li><strong>Distance estimée :</strong> {$distance} milliards de km</li>
                            <li><strong>Date de réservation :</strong> " . date('d-m-Y H:i') . "</li>
                        </ul>
                        <p>Nous vous remercions pour votre confiance et vous souhaitons un agréable voyage.</p>
                        <p>Si vous avez des questions ou des modifications à effectuer sur votre réservation, n'hésitez pas à nous contacter.</p>
                    </div>
                    <div class='footer'>
                        &copy; 2025 ORBIT. Tous droits réservés.
                    </div>
                </div>
            </body>
            </html>
            ";
    email($email, $subject, $message);

    // Redirection après la réservation
    header("Location: ../page/cart.php?message=Reservation enregistrée.&type=success");
    exit;
}
