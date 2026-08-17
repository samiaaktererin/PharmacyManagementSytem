-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Sep 27, 2025 at 07:37 AM
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
-- Database: `pharmacy_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin_users`
--

CREATE TABLE `admin_users` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admin_users`
--

INSERT INTO `admin_users` (`id`, `username`, `password`) VALUES
(1, 'admin', '0192023a7bbd73250516f069df18b500');

-- --------------------------------------------------------

--
-- Table structure for table `customers`
--

CREATE TABLE `customers` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `phone` varchar(20) NOT NULL,
  `address` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `customers`
--

INSERT INTO `customers` (`id`, `name`, `phone`, `address`, `created_at`) VALUES
(1, 'Joynal', '01885235769', 'hghjb', '2025-08-22 04:25:08'),
(2, 'sharif', '01885235769', 'uttata-10', '2025-08-22 04:27:41'),
(3, 'Joynal', '01885235769', 'uttara-10', '2025-08-23 16:02:57');

-- --------------------------------------------------------

--
-- Table structure for table `medicines`
--

CREATE TABLE `medicines` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `generic_name` varchar(255) DEFAULT NULL,
  `batch_no` varchar(50) DEFAULT NULL,
  `quantity` int(11) NOT NULL,
  `cost_price` decimal(10,2) DEFAULT 0.00,
  `selling_price` decimal(10,2) NOT NULL DEFAULT 0.00,
  `price_per_strip` decimal(10,2) DEFAULT 0.00,
  `expiry_date` date DEFAULT NULL,
  `category` varchar(50) DEFAULT 'Medicine'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `medicines`
--

INSERT INTO `medicines` (`id`, `name`, `generic_name`, `batch_no`, `quantity`, `cost_price`, `selling_price`, `price_per_strip`, `expiry_date`, `category`) VALUES
(1, 'Joynal', 'Paracetamol', 'rest3wqr', 2, 0.00, 0.00, 40.00, '2025-08-28', 'Medicine'),
(2, 'naprox', 'Paracetamol', '5327642', -1, 0.00, 0.00, 60.00, '2030-07-28', 'Medicine'),
(3, 'Osfort DL', 'Paracetamol', '1245632', 44, 0.00, 25.00, 0.00, '2028-06-29', 'Medicine'),
(4, 'Napa Extend', 'Paracetamol', 'B123', 46, 0.00, 15.00, 0.00, '2026-01-01', 'Medicine'),
(5, 'Savlon Antiseptic', 'Chlorhexidine', 'C567', 28, 0.00, 120.00, 0.00, '2027-05-01', 'Cosmetic'),
(6, 'Hot Water Bag', 'Medical Equipment', 'E111', 20, 0.00, 300.00, 0.00, '2030-12-31', 'Medical Equipment'),
(7, 'Horlicks 500g', 'Nutrition', 'F321', 37, 0.00, 450.00, 0.00, '2026-07-01', 'Grocery'),
(8, 'Napa Extend', 'Paracetamol', 'B123', 50, 0.00, 15.00, 0.00, '2026-01-01', 'Medicine'),
(9, 'Ace Plus', 'Paracetamol + Caffeine', 'B456', 75, 0.00, 20.00, 0.00, '2027-06-01', 'Medicine'),
(10, 'Maxpro 20mg', 'Esomeprazole', 'B789', 38, 0.00, 120.00, 0.00, '2026-08-15', 'Medicine'),
(11, 'Losectil 40mg', 'Omeprazole', 'B910', 59, 0.00, 100.00, 0.00, '2028-05-01', 'Medicine'),
(12, 'Savlon Antiseptic', 'Chlorhexidine', 'C567', 29, 0.00, 120.00, 0.00, '2027-05-01', 'Cosmetic'),
(13, 'Dettol Soap', 'Triclosan', 'C678', 99, 0.00, 55.00, 0.00, '2028-01-01', 'Cosmetic'),
(14, 'Dove Shampoo 200ml', 'Personal Care', 'C111', 25, 0.00, 280.00, 0.00, '2027-12-01', 'Cosmetic'),
(15, 'Nivea Cream 100ml', 'Moisturizer', 'C222', 40, 0.00, 350.00, 0.00, '2029-07-01', 'Cosmetic'),
(16, 'Hot Water Bag', 'Medical Equipment', 'E111', 20, 0.00, 300.00, 0.00, '2030-12-31', 'Medical Equipment'),
(17, 'BP Machine', 'Digital Blood Pressure Monitor', 'E222', 6, 0.00, 2200.00, 0.00, '2032-01-01', 'Medical Equipment'),
(18, 'Surgical Mask (Box of 50)', 'Disposable Mask', 'E333', 200, 0.00, 350.00, 0.00, '2030-10-01', 'Medical Equipment'),
(19, 'Wheelchair', 'Mobility Aid', 'E444', 5, 0.00, 8500.00, 0.00, '2035-01-01', 'Medical Equipment'),
(20, 'Horlicks 500g', 'Nutrition', 'F321', 40, 0.00, 450.00, 0.00, '2026-07-01', 'Grocery'),
(21, 'Ensure Nutrition 400g', 'Adult Nutrition', 'F654', 25, 0.00, 1250.00, 0.00, '2027-02-01', 'Grocery'),
(22, 'Pediasure 400g', 'Child Nutrition', 'F987', 29, 0.00, 1350.00, 0.00, '2026-11-01', 'Grocery'),
(23, 'Complan 500g', 'Health Drink', 'F111', 33, 0.00, 600.00, 0.00, '2028-03-01', 'Grocery');

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `total` decimal(10,2) DEFAULT NULL,
  `order_date` timestamp NOT NULL DEFAULT current_timestamp(),
  `status` varchar(50) NOT NULL DEFAULT 'Pending',
  `payment_method` varchar(50) DEFAULT 'Cash on Delivery'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`id`, `user_id`, `total`, `order_date`, `status`, `payment_method`) VALUES
(1, 1, 0.00, '2025-08-29 14:55:47', 'Pending', 'Cash on Delivery'),
(2, 1, 25.00, '2025-08-30 06:30:06', 'Pending', 'Cash on Delivery'),
(3, 1, 120.00, '2025-08-30 06:32:15', 'Pending', 'Cash on Delivery'),
(4, 1, 120.00, '2025-08-30 06:35:43', 'Pending', 'Cash on Delivery'),
(5, 1, 450.00, '2025-08-30 06:35:58', 'Pending', 'bKash'),
(6, 1, 25.00, '2025-08-31 04:04:17', 'Cancelled', 'bKash'),
(7, 1, 15.00, '2025-09-01 17:27:39', 'Shipped', 'Cash on Delivery'),
(8, 1, 1350.00, '2025-09-02 12:55:09', 'Delivered', 'Card Payment'),
(9, 1, 25.00, '2025-09-02 13:22:54', 'Delivered', 'Cash on Delivery'),
(10, 1, 25.00, '2025-09-02 17:25:48', 'Shipped', 'bKash'),
(11, 1, 160.00, '2025-09-03 09:04:16', 'Pending', 'Cash on Delivery'),
(12, 1, 0.00, '2025-09-03 10:39:21', 'Delivered', 'bKash'),
(13, 3, 15.00, '2025-09-06 08:54:29', 'Pending', 'Cash on Delivery'),
(14, 3, 195.00, '2025-09-06 16:45:51', 'Pending', 'Cash on Delivery');

-- --------------------------------------------------------

--
-- Table structure for table `order_items`
--

CREATE TABLE `order_items` (
  `id` int(11) NOT NULL,
  `order_id` int(11) DEFAULT NULL,
  `medicine_id` int(11) DEFAULT NULL,
  `quantity` int(11) DEFAULT NULL,
  `price` decimal(10,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `order_items`
--

INSERT INTO `order_items` (`id`, `order_id`, `medicine_id`, `quantity`, `price`) VALUES
(1, 2, 2, 5, 0.00),
(2, 2, 1, 3, 0.00),
(3, 2, 3, 1, 25.00),
(4, 3, 5, 1, 120.00),
(5, 4, 5, 1, 120.00),
(6, 5, 7, 1, 450.00),
(7, 6, 3, 1, 25.00),
(8, 7, 2, 1, 0.00),
(9, 7, 4, 1, 15.00),
(10, 8, 22, 1, 1350.00),
(11, 9, 3, 1, 25.00),
(12, 10, 3, 1, 25.00),
(13, 11, 12, 1, 120.00),
(14, 11, 3, 1, 25.00),
(15, 11, 4, 1, 15.00),
(16, 12, 2, 1, 0.00),
(17, 13, 1, 1, 0.00),
(18, 13, 2, 1, 0.00),
(19, 13, 4, 1, 15.00),
(20, 14, 3, 1, 25.00),
(21, 14, 11, 1, 100.00),
(22, 14, 13, 1, 55.00),
(23, 14, 4, 1, 15.00);

-- --------------------------------------------------------

--
-- Table structure for table `prescriptions`
--

CREATE TABLE `prescriptions` (
  `id` int(11) NOT NULL,
  `customer_id` int(11) NOT NULL,
  `file_name` varchar(255) NOT NULL,
  `file_path` varchar(255) NOT NULL,
  `uploaded_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `prescriptions`
