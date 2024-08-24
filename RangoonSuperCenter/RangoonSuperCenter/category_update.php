<?php
require_once("database/db_connect.php");

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["new_category"])) {
    $newCategory = $_POST["new_category"];

    // Validate and sanitize input if needed

    try {
        $categoryId = $_GET["catID"];  // Assuming you are passing the catID through the URL

        // Update category name in the database
        $stmt = $pdo->prepare("UPDATE categories SET catName = :newCategory WHERE catID = :categoryId");
        $stmt->bindParam(':newCategory', $newCategory);
        $stmt->bindParam(':categoryId', $categoryId);
        $stmt->execute();

        // Redirect to category_list.php after successful deletion
        echo "Category Updated Successfully";
        header("Location: category_list.php");
         exit();
        
    } catch (Exception $e) {
        echo "Error updating category: " . $e->getMessage();
    }
}

// Fetch the existing category name for display
if (isset($_GET["catID"])) {
    $categoryId = $_GET["catID"];
    $stmt = $pdo->prepare("SELECT catName FROM categories WHERE catID = :categoryId");
    $stmt->bindParam(':categoryId', $categoryId);
    $stmt->execute();

    // Fetch the result and handle if the category is not found
    $category = $stmt->fetch(PDO::FETCH_ASSOC);
    if (!$category) {
        echo "Category not found. catID: " . $categoryId;
        exit();
    }
} else {
    // Handle the case when catID is not provided in the URL
    echo "Category ID not provided.";
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - Edit Category</title>
    <!-- Tailwind CSS link -->
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <!-- Fontawesome link -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Open+Sans:wght@300;500;700;800&family=Roboto:wght@100;300;400;500;700&display=swap');
        * {
            font-family: 'Open Sans', 'Roboto', sans-serif;
        }
    </style>
</head>
<body class="font-sans flex">
    <?php require_once("aside.php"); ?>
    <main class="w-full pl-[15%]">
        <?php require_once("navbar.php"); ?>

        <section class="px-4 sm:px-10 mt-10">
            <!-- update category start -->
            <article class="flex justify-center items-center">
                <form action="category_update.php?catID=<?php echo $categoryId; ?>" method="post" class="border-slate-300 border shadow-xl rounded-xl p-8 w-full max-w-md">
                    <label for="category" class="block text-lg font-bold mb-2">
                        Category
                    </label>
                    <input class="w-full text-slate-800 bg-slate-50 border-blue-500 border rounded-lg px-3 py-1 focus:outline-blue-500 focus:border-blue-500 focus:ring-blue-500" type="text" name="new_category" value="<?php echo isset($category['catName']) ? $category['catName'] : ''; ?>" placeholder="Change category...">

                    <div class="flex justify-end mt-5">
                        <button type="submit" class="bg-blue-500 hover:bg-blue-600 px-4 py-2 rounded-lg text-white text-center text-sm">
                            <i class="fas fa-arrow-right"></i> Change
                        </button>
                    </div>
                </form>
            </article>
            <!-- update category end -->
        </section>
    </main>

    <footer></footer>
    <script src="app.js"></script>
</body>
</html>
