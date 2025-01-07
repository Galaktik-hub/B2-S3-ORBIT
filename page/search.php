<?php

?>


<!DOCTYPE html>
<html lang="fr">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Recherche du trajet optimal...</title>
        <link href="https://fonts.googleapis.com/css2?family=Orbitron:wght@400;700&family=Montserrat:wght@400;600&display=swap" rel="stylesheet">
        <link rel="stylesheet" href="../style/starwars.css">
        <link rel="stylesheet" href="../style/loading.css">
    </head>

    <body>
        <div class="space">
            <div class="stars"></div>
        </div>

        <div class="main-container">
            <div id='universe'>
              <div id='galaxy'>
                <div class='circle'></div>
                <div class='circle2'></div>
                <div class='circle3'></div>
                <div id='orbit0'>
                  <div id='pos0'>
                    <div id='dot0'></div>
                  </div>
                </div>
                <div id='orbit1'>
                  <div id='pos1'>
                    <div id='dot1'></div>
                  </div>
                </div>
                <div id='orbit2'>
                  <div id='pos2'>
                    <div id='dot2'></div>
                  </div>
                </div>
                <div id='orbit3'>
                  <div id='pos3'>
                    <div id='dot3'></div>
                  </div>
                </div>
              </div>
            </div>

            <h2>En cours de recherche du meilleur chemin... Que la patience soit avec vous !</h2>
        </div>

        <script src="../js/starwars.js"></script>
        <script src="../js/galaxy.js"></script>
    </body>
</html>