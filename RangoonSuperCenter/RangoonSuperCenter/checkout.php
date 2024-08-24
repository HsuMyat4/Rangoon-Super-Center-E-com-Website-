<?php
// Start or resume the session
session_start();

require_once("user_navbar.php");
require_once("database/db_connect.php");

// Function to calculate the total price for a specific product
function calculateTotal($price, $quantity)
{
    return $price * $quantity;
}

// Check if the place_order form is submitted
if (isset($_POST['place_order'])) {
    try {
        // Insert order details into the orders table
        $insertOrderSql = "INSERT INTO orders (userID, orderDate, totalPrice, Address, PaymentType) VALUES (:userID, NOW(), :totalPrice, :address, :paymentType)";
        $insertOrderStmt = $pdo->prepare($insertOrderSql);
        $insertOrderStmt->bindParam(':userID', $_SESSION['userID'], PDO::PARAM_INT);

        // Calculate the total price without delivery cost
        $totalPrice = array_sum(array_map(function ($product) {
            return calculateTotal($product['productPrice'], $product['qty']);
        }, $_SESSION['cart']));

        $insertOrderStmt->bindParam(':totalPrice', $totalPrice, PDO::PARAM_STR);
        $insertOrderStmt->bindParam(':address', $_POST['address'], PDO::PARAM_STR);
        $insertOrderStmt->bindParam(':paymentType', $_POST['payment'], PDO::PARAM_STR);

        // Execute the order insertion
        if ($insertOrderStmt->execute()) {
            // Retrieve the last inserted orderID
            $lastOrderID = $pdo->lastInsertId();

            // Insert order line details into the orderLine table
            $insertOrderLineSql = "INSERT INTO orderline (orderID, productID, quantity) VALUES (:orderID, :productID, :quantity)";
            $insertOrderLineStmt = $pdo->prepare($insertOrderLineSql);

            // Loop through each product in the cart and insert order line
            foreach ($_SESSION['cart'] as $productId => $product) {
                $insertOrderLineStmt->bindParam(':orderID', $lastOrderID, PDO::PARAM_INT);
                $insertOrderLineStmt->bindParam(':productID', $productId, PDO::PARAM_INT);
                $insertOrderLineStmt->bindParam(':quantity', $product['qty'], PDO::PARAM_INT);

                // Execute the order line insertion
                if (!$insertOrderLineStmt->execute()) {
                    echo "Failed to insert order line. Error: " . implode(", ", $insertOrderLineStmt->errorInfo());
                    exit();
                }
            }

            // Clear the shopping cart after successful order placement
            unset($_SESSION['cart']);

            // Redirect to a success page or display a success message using JavaScript
            echo '<script>window.location.href = "thankyou.php";</script>';
            exit();
        } else {
            // Handle order insertion failure
            echo "Failed to place the order. Error: " . implode(", ", $insertOrderStmt->errorInfo());
        }
    } catch (PDOException $e) {
        // Handle database error
        echo "Error: " . $e->getMessage();
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Checkout</title>
    <!-- Add Bootstrap CSS link -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <!-- Add your custom styles here -->
    <style>
        /* Add your custom styles here */
        .rounded-box {
            border-radius: 15px;
            border: 1px solid #ddd;
            padding: 20px;
            margin-bottom: 20px;
        }

        .product-details {
            display: flex;
            margin-bottom: 20px;
        }

        .product-image {
            width: 100px;
            height: 100px;
            object-fit: cover;
            border-radius: 10px;
            margin-right: 10px;
        }

        .product-info {
            flex-grow: 1;
        }

        .quantity-and-price {
            display: flex;
            justify-content: space-between;
        }

        .proceed-buttons {
            display: flex;
            justify-content: space-between;
            margin-top: 20px;
        }
    </style>
</head>

<body>
    <div class="container mt-3">
        <div class="row">
            <div class="col-md-6">
                <!-- Left Box: User Information -->
                <div class="rounded-box">
                    <h3>Shipping Information</h3>
                    <form method="post" action="checkout.php">
                        <!-- Your form fields go here -->
                        <div class="form-group">
                            <label for="address">Address:</label>
                            <input type="text" class="form-control" id="address" name="address" placeholder="Enter your address" required>
                        </div>
                        <div class="form-group">
                            <label for="payment">Payment Method:</label>
                            <select class="form-control" id="payment" name="payment" required>
                                <option value="credit">Credit Card</option>
                                <option value="paypal">PayPal</option>
                                <option value="wavepay">WavePay</option>
                                <option value="kpay">KPay</option>
                            </select>
                        </div>
                        <button type="submit" name="place_order" class="btn btn-primary">Place Order</button>
                    </form>
                </div>
            </div>

            <div class="col-md-6">
                <!-- Right Box: Cart Details -->
                <div class="rounded-box">
                    <h3>Order Details</h3>
                    <?php if (isset($_SESSION['cart']) && !empty($_SESSION['cart'])) : ?>
                        <?php foreach ($_SESSION['cart'] as $productId => $product) : ?>
                            <div class="product-details">
                                <img src="<?= $product['productImg'] ?>" alt="<?= $product['productName'] ?>" class="product-image">
                                <div class="product-info">
                                    <h4><?= $product['productName'] ?></h4>
                                    <div class="quantity-and-price">
                                        <p>Quantity: <?= $product['qty'] ?></p>
                                        <p>Price: <?= calculateTotal($product['productPrice'], $product['qty']) ?> Ks</p>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>

                        <!-- Display subtotal, delivery cost, and total price -->
                        <div class="text-end mt-3">
                            <strong>Total Price: <?= array_sum(array_map(function ($product) {
                                    return calculateTotal($product['productPrice'], $product['qty']);
                                }, $_SESSION['cart'])) ?> Ks</strong>
                        </div>
                    <?php else : ?>
                        <p>Your shopping cart is empty. <a href="index.php">Continue shopping</a></p>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>

    
    <!-- Bootstrap and other scripts go here -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
</body>
<footer style="position:absolute; bottom:0;left:0; width:100%">
<?php require_once("footer.php"); ?>
</footer>
</html>