--

INSERT INTO `prescriptions` (`id`, `customer_id`, `file_name`, `file_path`, `uploaded_at`) VALUES
(4, 121, 'dabdafc7-c647-4210-80e8-0858c389b043.png', 'uploads/1756821246_dabdafc7-c647-4210-80e8-0858c389b043.png', '2025-09-02 13:54:06'),
(5, 121, 'dabdafc7-c647-4210-80e8-0858c389b043.png', 'uploads/1756824479_dabdafc7-c647-4210-80e8-0858c389b043.png', '2025-09-02 14:47:59'),
(6, 212, 'dabdafc7-c647-4210-80e8-0858c389b043.png', 'uploads/1756829122_dabdafc7-c647-4210-80e8-0858c389b043.png', '2025-09-02 16:05:22'),
(7, 4, 'WhatsApp Image 2025-09-06 at 3.08.01 PM.jpeg', 'uploads/1757159415_WhatsApp Image 2025-09-06 at 3.08.01 PM.jpeg', '2025-09-06 11:50:15'),
(8, 4, 'WhatsApp Image 2025-09-06 at 3.08.01 PM.jpeg', 'uploads/1757159431_WhatsApp Image 2025-09-06 at 3.08.01 PM.jpeg', '2025-09-06 11:50:31'),
(9, 5, 'Screenshot_38.png', 'uploads/1757177696_Screenshot_38.png', '2025-09-06 16:54:56');

