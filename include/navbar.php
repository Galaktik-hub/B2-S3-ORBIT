<link rel="stylesheet" href="../style/navbar.css">
<?php
include('../include/svg.php');
$infoUser = getInfo();
?>

<nav class="navbar">
    <div class="container-nav">
        <div class="logo">
            <a href="index.php">ORBIT</a>
        </div>
        <ul class="nav-links">
            <li>
                <a href="../back/logout.php">Déconnexion</a>
            </li>
            <li>
                <a href="account.php"><img src="<?php echo $infoUser->pp; ?>" class="accountpp" alt="PP"></a>
            </li>
            <li id="overlayButton">
                <img src="../images/settings.svg" id="svg-settings-icon" alt="Paramètres">
            </li>
        </ul>
    </div>
</nav>

<div class="overlay">
    <div class="cross">
        <div class="bar"></div>
        <div class="bar"></div>
    </div>
    <ul>
        <a href="index.php">
            <div class="svg">
                <?php echo svg('home'); ?>
            </div>
            <p>Accueil</p>
        </a>
        <a href="account.php">
            <div class="svg">
                <?php echo svg('account'); ?>
            </div>
            <p>Compte</p>
        </a>
        <a href="map.php">
            <div class="svg">
                <?php echo svg('map'); ?>
            </div>
            <p>Carte et Plans</p>
        </a>
        <a href="info_trafic.php">
            <div class="svg">
                <?php echo svg('attention'); ?>
            </div>
            <p>Info Trafic</p>
        </a>
        <a href="horraire.php">
            <div class="svg">
                <?php echo svg('clock'); ?>
            </div>
            <p>Horraires</p>
        </a>
        <a href="travel_form.php">
            <div class="svg">
                <?php echo svg('route-planning'); ?>
            </div>
            <p>Planifier un voyage</p>
        </a>
        <a href="../back/logout.php">
            <div class="svg">
                <?php echo svg('logout'); ?>
            </div>
            <p>Déconnexion</p>
        </a>
    </ul>
</div>

<script>
    const svgIcon = document.getElementById('svg-settings-icon');
    svgIcon.addEventListener('mouseover', () => {
        svgIcon.style.filter = 'brightness(0) saturate(100%) invert(89%) sepia(96%) saturate(2679%) hue-rotate(85deg) brightness(102%) contrast(105%)';
    });

    svgIcon.addEventListener('mouseout', () => {
        svgIcon.style.filter = 'none';
    });

    const overlay = document.querySelector('.overlay');
    const cross = document.querySelector('.cross');
    const overlayButton = document.getElementById('overlayButton');

    overlayButton.addEventListener('click', () => {
        overlay.classList.add('show');
    });

    cross.addEventListener('click', () => {
        overlay.classList.remove('show');
    });
</script>