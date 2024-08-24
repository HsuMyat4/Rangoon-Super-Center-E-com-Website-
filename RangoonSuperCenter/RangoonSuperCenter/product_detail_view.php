<?php
require_once("database/db_connect.php");

// Check if proID is set and is a numeric value
if (!isset($_GET['proID']) || !is_numeric($_GET['proID'])) {
    header("Location: product_list.php");
    exit();
}

// Assign proID from the GET parameters
$productID = $_GET['proID'];

// SQL query to select a product based on proID
$sql = "SELECT * FROM products WHERE productID = :productID";
$stmt = $pdo->prepare($sql);
$stmt->bindParam(':productID', $productID, PDO::PARAM_INT);
$stmt->execute();

// Fetch product details from the database
$product = $stmt->fetch(PDO::FETCH_ASSOC);

// Redirect to product_list.php if the product is not found
if (!$product) {
    header("Location: product_list.php");
    exit();
}

// Fetch category name based on product's catID
$categorySql = "SELECT catName FROM categories WHERE catID = :catID";
$categoryStmt = $pdo->prepare($categorySql);
$categoryStmt->bindParam(':catID', $product['catID'], PDO::PARAM_INT);
$categoryStmt->execute();
$category = $categoryStmt->fetch(PDO::FETCH_ASSOC);
$categoryName = $category ? $category['catName'] : 'N/A';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product Details</title>
    <link rel="stylesheet" href="https://cdn.tailwindcss.com" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Open+Sans:wght@300;500;700;800&family=Roboto:wght@100;300;400;500;700&display=swap');

        * {
            font-family: 'Open Sans', sans-serif;
            font-family: 'Roboto', sans-serif;
        }
    </style>
</head>
<body class="font-sans flex">
    <?php require_once("aside.php"); ?>
    
    <main class="w-full pl-[15%]">
        <?php require_once("navbar.php"); ?>
        
        <section class="px-10 mt-5">
            <a class="text-blue-500" href="product_list.php">
                <i class="fas fa-arrow-left"></i> Back to Product List
            </a>

            <article class="flex justify-center items-center mt-10">
                <div class="border-slate-300 border shadow-xl rounded-xl p-3 w-[600px]">
                    <h1 class="text-center text-3xl text-blue-500 font-bold ">
                        Product Details
                    </h1>


                    <div class="grid grid-cols-6 justify-center items-center mt-3">
                        <!-- Product Image start  -->
                        <div class=" col-span-3">
                            <div class="shadow-md rounded-lg overflow-hidden max-h-[300px]">
                                <img class="w-full h-full object-cover" src="<?= $product['productImg'] ?>" alt="<?= $product['productName'] ?>" class="w-full object-contain">
                            </div>
                        </div>
                        <!-- Product Image end  -->

                        <!-- Product information start  -->
                        <div class="col-span-3 p-3">
                            <div>
                                <label class="block text-md font-bold mb-1">
                                    Product ID
                                </label>
                                <p><?= $product['productID'] ?></p>
                            </div>

                            <div class="mt-1">
                                <label class="block text-md font-bold mb-1">
                                    Product Name
                                </label>
                                <p><?= $product['productName'] ?></p>
                            </div>

                            <div class="mt-1">
                                <label class="block text-md font-bold mb-1">
                                    Category
                                </label>
                                <p><?= $categoryName ?></p>
                            </div>

                            <div class="mt-1">
                                <label class="block text-md font-bold mb-1">
                                    Product Price
                                </label>
                                <p><?= $product['productPrice'] ?> Ks</p>
                            </div>

                            <div class="mt-1">
                                <label class="block text-md font-bold mb-1">
                                    Instock Quantity
                                </label>
                                <p><?= $product['instockQty'] ?></p>
                            </div>
                        </div>
                        <!-- Product information end  -->

                    </div>

                    
                    
                </div>
            </article>
        </section>
    </main>

    <footer>
        <!-- Footer content goes here -->
    </footer>
</body>
</html>
