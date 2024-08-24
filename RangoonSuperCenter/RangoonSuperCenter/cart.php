<?php
// Start or resume the session
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once("user_navbar.php");


// Function to calculate the total price for a specific product
function calculateTotal($price, $quantity)
{
    return $price * $quantity;
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Shopping Cart</title>
    <!-- Add Bootstrap CSS link -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <style>
        /* Add your custom styles here */
        .product-image {
            width: 100px;
            height: 100px;
            object-fit: cover;
        }

        .product-details {
            display: flex;
        }

        .product-info {
            margin-left: 10px;
            flex-grow: 1;
        }

        .quantity-input {
            width: 50px;
        }

        .cart-item {
            border: 1px solid #ddd;
            border-radius: 5px;
            padding: 10px;
            margin-bottom: 20px;
            display: flex;
        }

        .cart-item:last-child {
            margin-bottom: 0;
        }

        .total-price {
            font-weight: bold;
            font-size: 20px;
            margin-top: 30px;
        }

        .proceed-button {
            margin-top: 20px;
            margin-bottom: 120px;
        }

        .empty-cart {
            text-align: center;
            margin-top: 50px;
            font-size: 18px;
            color: #999;
        }
        /* .footer_div{
            padding-top: 130px;
        } */
        .text-end proceed-button{
            margin-bottom: 9px;
        }
    </style>
</head>

<body>
    <div class="container mt-3">
        <h2>Shopping Cart</h2>

        <?php if (isset($_SESSION['cart']) && !empty($_SESSION['cart'])) : ?>
            <?php foreach ($_SESSION['cart'] as $productId => $product) : ?>
                <div class="cart-item">
                    <img src="<?= $product['productImg'] ?? '' ?>" alt="<?= $product['productName'] ?? 'Unknown' ?>" class="product-image">
                    <div class="product-info">
                        <h4><?= $product['productName'] ?? 'Unknown' ?></h4>
                        <?php
                        // Check if productCat and productPrice exist before querying the category
                        if (isset($product['productCat'])) {
                            $catID = $product['productCat'];
                            // Fetch the category name based on productCat
                            $category_sql = "SELECT catName FROM categories WHERE catID = :catID";
                            try {
                                $stmt = $pdo->prepare($category_sql);
                                $stmt->bindParam(':catID', $catID, PDO::PARAM_INT);
                                $stmt->execute();
                                $category = $stmt->fetchColumn();
                            } catch (PDOException $e) {
                                // Handle the SQL error more gracefully
                                echo 'Error fetching category: ' . $e->getMessage();
                                $category = 'Unknown';
                            }
                            // Output the category name
                            echo '<p>Category: ' . $category . '</p>';
                        } else {
                            echo '<p>Category: Unknown</p>';
                        }

                        echo '<p>Price: ' . ($product['productPrice'] ?? 'Unknown') . ' Ks</p>';
                        ?>
                    </div>
                    <div class="quantity-actions">
                    <form method="post" action="updateQuantity.php" class="d-inline">
                            <input type="hidden" name="product_id" value="<?= $productId ?>">
                            <button type="submit" class="btn btn-outline-danger btn-sm" name="action" value="decrease">-</button>
                        </form>
                        <input type="number" value="<?= $product['qty'] ?? 0 ?>" class="quantity-input" disabled>

                        <form method="post" action="updateQuantity.php" class="d-inline">
                            <input type="hidden" name="product_id" value="<?= $productId ?>">
                            <button type="submit" class="btn btn-outline-success btn-sm" name="action" value="increase">+</button>
                        </form>
                        <form method="post" action="updateQuantity.php" class="d-inline">
                            <input type="hidden" name="product_id" value="<?= $productId ?>">
                            <button type="submit" class="btn btn-outline-danger btn-sm ml-2" name="action" value="remove">Remove</button>
                        </form>
                    </div>
                </div>
            <?php endforeach; ?>

            <!-- Display total price and proceed button -->
            <div class="text-end mt-3">
                <strong class="total-price">Total: <?= array_sum(array_map(function ($product) {
                    return calculateTotal($product['productPrice'] ?? 0, $product['qty'] ?? 0);
                }, $_SESSION['cart'])) ?> Ks</strong>
            </div>

            <div class="text-end proceed-button">
                <a href="checkout.php" class="btn btn-primary">Proceed to Checkout</a>
            </div>

        <?php else : ?>
            <div class="empty-cart">
                Your shopping cart is empty. <a href="index.php">Continue shopping</a>
            </div>
        <?php endif; ?>
    </div>
    <div class="footer_div">
        
    <?php require_once("footer.php"); ?>
    </div>

    <!-- Bootstrap and other scripts go here -->
</body>

</html>
