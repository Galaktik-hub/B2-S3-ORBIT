<?php
include('../back/back_function.php');
checkLogin();
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Galactic Traveler - Info Trafic</title>
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
            <h1>Info Trafic</h1>
        </div>

        <div class="infoTrafic">
            <div class="navbarTrafic">
                <ul>
                    <li id="navette">Navette</li>
                    <li id="vaisseau">Vaisseau</li>
                </ul>
            </div>
        </div>

    </main>

    <script src="../js/starwars.js"></script>
</body>

</html>