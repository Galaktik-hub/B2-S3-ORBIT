<?php
include('../back/back_function.php');
include('../back/cnx.php');
checkLogin();

$stmt = $pdo->prepare("
    SELECT ships.name AS ship_name, perturbation.perturbation, perturbation.message, perturbation.end_date
    FROM perturbation
    JOIN ships ON perturbation.shipid = ships.id
    WHERE perturbation.end_date >= CURDATE()
    ORDER BY perturbation.end_date ASC
");
$stmt->execute();
$perturbations = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Récupération des voyages récents
$recentTravelsQuery = "
    SELECT 
        orders.time_of_order, 
        dp.name AS departure_planet, 
        ap.name AS arrival_planet 
    FROM orders
    JOIN planets dp ON orders.departure_planet_id = dp.id
    JOIN planets ap ON orders.arrival_planet_id = ap.id
    WHERE orders.user_id = :user_id 
      AND orders.order_type = 2 
      AND orders.time_of_order >= DATE_SUB(CURDATE(), INTERVAL 1 MONTH)
    ORDER BY orders.time_of_order DESC
";
$stmtRecentTravels = $pdo->prepare($recentTravelsQuery);
$stmtRecentTravels->execute(['user_id' => $_SESSION['id']]);
$recentTravels = $stmtRecentTravels->fetchAll(PDO::FETCH_ASSOC);

// Récupération des actualités récentes
$newsQuery = "
    SELECT type, content, created_at 
    FROM news
    WHERE created_at >= DATE_SUB(CURDATE(), INTERVAL 1 MONTH)
    ORDER BY created_at DESC
";
$stmtNews = $pdo->prepare($newsQuery);
$stmtNews->execute();
$newsItems = $stmtNews->fetchAll(PDO::FETCH_ASSOC);

include '../back/back_planets_search.php';
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ORBIT - Accueil</title>
    <link href="https://fonts.googleapis.com/css2?family=Orbitron:wght@400;700&family=Montserrat:wght@400;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../style/main.css">
    <link rel="stylesheet" href="../style/modal.css">
    <link rel="stylesheet" href="../style/starwars.css">
</head>

<body>

    <?php
    include('../include/navbar.php');
    include('../include/chat-bot.html');
    ?>

    <div class="space">
        <div class="stars"></div>
        <div class="planets"></div>
    </div>

    <main>
        <form action="travel_form.php" method="post" class="topTitle">
            <div class="input-container">
                <input type="text" name="endPlanet" id="endPlanet" placeholder="Votre destination" required>
                <button type="submit" class="submit-button">
                    &#8594; <!-- Flèche droite -->
                </button>
            </div>
        </form>


        <div class="containerLink">
            <a href="info_trafic.php" class="link">
                <?php echo svg('attention'); ?>
                <p>Info Trafic</p>
            </a>
            <a href="travel_form.php" class="link">
                <?php echo svg('route-planning'); ?>
                <p>Planifier un voyage</p>
            </a>
            <a href="map.php" class="link">
                <?php echo svg('map'); ?>
                <p>Carte et Plans</p>
            </a>
        </div>

        <section class="news">
            <h2>Actualités Galactiques</h2>
            <?php if (!empty($newsItems)): ?>
            <?php foreach ($newsItems as $news): ?>
                <div class="news-item">
                    <p>(<?= htmlspecialchars(date('d-m-Y', strtotime($news['created_at']))) ?>) <strong><?= htmlspecialchars(ucfirst($news['type'])) ?> :</strong> <?= htmlspecialchars($news['content']) ?></p>
                </div>
            <?php endforeach; ?>
            <?php else: ?>
                <p>Aucune actualité récente disponible.</p>
            <?php endif; ?>
        </section>


        <section class="traffic">
            <h2>Perturbations à venir</h2>
            <?php if (count($perturbations) > 0): ?>
                <table>
                    <thead>
                        <tr>
                            <th>Vaisseau</th>
                            <th>Perturbation</th>
                            <th>Message</th>
                            <th>Date de Fin</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($perturbations as $perturbation): ?>
                            <tr>
                                <td><?= htmlspecialchars($perturbation['ship_name']) ?></td>
                                <td>
                                    <?php
                                    echo $perturbation['perturbation'] == 1
                                        ? 'Ralentit'
                                        : ($perturbation['perturbation'] == 2 ? 'Interrompu' : htmlspecialchars($perturbation['perturbation']));
                                    ?>
                                </td>
                                <td><?= htmlspecialchars($perturbation['message']) ?></td>
                                <td><?= htmlspecialchars($perturbation['end_date']) ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            <?php else: ?>
                <p>Aucune perturbation, trafic fluide.</p>
            <?php endif; ?>
        </section>

        <div class="services">
            <h2>Services Disponibles</h2>
            <div class="service-item">
                <p><strong>Transport :</strong> Réservez un taxi spatial ou planifiez votre voyage.</p>
            </div>
            <div class="service-item">
                <p><strong>Cartes :</strong> Explorez les cartes des galaxies et planètes.</p>
            </div>
            <div class="service-item">
                <p><strong>Info Trafic :</strong> Consultez les perturbations en temps réel.</p>
            </div>
        </div>

        <section class="traffic">
            <h2>Vos Voyages Récents</h2>
            <?php if (!empty($recentTravels)): ?>
                <table>
                    <thead>
                        <tr>
                            <th>Date</th>
                            <th>Planète de départ</th>
                            <th>Planète d'arrivée</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($recentTravels as $travel): ?>
                            <tr>
                                <td><?= htmlspecialchars(date('d-m-Y', strtotime($travel['time_of_order']))) ?></td>
                                <td><?= htmlspecialchars($travel['departure_planet']) ?></td>
                                <td><?= htmlspecialchars($travel['arrival_planet']) ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            <?php else: ?>
                <p>Aucun voyage récent dans les 30 derniers jours.</p>
            <?php endif; ?>
        </section>

    </main>

    <div id="modal" class="modal">
        <div class="modal-content">
            <div class="modal-header" id="modal-header"></div>
            <div class="modal-body" id="modal-body"></div>
            <button class="close-btn" id="close-modal">Fermer</button>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>

    <script src="../js/starwars.js"></script>
    <script src="../js/modal.js"></script>
    <script src="../js/travel_form.js"></script>
</body>

</html>