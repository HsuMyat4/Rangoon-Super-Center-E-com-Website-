<?php
require_once('database/db_connect.php');
session_start();

// Check if the user is logged in
if (!isset($_SESSION['username'])) {
    header("Location: register_form.php"); 
    exit();
}

$id = $_GET['productID'];

$get_product = "
    SELECT p.*, c.catName
    FROM products p
    JOIN categories c ON p.catID = c.catID
    WHERE productID = :id
";

try {
    $stmt = $pdo->prepare($get_product);
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    $stmt->execute();
    $product = $stmt->fetchAll(PDO::FETCH_ASSOC);

    if (empty($product)) {
        // Product not found, handle accordingly (e.g., redirect to an error page)
        header("Location: error.php");
        exit();
    }

    if (!isset($_SESSION['cart'])) {
        $_SESSION['cart'] = [];
    }

    if (!isset($_SESSION['cart'][$id])) {
        $_SESSION['cart'][$id] = [
            'productID' => $id,
            'productName' => $product[0]['productName'],
            'productCat' => $product[0]['catID'], 
            'productPrice' => $product[0]['productPrice'],
            'productStock' => $product[0]['productStock'],
            'productImg' => $product[0]['productImg'],
            'qty' => 1,
        ];
    } else {
        $_SESSION['cart'][$id]['qty'] += 1;
    }

    header("Location: index.php");
    exit();
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}
?>
