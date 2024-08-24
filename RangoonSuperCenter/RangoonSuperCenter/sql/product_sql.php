<?php
    require_once("../database/db_connect.php");

   // print_r($pdo);

    $table = "products";
    $tablecreate = "CREATE TABLE IF NOT EXISTS $table(
    productID INT PRIMARY KEY AUTO_INCREMENT,
    productImg VARCHAR(255),
    productName VARCHAR(255) NOT NULL,
    productPrice DECIMAL(10, 2) NOT NULL,
    instockQty INT,
    catID INT,
    FOREIGN KEY (catID) REFERENCES Categories(catID)
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