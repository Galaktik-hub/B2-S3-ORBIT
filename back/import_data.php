<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Import & Search</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">

    <style>
        .btn-import {
            margin: 10px;
            width: 180px;
        }
        .feedback {
            margin-top: 20px;
            font-weight: bold;
        }
    </style>
</head>
<body class="container">

<h1 class="mt-5">Star Wars Data Import & Search</h1>

<!-- Import Buttons -->
<div class="import-buttons">
    <button id="importShips" class="btn btn-secondary btn-import">Importer Vaisseaux</button>
    <button id="importPlanets" class="btn btn-primary btn-import">Importer Planètes</button>
</div>
<div id="importFeedback" class="feedback"></div>


<!-- jQuery, jQuery UI, Bootstrap JS -->
<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

<script src="../js/import_data.js"></script>

</body>
</html>
