<?php
// Your PDO connection
require_once("database/db_connect.php");

// Check if the form is submitted for confirming product deletion
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["confirm_delete"])) {
    // Get product ID from the form
    $proID = $_POST["proID"];

    // Delete the product from the database
    deleteProduct($proID, $pdo);

    // Redirect back to the product list page or perform any other actions as needed
    header("Location: product_list.php");
    exit();
} else {
    // Redirect to the product list page if accessed without proper form submission
    header("Location: product_list.php");
    exit();
}

// Function to delete a product
function deleteProduct($proID, $pdo) {
    $stmt = $pdo->prepare("DELETE FROM products WHERE productID = :proID");
    $stmt->bindParam(':proID', $proID);
    $stmt->execute();
}
?>
