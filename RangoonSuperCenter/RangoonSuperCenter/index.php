<?php
require_once('database/db_connect.php');
session_start();



// Build the base SQL query
$product_sql = "SELECT * FROM products WHERE 1";

// Handle search parameters
if (isset($_GET['search_name']) && !empty($_GET['search_name'])) {
    $search_name = $_GET['search_name'];
    $product_sql .= " AND productName LIKE '%$search_name%'";
}

if (isset($_GET['search_category']) && !empty($_GET['search_category'])) {
    $search_category = $_GET['search_category'];
    $product_sql .= " AND catID = $search_category";
}

if (isset($_GET['min_price']) && !empty($_GET['min_price'])) {
    $min_price = $_GET['min_price'];
    $product_sql .= " AND productPrice >= $min_price";
}

if (isset($_GET['max_price']) && !empty($_GET['max_price'])) {
    $max_price = $_GET['max_price'];
    $product_sql .= " AND productPrice <= $max_price";
}

try {
    $stmt = $pdo->query($product_sql);
    $products = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    // Handle database query errors
    echo 'Error fetching products: ' . $e->getMessage();
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Homepage</title>

    <style>
        .card-img-top {
            object-fit: cover;
            height: 300px; /* Set the image height as per your requirement */
        }


        @media (max-width: 576px) {
            .card-img-top {
                height: 150px; /* Adjust the image height for smaller devices */
            }
        }
    </style>
</head>
<body>

<?php require_once("user_navbar.php"); ?>


<div class="container">
    <div class="row justify-content-center">
        <?php foreach ($products as $product): ?>
            <?php $productID = $product['productID']; ?>
            <div class="card mx-3 my-3 col-lg-3 col-sm-12">
                <div>
                    <img src="<?= $product['productImg'] ?>" class="card-img-top" alt="Product Image">
                </div>

                <div class="card-body">
                    <h5 class="card-title"><?= $product['productName'] ?></h5>
                    <?php
                    $catID = $product['catID'];
                    $category_sql = "SELECT catName FROM categories WHERE catID = $catID";
                    $stmt = $pdo->query($category_sql);
                    $category = $stmt->fetchColumn();
                    ?>
                    <p class="card-text"><?= $category ?></p>
                </div>
                <ul class="list-group list-group-flush">
                    <li class="list-group-item">Remaining: <?= $product['instockQty'] ?></li>
                    <li class="list-group-item">Price <?= $product['productPrice'] ?> Ks.</li>
                </ul>
                <div class="card-body text-center">
                     <?php
            if (isset($_SESSION['username'])) {
                // If the user is logged in, show the "Add to Cart" button
                echo "<a href='add_to_cart.php?productID=$productID' class='btn btn-outline-dark'>Add To Cart</a>";
            } else {
                // If the user is not logged in, redirect to the login form
                echo "<a href='login_form.php' class='btn btn-outline-dark'>Add to Cart</a>";
            }
            ?>
                </div>
            </div>
        <?php endforeach ?>
    </div>
</div>
<?php require_once("footer.php"); ?>
</body>
</html>
