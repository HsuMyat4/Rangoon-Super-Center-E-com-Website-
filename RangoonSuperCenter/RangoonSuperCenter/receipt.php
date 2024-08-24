<?php
// Start or resume the session
session_start();

// Use output buffering to prevent header-related errors
ob_start();

require_once("user_navbar.php");
require_once("database/db_connect.php");

// Function to calculate the total price for a specific product
function calculateTotal($price, $quantity)
{
    return $price * $quantity;
}

// Check if the user has items in the cart
if (isset($_SESSION['cart']) && !empty($_SESSION['cart'])) {
    // Fetch order details from the database
    $orderQuery = "SELECT orderID FROM orders ORDER BY orderID DESC LIMIT 1"; // Adjust the query based on your schema
    $stmt = $pdo->prepare($orderQuery);
    $stmt->execute();
    $order = $stmt->fetch(PDO::FETCH_ASSOC);

    // Include any additional information you may need for the receipt, such as user details, order date, etc.
    ?>

    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Receipt</title>
        <style>
            body {
                font-family: Arial, sans-serif;
                margin: 20px;
                background-color: #f5f5f5;
            }

            .container {
                max-width: 800px;
                margin: 0 auto;
                background-color: #fff;
                padding: 20px;
                border-radius: 8px;
                box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            }

            h2 {
                text-align: center;
                color: #333;
            }

            table {
                width: 100%;
                border-collapse: collapse;
                margin-top: 20px;
            }

            th,
            td {
                border: 1px solid #ddd;
                padding: 8px;
                text-align: left;
            }

            th {
                background-color: #f2f2f2;
            }

            .total {
                font-weight: bold;
                font-size: 18px;
                margin-top: 20px;
            }

            .thank-you {
                text-align: center;
                margin-top: 20px;
                color: #888;
            }

            .d-flex {
                align-items: center;
            }
        </style>
    </head>

    <body>
        <div class="container">
            <h2>Receipt</h2>

            <p><strong>Order ID:</strong> <?= $order['orderID'] ?></p>
            <p><strong>Order Date:</strong> <?= date('Y-m-d H:i:s') ?></p>

            <!-- Display product information in a table -->
            <table>
                <thead>
                    <tr>
                        <th>Product</th>
                        <th>Quantity</th>
                        <th>Price (Ks)</th>
                        <th>Total (Ks)</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($_SESSION['cart'] as $productId => $product) : ?>
                        <tr>
                            <td><?= $product['productName'] ?></td>
                            <td><?= $product['qty'] ?></td>
                            <td><?= $product['productPrice'] ?></td>
                            <td><?= calculateTotal($product['productPrice'], $product['qty']) ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>

            <!-- Display total price -->
            <p class="total"><strong>Total Price:</strong> <?= array_sum(array_map(function ($product) {
                return calculateTotal($product['productPrice'], $product['qty']);
            }, $_SESSION['cart'])) ?> Ks</p>

            <!-- Additional details if needed -->

            <p class="thank-you">Thank you for shopping with us!</p>
        </div>
    </body>

    </html>

    <?php
    // Clear the output buffer and send the content to the browser
    ob_end_flush();
    // Clear the shopping cart after generating the receipt
    unset($_SESSION['cart']);
} else {
    // If the cart is empty, redirect to the main page or display an appropriate message
    header("Location: index.php");
    exit();
}
?>
