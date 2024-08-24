-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 17, 2024 at 02:57 AM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `rangoon_supercenter`
--

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `catID` int(11) NOT NULL,
  `catName` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`catID`, `catName`) VALUES
(4, 'Clothing'),
(5, 'Electronic'),
(6, 'Shoes'),
(10, 'Vegetable'),
(11, 'Accessories');

-- --------------------------------------------------------

--
-- Table structure for table `orderline`
--

CREATE TABLE `orderline` (
  `orderlineID` int(11) NOT NULL,
  `orderID` int(11) DEFAULT NULL,
  `productID` int(11) DEFAULT NULL,
  `quantity` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `orderline`
--

INSERT INTO `orderline` (`orderlineID`, `orderID`, `productID`, `quantity`) VALUES
(54, 27, 14, 1),
(55, 27, 15, 1),
(56, 27, 16, 1),
(57, 28, 15, 1),
(58, 28, 16, 1),
(59, 29, 14, 3),
(60, 29, 18, 2),
(61, 30, 14, 3),
(62, 30, 18, 2),
(63, 31, 18, 1),
(64, 32, 16, 1),
(65, 32, 15, 1),
(66, 33, 19, 1),
(67, 33, 16, 1);

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `orderID` int(11) NOT NULL,
  `userID` int(11) DEFAULT NULL,
  `orderDate` timestamp NOT NULL DEFAULT current_timestamp(),
  `totalPrice` decimal(10,2) DEFAULT NULL,
  `Address` varchar(500) DEFAULT NULL,
  `PaymentType` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`orderID`, `userID`, `orderDate`, `totalPrice`, `Address`, `PaymentType`) VALUES
(27, 9, '2024-01-14 09:05:35', 70000.00, 'Hlaing Tharyar', 'paypal'),
(28, 9, '2024-01-14 13:55:02', 40000.00, 'Pathein', 'wavepay'),
(29, 14, '2024-01-15 02:27:20', 110000.00, 'Heldan', 'wavepay'),
(30, 14, '2024-01-15 02:55:30', 110000.00, 'Heldan', 'wavepay'),
(31, 9, '2024-01-16 05:17:49', 10000.00, 'Heldan', 'credit'),
(32, 12, '2024-01-16 14:44:51', 40000.00, 'Yangon', 'wavepay'),
(33, 12, '2024-01-16 15:05:19', 60000.00, 'Pathein', 'paypal');

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `productID` int(11) NOT NULL,
  `productImg` varchar(255) DEFAULT NULL,
  `productName` varchar(255) NOT NULL,
  `productPrice` decimal(10,2) NOT NULL,
  `instockQty` int(11) DEFAULT NULL,
  `catID` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`productID`, `productImg`, `productName`, `productPrice`, `instockQty`, `catID`) VALUES
(14, 'images/shirt.png', 'Shirt', 30000.00, 20, 4),
(15, 'images/ElectricKettle.png', 'Kettle', 20000.00, 5, 5),
(16, 'images/Iron.PNG', 'Iron', 20000.00, 10, 5),
(18, 'images/summer.png', 'Dress', 10000.00, 20, 4),
(19, 'images/heels.png', 'High heel', 40000.00, 10, 6);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `userID` int(11) NOT NULL,
  `userName` varchar(255) NOT NULL,
  `userEmail` varchar(255) NOT NULL,
  `userPass` varchar(255) NOT NULL,
  `userCpass` varchar(255) NOT NULL,
  `gender` char(1) DEFAULT NULL,
  `userType` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`userID`, `userName`, `userEmail`, `userPass`, `userCpass`, `gender`, `userType`) VALUES
(4, 'Albert', 'albert8898@gmail.com', '$2y$10$yhQ1b7/Xm1Hkz7UmsPMsjeKvg8kg9YWo3gzrEkp4NTxH6E92tjyqm', '', 'm', 'Admin'),
(9, 'Hsu', 'hsu888@gmail.com', '$2y$10$OXvvNl0LxBKnjGNlHBMJ3OsduIAlUcNIqAChCOhA4DVIOK7Q0/QR6', '', 'f', 'User'),
(12, 'Bhone', 'bhone999@gmail.com', '$2y$10$mNOLVsO0RMLnL7.GqUeiQuPeHANdB/cuiugfCLbOhRmKjfXj6GFGG', '', 'm', 'User'),
(14, 'Aung', 'Aung666@gmail.com', '$2y$10$4yxeHMyG2ieZeksZkPFNZuGW6ZG9i0dNEHNej2NUZf86UYISHWpAW', '', 'm', 'User'),
(16, 'pyae', 'pyae111@gmail.com', '$2y$10$E2FBMmo0GxA6wMGto5oEWeKldPv4Dsntyrq7J96BDy4lqxoZlSLKa', '', 'm', 'User');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`catID`);

--
-- Indexes for table `orderline`
--
ALTER TABLE `orderline`
  ADD PRIMARY KEY (`orderlineID`),
  ADD KEY `orderID` (`orderID`),
  ADD KEY `productID` (`productID`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`orderID`),
  ADD KEY `userID` (`userID`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`productID`),
  ADD KEY `catID` (`catID`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`userID`),
  ADD UNIQUE KEY `userEmail` (`userEmail`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `catID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `orderline`
--
ALTER TABLE `orderline`
  MODIFY `orderlineID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=68;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `orderID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `productID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `userID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `orderline`
--
ALTER TABLE `orderline`
  ADD CONSTRAINT `orderline_ibfk_1` FOREIGN KEY (`orderID`) REFERENCES `orders` (`orderID`),
  ADD CONSTRAINT `orderline_ibfk_2` FOREIGN KEY (`productID`) REFERENCES `products` (`productID`);

--
-- Constraints for table `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_ibfk_1` FOREIGN KEY (`userID`) REFERENCES `users` (`userID`);

--
-- Constraints for table `products`
--
ALTER TABLE `products`
  ADD CONSTRAINT `products_ibfk_1` FOREIGN KEY (`catID`) REFERENCES `categories` (`catID`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
