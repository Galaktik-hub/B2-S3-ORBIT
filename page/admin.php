<?php
include '../back/cnx.php';
include('../back/back_function.php');
checkAdmin();

$stmt = $pdo->prepare("SELECT id, name FROM ships");
$stmt->execute();
$ships = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Gestion de l'insertion d'une perturbation
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['form_type']) && $_POST['form_type'] === 'perturbation') {
    $shipid = $_POST['shipid'];
    $perturbation = $_POST['perturbation'];
    $message = $_POST['message'];
    $end_date = $_POST['end_date'];

    $stmt = $pdo->prepare("INSERT INTO perturbation (shipid, perturbation, message, end_date) VALUES (?, ?, ?, ?)");
    $stmt->execute([$shipid, $perturbation, $message, $end_date]);

    echo "<script>alert('Perturbation ajoutée avec succès !');</script>";
}

// Gestion de l'insertion d'une actualité
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['form_type']) && $_POST['form_type'] === 'actualite') {
    $news_type = $_POST['news_type'];
    $news_content = $_POST['news_content'];

    $stmt = $pdo->prepare("INSERT INTO news (type, content, created_at) VALUES (?, ?, NOW())");
    $stmt->execute([$news_type, $news_content]);

    echo "<script>alert('Actualité ajoutée avec succès !');</script>";
}
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ORBIT - Accueil</title>
    <link href="https://fonts.googleapis.com/css2?family=Orbitron:wght@400;700&family=Montserrat:wght@400;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../style/main.css">
    <link rel="stylesheet" href="../style/modal.css">
    <link rel="stylesheet" href="../style/starwars.css">
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
        <div class="containerBloc" id="search-travel">
            <div class="bloc">
                <h1>Ajouter une Perturbation</h1>
                <div class="blocContainer">
                    <div class="account">
                        <h2>Ajouter une perturbation</h2>
                        <form action="" method="POST">
                            <input type="hidden" name="form_type" value="perturbation">
                            <ul>
                                <li>
                                    <div>
                                        <label for="shipid">ID du Vaisseau :</label>
                                    </div>
                                    <select id="shipid" name="shipid" required>
                                        <option value="">-- Sélectionnez un vaisseau --</option>
                                        <?php foreach ($ships as $ship): ?>
                                            <option value="<?= htmlspecialchars($ship['id']) ?>">
                                                <?= htmlspecialchars($ship['name']) ?>
                                            </option>
                                        <?php endforeach; ?>
                                    </select>
                                </li>
                                <li>
                                    <div>
                                        <label for="perturbation">Type de Perturbation :</label>
                                    </div>
                                    <select name="perturbation" id="perturbation">
                                        <option value="1">Ralentit</option>
                                        <option value="2">Interrompue</option>
                                    </select>
                                </li>
                                <li>
                                    <div>
                                        <label for="message">Message :</label>
                                    </div>
                                    <textarea id="message" name="message" rows="4" required></textarea>
                                </li>
                                <li>
                                    <div>
                                        <label for="end_date">Date de Fin :</label>
                                    </div>

                                    <input type="datetime-local" id="end_date" name="end_date" required>
                                </li>
                                <li>
                                    <input type="submit" value="Ajouter la perturbation">
                                </li>
                            </ul>
                        </form>
                    </div>
                </div>
                <div class="blocContainer">
                    <div class="account">
                        <h1>Ajouter une Actualité</h1>
                        <div class="blocContainer">
                            <form action="" method="POST">
                                <input type="hidden" name="form_type" value="actualite">
                                <ul>
                                    <li>
                                        <label for="news_type">Type d'Actualité :</label>
                                        <select name="news_type" id="news_type" required>
                                            <option value="alerte">Alerte</option>
                                            <option value="decouverte">Découverte</option>
                                            <option value="info">Information</option>
                                        </select>
                                    </li>
                                    <li>
                                        <label for="news_content">Contenu de l'Actualité :</label>
                                        <textarea id="news_content" name="news_content" rows="4" required></textarea>
                                    </li>
                                    <li>
                                        <input type="submit" value="Ajouter l'actualité">
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
            <button class="close-btn" id="close-modal">Fermer</button>
        </div>
    </div>

    <script src="../js/starwars.js"></script>
    <script src="../js/modal.js"></script>
</body>

</html>