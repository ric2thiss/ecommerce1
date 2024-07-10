-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 08, 2024 at 04:06 AM
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
(189, 12, 31, 1, 14),
(197, 14, 32, 1, 12);

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `OrderID` int(11) NOT NULL,
  `UserID` int(11) NOT NULL,
  `ProductID` int(11) NOT NULL,
  `Quantity` int(11) NOT NULL,
  `OrderDate` datetime NOT NULL,
  `TotalPrice` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`OrderID`, `UserID`, `ProductID`, `Quantity`, `OrderDate`, `TotalPrice`) VALUES
(12, 14, 31, 1, '2024-07-07 20:10:31', 14),
(13, 14, 32, 1, '2024-07-08 01:56:02', 12),
(14, 14, 31, 1, '2024-07-08 01:56:02', 14);

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
(31, 'Penshoppe Sweet Scents Cupcake Body Spray 70ml', 'PENSHOPPE Sweet Scents Cupcake Body Spray 70ml  Bring out your sweetness with the tempting blend of your favorite red velvet cupcake dessert!   -Formulated with Alcohol Denat ; Aqua ; -Fragrance ; Benzophenone-4 ; and Colorant  -Body spray  -Cupcake scent  -70ml/4.23fl. oz  -Best used in 3-4 years from opening  -When to toss: If the product starts to smell off ; changes color ', 14, 'uploads/2juT14YTyz54f7DOfRRAMtyi5lNYrZQpifeQvDtp (1).png', 0, '2024-07-07 17:22:44', 12),
(32, 'Penshoppe Pensport Extreme Fruity Musky Scent Body Spray - Perfume For Men 150ML', 'For the ultimate active lifestyle need of menBask in the fresh top notes of Citrus, Bergamot, Lemon, and Orange. Unique combination of Fruity, Floral, and Fougere provide a harmonious yet interesting middle notes. Woody and Musk undertones will leave them wanting more.', 12, 'uploads/sg-11134201-22110-4wbtxq3it7jv64.jpeg', 0, '2024-07-08 01:41:48', 0);

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
(23, '5X270202YB4892027', 'GYB3VQ8A6RVRU', '5X270202YB4892027', 14.00, 'USD', 'COMPLETED', 'John Doe', 'customer.ericka@gmail.com', 14, '2024-07-07 18:04:50'),
(24, '26062677Y9795644P', 'GYB3VQ8A6RVRU', '26062677Y9795644P', 14.00, 'USD', 'COMPLETED', 'John Doe', 'customer.ericka@gmail.com', 14, '2024-07-07 18:10:31'),
(25, '23R09758A37876839', 'GYB3VQ8A6RVRU', '23R09758A37876839', 26.00, 'USD', 'COMPLETED', 'John Doe', 'customer.ericka@gmail.com', 14, '2024-07-07 23:56:02');

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
  MODIFY `CartID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=198;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `OrderID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `product`
--
ALTER TABLE `product`
  MODIFY `ProductID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;

--
-- AUTO_INCREMENT for table `transactions`
--
ALTER TABLE `transactions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

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
