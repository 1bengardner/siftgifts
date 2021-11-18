-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 18, 2021 at 03:55 PM
-- Server version: 10.4.11-MariaDB
-- PHP Version: 7.3.18

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `gift_data`
--
CREATE DATABASE IF NOT EXISTS `gift_data` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `gift_data`;

DELIMITER $$
--
-- Procedures
--
CREATE PROCEDURE `add_gift` (IN `name` VARCHAR(255), IN `url` VARCHAR(255), IN `comments` TEXT)  NO SQL
BEGIN
INSERT INTO gift (name, url, notes)
VALUES (name, url, comments);
END$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `gift`
--

CREATE TABLE `gift` (
  `id` int(11) NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `url` varchar(255) DEFAULT NULL,
  `notes` text DEFAULT NULL,
  `reserved` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `gift`
--

INSERT INTO `gift` (`id`, `name`, `url`, `notes`, `reserved`) VALUES
(0, 'Christmas Sock', 'https://www.amazon.ca/Unique-Ivory-White-Christmas-Stockings/dp/B0747BXLCD', '', 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `gift`
--
ALTER TABLE `gift`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `gift`
--
ALTER TABLE `gift`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
