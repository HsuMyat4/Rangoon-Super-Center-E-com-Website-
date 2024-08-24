<?php
require_once("database/db_connect.php");

// Fetch orders with details from the database, including order quantity from orderLine table
$selectOrders = "SELECT orders.orderID, orders.userID, orders.orderDate, SUM(orderLine.quantity) as orderQty, orders.totalPrice
                 FROM orders
                 LEFT JOIN orderLine ON orders.orderID = orderLine.orderID
                 GROUP BY orders.orderID";

$stmtOrders = $pdo->query($selectOrders);
$orders = $stmtOrders->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">

<head>
<meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <!-- Tailwind css link  -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- <link rel="stylesheet" href="./output.css"> -->
    <!-- Fontawesome link  -->
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
    <?php
    require_once("aside.php");
    ?>

    <main class="w-full pl-[15%]">
        <?php
        require_once("navbar.php");
        ?>

        <section class="px-10 mt-10">
            <!-- Order list content start -->
            <article class="pt-10">
                <div class="relative overflow-x-auto shadow-md sm:rounded-lg mt-20">
                    <table class="w-full text-sm text-left rtl:text-right">
                        <thead class="text-xs text-gray-700 uppercase bg-gray-50">
                            <tr>
                                <th scope="col" class="px-3 py-3">Order ID</th>
                                <th scope="col" class="px-3 py-3">User ID</th>
                                <th scope="col" class="px-3 py-3">Order Date</th>
                                <th scope="col" class="px-3 py-3">Order Quantity</th>
                                <th scope="col" class="px-3 py-3">Total Amount</th>
                                <th scope="col" class="px-3 py-3">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($orders as $key => $order) : ?>
                                <tr class="border-b">
                                    
                                    <td class="px-3 py-4"><?= $order['orderID'] ?></td>
                                    
                                    <td class="px-3 py-4"><?= $order['userID'] ?></td>
                                    <td class="px-3 py-4"><?= date('Y-m-d H:i', strtotime($order['orderDate'])) ?></td>
                                    <td class="px-3 py-4"><?= $order['orderQty'] ?></td>
                                    <td class="px-3 py-4"><?= $order['totalPrice'] ?> Ks</td>
                                    <td class="px-3 py-4">
                                        <div class="flex items-center gap-x-4 w-full">
                                            <a href="order_detail_list.php?orderID=<?= $order['orderID'] ?>" class="font-medium text-blue-600 hover:underline">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </article>
            <!-- Order list content end -->
        </section>
    </main>

    <footer></footer>
    <script src="app.js"></script>
    
</body>

</html>
