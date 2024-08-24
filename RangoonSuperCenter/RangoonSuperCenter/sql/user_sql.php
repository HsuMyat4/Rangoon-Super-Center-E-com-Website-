<?php
    require_once("../database/db_connect.php");

   // print_r($pdo);

    $table = "users";
    $tablecreate = "CREATE TABLE IF NOT EXISTS $table(
    userID INT PRIMARY KEY  AUTO_INCREMENT,
    userName VARCHAR(255) NOT NULL,
    userEmail VARCHAR(255) UNIQUE NOT NULL,
    userPass VARCHAR(255) NOT NULL,
    userCPass VARCHAR(255) NOT NULL,
    gender CHAR(1),
    userType VARCHAR(50)
    );
    ";



    try {
        $pdo-> exec($tablecreate);
        echo "$table created.";
    }
    catch (Exception $e) {
        echo $e->getMessage();
    }
?>