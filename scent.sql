-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 06, 2024 at 10:54 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `scent`
--

-- --------------------------------------------------------

--
-- Table structure for table `carts`
--

CREATE TABLE `carts` (
  `CartID` int(11) NOT NULL,
  `UserID` int(11) NOT NULL,
  `ProductID` int(11) NOT NULL,
  `Quantity` int(11) NOT NULL,
  `TotalPrice` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `carts`
--

INSERT INTO `carts` (`CartID`, `UserID`, `ProductID`, `Quantity`, `TotalPrice`) VALUES
(180, 12, 23, 1, 2),
(185, 12, 22, 1, 120);

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `OrderID` int(11) NOT NULL,
  `UserID` int(11) NOT NULL,
  `ProductID` int(11) NOT NULL,
  `Quantity` int(11) NOT NULL,
  `OrderDate` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`OrderID`, `UserID`, `ProductID`, `Quantity`, `OrderDate`) VALUES
(1, 18, 23, 1, '2024-07-06 17:14:49'),
(2, 18, 23, 1, '2024-07-06 17:35:08'),
(7, 18, 25, 1, '2024-07-06 19:43:31'),
(8, 14, 25, 2, '2024-07-06 22:41:15'),
(9, 14, 23, 1, '2024-07-06 22:41:15'),
(10, 18, 22, 1, '2024-07-06 22:47:31');

-- --------------------------------------------------------

--
-- Table structure for table `product`
--

