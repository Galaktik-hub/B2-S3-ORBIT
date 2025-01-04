<?php
include 'cnx.php';

$pseudo = $_SESSION['pseudo'];

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['image'])) {
    $upload_dir = realpath('../assets/images/pp/') . '/'; // Chemin absolu
    $default_image = realpath('../assets/images/pp/account.png');

    $tmp_name = $_FILES['image']['tmp_name'];
    $file_name = uniqid() . "_" . basename($_FILES['image']['name']); // Nom unique
    $file_path = $upload_dir . $file_name;

    if ($_FILES['image']['error'] !== UPLOAD_ERR_OK) {
        $error_message = "Erreur de téléversement : " . $_FILES['image']['error'];
        header("Location: ../page/account.php?message=" . urlencode($error_message) . "&type=error");
        exit();
    }

    $allowed_types = ['image/jpeg', 'image/jpg', 'image/png', 'image/gif'];
    if (!in_array($_FILES['image']['type'], $allowed_types)) {
        $message = "Type de fichier non autorisé";
        header("Location: ../page/account.php?message=" . urlencode($message) . "&type=error");
        exit();
    }

    if ($_FILES['image']['size'] > 5_000_000) {
        $message = "Fichier trop lourd, le maximum autorisé est de 5 Mo.";
        header("Location: ../page/account.php?message=" . urlencode($message) . "&type=error");
        exit();
    }

    try {
        $sql = "SELECT pp FROM users WHERE pseudo = :pseudo";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':pseudo', $pseudo);
        $stmt->execute();
        $old_profile_image = $stmt->fetchColumn();

        if (move_uploaded_file($tmp_name, $file_path)) {
            chmod($file_path, 0644); // Permissions correctes pour le fichier
            $new_profile_image = '../assets/images/pp/' . $file_name;;

            if ($old_profile_image && $old_profile_image !== $default_image && file_exists($old_profile_image)) {
                unlink($old_profile_image);
            }

            $sql = "UPDATE users SET pp = :pp WHERE pseudo = :pseudo";
            $stmt = $pdo->prepare($sql);
            $stmt->bindParam(':pp', $new_profile_image);
            $stmt->bindParam(':pseudo', $pseudo);

            if ($stmt->execute()) {
                $message = "Photo de profil mise à jour";
                $type = "success";
            } else {
                $message = "Erreur lors de la mise à jour";
                $type = "error";
            }
        } else {
            $message = "Erreur lors de l'upload. Chemin : $file_path, Temp : $tmp_name";
            $type = "error";
        }
    } catch (Exception $e) {
        error_log("Erreur interne : " . $e->getMessage(), 3, '../logs/error.log');
        $message = "Erreur interne";
        $type = "error";
    }

    header("Location: ../page/account.php?message=" . urlencode($message) . "&type=" . urlencode($type));
} else {
    $message = "Requête invalide";
    $type = "error";
    header("Location: ../page/account.php?message=" . urlencode($message) . "&type=" . urlencode($type));
}
