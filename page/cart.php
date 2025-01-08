<?php
include('../back/back_function.php');
include('../back/cnx.php');
include('../back/back_calculate_price.php');
checkLogin();

// Récupération du panier depuis la base de données
$userId = $_SESSION['id']; // Assurez-vous d'avoir l'ID utilisateur dans la session
$cartQuery = "SELECT o.*, 
       d.name AS departure_name, 
       a.name AS arrival_name, 
       s.name AS ship_name, 
       s.speed_kmh 
FROM orders o
JOIN planets d ON o.departure_planet_id = d.id
JOIN planets a ON o.arrival_planet_id = a.id
JOIN ships s ON o.ship_id = s.id
WHERE o.user_id = :user_id
  AND o.order_type = 1;
";
$stmt = $pdo->prepare($cartQuery);
$stmt->execute(['user_id' => $userId]);
$cartItems = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Calcul du total et ajout des informations supplémentaires
$total = 0;
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ORBIT - Panier</title>
    <link href="https://fonts.googleapis.com/css2?family=Orbitron:wght@400;700&family=Montserrat:wght@400;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../style/main.css">
    <link rel="stylesheet" href="../style/starwars.css">
</head>

<body>

    <?php
    include('../include/navbar.php');
    ?>

    <div class="space">
        <div class="stars"></div>
        <div class="planets"></div>
    </div>

    <main>
        <div class="topTitle">
            <h1>Votre Panier</h1>
        </div>

        <div class="containerBloc bloc4">
            <?php if (isset($_SESSION['message'])) : ?>
                <p><?php echo $_SESSION['message']; ?></p>
            <?php endif; ?>
            <?php if (empty($cartItems)): ?>
                <p>Votre panier est vide. Ajoutez des articles pour passer à la commande.</p>
            <?php else: ?>
                <div class="bloc">
                    <?php foreach ($cartItems as $item):
                        // Récupération des informations du vaisseau
                        $speedQuery = "SELECT speed_kmh FROM ships WHERE id = :ship_id";
                        $stmt = $pdo->prepare($speedQuery);
                        $stmt->execute(['ship_id' => $item['ship_id']]);
                        $speed = $stmt->fetch(PDO::FETCH_ASSOC);

                        // Récupération des informations des planètes
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

                        // Calcul du prix et temps de trajet
                        $item['price'] = calculatePrice($item['distance'], $speed['speed_kmh']);
                        $total += $item['price'] * $item['number_of_ticket'];

                        // Calcul du temps estimé (distance en milliards de km, vitesse en km/h)
                        $distanceInKm = $item['distance'] * 1e9; // Conversion de la distance en milliards de km vers km
                        $timeEstimated = $distanceInKm / $speed['speed_kmh']; // Temps en heures

                        // Conversion du temps en jours, heures et minutes
                        $timeEstimatedDays = floor($timeEstimated / 24); // Nombre de jours (temps total divisé par 24)
                        $timeRemainingHours = $timeEstimated - ($timeEstimatedDays * 24); // Temps restant après avoir retiré les jours
                        $timeEstimatedHours = floor($timeRemainingHours); // Nombre d'heures
                        $timeEstimatedMinutes = round(($timeRemainingHours - $timeEstimatedHours) * 60); // Nombre de minutes restantes

                        $routeQuery = "SELECT planet_name, route_order FROM order_routes WHERE order_id = :order_id ORDER BY route_order ASC";
                        $stmtRoute = $pdo->prepare($routeQuery);
                        $stmtRoute->execute(['order_id' => $item['id']]);
                        $routes = $stmtRoute->fetchAll(PDO::FETCH_ASSOC);

                    ?>
                        <div class="cart-item">
                            <div class="cart-item-info">
                                <div>
                                    <span class="cart-item-label">Planète de départ :</span>
                                    <span class="cart-item-departure"><?= htmlspecialchars($item['departure']) ?></span>
                                </div>
                                <div>
                                    <span class="cart-item-label">Planète d'arrivée :</span>
                                    <span class="cart-item-arrival"><?= htmlspecialchars($item['arrival']) ?></span>
                                </div>
                                <div>
                                    <span class="cart-item-label">Vaisseau :</span>
                                    <span class="cart-item-ship"><?= htmlspecialchars($item['ship']) ?></span>
                                </div>
                                <div>
                                    <span class="cart-item-label">Distance :</span>
                                    <span class="cart-item-distance"><?= number_format($item['distance'], 2, ',', ' ') ?> milliards de km</span>
                                </div>
                                <div>
                                    <span class="cart-item-label">Temps estimé :</span>
                                    <span class="cart-item-time"><?= $timeEstimatedDays ?>j <?= $timeEstimatedHours ?>h <?= $timeEstimatedMinutes ?>min</span>
                                </div>

                                <div>
                                    <span class="cart-item-label">Prix unitaire :</span>
                                    <span class="cart-item-price"><?= number_format($item['price'], 2, ',', ' ') ?> €</span>
                                </div>

                                <div>
                                    <span class="cart-item-label">Prix total :</span>
                                    <span class="cart-item-total"><?= number_format($item['price'] * $item['number_of_ticket'], 2, ',', ' ') ?> €</span>
                                </div>

                                <div>
                                    <span class="cart-item-label">Planètes traversées :</span>
                                    <ul>
                                        <?php foreach ($routes as $route): ?>
                                            <li>Étape <?= $route['route_order'] ?> : <?= htmlspecialchars($route['planet_name']) ?></li>
                                        <?php endforeach; ?>
                                    </ul>
                                </div>

                            </div>
                            <br>
                            <div class="cart-item-quantity">
                                <form action="../back/update_cart.php" method="post">
                                    <span class="cart-item-label">Quantité :</span>
                                    <input type="hidden" name="product_id" value="<?= $item['id'] ?>">
                                    <input type="number" name="quantity" value="<?= $item['number_of_ticket'] ?>" min="1" max="99">
                                    <button type="submit" name="update" class="btn">Mettre à jour</button>
                                </form>
                            </div>
                            <div class="cart-item-action">
                                <form action="../back/update_cart.php" method="post">
                                    <input type="hidden" name="product_id" value="<?= $item['id'] ?>">
                                    <button type="submit" name="delete" class="btn">Supprimer</button>
                                </form>
                            </div>
                        </div>

                    <?php endforeach; ?>

                    <div class="cart-total">
                        <h3>Total: <?= number_format($total, 2, ',', ' ') ?> €</h3>
                        <form action="../back/back_checkout.php" method="post">
                            <input type="hidden" name="item_ids" value="<?= implode(',', array_column($cartItems, 'id')) ?>">
                            <button type="submit" class="btn">Passer à la commande</button>
                        </form>
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </main>

    <script src="../js/starwars.js"></script>
</body>

</html>