<?php
include('../back/back_function.php');
checkLogin();

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
            <a href="horaire.php" class="link">
                <?php echo svg('clock'); ?>
                <p>Horaire des Arrêts</p>
            </a>
            <a href="map.php" class="link">
                <?php echo svg('map'); ?>
                <p>Carte et Plans</p>
            </a>
        </div>
    </main>

    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>

    <script src="../js/starwars.js"></script>
    <script src="../js/travel_form.js"></script>
</body>

</html>