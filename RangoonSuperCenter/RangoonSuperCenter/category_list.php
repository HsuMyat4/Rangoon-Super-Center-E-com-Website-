<?php
// Your PDO connection
require_once("database/db_connect.php");

// Function to add a new category
function addCategory($catName, $pdo) {
    $stmt = $pdo->prepare("INSERT INTO categories (catName) VALUES (:catName)");
    $stmt->bindParam(':catName', $catName);
    $stmt->execute();
}

// Function to delete a category
function deleteCategory($catID, $pdo) {
    $stmt = $pdo->prepare("DELETE FROM categories WHERE catID = :catID");
    $stmt->bindParam(':catID', $catID);
    $stmt->execute();
}

// Check if the form is submitted for adding a category
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["add_category"])) {
    // Get category name from the form
    $newCategory = $_POST["category_name"];

    // Add the new category to the database
    addCategory($newCategory, $pdo);
}

// Check if the form is submitted for deleting a category
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["confirm_delete"])) {
    // Get the category ID from the form
    $catIDToDelete = $_POST["catID"];

    // Delete the category from the database
    deleteCategory($catIDToDelete, $pdo);
}

// Fetch all categories
$stmt = $pdo->query("SELECT * FROM categories");
$categories = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <!-- Tailwind CSS link  -->
    <!-- <link rel="stylesheet" href="./output.css"> -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Fontawesome link  -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    <style>
        @import url('https://fonts.googleapis.com/css2?family=Open+Sans:wght@300;500;700;800&family=Roboto:wght@100;300;400;500;700&display=swap');

        *{
            font-family: 'Open Sans', 'Roboto', sans-serif;
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
        <!-- Category list content start -->
        <article class="">
            <!-- start delete alert -->
            <div id="delete_alert" class="absolute top-32 left-1/2 transform -translate-x-1/2 -translate-y-[350px] duration-300 opacity-0 bg-slate-100 shadow-lg rounded-lg p-8 z-30">
                <form method="post" action="category_delete.php">
                    <input type="hidden" name="catID" id="delete_cat_id_input" value="">
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
                        <button onclick="toggleAlert('delete_alert', 'close')" type="button" class="bg-green-500 text-white text-md text-center rounded-lg shadow-lg hover:bg-green-600 duration-300 px-3 py-1">
                            No
                        </button>
                    </div>
                </form>
            </div>
            <!-- end delete alert -->

            <div class="flex justify-between items-center">
                <!-- create category start  -->
                <div class="flex items-center gap-x-2">
                    <form method="post" class="flex items-center gap-x-3">
                        <input type="text" name="category_name" class="text-slate-800 rounded-lg shadow-lg placeholder:text-slate-700 px-3 py-1 duration-300 text-lg ring-slate-300 border border-slate-300 outline-slate-300" placeholder="Create Category...">
                        <button type="submit" name="add_category" class="bg-red-500 text-white flex justify-center items-center rounded-lg px-3 py-2 shadow-lg">
                            Add
                        </button>
                    </form>
                </div>
                <!-- create category end  -->
            </div>
                

            <!-- Category list start  -->
            <div class="relative overflow-x-auto shadow-md sm:rounded-lg mt-10 ">
                <table class="w-full text-sm text-left rtl:text-right ">
                    <thead class="text-xs text-gray-700 uppercase bg-gray-50 ">
                    <tr>
                        <th scope="col" class="px-6 py-3">
                            Id
                        </th>
                        <th scope="col" class="px-6 py-3">
                            Category Name
                        </th>
                        <th scope="col" class="px-6 py-3">
                            Action
                        </th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php foreach ($categories as $category): ?>
                        <tr class="  border-b ">
                            <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap ">
                                <?php echo $category['catID']; ?>
                            </th>
                            <td class="px-6 py-4">
                                <?php echo $category['catName']; ?>
                            </td>
                            <td class="px-6 py-4 ">
                                <div class="flex items-center gap-x-2">
                                    <a href="category_update.php?catID=<?php echo $category['catID']; ?>" class="font-medium text-blue-600 hover:underline">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <div class="cursor-pointer">
                                        <!-- Modified: Moved the form inside the loop -->
                                        <button type="button" onclick="setAndToggleAlert('<?php echo $category['catID']; ?>')" class="text-red-600 hover:underline cursor-pointer">
                                            <i class="fas fa-trash text-red-600"></i>
                                        </button>
                                        <!-- End of modification -->
                                    </div>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
            <!-- Category list end  -->
        </article>
        <!-- Category list content end -->
    </section>
</main>

<footer>
</footer>

<script>
    function setAndToggleAlert(catID) {
        document.getElementById('delete_cat_id_input').value = catID;
        toggleAlert('delete_alert', 'show');
    }
</script>

<script src="app.js"></script>
</html>
