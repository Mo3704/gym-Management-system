-- phpMyAdmin SQL Dump
-- version 4.9.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 27, 2021 at 04:24 PM
-- Server version: 10.4.11-MariaDB
-- PHP Version: 7.2.26

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `webdamn_demo`
--

-- --------------------------------------------------------

--
-- Table structure for table `expense_users`
--

CREATE TABLE `expense_users` (
  `id` int(11) UNSIGNED NOT NULL,
  `first_name` varchar(255) DEFAULT NULL,
  `last_name` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `password` varchar(64) NOT NULL,
  `role` enum('admin') DEFAULT 'admin'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `expense_users`
--

INSERT INTO `expense_users` (`id`, `first_name`, `last_name`, `email`, `password`, `role`) VALUES
(1, 'web', 'damn', 'admin@webdamn.com', '202cb962ac59075b964b07152d234b70', 'admin'),
(2, 'Mark', 'Wood', 'mark@webdamn.com', '202cb962ac59075b964b07152d234b70', 'admin'),
(3, 'George', 'Smith', 'goerge@webdamn.com', '202cb962ac59075b964b07152d234b70', 'admin');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `expense_users`
--
ALTER TABLE `expense_users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `expense_users`
--
ALTER TABLE `expense_users`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
