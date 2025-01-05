<?php
include('../back/back_function.php');
checkLogin();

?>


<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ORBIT - Info Trafic</title>
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
                    <li id="contrebandier">Contrebandier</li>
                    <li id="empire">Empire</li>
                    <li id="rebelle">Rebelle</li>
                </ul>
            </div>

            <div class="traficInformation">
                <p id="defaultMessage">Veuillez sélectionner une faction pour afficher les vaisseaux.</p>

            </div>
            <div class="bottomMessageArea">
                <p id="messageDisplay"></p>
            </div>
        </div>

    </main>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const svgIcons = {
                settings: `<?php echo svg('settings'); ?>`,
                validate: `<?php echo svg('validate'); ?>`,
                attention: `<?php echo svg('attention'); ?>`
            };
            const shipsData = <?php echo json_encode(getShipsByCamp()); ?>;
            const traficInformation = document.querySelector('.traficInformation');
            const messageDisplay = document.getElementById('messageDisplay');

            function generateTraficInfo(camp) {
                traficInformation.innerHTML = '';

                if (shipsData[camp] && shipsData[camp].length > 0) {
                    shipsData[camp].forEach(ship => {
                        const div = document.createElement('div');
                        div.className = 'trafic-item';

                        const textNode = document.createElement('span');
                        textNode.textContent = ship;
                        div.appendChild(textNode);

                        const svgWrapper = document.createElement('div');
                        svgWrapper.className = 'svg-icon';
                        svgWrapper.innerHTML = svgIcons.validate;
                        div.appendChild(svgWrapper);

                        div.addEventListener('click', function() {
                            showTrafficMessage('Trafic fluide', ship);
                        });

                        traficInformation.appendChild(div);
                    });
                } else {
                    traficInformation.innerHTML = '<p>Aucun vaisseau trouvé pour cette faction.</p>';
                }
            }

            function showTrafficMessage(message, ship) {
                messageDisplay.innerHTML = '';

                const messageContainer = document.createElement('div');
                messageContainer.style.display = 'flex';
                messageContainer.style.flexDirection = 'column';
                messageContainer.style.alignItems = 'center';
                messageContainer.style.justifyContent = 'center';
                messageContainer.style.padding = '10px';
                messageContainer.style.backgroundColor = 'rgba(0, 0, 0, 0.7)';
                messageContainer.style.borderRadius = '5px';
                messageContainer.style.marginTop = '10px';
                messageContainer.style.color = 'white';

                const textSpan = document.createElement('span');
                textSpan.textContent = `${ship}:`;
                textSpan.style.marginBottom = '5px';

                const messageIconContainer = document.createElement('div');
                messageIconContainer.style.display = 'flex';
                messageIconContainer.style.alignItems = 'center';

                const textSpan2 = document.createElement('span');
                textSpan2.textContent = `${message}`;
                textSpan2.style.marginRight = '10px';

                const svgIcon = document.createElement('div');
                svgIcon.innerHTML = `<?php echo svg('validate'); ?>`;
                svgIcon.style.width = '24px';
                svgIcon.style.height = '24px';
                svgIcon.style.fill = '#4CAF50';

                messageIconContainer.appendChild(textSpan2);
                messageIconContainer.appendChild(svgIcon);

                messageContainer.appendChild(textSpan);
                messageContainer.appendChild(messageIconContainer);

                messageDisplay.appendChild(messageContainer);
            }

            document.body.addEventListener('click', function(e) {
                if (!e.target.closest('.trafic-item')) {
                    hideTrafficMessage();
                }
            }, true);

            function hideTrafficMessage() {
                messageDisplay.textContent = '';
            }

            document.getElementById('contrebandier').addEventListener('click', () => {
                generateTraficInfo('contrebandier');
            });
            document.getElementById('empire').addEventListener('click', () => {
                generateTraficInfo('empire');
            });
            document.getElementById('rebelle').addEventListener('click', () => {
                generateTraficInfo('rebelle');
            });
        });
    </script>

    <script src="../js/starwars.js"></script>
</body>

</html>