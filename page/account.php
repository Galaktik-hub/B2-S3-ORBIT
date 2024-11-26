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
                        <form action="../back/back_updateAccount.php" method="post">
                            <ul>
                                <li>
                                    <div>
                                        <?php echo svg('account'); ?> <label for="pseudo" class="responsiveLabel">Pseudo:</label>
                                    </div>
                                    <input type="text" value="<?php echo $infoUser->pseudo; ?>" name="pseudo">
                                </li>
                                <li>
                                    <div>
                                        <?php echo svg('email'); ?> <label for="email" class="responsiveLabel">Email :</label>
                                    </div>
                                    <input type="email" value="<?php echo $infoUser->email; ?>" name="email">
                                </li>
                                <li>
                                    <input type="submit" value="Mettre a jour">
                                </li>
                            </ul>
                        </form>
                        <form action="../back/back_updateAccount.php" method="post">
                            <ul>
                                <li>
                                    <img src="<?php echo $infoUser->pp; ?>" alt="PP" class="pp">
                                </li>
                                <li>
                                    <input type="file" name="image" id="image" required>
                                </li>
                                <li>
                                    <input type="submit" value="Mettre a jour">
                                </li>
                            </ul>
                        </form>
                        <form action="">
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
                    </div>
                </div>
            </div>
        </div>
    </main>

    <div id="modal" class="modal">
        <div class="modal-content">
            <div class="modal-header" id="modal-header"></div>
            <div class="modal-body" id="modal-body"></div>
            <button class="close-btn" id="close-modal">Close</button>
        </div>
    </div>

    <script src="../js/starwars.js"></script>
    <script src="../js/modal.js"></script>
</body>

</html>