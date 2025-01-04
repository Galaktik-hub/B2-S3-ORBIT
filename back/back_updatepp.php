<?php
include 'back_function.php';
include 'cnx.php';

$pseudo = $_SESSION['pseudo'];

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['image'])) {
    $upload_dir = '../assets/images/pp/';
    $default_image = '../assets/images/pp/account.png';

    $tmp_name = $_FILES['image']['tmp_name'];
    $file_name = uniqid() . "_" . basename($_FILES['image']['name']); // Nom unique
    $file_path = $upload_dir . $file_name;

    try {
        $sql = "SELECT pp FROM users WHERE pseudo = :pseudo";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':pseudo', $pseudo);
        $stmt->execute();
        $old_profile_image = $stmt->fetchColumn();

        if (move_uploaded_file($tmp_name, $file_path)) {
            $new_profile_image = $file_path;

            if ($old_profile_image && $old_profile_image !== $default_image && file_exists($old_profile_image)) {
                unlink($old_profile_image);
            }

            $sql = "UPDATE users SET pp = :pp WHERE pseudo = :pseudo";
            $stmt = $pdo->prepare($sql);
            $stmt->bindParam(':pp', $new_profile_image);
            $stmt->bindParam(':pseudo', $pseudo);

            if ($stmt->execute()) {
                $message = urlencode("Photo de profil mise à jour");
                $type = urlencode("success");
                header("Location: ../page/account.php?message=$message&type=$type");
            } else {
                $message = urlencode("Erreur lors de la mise à jour");
                $type = urlencode("error");
                header("Location: ../page/account.php?message=$message&type=$type");
            }
        } else {
            $message = urlencode("Erreur lors de l'upload");
            $type = urlencode("error");
            header("Location: ../page/account.php?message=$message&type=$type");
        }
    } catch (Exception $e) {
        $message = urlencode("Erreur interne");
        $type = urlencode("error");
        header("Location: ../page/account.php?message=$message&type=$type");
    }
} else {
    $message = urlencode("Requête invalide");
    $type = urlencode("error");
    header("Location: ../page/account.php?message=$message&type=$type");
}
