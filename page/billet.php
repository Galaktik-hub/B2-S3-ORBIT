<?php
include('../back/back_function.php');
include('../back/cnx.php');
$infoUser = getInfo();
checkLogin();

// Récupération des billets pour l'utilisateur connecté
$userId = $_SESSION['id'];

$ticketQuery = "
    SELECT 
        o.id AS ticket_id,
        dp.name AS departure_planet,
        ap.name AS arrival_planet,
        s.name AS ship_name,
        o.distance,
        o.time_of_order,
        o.number_of_ticket,
        o.order_type,
        o.taxi
    FROM orders o
    JOIN planets dp ON o.departure_planet_id = dp.id
    JOIN planets ap ON o.arrival_planet_id = ap.id
    JOIN ships s ON o.ship_id = s.id
    WHERE o.user_id = :user_id
    ORDER BY o.time_of_order DESC
";
$stmtTickets = $pdo->prepare($ticketQuery);
$stmtTickets->execute(['user_id' => $userId]);
$tickets = $stmtTickets->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ORBIT - Billet</title>
    <link href="https://fonts.googleapis.com/css2?family=Orbitron:wght@400;700&family=Montserrat:wght@400;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../style/main.css">
    <link rel="stylesheet" href="../style/starwars.css">
    <link rel="stylesheet" href="../style/modal.css">
    <link rel="stylesheet" href="../style/form.css">
</head>

<body>

    <?php include('../include/navbar.php'); ?>

    <div class="space">
        <div class="stars"></div>
        <div class="planets"></div>
    </div>

    <main>
        <div class="containerBloc">
            <div class="bloc bloc2">
                <h1>Mes Billets</h1>
                <?php if (!empty($tickets)): ?>
                    <table class="ticket-table">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Planète de départ</th>
                                <th>Planète d'arrivée</th>
                                <th>Vaisseau</th>
                                <th>Distance (Mrd km)</th>
                                <th>Date</th>
                                <th>Nombre de Passagers</th>
                                <th>Type</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($tickets as $ticket): ?>
                                <tr>
                                    <td><?= htmlspecialchars($ticket['ticket_id']) ?></td>
                                    <td><?= htmlspecialchars($ticket['departure_planet']) ?></td>
                                    <td><?= htmlspecialchars($ticket['arrival_planet']) ?></td>
                                    <td><?= htmlspecialchars($ticket['ship_name']) ?></td>
                                    <td><?= number_format($ticket['distance'], 2, ',', ' ') ?></td>
                                    <td><?= htmlspecialchars(date('d-m-Y H:i', strtotime($ticket['time_of_order']))) ?></td>
                                    <td><?= htmlspecialchars($ticket['number_of_ticket']) ?></td>
                                    <td><?= $ticket['taxi'] == 1 ? 'Taxi' : 'Transport public' ?></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                <?php else: ?>
                    <p>Vous n'avez aucun billet enregistré.</p>
                <?php endif; ?>
            </div>
        </div>
    </main>

    <div id="modal" class="modal">
        <div class="modal-content">
            <div class="modal-header" id="modal-header"></div>
            <div class="modal-body" id="modal-body"></div>
            <button class="close-btn" id="close-modal">Fermer</button>
        </div>
    </div>

    <script src="../js/starwars.js"></script>
    <script src="../js/modal.js"></script>
</body>

</html>