<?php
include('../back/back_function.php');
checkLogin();
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Galactic Traveler - Compte</title>
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
        <div class="containerBloc">
            <div class="bloc">
                <h1>Compte</h1>
                <div class="blocContainer">
                    <div class="account">
                        <form action="">
                            <ul>
                                <li>
                                    <?php echo svg('account'); ?> <input type="text" placeholder="Nom">
                                </li>
                                <li>
                                    <?php echo svg('account'); ?> <input type="text" placeholder="Pseudo">
                                </li>
                                <li>
                                    <?php echo svg('email'); ?> <input type="email" placeholder="Email">
                                </li>
                                <li>
                                    <input type="submit" value="Mettre a jour">
                                </li>
                            </ul>
                        </form>
                        <form action="">
                            <ul>
                                <li>
                                    <?php echo svg('password'); ?> <input type="password" placeholder="Ancien Mot de Passe">
                                </li>
                                <li>
                                    <?php echo svg('password'); ?> <input type="password" placeholder="Nouveau Mot de Passe">
                                </li>
                                <li>
                                    <input type="submit" value="Mettre a jour">
                                </li>
                            </ul>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <script src="../js/starwars.js"></script>
</body>

</html>