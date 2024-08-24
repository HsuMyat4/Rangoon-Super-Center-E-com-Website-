<?php
require_once("database/db_connect.php");

// Check if orderID is provided in the query string
if (isset($_GET['orderID'])) {
    $orderID = $_GET['orderID'];

    // Fetch order details from the database, including product details
    $selectOrderDetails = "SELECT orderline.*, products.productName, products.productImg, products.productPrice
                          FROM orderline
                          JOIN products ON orderLine.productID = products.productID
                          WHERE orderline.orderID = :orderID";

    $stmtOrderDetails = $pdo->prepare($selectOrderDetails);
    $stmtOrderDetails->bindParam(':orderID', $orderID, PDO::PARAM_INT);
    $stmtOrderDetails->execute();

    $orderDetails = $stmtOrderDetails->fetchAll(PDO::FETCH_ASSOC);

    // Fetch general order information
    $selectOrderInfo = "SELECT * FROM orders WHERE orderID = :orderID";
    $stmtOrderInfo = $pdo->prepare($selectOrderInfo);
    $stmtOrderInfo->bindParam(':orderID', $orderID, PDO::PARAM_INT);
    $stmtOrderInfo->execute();

    $orderInfo = $stmtOrderInfo->fetch(PDO::FETCH_ASSOC);
} else {
    // Redirect to the order list page if orderID is not provided
    header("Location: order_list.php");
    exit();
}
?>

<body class="font-sans flex">
    <?php
    require_once("aside.php");
    ?>

    <main class="w-full pl-[15%]">
        <?php
        require_once("navbar.php");
        ?>

        <section class="container mx-auto mt-10">
            <h1 class="text-2xl font-bold mb-4">Order Details - Order ID: <?= $orderID ?></h1>

            <!-- Display general order information -->
            <div class="mb-8 p-3 rounded-lg shadow-md  bg-blue-500 text-white max-w-[300px]">
                <p><strong>User ID:</strong> <?= $orderInfo['userID'] ?></p>
                <p class="mt-1"><strong>Order Date:</strong> <?= $orderInfo['orderDate'] ?></p>
                <p class="mt-1"><strong>Total Price:</strong> <?= $orderInfo['totalPrice'] ?> Ks</p>
                <!-- Add more details as needed -->
            </div>

            <!-- Display order line details -->
            <table class="w-full text-sm text-left rtl:text-right shadow-md">
                <thead class="text-xs text-gray-700 uppercase bg-gray-300">
                    <tr>
                        <th scope="col" class="px-3 py-3">Product Name</th>
                        <th scope="col" class="px-3 py-3">Product Image</th>
                        <th scope="col" class="px-3 py-3">Quantity</th>
                        <th scope="col" class="px-3 py-3">Price</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($orderDetails as $orderItem) : ?>
                        <tr class="border-b hover:bg-slate-100 duration-300">
                            <td class="px-3 py-4"><?= $orderItem['productName'] ?></td>
                            <td class="px-3 py-4">
                            <img src="<?= $orderItem['productImg'] ?>" alt="Product Image" class="w-16 h-16 object-cover"></td>
                            <td class="px-3 py-4"><?= $orderItem['quantity'] ?></td>
                            <td class="px-3 py-4"><?= $orderItem['productPrice'] ?> Ks</td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </section>
    </main>

    <footer></footer>
    <!-- Add your scripts and closing tags here -->
</body>

</html>
