<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Exécution Java</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
            padding: 0;
            background-color: #f4f4f4;
            color: #333;
        }
        h1 {
            text-align: center;
            color: #444;
        }
        form {
            max-width: 500px;
            margin: 0 auto;
            background: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }
        form label {
            font-weight: bold;
            margin-top: 10px;
            display: block;
        }
        form input, form select, form button {
            width: 100%;
            padding: 10px;
            margin-top: 5px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 4px;
            font-size: 16px;
        }
        form button {
            background-color: #5cb85c;
            color: white;
            font-weight: bold;
            cursor: pointer;
        }
        form button:hover {
            background-color: #4cae4c;
        }
        .output {
            max-width: 700px;
            margin: 20px auto;
            background: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }
        pre {
            background: #f9f9f9;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 4px;
            overflow-x: auto;
        }
    </style>
</head>
<body>

<h1>Recherche de Chemin Intergalactique</h1>

<form method="POST">
    <label for="start">ID Planète de Départ :</label>
    <input type="number" id="start" name="start" required>

    <label for="end">ID Planète d'Arrivée :</label>
    <input type="number" id="end" name="end" required>

    <label for="faction">Faction :</label>
    <select id="faction" name="faction" required>
        <option value="Empire">Empire</option>
        <option value="Neutre">Neutre</option>
        <option value="Rebelles">Rebelles</option>
    </select>

    <button type="submit">Exécuter</button>
</form>

<div class="output">
    <?php
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $start = intval($_POST['start']);
        $end = intval($_POST['end']);
        $faction = htmlspecialchars($_POST['faction'], ENT_QUOTES, 'UTF-8');

        $output = [];
        $returnCode = 0;

        exec("java -jar ../java/target/but2-sae4-orbit-1.0-SNAPSHOT.jar ../c/main $start $end $faction 2>&1", $output, $returnCode);

        if ($returnCode === 0) {
            echo "<h2>Résultat :</h2>";
            echo "<pre>" . implode("\n", $output) . "</pre>";
        } else {
            echo "<h2>Erreur :</h2>";
            echo "<pre>" . implode("\n", $output) . "</pre>";
        }
    }
    ?>
</div>

</body>
</html>
