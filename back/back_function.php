<?php
session_start();

function checkLogin()
{
    if (!isset($_SESSION['pseudo'])) {
        $message = urlencode("Vous devez être connecté pour accéder à cette page");
        $type = urlencode("error");
        header("Location: ../index.html?message=$message&type=$type");
        exit();
    }
}

function checkAdmin()
{
    if ($_SESSION['role'] !== 'admin') {
        $message = urlencode("Vous devez être administrateur pour accéder à cette page");
        $type = urlencode("error");
        header("Location: index.php?message=$message&type=$type");
        exit();
    }
}

function getInfo()
{
    include 'cnx.php';

    $sql = "SELECT * FROM users WHERE pseudo = :pseudo LIMIT 1";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':pseudo', $_SESSION['pseudo'], PDO::PARAM_STR);
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_OBJ);

    return $result ?: null;
}

function getId($pseudo)
{
    include 'cnx.php';

    $sql = "SELECT id FROM users WHERE pseudo = :pseudo LIMIT 1";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':pseudo', $pseudo, PDO::PARAM_INT);
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($result) {
        return $result['id'];
    } else {
        return null;
    }
}

function isOnProd()
{
    // Define if the project is in prod or local
    return false;
}

function isUsingGraalVMExe() {
    return false;
}

function getShipsByCamp()
{
    include('cnx.php');
    $sql = "
        SELECT ships.name, ships.camp, perturbation.perturbation, perturbation.message, perturbation.end_date
        FROM ships
        LEFT JOIN perturbation ON ships.id = perturbation.shipid
        ORDER BY ships.camp
    ";
    $result = $pdo->query($sql);

    $ships = array('contrebandier' => [], 'empire' => [], 'rebelle' => []);

    if ($result->rowCount() > 0) {
        while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
            $normalizedCamp = strtolower($row['camp']);
            $normalizedCamp = rtrim($normalizedCamp, 's');
            if (isset($ships[$normalizedCamp])) {
                $ships[$normalizedCamp][] = [
                    'name' => $row['name'],
                    'perturbation' => $row['perturbation'],
                    'message' => $row['message'],
                    'end_date' => $row['end_date']
                ];
            }
        }
    }

    return $ships;
}
