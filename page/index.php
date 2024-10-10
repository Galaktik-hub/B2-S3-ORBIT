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
</head>

<body>

    <nav class="navbar">
        <div class="container">
            <div class="logo">
                <a href="index.php">Galactic Traveler</a>
            </div>
            <ul class="nav-links">
                <li><a href="../back/logout.php">Déconnexion</a></li>
            </ul>
        </div>
    </nav>

    <div class="space">
        <div class="stars"></div>
        <div class="planets"></div>
    </div>

    <header>
        <div class="container">
            <h1>Bienvenue sur le Galactic Traveler</h1>
            <p>Explorez l'univers, connectez-vous avec d'autres voyageurs et découvrez de nouveaux mondes !</p>
        </div>
    </header>

    <main>
        <section class="about" id="about">
            <h2>À propos de la galaxie</h2>
            <p>Galactic Traveler est votre passerelle vers un monde d'exploration. Découvrez des planètes, des lunes et des systèmes stellaires en parcourant la galaxie. Rejoignez une communauté d'explorateurs comme vous !</p>
        </section>

        <section class="features" id="features">
            <div class="feature-item">
                <h3>Planètes</h3>
                <p>Visitez des planètes mystérieuses et explorez leurs environnements uniques.</p>
            </div>
            <div class="feature-item">
                <h3>Communauté</h3>
                <p>Connectez-vous avec d'autres voyageurs à travers la galaxie.</p>
            </div>
            <div class="feature-item">
                <h3>Systèmes Stellaires</h3>
                <p>Naviguez à travers différents systèmes stellaires et découvrez des secrets cachés.</p>
            </div>
        </section>
    </main>

    <footer>
        <div class="container">
            <p>Développé par l'équipe &copy; 2024</p>
        </div>
    </footer>

    <script src="../js/main.js"></script>
</body>
</html>
