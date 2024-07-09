-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Feb 28, 2024 at 02:54 PM
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
-- Database: `ccwebsite`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`id`, `username`, `password`) VALUES
(1, 'admin', '$2y$10$Q7CkM9Wd1U78jB9P.Nez1.HaVc5h/f1kMI1kvfzukth.GUQjDlyeC');

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` int(11) NOT NULL,
  `payment_id` varchar(255) NOT NULL,
  `order_id` varchar(255) NOT NULL,
  `total_amount` decimal(10,2) NOT NULL,
  `product_id` int(11) NOT NULL,
  `product_name` varchar(255) NOT NULL,
  `product_quantity` int(11) NOT NULL,
  `product_price` decimal(10,2) NOT NULL,
  `product_size` varchar(50) DEFAULT NULL,
  `user_name` varchar(255) DEFAULT NULL,
  `user_email` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`id`, `payment_id`, `order_id`, `total_amount`, `product_id`, `product_name`, `product_quantity`, `product_price`, `product_size`, `user_name`, `user_email`) VALUES
(30, 'pay_NZCwons8kXO7g0', 'ORDER65c786423c3dc', 1200.00, 0, 'Radha Krishna', 1, 550.00, '6x8', 'Kevin Darji', 'kevinddarji@gmail.com'),
(31, 'pay_NZCwons8kXO7g0', 'ORDER65c786423c3dc', 1200.00, 0, 'Cartoon Drawing\n                                                Painting', 1, 550.00, '6x8', 'Kevin Darji', 'kevinddarji@gmail.com');

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `product_id` int(11) NOT NULL,
  `productName` varchar(255) NOT NULL,
  `productImage` varchar(255) NOT NULL,
  `size` varchar(10) NOT NULL,
  `price` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`product_id`, `productName`, `productImage`, `size`, `price`) VALUES
(1, 'Radha Krishna', 'product1.jpg', '6x8', 550),
(2, 'Radha Krishna', 'product1.jpg', '9x12', 700),
(3, 'Radha Krishna', 'product1.jpg', '12x16', 850),
(7, 'Candid Photo', 'product2.jpg', '6x8', 550),
(8, 'Candid Photo', 'product2.jpg', '9x12', 700),
(9, 'Candid Photo', 'product2.jpg', '12x16', 850),
(10, 'Anime Drawing Painting', 'product3.jpg', '6x8', 550),
(11, 'Anime Drawing Painting', 'product3.jpg', '9x12', 700),
(12, 'Anime Drawing Painting', 'product3.jpg', '12x16', 850),
(16, 'Cartoon Drawing Painting', 'product4.jpg', '6x8', 550),
(17, 'Cartoon Drawing Painting', 'product4.jpg', '9x12', 700),
(18, 'Cartoon Drawing Painting', 'product4.jpg', '12x16', 850),
(26, 'Ganapti Painting', 'product5.jpg', '6x8', 550),
(27, 'Ganapti Painting', 'product5.jpg', '9x12', 700),
(28, 'Ganapti Painting', 'product5.jpg', '12x16', 850),
(30, 'Group Photo Painting', 'product6.jpg', '6x8', 550),
(31, 'Group Photo Painting', 'product6.jpg', '9x12', 700),
(32, 'Group Photo Painting', 'product6.jpg', '12x16', 850),
(34, 'Bestie Photo Painting', 'product7.jpg', '6x8', 550),
(35, 'Bestie Photo Painting', 'product7.jpg', '9x12', 700),
(36, 'Bestie Photo Painting', 'product7.jpg', '12x16', 850),
(38, 'Candid Painting', 'product8.jpg', '6x8', 550),
(39, 'Candid Painting', 'product8.jpg', '9x12', 700),
(40, 'Candid Painting', 'product8.jpg', '12x16', 850),
(41, 'BTS Painting', 'product9.jpg', '6x8', 550),
(42, 'BTS Painting', 'product9.jpg', '9x12', 700),
(43, 'BTS Painting', 'product9.jpg', '12x16', 850);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `verification_token` varchar(255) DEFAULT NULL,
  `verified` tinyint(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `password`, `verification_token`, `verified`) VALUES
(8, 'Kevin Darji', 'kevinddarji@gmail.com', 'Kddarji@12', NULL, 0);

-- --------------------------------------------------------

--
-- Table structure for table `user_addresses`
--

CREATE TABLE `user_addresses` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `address` varchar(255) NOT NULL,
  `city` varchar(100) NOT NULL,
  `zipcode` varchar(20) NOT NULL,
  `phone` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user_addresses`
--

INSERT INTO `user_addresses` (`id`, `name`, `address`, `city`, `zipcode`, `phone`) VALUES
(2, 'Kevin Darji', '502 Span Excellency, Near Dmart, Bhayandar West', 'Mumbai', '401101', '8850620865');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`product_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user_addresses`
--
ALTER TABLE `user_addresses`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `product_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=44;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `user_addresses`
--
ALTER TABLE `user_addresses`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
