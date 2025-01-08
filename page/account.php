<?php
include('../back/back_function.php');
$infoUser = getInfo();
checkLogin();
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ORBIT - Compte</title>
    <link href="https://fonts.googleapis.com/css2?family=Orbitron:wght@400;700&family=Montserrat:wght@400;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../style/main.css">
    <link rel="stylesheet" href="../style/starwars.css">
    <link rel="stylesheet" href="../style/modal.css">
    <link rel="stylesheet" href="../style/form.css">
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
        <div class="containerBloc">
            <div class="bloc bloc2">
                <h1>Compte</h1>
                <div class="blocContainer">
                    <div class="account">
                        <form action="../back/back_updateAccount.php" method="post">
                            <ul>
                                <li>
                                    <div>
                                        <?php echo svg('account'); ?> <label for="pseudo" class="responsiveLabel">Pseudo:</label>
                                    </div>
                                    <input type="text" placeholder="<?php echo $infoUser->pseudo; ?>" name="pseudo" required>
                                </li>
                                <li>
                                    <div>
                                        <?php echo svg('email'); ?> <label for="email" class="responsiveLabel">Email :</label>
                                    </div>
                                    <input type="email" placeholder="<?php echo $infoUser->email; ?>" name="email" required>
                                </li>
                                <li>
                                    <input type="submit" value="Mettre a jour">
                                </li>
                            </ul>
                        </form>
                        <form action="../back/back_updatepp.php" method="post" enctype="multipart/form-data">
                            <ul>
                                <li>
                                    <img src="<?php echo $infoUser->pp; ?>" alt="PP" class="pp">
                                </li>
                                <li>
                                    <input type="file" name="image" id="image" accept="image/gif, image/png, image/jpeg, image/jpg" required>
                                </li>
                                <li>
                                    <input type="submit" value="Mettre a jour">
                                </li>
                            </ul>
                        </form>
                        <form action="../back/back_updatePassword.php" method="post">
                            <ul>
                                <li>
                                    <div>
                                        <?php echo svg('password'); ?> <label for="password" class="responsiveLabel">Ancien:</label>
                                    </div>
                                    <input type="password" placeholder="Ancien Mot de Passe" name="password">
                                </li>
                                <li>
                                    <div>
                                        <?php echo svg('password'); ?> <label for="password2" class="responsiveLabel">Nouveau:</label>
                                    </div>
                                    <input type="password" placeholder="Nouveau Mot de Passe" name="password2">
                                </li>
                                <li>
                                    <input type="submit" value="Mettre a jour">
                                </li>
                            </ul>
                        </form>
                        <div class="buttonContainer">
                            <ul>
                                <li>
                                    <button id="generate-pdf">Téléchargez mes commandes passées</button>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <div id="modal" class="modal">
        <div class="modal-content">
            <div class="modal-header" id="modal-header"></div>
            <div class="modal-body" id="modal-body"></div>
            <button class="close-btn" id="close-modal">Fermer</button>
        </div>
    </div>

    <script src="../js/starwars.js"></script>
    <script src="../js/modal.js"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.9.2/html2pdf.bundle.min.js"></script>

    <script>
        document.getElementById('generate-pdf').addEventListener('click', async () => {
            try {
                // Charger le fichier billet.html
                const htmlResponse = await fetch('../assets/blank_pages/billet.html');
                if (!htmlResponse.ok) throw new Error('Erreur lors du chargement de billet.html');
                const htmlTemplate = await htmlResponse.text();

                // Récupérer les données de l'API
                const response = await fetch('../back/back_download_orders.php');
                if (!response.ok) throw new Error('Erreur lors de la récupération des données de l\'API');
                const tickets = await response.json();

                if (!tickets.length) {
                    alert('Aucun billet à générer.');
                    return;
                }

                // Créer un conteneur temporaire pour manipuler le contenu
                const container = document.createElement('div');
                container.innerHTML = htmlTemplate;

                const ticketTemplate = container.querySelector('#ticket-template').innerHTML;
                const ticketsContainer = document.createElement('div');

                tickets.forEach(ticket => {
                    const ticketHTML = ticketTemplate
                        .replace('<span id="departure"></span>', ticket.departure)
                        .replace('<span id="arrival"></span>', ticket.arrival)
                        .replace('<span id="distance"></span>', ticket.distance)
                        .replace('<span id="time_of_order"></span>', ticket.time_of_order)
                        .replace('<span id="ship"></span>', ticket.ship)
                        .replace('<span id="number_of_ticket"></span>', ticket.number_of_ticket);
                    ticketsContainer.innerHTML += ticketHTML;
                });

                // Options pour html2pdf.js
                const options = {
                    margin: 0.5,
                    filename: 'récapitulatif_commandes.pdf',
                    image: { type: 'jpeg', quality: 0.98 },
                    html2canvas: { scale: 2 },
                    jsPDF: { unit: 'in', format: 'letter', orientation: 'portrait' }
                };

                // Générer le PDF
                await html2pdf().from(ticketsContainer).set(options).save();
            } catch (error) {
                console.error('Erreur :', error);
                alert('Une erreur est survenue. Consultez la console pour plus de détails.');
            }
        });
    </script>
</body>

</html>