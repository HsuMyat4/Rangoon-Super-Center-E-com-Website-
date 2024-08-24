<?php
require_once( 'database/db_connect.php' );
?>

<!DOCTYPE html>
<html lang = 'en'>
<head>
    <meta charset = 'UTF-8'>
    <meta name = 'viewport' content = 'width=device-width, initial-scale=1.0'>
    <title>Admin Dashboard</title>
    <!-- Tailwind css link  -->
    <script src = 'https://cdn.tailwindcss.com'></script>
    <!-- Fontawesome link  -->
    <link rel = 'stylesheet' href = 'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css' integrity = 'sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==' crossorigin = 'anonymous' referrerpolicy = 'no-referrer' />

        <style>
            @import url( 'https://fonts.googleapis.com/css2?family=Open+Sans:wght@300;500;700;800&family=Roboto:wght@100;300;400;500;700&display=swap' );
            @import url( 'https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500&family=Salsa&display=swap' );

* {
    font-family: 'Open Sans', sans-serif;
    font-family: 'Roboto', sans-serif;
}

.font-salsa {
    font-family: 'Poppins', sans-serif;
    font-family: 'Salsa', cursive;
}
</style>

</head>
    <body class = 'font-sans flex '>
        <aside class = 'bg-blue-500 w-[15%] min-h-[100vh] fixed'>
            <h1 class = 'text-white text-3xl text-center pt-10 placeholder:'>
                Admin Dashboard
            </h1>

        <div class = 'mt-20 flex flex-col gap-y-5 justify-center items-center px-3 '>
            <!-- for category list  -->
            <a href = 'category_list.php' class = 'w-full py-3 bg-blue-600 text-lg text-white rounded-md text-center duration-300 hover:bg-blue-700/80 text-decoration-none'>
                Category List
            </a>

            <!-- for Product list  -->
            <a href = 'product_list.php' class = 'w-full py-3 bg-blue-600 text-lg text-white rounded-md text-center duration-300 hover:bg-blue-700/80 text-decoration-none'>
                Product List
            </a>

            <!-- for User list  -->
            <a href = 'user_list.php' class = 'w-full py-3 bg-blue-600 text-lg text-white rounded-md text-center duration-300 hover:bg-blue-700/80 text-decoration-none'>
                User List
            </a>

            <!-- for Order list  -->
            <a href = 'order_list.php' class = 'w-full py-3 bg-blue-600 text-lg text-white rounded-md text-center duration-300 hover:bg-blue-700/80 text-decoration-none'>
                Order List
            </a>

    </div>
</aside>
</body>

