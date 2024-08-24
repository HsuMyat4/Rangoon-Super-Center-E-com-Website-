<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once('database/db_connect.php');


$loggedInUser = isset($_SESSION['username']) ? $_SESSION['username'] : null;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rangoon Supercenter</title>

    <style>
        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500&family=Salsa&display=swap');

        /* Add your custom styles here */
        body {
            font-family: 'Arial', sans-serif;
            margin: 0;
            padding: 0;
        }

        .font-salsa{
            font-family: 'Poppins', sans-serif;
            font-family: 'Salsa', cursive;
        }

        nav {
            background-color: #f5f5f5;
            color: black;
            padding: 10px 20px;
        }

        nav .navbar-brand {
            font-size: 20px;
            font-weight: bold;
        }

        nav .navbar-toggler {
            background: none;
            border: none;
        }

        nav .navbar-toggler-icon {
            font-size: 20px;
        }

        nav .form-control {
            width: 250px;
            border-radius: 5px;
        }

        nav .btn-outline-success {
            margin-right: 10px;
        }

        nav .fa-cart-shopping {
            font-size: 2em;
        }

        nav .fs-5 {
            font-size: 12px;
            background-color: #28a745;
            border-radius: 50%;
            padding: 4px 6px;
            color: #fff;
            margin-left: 2px;
        }

        nav .dropdown-toggle {
            background: none;
            border: none;
            color: black;
            font-weight: bold;
        }

        nav .dropdown-menu {
            min-width: auto;
        }

        nav .dropdown-item {
            padding: 5px 10px;
            font-size: 14px;
        }

        nav .btn-outline-info {
            margin-left: 10px;
        }

        nav .ml-auto {
            margin-left: auto;
        }

        nav .me-3 {
            margin-right: 3rem;
        }

        nav .d-flex {
            align-items: center;
        }

        .text-blue-500 {
        color: #4299e1!important; /* Replace with the desired blue color code */
        }

        .text-3xl {
        font-size: 1.875rem; /* Adjust the font size as needed */
        }

        .font-bold {
        font-weight: bold;
        }

        .font-salsa {
        font-family: 'Salsa', sans-serif; /* Replace 'Salsa' with the desired font family */
        }

        .opacity-95{
        opacity: 0.95;
        }

        /* Applying text-shadow */
        .style-with-text-shadow {
        text-shadow: 2px 2px 5px rgb(191, 219, 254);
        }
    </style>
</head>
<body>

<nav class="navbar navbar-expand-lg bg-body-tertiary">
    <div class="container-fluid d-flex justify-content-between w-100">
    <a class="navbar-brand" href="index.php" style="margin-right:100px;">
            <span class="text-blue-500 text-3xl font-bold font-salsa opacity-95" style="text-shadow:2px 2px 5px rgb(191 219 254);" style="color: #4299e1;">
                Rangoon 
            </span>
            <br>
            <div class="" style="position:relative;"></div>
            <span class="font-salsa text-3xl font-bold opacity-95" style="margin-top:-15px!important;position:absolute;top:70px;margin-left:10px;">
                Supercenter
            </span>
        </a>



        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent"
            aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">

            <!-- Your search form or other navigation items -->
            <form class="d-flex pt-3 me-3" action="index.php" method="get">
                <input class="form-control me-2" style="width:200px;" type="search" placeholder="Search by name" name="search_name" aria-label="Search">
                <select class="form-control me-2" style="width:200px;" name="search_category">
                    <option value="">All Categories</option>
                    <?php
                    $category_sql = "SELECT * FROM categories";
                    $stmt = $pdo->query($category_sql);
                    $categories = $stmt->fetchAll(PDO::FETCH_ASSOC);
                    foreach ($categories as $category) {
                        echo "<option value='{$category['catID']}'>{$category['catName']}</option>";
                    }
                    ?>
                </select>
                <input class="form-control me-2" style="width:200px;" type="number" placeholder="Min" name="min_price">
                <input class="form-control me-2" style="width:200px;" type="number" placeholder="Max" name="max_price">
                <button class="btn btn-outline-success" type="submit">Search</button>
            </form>
        </div>

        <div class="w-auto">
                <div class="ml-auto d-flex" >
                    <div class="me-3">
                        <a href="Cart.php">
                            <i class="fa-solid fa-cart-shopping" alt="Shopping Cart"></i>
                        </a>
                        <?php
                        $qty = 0;
                        if (isset($_SESSION['cart'])) {
                            foreach ($_SESSION['cart'] as $key => $val) {
                                if (isset($_SESSION['cart'][$key]['qty'])) {
                                    $qty += $_SESSION['cart'][$key]['qty'];
                                }
                            }
                        }
                        ?>
                        <span><sup class="fs-5"><?= $qty ?></sup></span>
                    </div>
                    <div>
                        
                        <!-- Display the logged-in user's name -->
                            <div class="ml-auto">
                        <?php if (!$loggedInUser): ?>
                            <!-- Display login or register buttons -->
                            <a class="btn btn-outline-success" href="login_form.php">Sign In</a>
                            <a class="btn btn-outline-info" href="register_form.php">Sign Up</a>

                    <?php else: ?>
                         <!-- Display the logged-in user's name and Logout button -->
                        <span>Welcome, <?= $loggedInUser ?></span>
                        <form action="logout.php" method="post">
                            <button type="submit" name="logout" class="btn btn-outline-danger">Logout</button>
                        </form>
                    <?php endif; ?>
                            </div>
                 
                    </div>
                </div>
            </div>
    </div>
</nav>

</body>
</html>
