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
            <div class="news-item">
                <p><strong>Alerte :</strong> Une tempête ionique prévue sur Naboo cette semaine.</p>
            </div>
            <div class="news-item">
                <p><strong>Découverte :</strong> Une nouvelle route hyperspatiale sécurisée entre Tatooine et Coruscant.</p>
            </div>
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

        <div class="recent-travels">
            <h2>Vos Voyages Récents</h2>
            <ul>
                <li><strong>Planète :</strong> Tatooine → Coruscant | <strong>Date :</strong> 2025-01-01</li>
                <li><strong>Planète :</strong> Naboo → Hoth | <strong>Date :</strong> 2024-12-25</li>
            </ul>
        </div>
    </main>

    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>

    <script src="../js/starwars.js"></script>
    <script src="../js/travel_form.js"></script>
</body>

</html>