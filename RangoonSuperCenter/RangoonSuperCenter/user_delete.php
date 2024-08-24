<?php
// Your PDO connection
require_once("database/db_connect.php");

// Check if the form is submitted for confirming user deletion
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["confirm_delete"])) {
    // Get user ID from the form
    $userID = $_POST["userID"];

    // Delete the user from the database
    deleteUser($userID, $pdo);

    // Redirect back to the user list page or perform any other actions as needed
    header("Location: user_list.php");
    exit();
} else {
    // Redirect to the user list page if accessed without proper form submission
    header("Location: user_list.php");
    exit();
}

// Function to delete a user
function deleteUser($userID, $pdo) {
    $stmt = $pdo->prepare("DELETE FROM users WHERE userID = :userID");
    $stmt->bindParam(':userID', $userID);
    $stmt->execute();
}
?>