-- --------------------------------------------------------

--
-- Table structure for table `profit`
--

CREATE TABLE `profit` (
  `id` int(10) UNSIGNED NOT NULL,
  `medicine_name` varchar(255) NOT NULL,
  `quantity` int(10) UNSIGNED NOT NULL,
  `cost_price` decimal(10,2) NOT NULL,
  `selling_price` decimal(10,2) NOT NULL,
  `sale_date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `profit`
--

INSERT INTO `profit` (`id`, `medicine_name`, `quantity`, `cost_price`, `selling_price`, `sale_date`) VALUES
(1, 'Paracetamol 500mg', 20, 0.80, 1.50, '2025-09-06'),
(2, 'Amoxicillin 250mg', 15, 1.20, 2.50, '2025-09-06'),
(3, 'Vitamin C 1000mg', 10, 0.50, 1.20, '2025-09-06'),
(4, 'Ibuprofen 400mg', 12, 1.00, 2.00, '2025-09-01'),
(5, 'Cough Syrup 100ml', 8, 2.00, 3.50, '2025-08-30'),
(6, 'Antacid Tablets', 18, 0.60, 1.20, '2025-08-25'),
(7, 'Paracetamol 500mg', 25, 0.80, 1.50, '2025-08-02'),
(8, 'Vitamin C 1000mg', 30, 0.50, 1.20, '2025-07-28');

-- --------------------------------------------------------

--
-- Table structure for table `sales`
--

CREATE TABLE `sales` (
  `id` int(11) NOT NULL,
  `customer_name` varchar(255) NOT NULL,
  `total` decimal(10,2) NOT NULL,
  `tax_rate` decimal(5,2) DEFAULT 0.00,
  `grand_total` decimal(10,2) NOT NULL,
  `profit` decimal(10,2) DEFAULT 0.00,
  `sale_date` datetime DEFAULT current_timestamp(),
  `subtotal` decimal(10,2) NOT NULL DEFAULT 0.00,
  `tax_amount` decimal(10,2) NOT NULL DEFAULT 0.00
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `sales`
--

INSERT INTO `sales` (`id`, `customer_name`, `total`, `tax_rate`, `grand_total`, `profit`, `sale_date`, `subtotal`, `tax_amount`) VALUES
(1, 'Joynal', 0.00, 5.00, 0.00, 0.00, '2025-08-27 10:47:26', 0.00, 0.00),
(2, 'Joynal', 0.00, 5.00, 0.00, 0.00, '2025-08-27 10:47:37', 0.00, 0.00),
(3, '0', 0.00, 0.00, 0.00, 0.00, '2025-08-27 11:00:20', 0.00, 0.00),
(4, 'Sharif', 0.00, 5.00, 4.20, 0.00, '2025-08-27 11:01:48', 4.00, 0.20),
(5, 'Joynal', 0.00, 5.00, 4.20, 0.00, '2025-08-27 11:02:27', 4.00, 0.20),
(6, 'Joynal', 0.00, 5.00, 4.20, 0.00, '2025-08-27 11:03:24', 4.00, 0.20),
(7, 'Nayeem', 0.00, 5.00, 4.20, 0.00, '2025-08-27 11:08:32', 4.00, 0.20),
(8, 'Nayeem', 0.00, 5.00, 4.20, 0.00, '2025-08-27 22:11:34', 4.00, 0.20),
(9, 'Joynal', 0.00, 5.00, 4.20, 4.00, '2025-08-27 22:29:12', 4.00, 0.20),
(10, 'Joynal', 0.00, 5.00, 4.20, 4.00, '2025-08-27 22:30:25', 4.00, 0.20),
(11, 'Joynal', 0.00, 5.00, 4.20, 4.00, '2025-08-27 22:30:53', 4.00, 0.20),
(12, 'Joynal', 0.00, 5.00, 4.20, 4.00, '2025-08-27 22:33:57', 4.00, 0.20),
(13, 'Sharif', 0.00, 5.00, 4.20, 4.00, '2025-08-27 22:37:26', 4.00, 0.20),
(14, 'Joynal', 0.00, 5.00, 4.20, 4.00, '2025-08-28 11:40:23', 4.00, 0.20),
(15, 'Joynal', 0.00, 5.00, 4.20, 4.00, '2025-08-28 11:45:18', 4.00, 0.20),
(16, 'Joynal', 0.00, -5.00, 3.80, 4.00, '2025-08-28 19:16:24', 4.00, -0.20),
(17, 'Joynal', 0.00, -5.00, 57.00, 60.00, '2025-08-28 19:22:22', 60.00, -3.00),
(18, 'Joynal', 0.00, 5.00, 4.20, 4.00, '2025-08-28 20:11:34', 4.00, 0.20),
(19, 'Joynal', 0.00, 5.00, 4.20, 4.00, '2025-08-28 20:18:40', 4.00, 0.20),
(20, 'Joynal', 0.00, 5.00, 4.20, 4.00, '2025-08-28 20:20:35', 4.00, 0.20),
(21, 'Joynal', 0.00, 5.00, 4.20, 4.00, '2025-08-28 20:21:36', 4.00, 0.20),
(22, 'Joynal', 0.00, 5.00, 4.20, 4.00, '2025-08-28 20:22:50', 4.00, 0.20),
(23, 'Joynal', 0.00, 5.00, 4.20, 4.00, '2025-08-28 20:25:09', 4.00, 0.20),
(24, 'Joynal', 0.00, 5.00, 4.20, 4.00, '2025-08-28 20:27:26', 4.00, 0.20),
(25, 'Joynal', 0.00, 5.00, 210.00, 200.00, '2025-08-28 20:31:37', 200.00, 10.00),
(26, 'Joynal', 0.00, 5.00, 945.00, 900.00, '2025-08-31 10:05:25', 900.00, 45.00),
(27, 'Joynal', 0.00, 5.00, 252.00, 240.00, '2025-09-03 14:31:56', 240.00, 12.00),
(28, 'Joynal', 0.00, -5.00, 38.00, 40.00, '2025-09-03 15:08:34', 40.00, -2.00),
(29, 'Joynal', 0.00, 5.00, 508.20, 484.00, '2025-09-03 20:12:53', 484.00, 24.20),
(30, 'Bill', 0.00, 5.00, 2961.00, 2820.00, '2025-09-06 17:34:58', 2820.00, 141.00),
(31, 'Bob', 0.00, 5.00, 7602.00, 7240.00, '2025-09-06 22:57:55', 7240.00, 362.00);

-- --------------------------------------------------------

--
-- Table structure for table `sales_items`
--

CREATE TABLE `sales_items` (
  `id` int(11) NOT NULL,
  `sale_id` int(11) NOT NULL,
  `medicine_id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL,
  `selling_price` decimal(10,2) DEFAULT 0.00,
  `qty` int(11) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `cost_price` decimal(10,2) DEFAULT 0.00,
  `profit` decimal(10,2) DEFAULT 0.00,
  `total` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `sales_items`
--

INSERT INTO `sales_items` (`id`, `sale_id`, `medicine_id`, `quantity`, `selling_price`, `qty`, `price`, `cost_price`, `profit`, `total`) VALUES
(3, 4, 1, 2, 0.00, 0, 2.00, 0.00, 0.00, 0.00),
(4, 5, 1, 2, 0.00, 0, 2.00, 0.00, 0.00, 0.00),
(5, 6, 1, 2, 0.00, 0, 2.00, 0.00, 0.00, 0.00),
(6, 7, 1, 2, 0.00, 0, 2.00, 0.00, 0.00, 0.00),
(7, 8, 1, 2, 0.00, 0, 2.00, 0.00, 0.00, 0.00),
(8, 10, 1, 2, 2.00, 0, 0.00, 0.00, 4.00, 4.00),
(9, 11, 1, 2, 2.00, 0, 0.00, 0.00, 4.00, 4.00),
(10, 12, 1, 2, 2.00, 0, 0.00, 0.00, 4.00, 4.00),
(11, 13, 1, 2, 2.00, 0, 0.00, 0.00, 4.00, 4.00),
(12, 14, 1, 2, 2.00, 0, 0.00, 0.00, 4.00, 4.00),
(13, 15, 1, 2, 2.00, 0, 0.00, 0.00, 4.00, 4.00),
(14, 16, 1, 2, 2.00, 0, 0.00, 0.00, 4.00, 4.00),
(15, 17, 2, 6, 10.00, 0, 0.00, 0.00, 60.00, 60.00),
(16, 18, 1, 2, 2.00, 0, 0.00, 0.00, 4.00, 4.00),
(17, 19, 1, 2, 2.00, 0, 0.00, 0.00, 4.00, 4.00),
(18, 20, 1, 2, 2.00, 0, 0.00, 0.00, 4.00, 4.00),
(19, 21, 1, 2, 2.00, 0, 0.00, 0.00, 4.00, 4.00),
(20, 22, 1, 2, 2.00, 0, 0.00, 0.00, 4.00, 4.00),
(21, 23, 1, 2, 2.00, 0, 0.00, 0.00, 0.00, 4.00),
(22, 24, 1, 2, 2.00, 0, 0.00, 0.00, 0.00, 4.00),
(23, 25, 2, 5, 40.00, 0, 0.00, 0.00, 0.00, 200.00),
(24, 26, 7, 2, 450.00, 0, 0.00, 0.00, 0.00, 900.00),
(25, 27, 10, 2, 120.00, 0, 0.00, 0.00, 0.00, 240.00),
(26, 28, 9, 2, 20.00, 0, 0.00, 0.00, 0.00, 40.00),
(27, 29, 2, 22, 22.00, 0, 0.00, 0.00, 0.00, 484.00),
(28, 30, 9, 1, 20.00, 0, 0.00, 0.00, 0.00, 20.00),
(29, 30, 17, 1, 2200.00, 0, 0.00, 0.00, 0.00, 2200.00),
(30, 30, 23, 1, 600.00, 0, 0.00, 0.00, 0.00, 600.00),
(31, 31, 9, 2, 20.00, 0, 0.00, 0.00, 0.00, 40.00),
(32, 31, 17, 3, 2200.00, 0, 0.00, 0.00, 0.00, 6600.00),
(33, 31, 23, 1, 600.00, 0, 0.00, 0.00, 0.00, 600.00);

-- --------------------------------------------------------

--
-- Table structure for table `suppliers`
--

CREATE TABLE `suppliers` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `company_group` varchar(100) DEFAULT NULL,
  `contact` varchar(50) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `suppliers`
--

INSERT INTO `suppliers` (`id`, `name`, `company_group`, `contact`, `email`, `address`, `created_at`) VALUES
(1, 'Joynal', NULL, '01610146184', 'mdjoynalabedin2100@gmail.com', 'uttara-10,dhaka', '2025-08-23 17:36:55'),
(2, 'Nayeem', 'Square Grop Ltd.', '01610146188', 'mdnayem@gmail.com', 'uttara-10,dhaka', '2025-08-24 13:06:42');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `name` varchar(100) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `password`, `created_at`) VALUES
(1, 'Joynal', 'mdJoynal@gmail.com', '123', '2025-08-29 13:17:28'),
(3, 'sam', 'sam@gmail.com', '$2y$10$BOo.Br9LRTPz.dKmMxUH8..wtkGKilya8gSA8GZh3hrTzZBg7fmFa', '2025-09-06 08:52:31');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin_users`
--
ALTER TABLE `admin_users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- Indexes for table `customers`
--
ALTER TABLE `customers`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `medicines`
--
ALTER TABLE `medicines`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `order_items`
--
ALTER TABLE `order_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `order_id` (`order_id`),
  ADD KEY `medicine_id` (`medicine_id`);

--
-- Indexes for table `prescriptions`
--
ALTER TABLE `prescriptions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `customer_id` (`customer_id`);

