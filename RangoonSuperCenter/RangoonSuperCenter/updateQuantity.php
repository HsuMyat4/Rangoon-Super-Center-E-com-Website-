<?php
// Start or resume the session
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}


// Function to update the quantity of a specific product in the cart
function updateQuantity($productId, $action)
{
    if (isset($_SESSION['cart'][$productId])) {
        switch ($action) {
            case 'increase':
                $_SESSION['cart'][$productId]['qty']++;
                break;
            case 'decrease':
                if ($_SESSION['cart'][$productId]['qty'] > 1) {
                    $_SESSION['cart'][$productId]['qty']--;
                }
                break;
            case 'remove':
                unset($_SESSION['cart'][$productId]);
                break;
        }
    }
}

// Check if the necessary data is provided in the POST request
if (isset($_POST['product_id'], $_POST['action'])) {
    $productId = $_POST['product_id'];
    $action = $_POST['action'];

    // Update the quantity based on the action
    updateQuantity($productId, $action);

    // Redirect back to the shopping cart page
    header("Location: cart.php");
    exit();
} else {
    // Handle invalid or missing data
    echo "Invalid request";
    exit();
}
?>
