<?php
include('../back/back_function.php');
checkLogin();
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Galactic Traveler - Accueil</title>
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
            <input type="text" placeholder="Choisir son itinéraire">
        </div>

        <div class="containerLink">
            <a href="" class="link">
                <?php echo svg('attention'); ?>
                <p>Info Trafic</p>
            </a>
            <a href="" class="link">
                <?php echo svg('clock'); ?>
                <p>Horraire des Arrêts</p>
            </a>
            <a href="map.php" class="link">
                <?php echo svg('map'); ?>
                <p>Carte et Plans</p>
            </a>
        </div>
    </main>

    <script src="../js/starwars.js"></script>
</body>

</html>