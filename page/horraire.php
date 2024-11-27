<?php
include('../back/back_function.php');
checkLogin();
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Galactic Traveler - Horraires</title>
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
            <h1>Horraires</h1>
        </div>

        <div class="infoTrafic">
            <div class="navbarTrafic">
                <ul>
                    <li id="navette">Navette</li>
                    <li id="vaisseau">Vaisseau</li>
                </ul>
            </div>

            <div class="traficInformation">

            </div>
        </div>

    </main>

    <script>
        const svgIcons = {
            account: `<?php echo svg('account'); ?>`,
            home: `<?php echo svg('home'); ?>`,
            settings: `<?php echo svg('settings'); ?>`,
            map: `<?php echo svg('map'); ?>`,
            password: `<?php echo svg('password'); ?>`,
            email: `<?php echo svg('email'); ?>`,
            validate: `<?php echo svg('validate'); ?>`,
            clock: `<?php echo svg('clock'); ?>`,
            attention: `<?php echo svg('attention'); ?>`
        };

        const navetteButton = document.getElementById('navette');
        const vaisseauButton = document.getElementById('vaisseau');
        const traficInformation = document.querySelector('.traficInformation');

        function generateTraficInfo(type) {
            traficInformation.innerHTML = '';

            for (let i = 1; i <= 25; i++) {
                const div = document.createElement('div');
                div.className = 'trafic-item';

                const textNode = document.createElement('span');
                textNode.textContent = `${type} ${i}`;
                div.appendChild(textNode);

                const svgWrapper = document.createElement('div');
                svgWrapper.className = 'svg-icon';
                svgWrapper.innerHTML = svgIcons.validate;
                div.appendChild(svgWrapper);

                traficInformation.appendChild(div);
            }
        }

        navetteButton.addEventListener('click', () => {
            generateTraficInfo('Navette');
        });

        vaisseauButton.addEventListener('click', () => {
            generateTraficInfo('Vaisseau');
        });
    </script>

    <script src="../js/starwars.js"></script>
</body>

</html>