CREATE TABLE `product` (
  `ProductID` int(11) NOT NULL,
  `ProductTitle` varchar(100) NOT NULL,
  `ProductDescription` varchar(500) NOT NULL,
  `Price` int(11) NOT NULL,
  `ProductImage` varchar(100) NOT NULL,
  `ProductDiscount` int(11) NOT NULL,
  `ProductReg` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `Stock` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `product`
--

INSERT INTO `product` (`ProductID`, `ProductTitle`, `ProductDescription`, `Price`, `ProductImage`, `ProductDiscount`, `ProductReg`, `Stock`) VALUES
(22, 'Lorem IpsumLorem Ipsum', 'Lorem IpsumLorem IpsumLorem Ipsum', 120, 'uploads/Screenshot 2023-05-16 195458.png', 0, '2024-07-06 20:46:04', 1),
(23, 'Lorem IpsumLorem Ipsum', 'Lorem IpsumLorem IpsumLorem Ipsum', 2, 'uploads/Screenshot 2023-05-16 195458.png', 0, '2024-07-06 13:36:25', 12),
(24, 'Penshoppe Love Story For Men (4 X 70ml)', 'CHAT WITH US TO CONFIRM STOCK AVAILABILITY EXPIRATION DATE: FEB 1 2023 Fruity Body spray for men Perfect pair of long-lasting scents At affordable price Get it now!', 579, 'uploads/perfume-bottle-dox7ee1-600.jpg', 0, '2024-07-06 19:21:43', 1),
(25, 'test product', 'test description', 1, 'uploads/Screenshot 2023-03-09 124609.png', 0, '2024-07-06 16:42:24', 12),
(26, 'test product 2', 'test description 2', 1, 'uploads/Screenshot 2023-03-07 161447.png', 0, '2024-07-06 16:43:54', 12),
(27, 'last hahah', 'last hahah', 12, 'uploads/Screenshot 2023-03-03 112830.png', 0, '2024-07-06 16:44:33', 12);

-- --------------------------------------------------------

--
-- Table structure for table `transactions`
--

CREATE TABLE `transactions` (
  `id` int(11) NOT NULL,
  `order_id` varchar(255) NOT NULL,
  `payer_id` varchar(255) NOT NULL,
  `payment_id` varchar(255) NOT NULL,
  `amount` decimal(10,2) NOT NULL,
  `currency` varchar(10) NOT NULL,
  `status` varchar(50) NOT NULL,
  `payer_name` varchar(255) NOT NULL,
  `payer_email` varchar(255) NOT NULL,
  `user_id` int(11) NOT NULL,
  `transaction_date` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `transactions`
--

INSERT INTO `transactions` (`id`, `order_id`, `payer_id`, `payment_id`, `amount`, `currency`, `status`, `payer_name`, `payer_email`, `user_id`, `transaction_date`) VALUES
(13, '8U6602443B540583B', 'GYB3VQ8A6RVRU', '8U6602443B540583B', 2.00, 'USD', 'COMPLETED', 'John Doe', 'customer.ericka@gmail.com', 18, '2024-07-06 15:08:37'),
(14, '6C931032NT808714M', 'GYB3VQ8A6RVRU', '6C931032NT808714M', 2.00, 'USD', 'COMPLETED', 'John Doe', 'customer.ericka@gmail.com', 18, '2024-07-06 15:14:47'),
(15, '26P36977D4585735A', 'GYB3VQ8A6RVRU', '26P36977D4585735A', 2.00, 'USD', 'COMPLETED', 'John Doe', 'customer.ericka@gmail.com', 18, '2024-07-06 15:35:07'),
(16, '0H0604315B939823T', 'GYB3VQ8A6RVRU', '0H0604315B939823T', 2.00, 'USD', 'COMPLETED', 'John Doe', 'customer.ericka@gmail.com', 18, '2024-07-06 17:32:12'),
(17, '95H83421C1746570N', 'GYB3VQ8A6RVRU', '95H83421C1746570N', 2.00, 'USD', 'COMPLETED', 'John Doe', 'customer.ericka@gmail.com', 18, '2024-07-06 17:35:42'),
(18, '53G03672DS475063X', 'GYB3VQ8A6RVRU', '53G03672DS475063X', 2.00, 'USD', 'COMPLETED', 'John Doe', 'customer.ericka@gmail.com', 18, '2024-07-06 17:38:16'),
(19, '29D85636MU368793R', 'GYB3VQ8A6RVRU', '29D85636MU368793R', 2.00, 'USD', 'COMPLETED', 'John Doe', 'customer.ericka@gmail.com', 18, '2024-07-06 17:42:41'),
(20, '65W56854858565131', 'GYB3VQ8A6RVRU', '65W56854858565131', 1.00, 'USD', 'COMPLETED', 'John Doe', 'customer.ericka@gmail.com', 18, '2024-07-06 17:43:31'),
(21, '1X2766940L478524U', 'GYB3VQ8A6RVRU', '1X2766940L478524U', 4.00, 'USD', 'COMPLETED', 'John Doe', 'customer.ericka@gmail.com', 14, '2024-07-06 20:41:15'),
(22, '7U372280MJ928413P', 'GYB3VQ8A6RVRU', '7U372280MJ928413P', 120.00, 'USD', 'COMPLETED', 'John Doe', 'customer.ericka@gmail.com', 18, '2024-07-06 20:47:31');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `UserID` int(11) NOT NULL,
  `FirstName` varchar(50) NOT NULL,
  `LastName` varchar(50) NOT NULL,
  `Email` varchar(50) NOT NULL,
  `Contact` int(12) NOT NULL,
  `Password` varchar(100) NOT NULL,
  `Role` int(11) NOT NULL,
  `RegDate` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `Profile` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`UserID`, `FirstName`, `LastName`, `Email`, `Contact`, `Password`, `Role`, `RegDate`, `Profile`) VALUES
(12, 'Ric Charles', 'Paquibot', 'admin@admin.com', 2147483647, '$2y$10$2o/LwDiw2Dvc/9sGVUD1cO4MV9fF5zPsTrslEBZDLdBXK1EAWDHSm', 1, '2024-07-01 00:12:43', ''),
(13, 'ekay', 'ekay', 'ekay@ekay.com', 123123, '$2y$10$srR70dcOkNSP7TbUczcMC.DG/RKxRvfkAPGxb.sTdRayfGJ/tYDGC', 0, '2024-07-01 02:39:36', ''),
(14, 'Customer', 'Customer', 'Customer@Customer.com', 213123, '$2y$10$Pdds1h6Y7u7hRT3xS8w0T.0lbf5djnKNUJMSi1B6cFqtHWT49uuPe', 0, '2024-07-03 07:52:35', ''),
(18, 'Customer2', 'Customer2', 'Customer2@Customer2.com', 123123, '$2y$10$sS73crYIGpfA96Xl7c9RIeCCbIfjHP71OSEaDSFZe3ZRutJm8bWWW', 0, '2024-07-06 08:32:46', '');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `carts`
--
ALTER TABLE `carts`
  ADD PRIMARY KEY (`CartID`),
  ADD KEY `UserID` (`UserID`),
  ADD KEY `ProductID` (`ProductID`),
  ADD KEY `UserID_2` (`UserID`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`OrderID`),
  ADD KEY `UserID` (`UserID`),
  ADD KEY `ProductID` (`ProductID`);

--
-- Indexes for table `product`
--
ALTER TABLE `product`
  ADD PRIMARY KEY (`ProductID`);

--
-- Indexes for table `transactions`
--
ALTER TABLE `transactions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`UserID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `carts`
--
ALTER TABLE `carts`
  MODIFY `CartID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=187;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `OrderID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `product`
--
ALTER TABLE `product`
  MODIFY `ProductID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT for table `transactions`
--
ALTER TABLE `transactions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `UserID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `carts`
--
ALTER TABLE `carts`
  ADD CONSTRAINT `carts_ibfk_1` FOREIGN KEY (`ProductID`) REFERENCES `product` (`ProductID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `carts_ibfk_2` FOREIGN KEY (`UserID`) REFERENCES `users` (`UserID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_ibfk_1` FOREIGN KEY (`UserID`) REFERENCES `users` (`UserID`),
  ADD CONSTRAINT `orders_ibfk_2` FOREIGN KEY (`ProductID`) REFERENCES `product` (`ProductID`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
