<?php
include('../back/back_function.php');
checkLogin();
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
  <script>
    const fetchResults = async () => {
      const response = await fetch('../back/back_find_shortest_path.php', {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json'
        },
        body: JSON.stringify({
          startPlanet: '<?php echo $_POST["startPlanet"]; ?>',
          endPlanet: '<?php echo $_POST["endPlanet"]; ?>',
          legion: '<?php echo $_POST["legion"]; ?>',
          passengers: '<?php echo $_POST["passengers"]; ?>',
          shipName: '<?php echo $_POST["shipName"]; ?>',
        })
      });

      const result = await response.json();
      if (result.success) {
        const params = new URLSearchParams({
          distance: result.distance,
          startPlanetId: result.startPlanetId,
          endPlanetId: result.endPlanetId,
          shipId: result.shipId,
          startPlanet: result.startPlanet,
          endPlanet: result.endPlanet,
          ship: result.ship,
          legion: result.legion,
          passengers: result.passengers,
          routeNames: JSON.stringify(result.routeNames)
        });
        window.location.href = 'map.php?' + params.toString();
      } else {
        alert('Erreur : ' + result.message);
      }
    };

    fetchResults();
  </script>
</body>

</html>