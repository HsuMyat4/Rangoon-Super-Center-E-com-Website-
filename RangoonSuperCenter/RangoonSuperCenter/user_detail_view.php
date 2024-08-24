<?php
require_once("database/db_connect.php");

// Check if the user ID is provided in the query parameters
if (isset($_GET['userID']) && !empty($_GET['userID'])) {
    $userId = $_GET['userID'];

    // Fetch user details from the database
    $selectSql = "SELECT * FROM users WHERE userID = :userId";
    $selectStmt = $pdo->prepare($selectSql);
    $selectStmt->bindParam(':userId', $userId, PDO::PARAM_INT);
    $selectStmt->execute();

    if ($selectStmt->rowCount() > 0) {
        $user = $selectStmt->fetch(PDO::FETCH_ASSOC);
    } else {
        $errorMessage = "User not found.";
    }
} else {
    $errorMessage = "User ID not provided.";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Details</title>
    <!-- Tailwind CSS link -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css">
    <!-- Fontawesome link -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>
<body class="font-sans flex">
    <?php require_once("aside.php"); ?>
    
    <main class="w-full pl-[15%]">
        <?php require_once("navbar.php"); ?>
        
        <section class="px-10 mt-5">
            <a class="text-blue-500" href="user_list.php">
                <i class="fas fa-arrow-left"></i> Back to User List
            </a>

            <article class="flex justify-center items-center">
                <?php if (isset($errorMessage)): ?>
                    <div class="bg-red-200 text-red-700 py-2 px-4 mt-4 mb-4 rounded-md">
                        <?= $errorMessage ?>
                    </div>
                <?php else: ?>
                    <div class="border-slate-300 border shadow-xl rounded-xl p-5 w-[500px]">
                        <h1 class="text-center text-3xl text-blue-500 font-bold">
                            User Details
                        </h1>

                        <div class="mt-5">
                            <label class="block text-md font-bold">
                                User ID
                            </label>
                            <p class="mt-1 text-slate-800"><?= $user['userID'] ?></p>
                        </div>

                        <div class="mt-3">
                            <label class="block text-md font-bold">
                                User Name
                            </label>
                            <p class="mt-1 text-slate-800"><?= $user['userName'] ?></p>
                        </div>

                        <div class="mt-3">
                            <label class="block text-md font-bold">
                                Email
                            </label>
                            <p class="mt-1 text-slate-800"><?= $user['userEmail'] ?></p>
                        </div>

                        <div class="mt-3">
                            <label class="block text-md font-bold">
                                Gender
                            </label>
                            <p class="mt-1 text-slate-800"><?= ($user['gender'] === 'M') ? 'Male' : 'Female' ?></p>
                        </div>

                        <div class="mt-3">
                            <label class="block text-md font-bold">
                                User Type
                            </label>
                            <p class="mt-1 text-slate-800"><?= $user['userType'] ?></p>
                        </div>
                    </div>
                <?php endif; ?>
            </article>
        </section>
    </main>

    <footer>
        <!-- Footer content goes here -->
    </footer>
</body>
</html>
