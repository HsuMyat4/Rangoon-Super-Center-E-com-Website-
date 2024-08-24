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

// Initialize variables with product details
$product_name = $product['productName'];
$product_price = $product['productPrice'];
$product_instock = $product['instockQty'];
$product_category = $product['catID'];

// Check if the form is submitted using POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Update variables with new values from the form
    $productName = $_POST['proName'];
    $productPrice = $_POST['proPrice'];
    $productInstock = $_POST['proInstock'];
    $productCategory = $_POST['proCategory'];

    // Check if a new image file is uploaded
    if (!empty($_FILES['proImage']['name'])) {
        $imageName = $_FILES['proImage']['name'];
        $imageTmpName = $_FILES['proImage']['tmp_name'];
        $productImg = "images/" . $imageName;

        // Move the uploaded image file to the destination
        move_uploaded_file($imageTmpName, $productImg);

        // Update the productImg column in the database
        $updateImgSql = "UPDATE products SET productImg = :productImg WHERE productID = :productID";
        $updateImgStmt = $pdo->prepare($updateImgSql);
        $updateImgStmt->bindParam(':productImg', $productImg, PDO::PARAM_STR);
        $updateImgStmt->bindParam(':productID', $productID, PDO::PARAM_INT);
        $updateImgStmt->execute();
    }

    // SQL query to update product details in the database
    $updateSql = "UPDATE products SET productName = :productName, catID = :productCat, productPrice = :productPrice, instockQty = :productStock WHERE productID = :productID";

 

    $updateStmt = $pdo->prepare($updateSql);
    $updateStmt->bindParam(':productName', $productName, PDO::PARAM_STR);
    $updateStmt->bindParam(':productCat', $productCategory, PDO::PARAM_INT);
    $updateStmt->bindParam(':productPrice', $productPrice, PDO::PARAM_INT);
    $updateStmt->bindParam(':productStock', $productInstock, PDO::PARAM_INT);
    $updateStmt->bindParam(':productID', $productID, PDO::PARAM_INT);

    // Redirect to product_edit.php with success parameter if update is successful, otherwise display an error message
    if ($updateStmt->execute()) {
        header("Location: product_list.php?success=true");
        exit();
    } else {
        $errorMessage = "Update failed: " . implode(", ", $updateStmt->errorInfo());
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <script src="https://cdn.tailwindcss.com"></script>
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
        
        <section class="px-10 mt-5">
            <a class="text-blue-500 " href="product_list.php">
                <i class="fas fa-arrow-left"></i>
            </a>

            <article class="flex justify-center items-center">
                <form action="product_update.php?proID=<?= $productID ?>" method="POST" id="productForm" enctype="multipart/form-data" class="border-slate-300 border shadow-xl rounded-xl p-5 w-[500px] overflow-hidden">
                    <h1 class="text-center text-3xl text-blue-500 font-bold">
                        Product
                    </h1>

                    <div class="mt-5">
                        <label for="id" class="block text-md ">
                            Product ID
                        </label>
                        <input type="text" id="productID" value="<?= $productID ?>" name="proID" readonly class="w-full mt-1 text-slate-800 bg-slate-50 border-blue-500 border rounded-lg px-3 py-1 focus:outline-blue-500 focus:border-blue-500 focus:ring-blue-500" >
                    </div>

                    <div class="">
                        <div class="flex justify-center items-center rounded-xl overflow-hidden shadow-xl w-full h-[200px] object-contain">
                            <img id="previewImage" src="<?= $product['productImg'] ?>" alt="<?= $product['productName'] ?>" class="w-full object-contain">
                        </div>
                        
                        <input type="file" id="proImage" name="proImage" onchange="previewFile()" class="mt-3">
                    </div>

                    <div class="mt-5">
                        <label for="pName" class="block text-md ">
                            Name
                        </label>
                        <input type="text" id="productName" value="<?= $product_name ?>" name="proName" class="w-full mt-1 text-slate-800 bg-slate-50 border-blue-500 border rounded-lg px-3 py-1 focus:outline-blue-500 focus:border-blue-500 focus:ring-blue-500" >
                    </div>

                    <div class="mt-5">
                        <label for="category" class="block text-md ">
                            Category
                        </label>
                        <select id="category" name="proCategory" class="w-full mt-1 text-slate-800 bg-slate-50 border-blue-500 border rounded-lg px-3 py-1 focus:outline-blue-500 focus:border-blue-500 focus:ring-blue-500">
                            <?php
                                $categoryQuery = "SELECT catID, catName FROM categories";
                                $categories = $pdo->query($categoryQuery);
                                foreach ($categories as $category) {
                                    $selected = ($category['catID'] == $product_category) ? 'selected' : '';
                                    echo "<option value='" . $category['catID'] . "' $selected>" . $category['catName'] . "</option>";
                                }
                            ?>
                        </select>
                    </div>

                    <div class="mt-5">
                        <label for="pPrice" class="block text-md ">
                            Price
                        </label>
                        <input type="number" id="productPrice" value="<?= $product_price ?>" name="proPrice" step="0.01" class="w-full mt-1 text-slate-800 bg-slate-50 border-blue-500 border rounded-lg px-3 py-1 focus:outline-blue-500 focus:border-blue-500 focus:ring-blue-500">
                    </div>

                    <div class="mt-5">
                        <label for="instock" class="block text-md ">
                            Instock Qty
                        </label>
                        <input type="number" id="instockQty" value="<?= $product_instock ?>" name="proInstock" class="w-full mt-1 text-slate-800 bg-slate-50 border-blue-500 border rounded-lg px-3 py-1 focus:outline-blue-500 focus:border-blue-500 focus:ring-blue-500">
                    </div>



                    <div class="flex justify-end mt-5">
                        <div class="">
                            <button type="submit" name="update" class="bg-blue-500 duration hover:bg-blue-600 px-2 py-1 rounded-lg text-white text-center text-md">
                                <i class="fa-solid fa-arrows-rotate"></i>
                                Change
                            </button>
                        </div>
                    </div>
                </form>
            </article>
        </section>
    </main>

    <footer>
        <!-- Footer content goes here -->
    </footer>

    <script>
        function previewFile() {
            var preview = document.getElementById('previewImage');
            var fileInput = document.getElementById('proImage');
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
</body>
</html>
