<?php
require_once("database/db_connect.php");

if (isset($_POST['submit'])) {
    $userName = $_POST['userName'];
    $userEmail = $_POST['userEmail'];
    $userPass = $_POST['userPass'];
    $userCpass = $_POST['userCpass'];
    $gender = $_POST['gender'];

    // Validate input
    $error = [];
    if (empty($userName) || empty($userEmail) || empty($userPass) || empty($userCpass) || empty($gender)) {
        $error[] = 'All fields are required.';
    }

    if (!filter_var($userEmail, FILTER_VALIDATE_EMAIL)) {
        $error[] = 'Invalid email address.';
    }

    if ($userPass !== $userCpass) {
        $error[] = 'Passwords do not match.';
    }

    if (empty($error)) {
        try {
            // Check if the user already exists
            $select = "SELECT * FROM users WHERE userEmail = :userEmail";
            $stmt = $pdo->prepare($select);
            $stmt->execute(['userEmail' => $userEmail]);

            if ($stmt->rowCount() > 0) {
                $error[] = 'User already exists!';
            } else {
                // Hash the password
                $hashedPassword = password_hash($userPass, PASSWORD_DEFAULT);

                // Insert user into the database
                $insert = "INSERT INTO users(userName, userEmail, userPass, gender, userType) VALUES(:userName, :userEmail, :userPass, :gender, :userType)";
                $stmt = $pdo->prepare($insert);
                $stmt->execute(['userName' => $userName, 'userEmail' => $userEmail, 'userPass' => $hashedPassword, 'gender' => $gender, 'userType' => 'User']);

                // Redirect to login page after successful registration

                header('location: login_form.php');
                exit();
            }
        } catch (PDOException $e) {
            // Handle database errors
            $error[] = 'Database error: ' . $e->getMessage();
        }
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register Form</title>

    <!-- Custom CSS file link -->
    <link rel="stylesheet" href="form.css">
</head>

<body>

    <div class="form-container">
        <form action="" method="post">
            <h3>Register Now</h3>
            <?php
            if (isset($error)) {
                foreach ($error as $error) {
                    echo '<span class="error-msg">' . $error . '</span>';
                };
            };
            ?>
            <p>Your Name<sup>*</sup></p>
            <input type="text" name="userName" required placeholder="Enter your name">
            <p>Your Email<sup>*</sup></p>
            <input type="email" name="userEmail" required placeholder="Enter your email">
            <p>Password<sup>*</sup></p>
            <input type="password" name="userPass" required placeholder="Enter your password">
            <p>Confirm Password<sup>*</sup></p>
            <input type="password" name="userCpass" required placeholder="Confirm your password">
            <p>Gender<sup>*</sup></p>
            <select name="gender">
                <option value="male">Male</option>
                <option value="female">Female</option>
            </select>

            <input type="submit" name="submit" value="Register Now" class="form-btn">
            <p>Already have an account? <a href="login_form.php">Login now</a></p>
        </form>
    </div>

</body>

</html>
