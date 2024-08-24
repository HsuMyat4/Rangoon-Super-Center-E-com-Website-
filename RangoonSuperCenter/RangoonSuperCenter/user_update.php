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

        // Check if the form is submitted using POST
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Validate and sanitize user inputs
            $userName = htmlspecialchars(trim($_POST['userName']));
            $userEmail = htmlspecialchars(trim($_POST['userEmail']));
            $gender = htmlspecialchars(trim($_POST['gender']));
            $userType = htmlspecialchars(trim($_POST['userType']));

            // Perform validation (you can add more validation as needed)
            if (empty($userName) || empty($userEmail) || empty($gender) || empty($userType)) {
                $errorMessage = "All fields are required.";
            } elseif (!filter_var($userEmail, FILTER_VALIDATE_EMAIL)) {
                $errorMessage = "Invalid email address.";
            } else {
                // Update user data in the database
                $updateSql = "UPDATE users 
                              SET userName = :userName, userEmail = :userEmail, gender = :gender, userType = :userType 
                              WHERE userID = :userId";

                $updateStmt = $pdo->prepare($updateSql);
                $updateStmt->bindParam(':userName', $userName, PDO::PARAM_STR);
                $updateStmt->bindParam(':userEmail', $userEmail, PDO::PARAM_STR);
                $updateStmt->bindParam(':gender', $gender, PDO::PARAM_STR);
                $updateStmt->bindParam(':userType', $userType, PDO::PARAM_STR);
                $updateStmt->bindParam(':userId', $userId, PDO::PARAM_INT);

                if ($updateStmt->execute()) {
                    header("Location: user_list.php?success=update");
                    exit();
                } else {
                    $errorMessage = "User update failed: " . implode(", ", $updateStmt->errorInfo());
                }
            }
        }
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
    <title>Update User</title>
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
            <a class="text-blue-500 " href="user_list.php">
                <i class="fas fa-arrow-left"></i>
            </a>

            <article class="flex justify-center items-center">
                <?php if (isset($errorMessage)): ?>
                    <div class="bg-red-200 text-red-700 py-2 px-4 mt-4 mb-4 rounded-md">
                        <?= $errorMessage ?>
                    </div>
                <?php else: ?>
                    <form action="user_update.php?userID=<?= $userId ?>" method="POST" class="border-slate-300 border shadow-xl rounded-xl p-5 w-[500px] overflow-hidden">
                        <h1 class="text-center text-3xl text-blue-500 font-bold">
                            Update User
                        </h1>

                        <div class="mt-5">
                            <label for="userName" class="block text-md">
                                User Name
                            </label>
                            <input type="text" id="userName" name="userName" value="<?= $user['userName'] ?>" class="w-full mt-1 text-slate-800 bg-slate-50 border-blue-500 border rounded-lg px-3 py-1 focus:outline-blue-500 focus:border-blue-500 focus:ring-blue-500">
                        </div>

                        <div class="mt-5">
                            <label for="userEmail" class="block text-md">
                                Email
                            </label>
                            <input type="email" id="userEmail" name="userEmail" value="<?= $user['userEmail'] ?>" class="w-full mt-1 text-slate-800 bg-slate-50 border-blue-500 border rounded-lg px-3 py-1 focus:outline-blue-500 focus:border-blue-500 focus:ring-blue-500">
                        </div>

                        <div class="mt-5">
                            <label for="gender" class="block text-md">
                                Gender
                            </label>
                            <select id="gender" name="gender" class="w-full mt-1 text-slate-800 bg-slate-50 border-blue-500 border rounded-lg px-3 py-1 focus:outline-blue-500 focus:border-blue-500 focus:ring-blue-500">
                                <option value="M" <?= ($user['gender'] === 'M') ? 'selected' : '' ?>>Male</option>
                                <option value="F" <?= ($user['gender'] === 'F') ? 'selected' : '' ?>>Female</option>
                            </select>
                        </div>

                        <div class="mt-5">
                            <label for="userType" class="block text-md">
                                User Type
                            </label>
                            <select id="userType" name="userType" class="w-full mt-1 text-slate-800 bg-slate-50 border-blue-500 border rounded-lg px-3 py-1 focus:outline-blue-500 focus:border-blue-500 focus:ring-blue-500">
                                <option value="Admin" <?= ($user['userType'] === 'Admin') ? 'selected' : '' ?>>Admin</option>
                                <option value="User" <?= ($user['userType'] === 'User') ? 'selected' : '' ?>>User</option>
                            </select>
                        </div>

                        <div class="flex justify-end mt-5">
                            <div class="">
                                <button type="submit" name="edit" class="bg-blue-500 duration hover:bg-blue-600 px-2 py-1 rounded-lg text-white text-center text-md">
                                    <i class="fa-solid fa-pencil"></i>
                                    Update
                                </button>
                            </div>
                        </div>
                    </form>
                <?php endif; ?>
            </article>
        </section>
    </main>

    <footer>
        <!-- Footer content goes here -->
    </footer>
</body>
</html>
