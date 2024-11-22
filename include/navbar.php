<link rel="stylesheet" href="../style/navbar.css">

<nav class="navbar">
    <div class="container">
        <div class="logo">
            <a href="index.php">Galactic Traveler</a>
        </div>
        <ul class="nav-links">
            <li><a href="../back/logout.php">Déconnexion</a></li>
            <li><a href="">
                    <img src="../images/settings.svg" id="svg-settings-icon" alt="Paramètres">
                </a></li>
        </ul>
    </div>
</nav>

<script>
    const svgIcon = document.getElementById('svg-settings-icon');
    svgIcon.addEventListener('mouseover', () => {
        svgIcon.style.filter = 'brightness(0) saturate(100%) invert(89%) sepia(96%) saturate(2679%) hue-rotate(85deg) brightness(102%) contrast(105%)';
    });

    svgIcon.addEventListener('mouseout', () => {
        svgIcon.style.filter = 'none'; 
    });
</script>