<?php
    require_once("../database/db_connect.php");

   // print_r($pdo);

    $table = "orders";
    $tablecreate = "CREATE TABLE IF NOT EXISTS $table(
    orderID INT PRIMARY KEY AUTO_INCREMENT,
    userID INT,
    orderDate TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    totalPrice DECIMAL(10, 2),
    Address VARCHAR (500),
    PaymentType VARCHAR (50),
    FOREIGN KEY (userID) REFERENCES Users(userID)
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