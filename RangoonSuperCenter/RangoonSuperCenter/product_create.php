<?php

require_once("database/db_connect.php"); // Include the file where you establish the PDO connection

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    try {
        // Check if 'pImg' is set in the $_FILES array
        if (isset($_FILES['pImg'])) {
            $imageName = $_FILES['pImg']['name'];
            $imageTmpName = $_FILES['pImg']['tmp_name'];
            $productImg = "images/" . $imageName;

            move_uploaded_file($imageTmpName, $productImg);

            $name = $_POST['pName'];
            $category = $_POST['category'];
            $price = $_POST['pPrice'];
            $instock = $_POST['instock'];

            // Assuming $pdo is your PDO connection object
            $insert_sql = "INSERT INTO products (productImg, productName, productPrice, instockQty, catID) 
            VALUES (:productImg, :name, :price, :instock, :catID)";
            $stmt = $pdo->prepare($insert_sql);
            $stmt->bindParam(':productImg', $productImg, PDO::PARAM_STR);
            $stmt->bindParam(':name', $name, PDO::PARAM_STR);
            $stmt->bindParam(':price', $price, PDO::PARAM_INT);
            $stmt->bindParam(':instock', $instock, PDO::PARAM_INT);
            $stmt->bindParam(':catID', $category, PDO::PARAM_INT);

            $stmt->execute();

            header("Location: product_list.php?success=ok");
            exit();
        } else {
            echo "File 'pImg' not uploaded.";
        }
    } catch (Exception $e) {
        echo $e->getMessage();
    }
}
?>






<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <!-- Tailwind css link  -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Fontawesome link  -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    <style>
        @import url('https://fonts.googleapis.com/css2?family=Open+Sans:wght@300;500;700;800&family=Roboto:wght@100;300;400;500;700&display=swap');

        *{
            font-family: 'Open Sans', sans-serif;
            font-family: 'Roboto', sans-serif;
        }
    </style>

</head>
<body class="font-sans flex ">
<?php require_once ("aside.php"); ?>

    <main class="w-full pl-[15%]">
 <?php require_once ("navbar.php"); ?>

        <section class="px-10 mt-10">

            <!-- update category start  -->
            <article class="flex justify-center items-center">
                <form action="" method="post" enctype="multipart/form-data" class="border-slate-300 border shadow-xl rounded-xl p-8 w-[400px] overflow-hidden" >
               
                    <h1 class="text-center text-3xl text-blue-500 font-bold">
                        Product
                    </h1>

                    
                    <!-- Product Image start  -->
                    <div class="">
                        <div class="flex justify-center items-center rounded-xl overflow-hidden shadow-xl w-full h-[200px] object-contain">
                            <img class="w-full object-contain" id="previewImg" src="#">
                        </div>
                        <input type="file" class="form-control" id="pImg" name="pImg" accept="image/*" required onchange="previewFile()" class="mt-3">
                    </div>
                    <!-- Product Image end  -->
                    
                    <!-- Product Name start  -->
                    <div class="mt-5">
                        <label for="pName" class="block text-md ">
                            Name
                        </label>
                        <input type="text" id="pName"  name="pName" required placeholder="Name..." class="w-full mt-1 text-slate-800 bg-slate-50 border-blue-500 border rounded-lg px-3 py-1 focus:outline-blue-500 focus:border-blue-500 focus:ring-blue-500" >
                    </div>
                    <!-- Product Name end  -->

                    

                     <!-- Product Categoroy start  -->
                    <div class="mt-5">
                        <label for="category" class="block text-md ">
                            Category
                        </label>
                        <select id="category" name="category" class="w-full mt-1 text-slate-800 bg-slate-50 border-blue-500 border rounded-lg px-3 py-1 focus:outline-blue-500 focus:border-blue-500 focus:ring-blue-500">


                        <?php
                                $categoryQuery = "SELECT catID, catName FROM categories";
                                $categories = $pdo->query($categoryQuery);
                                foreach ($categories as $category) {
                                    echo "<option value='" . $category['catID'] . "'>" . $category['catName'] . "</option>";
                                }
                                ?>
                    </select>
                    </div>
                    <!-- Product Category end  -->

                    <!-- Product Price start  -->
                    <div class="mt-5">
                        <label for="pPrice" class="block text-md ">
                         Price
                        </label>
                        <input type="number" id="pPrice"  name="pPrice" required step="0.01" class="w-full mt-1 text-slate-800 bg-slate-50 border-blue-500 border rounded-lg px-3 py-1 focus:outline-blue-500 focus:border-blue-500 focus:ring-blue-500">
                    </div>
                    <!-- Product Price end  -->

                    <!-- Product Instock start  -->
                        <div class="mt-5">
                        <label for="instock" class="block text-md ">
                        Instock Qty
                        </label>
                        <input type="number" id="instock"  name="instock" required class="w-full mt-1 text-slate-800 bg-slate-50 border-blue-500 border rounded-lg px-3 py-1 focus:outline-blue-500 focus:border-blue-500 focus:ring-blue-500">
                    </div>
                    <!-- Product Instock end  -->

                    <div class="flex justify-end mt-5">
                        <div class="">
                            <button type="submit" name="create" class=" bg-blue-500 duaration hover:bg-blue-600 px-2 py-1 rounded-lg text-white text-center text-sm">
                            <i class="fa-solid fa-plus"></i>
                                Create
                            </button>
 
                    
                        </div>
                    </div>
                </form>
            </article>
            <!-- update category end  -->
        </section>
    </main>

    <footer>

    </footer>
</body>
<script src="app.js"></script>

<script>
        function previewFile() {
            var preview = document.getElementById('previewImg');
            var fileInput = document.getElementById('pImg');
            var file = fileInput.files[0];
            var reader = new FileReader();

            reader.onloadend = function () {
                preview.src = reader.result;
            };

            if (file) {
                reader.readAsDataURL(file);
            } else {
                preview.src = '';
            }
        }
    </script>
</html>