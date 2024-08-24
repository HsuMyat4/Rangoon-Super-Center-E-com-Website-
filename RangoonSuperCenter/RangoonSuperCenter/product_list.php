<?php
// Your PDO connection
require_once("database/db_connect.php");

// Fetch products
$stmt = $pdo->query("SELECT * FROM products");
$products = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <!-- Tailwind CSS link  -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- <link rel="stylesheet" href="./output.css"> -->
    <!-- Fontawesome link  -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    <style>
        @import url('https://fonts.googleapis.com/css2?family=Open+Sans:wght@300;500;700;800&family=Roboto:wght@100;300;400;500;700&display=swap');

        * {
            font-family: 'Open Sans', 'Roboto', sans-serif;
        }
    </style>

</head>
<body class="font-sans flex ">
<?php
require_once("aside.php");
?>

<main class="w-full pl-[15%]">
    <?php
    require_once("navbar.php");
    ?>

    <section class="px-10 mt-10">

        <!-- Product list content start  -->
        <article class="">

            <!-- Delete alert start  -->
            <div id="delete_alert" class="absolute top-32 left-1/2 transform -translate-x-1/2 -translate-y-[350px] duration-300 opacity-0 bg-slate-100 shadow-lg rounded-lg p-8 z-30">
                 <form method="post" action="product_delete.php">
                    <input type="hidden" name="proID" id="delete_pro_id_input" value="">
                <div class="flex justify-center">
                    <div class="flex justify-center items-center border border-red-500 rounded-full h-12 w-12">
                        <i class="fas fa-xmark text-3xl text-red-500"></i>
                    </div>
                </div>

                <h1 class="text-xl text-slate-900 text-center mt-3">Are you sure to delete?</h1>
                <div class="flex justify-center items-center gap-x-6 mt-4">
                    <!-- Delete Btn  -->
                    <button type="submit" name="confirm_delete" class="bg-red-500 text-white text-md text-center rounded-lg shadow-lg hover:bg-red-600 duration-300 px-3 py-1">
                        Yes
                    </button>
                    <!-- Cancel Btn  -->
                    <button onclick="toggleAlert('delete_alert','close')" type="button"
                            class="bg-green-500 text-white text-md text-center rounded-lg shadow-lg hover:bg-green-600 duration-300 px-3 py-1">
                        No
                    </button>
                </div>
    </form>
            </div>
            <!-- Delete alert end  -->

            <div class="flex justify-between items-center">

                <!-- Create product start  -->
                <div class="flex items-center gap-x-2">
                    <a href="product_create.php"
                       class="bg-red-500 text-white flex justify-center items-center rounded-lg px-3 py-2 shadow-lg text-decoration-none">
                        Add
                    </a>
                </div>
                <!-- Create product end  -->
            </div>
            
            <!-- Product list start  -->
            <div class="relative overflow-x-auto shadow-md sm:rounded-lg mt-10 ">
                <table class="w-full text-sm text-left rtl:text-right ">
                    <thead class="text-xs text-gray-700 uppercase bg-gray-50 ">
                    <tr>
                        <th scope="col" class="px-6 py-3">
                            Product ID
                        </th>
                        <th scope="col" class="px-6 py-3">
                            Product Image
                        </th>
                        <th scope="col" class="px-6 py-3">
                            Product Name
                        </th>
                        <th scope="col" class="px-6 py-3">
                            Category
                        </th>
                        <th scope="col" class="px-6 py-3">
                            Product Price
                        </th>
                        <th scope="col" class="px-6 py-3">
                            Instock Quantity
                        </th>
                        <th scope="col" class="px-6 py-3">
                            Action
                        </th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php foreach ($products as $product): ?>
                        <tr class="  border-b ">
                           
                                <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap ">
                                    <?= $product['productID'] ?>
                                </th>
                                <td class="px-6 py-4">
                                    <img src="<?= $product['productImg'] ?>" alt="Product Image"
                                         class="w-16 h-16 object-cover">
                                </td>
                                <td class="px-6 py-4">
                                    <?= $product['productName'] ?>
                                </td>
                                <td class="px-6 py-4">
                                    <?= $product['catID'] ?>
                                </td>
                                <td class="px-6 py-4">
                                    <?= $product['productPrice'] ?> Ks
                                </td>
                                <td class="px-6 py-4">
                                    <?= $product['instockQty'] ?>
                                </td>
                                <td class="px-6 py-4 ">
                                    <div class="flex justify-center items-center gap-x-2">
                                    <a href="product_detail_view.php?proID=<?= $product['productID'] ?>"
                                           class="font-medium text-blue-600 hover:underline">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <a href="product_update.php?proID=<?= $product['productID'] ?>"
                                           class="font-medium text-blue-600 hover:underline">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <div class="cursor-pointer">
                                        <button type="button" onclick="setAndToggleAlert('<?php echo $product['productID']; ?>')" class="text-red-600 hover:underline cursor-pointer">
                                            <i class="fas fa-trash text-red-600"></i>
                                        </button>

                                        </div>
                                    </div>
                                </td>
                        
                        </tr>
                    <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
            <!-- Product list end  -->
        </article>
        <!-- Product list content end  -->
    </section>
</main>

<footer>
</footer>
<script>

// Function to set product ID and toggle the delete alert
function setAndToggleAlert(proID) {
    document.getElementById('delete_pro_id_input').value = proID;
    toggleAlert('delete_alert', 'show');
}
</script>
<script src="app.js"></script>

</body>
</html>


