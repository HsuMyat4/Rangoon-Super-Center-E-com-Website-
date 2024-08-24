<?php
    require_once("../database/db_connect.php");

   // print_r($pdo);

    $table = "orderLine";
    $tablecreate = "CREATE TABLE IF NOT EXISTS $table(
    orderlineID INT PRIMARY KEY AUTO_INCREMENT,
    orderID INT,
    productID INT,
    quantity INT,
    FOREIGN KEY (orderID) REFERENCES Orders(orderID),
    FOREIGN KEY (productID) REFERENCES Products(productID)
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