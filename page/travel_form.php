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
        <div class="containerBloc">
            <div class="bloc">
                <!-- Changer le nom des sections/balises car c'est un simple copier/coller de account.php -->
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
                                        <option value="" selected disabled>Any</option>
                                        <?php
                                        foreach ($shipNames as $shipName) {
                                            echo "<option value=\"{$shipName['name']}\">{$shipName['name']}</option>";
                                        }
                                        ?>
                                    </select>
                                </li>
                                <li>
                                    <input type="submit" value="Chercher votre voyage">
                                </li>
                            </ul>
                        </form>
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