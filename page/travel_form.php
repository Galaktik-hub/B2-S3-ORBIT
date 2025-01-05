<?php
include('../back/back_function.php');
checkLogin();

include '../back/back_planets_search.php';
include '../back/back_ships_search.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    //    $_SESSION['endPlanet'] = $_POST["endPlanet"];
    $endPlanet = $_POST["endPlanet"];
}
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ORBIT - Accueil</title>
    <link href="https://fonts.googleapis.com/css2?family=Orbitron:wght@400;700&family=Montserrat:wght@400;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../style/main.css">
    <link rel="stylesheet" href="../style/starwars.css">
    <link rel="stylesheet" href="../style/trave_form.css">
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
        <div class="containerBloc" id="search-travel">
            <div class="bloc">
                <h1>Planifier un voyage</h1>
                <div class="blocContainer">
                    <div class="account">
                        <form action="map.php" method="post">
                            <ul>
                                <li>
                                    <div>
                                        <label for="startPlanet" class="responsiveLabel">Départ :</label>
                                    </div>
                                    <input type="text" placeholder="Départ" name="startPlanet" id="startPlanet" required>
                                </li>
                                <li>
                                    <div>
                                        <label for="endPlanet" class="responsiveLabel">Destination:</label>
                                    </div>
                                    <input type="text" placeholder="Destination" value="<?php echo $endPlanet ?? '' ?>" name="endPlanet" id="endPlanet" required>
                                </li>
                                <li>
                                    <div>
                                        <label for="departureDate" class="responsiveLabel">Date du départ :</label>
                                    </div>
                                    <input type="date" value="<?= date('Y-m-d') ?>" name="departureDate" required>
                                </li>
                                <li>
                                    <div>
                                        <label for="departureTime" class="responsiveLabel">Heure du départ :</label>
                                    </div>
                                    <input type="time" value="<?= date("H:i"); ?>" name="departureTime" required>
                                </li>
                                <li>
                                    <div>
                                        <label for="passengers" class="responsiveLabel">Nombre de voyageurs :</label>
                                    </div>
                                    <input type="number" placeholder="Nombre de voyageurs" name="passengers" required>
                                </li>
                                <li>
                                    <div>
                                        <label for="shipName" class="responsiveLabel">Vaisseaux :</label>
                                    </div>
                                    <select id="shipName" class="form-control" required>
                                        <option value="" selected disabled>Vaisseaux</option>
                                        <?php
                                        foreach ($shipNames as $shipName) {
                                            echo "<option value=\"{$shipName['name']}\">{$shipName['name']}</option>";
                                        }
                                        ?>
                                    </select>
                                </li>
                                <li>
                                    <div>
                                        <label for="startPlanet" class="responsiveLabel">Départ :</label>
                                    </div>
                                    <select id="legion" name="legion" class="form-control" required>
                                        <option value="" disabled <?php echo empty($infoUser->role) ? 'selected' : ''; ?>>Légion</option>
                                        <option value="Empire" <?php echo $infoUser->role === 'Empire' ? 'selected' : ''; ?>>Empire</option>
                                        <option value="Neutre" <?php echo $infoUser->role === 'Neutre' ? 'selected' : ''; ?>>Neutre</option>
                                        <option value="Rebelles" <?php echo $infoUser->role === 'Rebelles' ? 'selected' : ''; ?>>Rebelles</option>
                                    </select>

                                </li>
                                <li>
                                    <input type="submit" value="Chercher votre voyage">
                                </li>
                            </ul>
                        </form>
                        <p style="margin-top: 10px;">Chercher un <a href="#" id="show-taxi-reservation">taxi privé</a></p>
                    </div>
                </div>
            </div>
        </div>
        <div class="containerBloc" id="taxi-reservation" style="display:none;">
            <div class="bloc">
                <h1>Réservation de taxi</h1>
                <h4>Service de réservation de taxi pour les voyageurs seuls.</h4>
                <h4>Profitez de tarifs avantageux et compétitifs grâce aux différentes compagnies proposées pour vous ammener à destination.</h4>
                <div class="blocContainer">
                    <div class="account">
                        <form action="cart.php" method="post">
                            <ul>
                                <li>
                                    <div>
                                        <label for="startPlanet" class="responsiveLabel">Départ :</label>
                                    </div>
                                    <input type="text" placeholder="Départ" name="startPlanet" id="startPlanet2" required>
                                </li>
                                <li>
                                    <div>
                                        <label for="endPlanet" class="responsiveLabel">Destination:</label>
                                    </div>
                                    <input type="text" placeholder="Destination" value="<?php echo $endPlanet ?? '' ?>" name="endPlanet" id="endPlanet2" required>
                                </li>
                                <li>
                                    <h3>Compagnies disponibles :</h3>
                                </li>
                                <li>
                                    <div class="taxi-card">
                                        <p class="company-name">HyperRide 3000</p>
                                        <p class="quote">"Plus rapide qu’un saut en hyperespace, et avec moins de turbulences !"</p>
                                        <p class="price">3500</p>
                                        <input type="submit" name="hyperide" value="Faire appel à cette compagnie">
                                    </div>
                                </li>
                                <li>
                                    <div class="taxi-card">
                                        <p class="company-name">VaderLimo</p>
                                        <p class="quote">"Quand vous êtes avec nous, la Force est déjà là."</p>
                                        <p class="price">5000</p>
                                        <input type="submit" name="vaderlimo" value="Faire appel à cette compagnie">
                                    </div>
                                </li>
                                <li>
                                    <div class="taxi-card">
                                        <p class="company-name">Millennium Cab</p>
                                        <p class="quote">"On ne battra pas le record de Kessel, mais presque !"</p>
                                        <p class="price">2000</p>
                                        <input type="submit" name="millennium" value="Faire appel à cette compagnie">
                                    </div>
                                </li>
                                <li>
                                    <div class="taxi-card">
                                        <p class="company-name">Tatooine Taxi Co.</p>
                                        <p class="quote">"Des sables aux étoiles, on vous emmène partout."</p>
                                        <p class="price">1500</p>
                                        <input type="submit" name="tatooine" value="Faire appel à cette compagnie">
                                    </div>
                                </li>
                                <li>
                                    <div class="taxi-card">
                                        <p class="company-name">JawaFly Services</p>
                                        <p class="quote">"Utiniiii ! Et vous voilà arrivé."</p>
                                        <p class="price">1200</p>
                                        <input type="submit" name="jawafly" value="Faire appel à cette compagnie">
                                    </div>
                                </li>
                            </ul>
                        </form>
                        <p style="margin-top: 10px;">Chercher un <a href="#" id="show-search-travel">transport public</a></p>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>

    <script src="../js/starwars.js"></script>
    <script src="../js/travel_form.js"></script>
</body>

</html>