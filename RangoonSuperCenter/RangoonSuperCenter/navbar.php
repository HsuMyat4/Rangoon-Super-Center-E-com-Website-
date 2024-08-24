<?php
session_start(); // Start or resume the session
require_once("database/db_connect.php");

$loggedInUser = isset($_SESSION['username']) ? $_SESSION['username'] : null;
?>

<!DOCTYPE html>
<html lang="en">

<head>
<meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <!-- Tailwind css link  -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Fontawesome link  -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    <style>
        @import url('https://fonts.googleapis.com/css2?family=Open+Sans:wght@300;500;700;800&family=Roboto:wght@100;300;400;500;700&display=swap');
        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500&family=Salsa&display=swap');

        *{
            font-family: 'Open Sans', sans-serif;
            font-family: 'Roboto', sans-serif;
        }

        .font-salsa{
            font-family: 'Poppins', sans-serif;
            font-family: 'Salsa', cursive;
        }
    </style>
</head>

<body class="font-sans flex">
    <main class="w-full m-[120px]">
        <header class="flex justify-between items-center border-slate-300 py-3 shadow-md w-[85%] px-5 bg-white fixed top-0 right-0 z-20">
            <!-- Logo Section start -->
            <section>
                <h1 class="text-blue-500 text-3xl font-bold font-salsa opacity-[0.95]" style="text-shadow:2px 2px 5px rgb(191 219 254);">
                    Rangoon 
                    <span class="text-slate-800 block ml-5 -mt-[15px] opacity-[0.95] font-salsa " >
                        Supercenter
                    </span>
                </h1>
            </section>
            <!-- Logo Section end -->

            <!-- Account Section start -->
            <section class="flex items-center gap-x-4 ml-auto">




                        <form action="logout.php" method="post">
                            <button type="submit" name="logout" class="btn btn-outline-danger">Logout</button>
                        </form>


                         
 
            </section>
            <!-- Account Section end -->
        </header>
    </main>
</body>

</html>
