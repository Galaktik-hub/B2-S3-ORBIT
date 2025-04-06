<?php
include('../back/cnx.php');
include('../back/back_function.php');
checkLogin();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $productId = $_POST['product_id'];
    $userId = $_SESSION['id'];

    // Vérification si la mise à jour de la quantité est demandée
    if (isset($_POST['update'])) {
        $quantity = $_POST['quantity'];

        // Vérifier si la quantité est valide (entre 1 et 99)
        if ($quantity >= 1 && $quantity <= 99) {
            $updateQuery = "UPDATE orders
                            SET number_of_ticket = :quantity
                            WHERE id = :product_id";
            $stmt = $pdo->prepare($updateQuery);
            $stmt->execute(['quantity' => $quantity, 'product_id' => $productId]);
            $_SESSION['message'] = "La quantité a été mise à jour avec succès.";
        } else {
            $_SESSION['message'] = "La quantité doit être comprise entre 1 et 99.";
        }
    }
    // Vérification si la suppression d'un article est demandée
    elseif (isset($_POST['delete'])) {
        // Suppression de l'article du panier
        $deleteQuery = "DELETE FROM orders WHERE id = :product_id";
        $stmt = $pdo->prepare($deleteQuery);
        $stmt->execute(['product_id' => $productId]);
        $_SESSION['message'] = "L'article a été supprimé du panier.";
    }
}
header("Location: ../page/cart.php");
exit();
