<?php
require_once("database/db_connect.php");

// Check if the form is submitted using POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Validate and sanitize user inputs
    $userName = htmlspecialchars(trim($_POST['userName']));
    $userEmail = htmlspecialchars(trim($_POST['userEmail']));
    $userPass = $_POST['userPass']; // Get password as plain text for hashing
    $userCPass = $_POST['userCPass']; // Get confirm password as plain text for comparison
    $gender = htmlspecialchars(trim($_POST['gender']));
    $userType = htmlspecialchars(trim($_POST['userType']));

    // Perform validation (you can add more validation as needed)
    if (empty($userName) || empty($userEmail) || empty($userPass) || empty($userCPass) || empty($gender) || empty($userType)) {
        $errorMessage = "All fields are required.";
    } elseif (!filter_var($userEmail, FILTER_VALIDATE_EMAIL)) {
        $errorMessage = "Invalid email address.";
    } elseif ($userPass !== $userCPass) {
        $errorMessage = "Passwords do not match.";
    } else {
        // Hash the password
        $hashedPassword = password_hash($userPass, PASSWORD_DEFAULT);

        // Insert user data into the database
        $insertSql = "INSERT INTO users (userName, userEmail, userPass, gender, userType) 
                      VALUES (:userName, :userEmail, :userPass, :gender, :userType)";
        
        $insertStmt = $pdo->prepare($insertSql);
        $insertStmt->bindParam(':userName', $userName, PDO::PARAM_STR);
        $insertStmt->bindParam(':userEmail', $userEmail, PDO::PARAM_STR);
        $insertStmt->bindParam(':userPass', $hashedPassword, PDO::PARAM_STR); // Use hashed password
        $insertStmt->bindParam(':gender', $gender, PDO::PARAM_STR);
        $insertStmt->bindParam(':userType', $userType, PDO::PARAM_STR);

        if ($insertStmt->execute()) {
            header("Location: user_list.php?success=create");
            exit();
        } else {
            $errorMessage = "User creation failed: " . implode(", ", $insertStmt->errorInfo());
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create User</title>
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
                <form action="user_create.php" method="POST" class="border-slate-300 border shadow-xl rounded-xl p-5 w-[500px] overflow-hidden">
                    <h1 class="text-center text-3xl text-blue-500 font-bold">
                        Create User
                    </h1>

                    <?php if (isset($errorMessage)): ?>
                        <div class="bg-red-200 text-red-700 py-2 px-4 mt-4 mb-4 rounded-md">
                            <?= $errorMessage ?>
                        </div>
                    <?php endif; ?>

                    <div class="mt-5">
                        <label for="userName" class="block text-md">
                            User Name
                        </label>
                        <input type="text" id="userName" name="userName" class="w-full mt-1 text-slate-800 bg-slate-50 border-blue-500 border rounded-lg px-3 py-1 focus:outline-blue-500 focus:border-blue-500 focus:ring-blue-500">
                    </div>

                    <div class="mt-5">
                        <label for="userEmail" class="block text-md">
                            Email
                        </label>
                        <input type="email" id="userEmail" name="userEmail" class="w-full mt-1 text-slate-800 bg-slate-50 border-blue-500 border rounded-lg px-3 py-1 focus:outline-blue-500 focus:border-blue-500 focus:ring-blue-500">
                    </div>

                    <div class="mt-5">
                        <label for="userPass" class="block text-md">
                            Password
                        </label>
                        <input type="password" id="userPass" name="userPass" class="w-full mt-1 text-slate-800 bg-slate-50 border-blue-500 border rounded-lg px-3 py-1 focus:outline-blue-500 focus:border-blue-500 focus:ring-blue-500">
                    </div>

                    <div class="mt-5">
                        <label for="userPass" class="block text-md">
                            Confirm Password
                        </label>
                        <input type="password" id="userCPass" name="userCPass" class="w-full mt-1 text-slate-800 bg-slate-50 border-blue-500 border rounded-lg px-3 py-1 focus:outline-blue-500 focus:border-blue-500 focus:ring-blue-500">
                    </div>

                    <div class="mt-5">
                        <label for="gender" class="block text-md">
                            Gender
                        </label>
                        <select id="gender" name="gender" class="w-full mt-1 text-slate-800 bg-slate-50 border-blue-500 border rounded-lg px-3 py-1 focus:outline-blue-500 focus:border-blue-500 focus:ring-blue-500">
                            <option value="M">Male</option>
                            <option value="F">Female</option>
                        </select>
                    </div>

                    <div class="mt-5">
                        <label for="userType" class="block text-md">
                            User Type
                        </label>
                        <select id="userType" name="userType" class="w-full mt-1 text-slate-800 bg-slate-50 border-blue-500 border rounded-lg px-3 py-1 focus:outline-blue-500 focus:border-blue-500 focus:ring-blue-500">
                            <option value="Admin">Admin</option>
                            <option value="User">User</option>
                        </select>
                    </div>

                    <div class="flex justify-end mt-5">
                        <div class="">
                            <button type="submit" name="create" class="bg-blue-500 duration hover:bg-blue-600 px-2 py-1 rounded-lg text-white text-center text-md">
                                <i class="fa-solid fa-plus"></i>
                                Create
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
</body>
</html>
