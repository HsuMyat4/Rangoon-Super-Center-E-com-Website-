<?php
// Your PDO connection
require_once("database/db_connect.php");

// Check if the form is submitted for confirming category deletion
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["confirm_delete"])) {
    // Get category ID from the form
    $catID = $_POST["catID"];

    // Delete the category from the database
    deleteCategory($catID, $pdo);

    // Redirect back to the category list page or perform any other actions as needed
    header("Location: category_list.php");
    exit();
} else {
    // Redirect to the category list page if accessed without proper form submission
    header("Location: category_list.php");
    exit();
}

// Function to delete a category
function deleteCategory($catID, $pdo) {
    $stmt = $pdo->prepare("DELETE FROM categories WHERE catID = :catID");
    $stmt->bindParam(':catID', $catID);
    $stmt->execute();
}
?>
