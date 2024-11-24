<link rel="stylesheet" href="../style/navbar.css">

<nav class="navbar">
    <div class="container">
        <div class="logo">
            <a href="index.php">Galactic Traveler</a>
        </div>
        <ul class="nav-links">
            <li>
                <a href="../back/logout.php">Déconnexion</a>
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