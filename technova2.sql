-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 19, 2025 at 10:24 PM
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
-- Database: `technova2`
--

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `category` varchar(50) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `stock` int(11) NOT NULL,
  `description` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `image` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `name`, `category`, `price`, `stock`, `description`, `created_at`, `image`) VALUES
(2, 'Intel Core i9-12900K', 'CPU', 500.04, 5, 'great', '2025-01-19 08:17:38', NULL),
(6, 'AMD Ryzen 5 5600X', 'CPU', 200.00, 51, '', '2025-01-19 20:35:57', NULL),
(7, 'Intel Core i5-12600K', 'CPU', 249.99, 40, NULL, '2025-01-19 20:35:57', NULL),
(8, 'NVIDIA RTX 3060', 'Graphics Card', 399.99, 30, NULL, '2025-01-19 20:35:57', NULL),
(9, 'Corsair Vengeance 16GB', 'RAM', 79.99, 100, NULL, '2025-01-19 20:35:57', NULL),
(10, 'Kingston NV2 1TB SSD', 'Storage', 99.99, 75, NULL, '2025-01-19 20:35:57', NULL),
(11, 'MSI B550M PRO-VDH', 'Motherboard', 149.99, 25, NULL, '2025-01-19 20:35:57', NULL),
(12, 'Cooler Master Hyper 212', 'CPU Cooler', 49.99, 80, NULL, '2025-01-19 20:35:57', NULL),
(13, 'Corsair RM750x PSU', 'Power Supply', 129.99, 35, NULL, '2025-01-19 20:35:57', NULL),
(15, 'Dell 27\" Monitor', 'Monitor', 299.99, 15, NULL, '2025-01-19 20:35:57', NULL),
(16, 'ASUS ROG Strix Z690-E', 'Motherboard', 379.99, 15, NULL, '2025-01-19 20:36:56', NULL),
(17, 'Crucial MX500 1TB SSD', 'Storage', 119.99, 60, NULL, '2025-01-19 20:36:56', NULL),
(18, 'Samsung 970 EVO Plus 2TB', 'Storage', 179.99, 40, NULL, '2025-01-19 20:36:56', NULL),
(19, 'G.SKILL Trident Z RGB 32GB', 'RAM', 169.99, 50, NULL, '2025-01-19 20:36:56', NULL),
(20, 'ASUS TUF RTX 3080', 'Graphics Card', 749.99, 10, NULL, '2025-01-19 20:36:56', NULL),
(21, 'EVGA 850W Gold PSU', 'Power Supply', 139.99, 30, NULL, '2025-01-19 20:36:56', NULL),
(22, 'Noctua NH-D15 CPU Cooler', 'CPU Cooler', 89.99, 20, NULL, '2025-01-19 20:36:56', NULL),
(23, 'Razer BlackWidow V3 Keyboard', 'Peripheral', 129.99, 25, NULL, '2025-01-19 20:36:56', NULL),
(24, 'Logitech G502 HERO Mouse', 'Peripheral', 49.99, 80, NULL, '2025-01-19 20:36:56', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('admin','user') DEFAULT 'user',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `email`, `password`, `role`, `created_at`) VALUES
(2, 'adminvishwa', 'adminvishwa@technova2.com', '$2y$10$SNca2yl1U2jup0O243OUl.EgICpLDd07coFVrL.M9A0dxfmW4d5RS', 'admin', '2025-01-19 07:32:58'),
(3, 'ashela', 'ash@gmail.com', '1014', 'user', '2025-01-19 08:50:18'),
(5, 'Test User', 'testuser@technova2.com', '$2y$10$62PXpQDQBhFnNep/pkdnYu5U12.kt1dVCljKFCpr8yirVRBuDCaEi', 'user', '2025-01-19 09:27:33'),
(6, 'tharu', 'tharu@gmail.com', '$2y$10$MNvD.SoTDPIHFrZbZ75IZud5HAmZ78hVK1sdZwsYVPUoaA6rs43oK', 'user', '2025-01-19 11:09:31'),
(7, 'aquib', 'aquib@gmail.com', '$2y$10$FmFSKuyCOW6qIysxEG.4I.52WFDEjvKNqil45DSK.AGd6rIbHYBMq', 'user', '2025-01-19 12:26:35'),
(11, 'dinoj', 'dinoj@gmail.com', '$2y$10$120LnI2C2hfunMhrk9zU6ecLUYRNaDja4Vsg4YmoGvkjobhmz0alW', 'user', '2025-01-19 21:10:51'),
(12, 'tharunethu', 'tharunethu@gmail.com', '$2y$10$cbpx9S/Ur2XYhbOdZA8IL.l3dglgXJDqCGNeiaISwFih7jEX5cCvK', 'user', '2025-01-19 21:16:17');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
