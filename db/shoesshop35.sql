-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 22, 2024 at 12:36 AM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.0.28

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
(9, 1, 'admin', '::1', 1, NULL),
(10, 1, 'admin', '::1', 1, NULL),
(11, 1, 'admin', '::1', 1, NULL),
(12, 1, 'admin', '::1', 1, NULL),
(13, 1, 'admin', '::1', 1, NULL),
(14, 1, 'admin', '::1', 1, NULL),
(15, 1, 'admin', '::1', 1, NULL),
(16, 1, 'admin', '::1', 1, NULL),
(17, 1, 'admin', '::1', 1, NULL),
(18, 1, 'admin', '::1', 1, NULL),
(19, 9, 'admin', '::1', 1, NULL),
(20, 9, 'admin', '::1', 1, NULL),
(21, 9, NULL, '::1', 1, 1719190567),
(22, 9, 'admin', '::1', 1, NULL),
(23, 9, 'admin', '::1', 1, NULL),
(24, 9, 'admin', '::1', 0, NULL),
(25, 9, 'admin', '::1', 1, NULL),
(26, 9, 'admin', '::1', 1, NULL),
(27, 9, 'admin', '::1', 1, NULL),
(28, 9, 'admin', '::1', 1, NULL),
(29, 9, 'admin', '::1', 1, NULL),
(30, 9, 'admin', '::1', 1, NULL),
(31, 9, 'admin', '::1', 0, NULL),
(32, 9, 'admin', '::1', 1, NULL);

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
  `product_no` varchar(100) NOT NULL,
  `product_name` varchar(255) NOT NULL,
  `order_no` varchar(50) NOT NULL,
  `employee` varchar(100) NOT NULL,
  `total_qty` int(11) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tblimport`
--

INSERT INTO `tblimport` (`id`, `product_no`, `product_name`, `order_no`, `employee`, `total_qty`, `created_at`) VALUES
(3, 'P002', 'Droker', 'OR-24-13', 'admin', 98, '2024-07-21 20:08:53');

-- --------------------------------------------------------

--
-- Table structure for table `tblimportdetail`
--

CREATE TABLE `tblimportdetail` (
  `id` int(11) NOT NULL,
  `order_id` int(11) NOT NULL,
  `product_no` varchar(50) NOT NULL,
  `qty` int(11) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tblorder`
--

