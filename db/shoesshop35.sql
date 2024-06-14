-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 14, 2024 at 11:16 AM
-- Server version: 10.4.27-MariaDB
-- PHP Version: 8.0.25

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `shoesshop35`
--

-- --------------------------------------------------------

--
-- Table structure for table `tblaccesslog`
--

CREATE TABLE `tblaccesslog` (
  `id` int(11) UNSIGNED NOT NULL,
  `user_id` int(11) UNSIGNED DEFAULT NULL,
  `type` varchar(191) DEFAULT NULL,
  `ip_address` varchar(191) DEFAULT NULL,
  `login_success` tinyint(1) UNSIGNED DEFAULT NULL,
  `created_at` int(11) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `tblaccesslog`
--

INSERT INTO `tblaccesslog` (`id`, `user_id`, `type`, `ip_address`, `login_success`, `created_at`) VALUES
(1, 1, 'admin', '::1', 1, NULL),
(2, 1, 'admin', '::1', 1, NULL),
(3, 1, 'admin', '::1', 1, NULL),
(4, 1, 'admin', '::1', 1, NULL),
(5, 1, 'admin', '::1', 1, NULL),
(6, 1, 'admin', '::1', 1, NULL),
(7, 1, 'admin', '::1', 1, NULL),
(8, 1, 'admin', '::1', 1, NULL),
(9, 1, 'admin', '::1', 1, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `tblcategory`
--

CREATE TABLE `tblcategory` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tblcategory`
--

INSERT INTO `tblcategory` (`id`, `name`, `created_at`) VALUES
(2, 'Male', '2024-06-10 09:38:53'),
(3, 'Female', '2024-06-10 10:37:36'),
(4, 'Kide', '2024-06-10 10:37:45');

-- --------------------------------------------------------

--
-- Table structure for table `tblimport`
--

CREATE TABLE `tblimport` (
  `id` int(11) NOT NULL,
  `employee_id` int(11) NOT NULL,
  `date` date NOT NULL,
  `total_qty` int(11) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tblimportdetail`
--

CREATE TABLE `tblimportdetail` (
  `id` int(11) NOT NULL,
  `order_id` int(11) NOT NULL,
  `product_no` varchar(50) NOT NULL,
  `qty` int(11) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tblorder`
--

CREATE TABLE `tblorder` (
  `id` int(11) NOT NULL,
  `order_no` varchar(20) NOT NULL,
  `product_no` varchar(50) NOT NULL,
  `date` date NOT NULL DEFAULT current_timestamp(),
  `total_qty` int(11) NOT NULL,
  `employee` varchar(100) NOT NULL,
  `status` tinyint(1) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tblorder`
--

INSERT INTO `tblorder` (`id`, `order_no`, `product_no`, `date`, `total_qty`, `employee`, `status`, `created_at`) VALUES
(8, '24-2', 'P002', '2024-06-14', 90, 'ka', 0, '2024-06-14 16:01:37'),
(9, '24-2', 'P001', '2024-06-14', 90, 'ka', 0, '2024-06-14 16:01:59'),
(10, '24-2', 'P001', '2024-06-14', 880, 'ka', 0, '2024-06-14 16:02:25'),
(11, '24-3', 'P001', '2024-06-14', 200, 'ka', 0, '2024-06-14 16:03:26'),
(12, '24-4', 'P002', '2024-06-14', 99, 'ka', 0, '2024-06-14 16:04:01'),
(13, '90', 'P002', '2024-06-14', 90, 'ka', 0, '2024-06-14 16:13:02'),
(14, '90', 'P002', '2024-06-14', 90, 'ka', 0, '2024-06-14 16:13:49'),
(15, '90', 'P002', '2024-06-14', 1290, 'ka', 0, '2024-06-14 16:14:19'),
(16, '90', 'P002', '2024-06-14', 90, 'ka', 0, '2024-06-14 16:14:53');

-- --------------------------------------------------------

--
-- Table structure for table `tblorderdetail`
--

CREATE TABLE `tblorderdetail` (
  `id` int(11) NOT NULL,
  `product_no` varchar(50) NOT NULL,
  `qty` int(11) NOT NULL,
  `base_price` decimal(10,2) NOT NULL,
  `sale_price` decimal(10,2) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tblorderdetail`
--

INSERT INTO `tblorderdetail` (`id`, `product_no`, `qty`, `base_price`, `sale_price`, `created_at`) VALUES
(7, 'P002', 90, '12000.00', '25000.00', '2024-06-14 16:01:37'),
(8, 'P001', 90, '7000.00', '8000.00', '2024-06-14 16:02:00'),
(9, 'P001', 880, '7000.00', '8000.00', '2024-06-14 16:02:25'),
(10, 'P001', 200, '7000.00', '8000.00', '2024-06-14 16:03:26'),
(11, 'P002', 99, '12000.00', '25000.00', '2024-06-14 16:04:01'),
(12, 'P002', 90, '12000.00', '25000.00', '2024-06-14 16:13:03'),
(13, 'P002', 90, '12000.00', '25000.00', '2024-06-14 16:13:49'),
(14, 'P002', 1290, '12000.00', '25000.00', '2024-06-14 16:14:19'),
(15, 'P002', 90, '12000.00', '25000.00', '2024-06-14 16:14:54');

-- --------------------------------------------------------

--
-- Table structure for table `tblproduct`
--

CREATE TABLE `tblproduct` (
  `id` int(11) NOT NULL,
  `barcode` int(20) NOT NULL,
  `product_no` varchar(50) NOT NULL,
  `image` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `qty` int(11) NOT NULL,
  `base_price` int(11) NOT NULL,
  `sale_price` int(11) NOT NULL,
  `date_expirt` date NOT NULL,
  `category_id` int(11) NOT NULL,
  `supplier_id` int(11) NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tblproduct`
--

INSERT INTO `tblproduct` (`id`, `barcode`, `product_no`, `image`, `name`, `qty`, `base_price`, `sale_price`, `date_expirt`, `category_id`, `supplier_id`, `status`, `created_at`) VALUES
(3, 345, 'P001', 'http://localhost:81/university/keokham/uploads/image/e2b0a89e4624721e2.jpeg', 'tiger headb 2', 200, 7000, 8000, '2027-06-10', 4, 2, 1, '2024-06-10 20:19:01'),
(4, 2147483647, 'P002', 'http://localhost:81/university/keokham/uploads/image/67ef7968e12bb8c2c.jpeg', 'Droker', 12, 12000, 25000, '2024-06-20', 3, 2, 1, '2024-06-14 15:18:23');

-- --------------------------------------------------------

--
-- Table structure for table `tblsale`
--

CREATE TABLE `tblsale` (
  `id` int(11) NOT NULL,
  `bill_no` varchar(50) NOT NULL,
  `barcode` int(11) NOT NULL,
  `product_name` varchar(100) NOT NULL,
  `qty` int(11) NOT NULL,
  `total_amount` decimal(10,2) NOT NULL,
  `payment_type` int(1) NOT NULL,
  `status` tinyint(1) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tblsupplyer`
--

CREATE TABLE `tblsupplyer` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `created_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tblsupplyer`
--

INSERT INTO `tblsupplyer` (`id`, `name`, `created_at`) VALUES
(1, 'Beer lao', '0000-00-00 00:00:00'),
(2, 'Tiger head', '0000-00-00 00:00:00'),
(3, 'ISC Comunity', '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `tbluser`
--

CREATE TABLE `tbluser` (
  `id` int(11) NOT NULL,
  `full_name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` varchar(100) NOT NULL,
  `active` tinyint(4) NOT NULL DEFAULT 1,
  `login_date` int(11) NOT NULL,
  `created_at` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `tbluser`
--

INSERT INTO `tbluser` (`id`, `full_name`, `email`, `password`, `role`, `active`, `login_date`, `created_at`) VALUES
(1, 'ka', 'ka', '$2y$12$XWOJeI8EUqpRUgQQk5o0z.3Uj2d5PzKlyJR/J8fUtUaw8tta1Dr3W', 'admin', 1, 1718347316, 12345678);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tblaccesslog`
--
ALTER TABLE `tblaccesslog`
  ADD PRIMARY KEY (`id`),
  ADD KEY `index_foreignkey_tblaccesslog_user` (`user_id`);

--
-- Indexes for table `tblcategory`
--
ALTER TABLE `tblcategory`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tblimport`
--
ALTER TABLE `tblimport`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tblimportdetail`
--
ALTER TABLE `tblimportdetail`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tblorder`
--
ALTER TABLE `tblorder`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tblorderdetail`
--
ALTER TABLE `tblorderdetail`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tblproduct`
--
ALTER TABLE `tblproduct`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tblsale`
--
ALTER TABLE `tblsale`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tblsupplyer`
--
ALTER TABLE `tblsupplyer`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbluser`
--
ALTER TABLE `tbluser`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tblaccesslog`
--
ALTER TABLE `tblaccesslog`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `tblcategory`
--
ALTER TABLE `tblcategory`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `tblimport`
--
ALTER TABLE `tblimport`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tblimportdetail`
--
ALTER TABLE `tblimportdetail`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tblorder`
--
ALTER TABLE `tblorder`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `tblorderdetail`
--
ALTER TABLE `tblorderdetail`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `tblproduct`
--
ALTER TABLE `tblproduct`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `tblsale`
--
ALTER TABLE `tblsale`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tblsupplyer`
--
ALTER TABLE `tblsupplyer`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `tbluser`
--
ALTER TABLE `tbluser`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
