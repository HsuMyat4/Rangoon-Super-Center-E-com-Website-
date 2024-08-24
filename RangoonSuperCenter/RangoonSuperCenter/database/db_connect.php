<?php
$host = 'localhost';
$dhname = 'mysql';
$dbuser = 'root';
$password = '';
$createdb = 'rangoon_supercenter';

require_once( 'db_connection.php' );
$connection = new Connection( $host, $dhname, $dbuser, $password );
$pdo = $connection->getConnection();

if ( $pdo ) {
    // echo 'Connection OK';

    $create_db = "CREATE DATABASE IF NOT EXISTS $createdb";


    $pdo->exec  ( $create_db );
    //direct execute

    $pdo->exec ( "USE $createdb" );
    // switch database from mysql

}

// else {
//     echo 'Connection Fail';
// }
?>

<head>

<link href = 'https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css' rel = 'stylesheet' integrity = 'sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN'
crossorigin = 'anonymous'>

<link href = 'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css' rel = 'stylesheet'>

<script src = 'https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js' integrity = 'sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL' crossorigin = 'anonymous'></script>
</head>