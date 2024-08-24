<?php
    require_once("../database/db_connect.php");

   // print_r($pdo);

    $table = "categories";
    $tablecreate = "CREATE TABLE IF NOT EXISTS $table(
    catID INT PRIMARY KEY AUTO_INCREMENT,
    catName VARCHAR(255) NOT NULL
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