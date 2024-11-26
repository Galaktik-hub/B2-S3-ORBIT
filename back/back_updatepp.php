<?php
include 'back_function.php';
include 'cnx.php';

$pseudo = $_SESSION['pseudo'];

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['image'])) {
    $upload_dir = '../images/pp/';
    $default_image = '../images/pp/account.png';

    if ($_FILES['image']['error'] === UPLOAD_ERR_OK) {
        $tmp_name = $_FILES['image']['tmp_name'];
        $file_name = basename($_FILES['image']['name']);
        $file_path = $upload_dir . $file_name;

        if (move_uploaded_file($tmp_name, $file_path)) {
            $new_profile_image = $file_path;
        } else {
            header("Location: ../page/account.php?message=Erreur lors de l'upload&type=error");
            exit();
        }
    } else {
        header("Location: ../page/account.php?message=Aucune image sélectionnée&type=error");
        exit();
    }

    try {
        $sql = "UPDATE users SET pp = :pp WHERE pseudo = :pseudo";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':pp', $new_profile_image);
        $stmt->bindParam(':pseudo', $pseudo);

        if ($stmt->execute()) {
            header("Location: ../page/account.php?message=Photo de profil mise à jour&type=success");
        } else {
            header("Location: ../page/account.php?message=Erreur lors de la mise à jour&type=error");
        }
    } catch (Exception $e) {
        header("Location: ../page/account.php?message=Erreur interne&type=error");
    }
} else {
    header("Location: ../page/account.php?message=Requête invalide&type=error");
}