CREATE TABLE `tblorder` (
  `id` int(11) NOT NULL,
  `order_no` varchar(50) NOT NULL,
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
(61, 'OR-24-8', 'P001', '2024-07-21', 250, 'admin', 0, '2024-07-21 19:57:35'),
(62, 'OR-24-13', 'P002', '2024-07-21', 98, 'admin', 0, '2024-07-21 20:08:29');

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
(3, 123, 'P001', 'http://localhost/university/keokham/uploads/image/e2b0a89e4624721e2.jpeg', 'tiger headb 2', 300, 7000, 8000, '2024-06-18', 4, 2, 1, '2024-06-10 20:19:01'),
(4, 456, 'P002', 'http://localhost/university/keokham/uploads/image/67ef7968e12bb8c2c.jpeg', 'Droker', 748, 12000, 25000, '2024-06-20', 3, 2, 1, '2024-06-14 15:18:23');

-- --------------------------------------------------------

--
-- Table structure for table `tblsale`
--

CREATE TABLE `tblsale` (
  `id` int(11) NOT NULL,
  `bill_no` varchar(50) NOT NULL,
  `employee` varchar(100) NOT NULL,
  `total_amount` decimal(10,2) NOT NULL,
  `payment_type` varchar(10) NOT NULL,
  `status` tinyint(1) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tblsale`
--

INSERT INTO `tblsale` (`id`, `bill_no`, `employee`, `total_amount`, `payment_type`, `status`, `created_at`) VALUES
(18, 'IV-24-22', 'admin', 33000.00, 'Cash', 0, '2024-06-26 20:13:28'),
(19, 'IV-24-23', 'admin', 16000.00, 'Cash', 0, '2024-07-22 04:50:57'),
(20, 'IV-24-24', 'admin', 33000.00, 'Cash', 0, '2024-07-22 04:52:04'),
(21, 'IV-24-25', 'admin', 66000.00, 'Cash', 0, '2024-07-22 04:53:06'),
(22, 'IV-24-26', 'admin', 33000.00, 'Cash', 0, '2024-07-22 05:08:40');

-- --------------------------------------------------------

--
-- Table structure for table `tblsaledetail`
--

CREATE TABLE `tblsaledetail` (
  `id` int(11) NOT NULL,
  `sale_id` int(11) NOT NULL,
  `bill_no` varchar(50) NOT NULL,
  `category` varchar(100) NOT NULL,
  `product_name` varchar(100) NOT NULL,
  `barcode` int(20) NOT NULL,
  `qty` int(11) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tblsaledetail`
--

INSERT INTO `tblsaledetail` (`id`, `sale_id`, `bill_no`, `category`, `product_name`, `barcode`, `qty`, `price`, `created_at`) VALUES
(18, 11, 'IV-24-12', 'Kide', 'tiger headb 2', 123, 2, 8000.00, '2024-06-17 16:59:24'),
(19, 12, 'IV-24-13', 'Female', 'Droker', 456, 2, 25000.00, '2024-06-17 17:00:36'),
(20, 13, 'IV-24-17', 'Kide', 'tiger headb 2', 123, 2, 8000.00, '2024-06-17 17:08:11'),
(21, 14, 'IV-24-18', 'Female', 'Droker', 456, 1, 25000.00, '2024-06-17 17:08:25'),
(22, 15, 'IV-24-19', 'Kide', 'tiger headb 2', 123, 1, 8000.00, '2024-06-18 08:34:06'),
(23, 15, 'IV-24-19', 'Female', 'Droker', 456, 3, 25000.00, '2024-06-18 08:34:06'),
(24, 16, 'IV-24-20', 'Kide', 'tiger headb 2', 123, 2, 8000.00, '2024-06-19 16:56:25'),
(25, 16, 'IV-24-20', 'Female', 'Droker', 456, 3, 25000.00, '2024-06-19 16:56:25'),
(26, 17, 'IV-24-21', 'Kide', 'tiger headb 2', 123, 4, 8000.00, '2024-06-20 22:51:50'),
(27, 17, 'IV-24-21', 'Female', 'Droker', 456, 2, 25000.00, '2024-06-20 22:51:50'),
(28, 18, 'IV-24-22', 'Kide', 'tiger headb 2', 123, 1, 8000.00, '2024-06-26 20:13:28'),
(29, 18, 'IV-24-22', 'Female', 'Droker', 456, 1, 25000.00, '2024-06-26 20:13:29'),
(30, 19, 'IV-24-23', 'Kide', 'tiger headb 2', 123, 2, 8000.00, '2024-07-22 04:50:57'),
(31, 20, 'IV-24-24', 'Female', 'Droker', 456, 1, 25000.00, '2024-07-22 04:52:04'),
(32, 20, 'IV-24-24', 'Kide', 'tiger headb 2', 123, 1, 8000.00, '2024-07-22 04:52:04'),
(33, 21, 'IV-24-25', 'Kide', 'tiger headb 2', 123, 2, 8000.00, '2024-07-22 04:53:06'),
(34, 21, 'IV-24-25', 'Female', 'Droker', 456, 2, 25000.00, '2024-07-22 04:53:06'),
(35, 22, 'IV-24-26', 'Kide', 'tiger headb 2', 123, 1, 8000.00, '2024-07-22 05:08:40'),
(36, 22, 'IV-24-26', 'Female', 'Droker', 456, 1, 25000.00, '2024-07-22 05:08:40');

-- --------------------------------------------------------

--
-- Table structure for table `tblsupplyer`
--

CREATE TABLE `tblsupplyer` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tblsupplyer`
--

INSERT INTO `tblsupplyer` (`id`, `name`, `created_at`) VALUES
(1, 'Beer lao', '0000-00-00 00:00:00'),
(2, 'Tiger head', '0000-00-00 00:00:00'),
(3, 'ISC Comunity 2', '0000-00-00 00:00:00');

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
(1, 'ka', 'ka', '$2y$12$XWOJeI8EUqpRUgQQk5o0z.3Uj2d5PzKlyJR/J8fUtUaw8tta1Dr3W', 'admin', 1, 1718790749, 12345678),
(9, 'admin', 'admin', '$2y$12$1dpXJ8dfJvf0dNNQsuEDo.Poitp/dfsq.D1qR3STuM4jkbxVVRNFW', 'admin', 1, 1721596232, 1718790779);

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
-- Indexes for table `tblsaledetail`
--
ALTER TABLE `tblsaledetail`
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
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;

--
-- AUTO_INCREMENT for table `tblcategory`
--
ALTER TABLE `tblcategory`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `tblimport`
--
ALTER TABLE `tblimport`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `tblimportdetail`
--
ALTER TABLE `tblimportdetail`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tblorder`
--
ALTER TABLE `tblorder`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=63;

--
-- AUTO_INCREMENT for table `tblorderdetail`
--
ALTER TABLE `tblorderdetail`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;

--
-- AUTO_INCREMENT for table `tblproduct`
--
ALTER TABLE `tblproduct`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `tblsale`
--
ALTER TABLE `tblsale`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT for table `tblsaledetail`
--
ALTER TABLE `tblsaledetail`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=37;

--
-- AUTO_INCREMENT for table `tblsupplyer`
--
ALTER TABLE `tblsupplyer`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `tbluser`
--
ALTER TABLE `tbluser`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
