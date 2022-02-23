-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Feb 23, 2022 at 01:46 AM
-- Server version: 10.4.11-MariaDB
-- PHP Version: 7.3.18

SET FOREIGN_KEY_CHECKS=0;
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

DELIMITER $$
--
-- Procedures
--
CREATE PROCEDURE `add_gift` (IN `name` VARCHAR(255), IN `url` VARCHAR(255), IN `comments` TEXT, IN `user` INT)  NO SQL
BEGIN
INSERT INTO gift (name, url, notes, user)
VALUES (name, url, comments, user);
END$$

CREATE PROCEDURE `add_reset_code` (IN `email` VARCHAR(320), IN `code` VARCHAR(255))  NO SQL
BEGIN
INSERT INTO reset_code(email, code)
VALUES (email, code);
END$$

CREATE PROCEDURE `remove_reset_code` (IN `email` VARCHAR(320))  NO SQL
BEGIN
DELETE FROM reset_code WHERE reset_code.email=email;
END$$

--
-- Functions
--
CREATE FUNCTION `is_valid_reset_code` (`email` VARCHAR(320), `code` VARCHAR(255)) RETURNS TINYINT(1) NO SQL
return (SELECT TIMESTAMPDIFF(MINUTE, issue_time, CURRENT_TIMESTAMP) < 15 FROM reset_code WHERE reset_code.email = email AND reset_code.code = code)$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `gift`
--

CREATE TABLE IF NOT EXISTS `gift` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `active` tinyint(1) NOT NULL DEFAULT 1,
  `name` varchar(255) DEFAULT NULL,
  `url` varchar(255) DEFAULT NULL,
  `notes` text DEFAULT NULL,
  `reserved` tinyint(1) NOT NULL DEFAULT 0,
  `user` int(11) NOT NULL,
  `creation_time` timestamp NULL DEFAULT current_timestamp(),
  `reserved_time` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk-gift-user` (`user`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `reset_code`
--

CREATE TABLE IF NOT EXISTS `reset_code` (
  `email` varchar(320) NOT NULL,
  `code` varchar(255) NOT NULL,
  `issue_time` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE IF NOT EXISTS `user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(30) NOT NULL,
  `email` varchar(320) NOT NULL,
  `encrypted_password` varchar(255) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `unique-user-email` (`email`) USING BTREE,
  UNIQUE KEY `unique-user-username` (`username`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `gift`
--
ALTER TABLE `gift`
  ADD CONSTRAINT `fk-gift-user` FOREIGN KEY (`user`) REFERENCES `user` (`id`);
SET FOREIGN_KEY_CHECKS=1;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
