-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Feb 08, 2024 at 10:57 AM
-- Server version: 10.4.24-MariaDB
-- PHP Version: 8.1.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `empl`
--

-- --------------------------------------------------------

--
-- Table structure for table `user_emp`
--

CREATE TABLE `user_emp` (
  `id` int(3) NOT NULL,
  `firstname` varchar(30) NOT NULL,
  `lastname` varchar(30) NOT NULL,
  `addr` varchar(20) NOT NULL,
  `age` int(3) NOT NULL,
  `sex` varchar(5) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `user_emp`
--

INSERT INTO `user_emp` (`id`, `firstname`, `lastname`, `addr`, `age`, `sex`) VALUES
(1, 'omar', 'khaklad', 'nn', 23, 'ذكر'),
(2, 'ali', 'abdo', 'AAA', 20, 'ذكر'),
(5, 'احمد', 'صالح', 'aa', 30, 'ذكر'),
(6, 'trki', 'abdo', 'gg', 21, 'ذكر'),
(7, 'omar', 'khaklad', 'aa', 21, 'ذكر');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `user_emp`
--
ALTER TABLE `user_emp`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `user_emp`
--
ALTER TABLE `user_emp`
  MODIFY `id` int(3) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
