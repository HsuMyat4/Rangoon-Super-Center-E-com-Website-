<?php
session_start();

require_once("database/db_connect.php");

if (isset($_POST['login'])) {
    $userEmail = $_POST['userEmail'];
    $userPass = $_POST['userPass'];

    try {
        // Use prepared statements to prevent SQL injection
        $select = "SELECT * FROM users WHERE userEmail = :userEmail";
        $stmt = $pdo->prepare($select);
        $stmt->execute(['userEmail' => $userEmail]);

        if ($stmt->rowCount() > 0) {
            $user = $stmt->fetch(PDO::FETCH_ASSOC);

            // Verify the password
            if (password_verify($userPass, $user['userPass'])) {
                // Set the user's ID in the session
                $_SESSION['userID'] = $user['userID'];

                // Set the user's name in the session (optional)
                $_SESSION['username'] = $user['userName'];

                if ($user['userType'] === 'User') {
                    header('location: index.php');
                    exit();
                } elseif ($user['userType'] === 'Admin') {
                    header('location: category_list.php');
                    exit();
                } else {
                    // Handle other user types or show an error
                    $error[] = 'Invalid user type';
                }
            } else {
                $error[] = 'Incorrect password';
            }
        } else {
            $error[] = 'User does not exist';
        }
    } catch (PDOException $e) {
        // Handle database errors
        $error[] = 'Database error: ' . $e->getMessage();
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Form</title>

    <!-- Custom CSS file link -->
    <link rel="stylesheet" href="form.css">
</head>

<body>

    <div class="form-container">
        <form action="" method="post">
            <h3>Login</h3>
            <?php
            if (isset($error)) {
                foreach ($error as $error) {
                    echo '<span class="error-msg">' . $error . '</span>';
                }
            }
            ?>
            <p>Your Email<sup>*</sup></p>
            <input type="email" name="userEmail" required placeholder="Enter your email">
            <p>Password<sup>*</sup></p>
            <input type="password" name="userPass" required placeholder="Enter your password">

            <input type="submit" name="login" value="Login" class="form-btn">
            <p>Don't have an account? <a href="register_form.php">Register now</a></p>
        </form>
    </div>

</body>

</html>
