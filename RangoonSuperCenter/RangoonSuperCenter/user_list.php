<?php
require_once("database/db_connect.php");

// Fetch users from the database
$query = "SELECT * FROM users";
$result = $pdo->query($query);

// Check if there are any users
if ($result->rowCount() > 0) {
    $users = $result->fetchAll(PDO::FETCH_ASSOC);
} else {
    $users = [];
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
<body class="font-sans flex ">
<?php
require_once("aside.php");
?>

<main class="w-full pl-[15%]">
    <?php
    require_once("navbar.php");
    ?>

        <section class="px-10 mt-10">

            <!-- user list content start  -->
            <article class="">
            <!-- start delete alert -->
            <div id="delete_alert" class="absolute top-32 left-1/2 transform -translate-x-1/2 -translate-y-[350px] duration-300 opacity-0 bg-slate-100 shadow-lg rounded-lg p-8 z-30">
                <form method="post" action="user_delete.php">
                    <input type="hidden" name="userID" id="delete_user_id_input" value="">
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

                    <!-- Add user start  -->
                    <div class="flex items-center gap-x-2"> 
                        <a href="user_create.php" class="bg-red-500 text-white flex justify-center items-center rounded-lg px-3 py-2 shadow-lg">
                            Add User
                        </a>
                    </div>
                    <!-- Add user end  -->
                </div>


                <!-- user list start  -->
                <div class="relative overflow-x-auto shadow-md sm:rounded-lg mt-10 ">
                    <table class="w-full text-sm text-left rtl:text-right ">
                        <thead class="text-xs text-gray-700 uppercase bg-gray-50 ">
                            <tr>
                                <th scope="col" class="px-3 py-3">
                                    User ID
                                </th>
                                <th scope="col" class="px-3 py-3">
                                    User Name
                                </th>
                                <th scope="col" class="px-3 py-3">
                                    Email
                                </th>

                                <th scope="col" class="px-3 py-3">
                                    Role
                                </th>
                                <th scope="col" class="px-3 py-3">
                                    Action
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php foreach ($users as $user): ?>
                            <tr class="  border-b ">
                                <!-- <th scope="row" class="px-3 py-4 font-medium text-gray-900 whitespace-nowrap ">
                                    <div class="rounded-lg shadow-lg w-[150px] h-[100px] overflow-hidden">
                                        <img class="w-full object" src="https://images.unsplash.com/photo-1542291026-7eec264c27ff?q=80&w=1000&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxzZWFyY2h8Mnx8c2hvZXN8ZW58MHx8MHx8fDA%3Dy" alt="">
                                    </div>
                                </th> -->
                                <th class="px-3 py-4">
                                <?= $user['userID'] ?>
                                </th>


                                <td class="px-3 py-4">
                                    <?= $user['userName'] ?>
                                </td>
                                <td class="px-3 py-4">
                                    <?= $user['userEmail'] ?>
                                </td>
                                <td class="px-3 py-4">
                                    <?= $user['userType'] ?>
                                </td>


                                <td class="px-3 py-4 ">
                                    <div class="flex  items-center gap-x-4 w-full">
                                    <a href="user_detail_view.php?userID=<?= $user['userID'] ?>" class="font-medium text-blue-600 hover:underline">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="user_update.php?userID=<?= $user['userID'] ?>" class="font-medium text-blue-600 hover:underline">
                                        <i class="fas fa-edit"></i>
                                    </a>
    
                                    <div class="cursor-pointer">
                                        <!-- Modified: Moved the form inside the loop -->
                                        <button type="button" onclick="setAndToggleAlert('<?php echo $user['userID']; ?>')" class="text-red-600 hover:underline cursor-pointer">
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
                <!-- user list end  -->


            </article>
 
        </section>
    </main>

    <footer>

    </footer>
    <script>
        function setAndToggleAlert(userID) {
        // Set the user ID in the hidden input field
        document.getElementById('delete_user_id_input').value = userID;
        // Show the delete confirmation alert
        toggleAlert('delete_alert', 'show');
    }
</script>
<script src="app.js"></script>
</body>

</html>