--
-- Indexes for table `profit`
--
ALTER TABLE `profit`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sale_date` (`sale_date`),
  ADD KEY `medicine_name` (`medicine_name`);

--
-- Indexes for table `sales`
--
ALTER TABLE `sales`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sales_items`
--
ALTER TABLE `sales_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sale_id` (`sale_id`),
  ADD KEY `medicine_id` (`medicine_id`);

--
-- Indexes for table `suppliers`
--
ALTER TABLE `suppliers`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin_users`
--
ALTER TABLE `admin_users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `customers`
--
ALTER TABLE `customers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `medicines`
--
ALTER TABLE `medicines`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `order_items`
--
ALTER TABLE `order_items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT for table `prescriptions`
--
ALTER TABLE `prescriptions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `profit`
--
ALTER TABLE `profit`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `sales`
--
ALTER TABLE `sales`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- AUTO_INCREMENT for table `sales_items`
--
ALTER TABLE `sales_items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;

--
-- AUTO_INCREMENT for table `suppliers`
--
ALTER TABLE `suppliers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `order_items`
--
ALTER TABLE `order_items`
  ADD CONSTRAINT `order_items_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`),
  ADD CONSTRAINT `order_items_ibfk_2` FOREIGN KEY (`medicine_id`) REFERENCES `medicines` (`id`);

--
-- Constraints for table `sales_items`
--
ALTER TABLE `sales_items`
  ADD CONSTRAINT `sales_items_ibfk_1` FOREIGN KEY (`sale_id`) REFERENCES `sales` (`id`),
  ADD CONSTRAINT `sales_items_ibfk_2` FOREIGN KEY (`medicine_id`) REFERENCES `medicines` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
