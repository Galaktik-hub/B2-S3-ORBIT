<?php
include('cnx.php');
include('back_function.php');
checkLogin();

try {
    // Récupérer les IDs des tickets depuis le POST
    if (empty($_POST['item_ids'])) {
        header("Location: ../page/cart.php?message=Aucun article sélectionné pour la commande.&type=error");
        exit();
    }

    // Sécuriser et transformer les IDs en un tableau
    $itemIds = array_map('intval', explode(',', $_POST['item_ids']));

    // Vérifier si des IDs ont bien été fournis
    if (empty($itemIds)) {
        header("Location: ../page/cart.php.message=Aucun article valide trouvé.&type=error");
        exit();
    }

    // Générer une liste d'espaces réservés pour la requête SQL
    $placeholders = implode(',', array_fill(0, count($itemIds), '?'));

    // Mettre à jour uniquement les tickets correspondants
    $updateQuery = "UPDATE orders 
                    SET order_type = 2 
                    WHERE id IN ($placeholders);";
    $stmt = $pdo->prepare($updateQuery);
    $stmt->execute($itemIds);

    // Vérifier si la mise à jour a réussi
    if ($stmt->rowCount() > 0) {
        header("Location: ../page/cart.php?message=Commande validée avec succès. Merci pour votre achat !&type=success");
        exit();
    } else {
        header("Location: ../page/cart.php?message=Une erreur est survenue lors de la validation de votre commande.&type=error");
        exit();
    }
} catch (PDOException $e) {
    // Gestion des erreurs de la base de données
    error_log("Erreur lors de la validation de commande : " . $e->getMessage());
    header("Location: ../page/cart.php?message=Une erreur est survenue lors de la validation de votre commande.&type=error");
    exit();
}
