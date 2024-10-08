-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 02, 2024 at 01:34 AM
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
DROP PROCEDURE IF EXISTS `add_gift`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `add_gift` (IN `name` VARCHAR(255), IN `url` VARCHAR(255), IN `comments` TEXT, IN `user` INT)  NO SQL
BEGIN
INSERT INTO gift (name, url, notes, user)
VALUES (TRIM(name), url, TRIM(comments), user);
END$$

DROP PROCEDURE IF EXISTS `add_message_email`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `add_message_email` (IN `user` INT)  NO SQL
BEGIN
REPLACE INTO message_email(user)
VALUES (user);
END$$

DROP PROCEDURE IF EXISTS `add_reset_code`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `add_reset_code` (IN `email` VARCHAR(320), IN `code` VARCHAR(255))  NO SQL
BEGIN
REPLACE INTO reset_code(email, code)
VALUES (email, code);
END$$

DROP PROCEDURE IF EXISTS `add_verification_code`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `add_verification_code` (IN `email` VARCHAR(320), IN `code` VARCHAR(255))  NO SQL
BEGIN
REPLACE INTO verification_code(email, code)
VALUES (email, code);
END$$

DROP PROCEDURE IF EXISTS `edit_gift`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `edit_gift` (IN `id` INT, IN `name` VARCHAR(255), IN `url` VARCHAR(255), IN `comments` TEXT, IN `user` INT)  NO SQL
UPDATE gift
SET `name` = name, `url` = url, notes = comments
WHERE gift.id=id AND gift.user=user$$

DROP PROCEDURE IF EXISTS `get_conversations`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `get_conversations` (IN `id` INT)  NO SQL
SELECT *
FROM message
JOIN (
  SELECT conversation_partner_id, MAX(most_recent) most_recent
  FROM (
    SELECT `from` conversation_partner_id, MAX(sent_time) most_recent
    FROM message
    WHERE `to`=id AND deleted=FALSE
    GROUP BY `from` UNION
    SELECT `to`, MAX(sent_time) most_recent
    FROM message
    WHERE `from`=id
    GROUP BY `to`
  ) most_recent_converation_message_by_partner
  GROUP BY conversation_partner_id
) conversation
ON (
  `to`=conversation_partner_id OR `from`=conversation_partner_id
) AND sent_time=most_recent
GROUP BY conversation_partner_id UNION
SELECT *, NULL conversation_partner_id, sent_time most_recent
FROM message
WHERE `from` is NULL AND `to`=id AND deleted=FALSE
ORDER BY most_recent DESC$$

DROP PROCEDURE IF EXISTS `get_message`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `get_message` (IN `id` INT)  NO SQL
BEGIN
SELECT * FROM message WHERE message.id = id;
UPDATE message SET unread=FALSE WHERE message.id=id;
END$$

DROP PROCEDURE IF EXISTS `read_messages`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `read_messages` (IN `reader` INT, IN `other` INT)  NO SQL
BEGIN

SELECT * FROM message
WHERE message.`to`=`reader` AND message.`from`=`other` AND deleted=FALSE
UNION (
  SELECT *
  FROM message
  WHERE message.`to`=`other` AND message.`from`=`reader`
) ORDER BY sent_time ASC;

UPDATE message
SET unread=FALSE
WHERE message.`to`=`reader` AND message.`from`=`other`;

END$$

DROP PROCEDURE IF EXISTS `update_profile`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `update_profile` (IN `id` INT, IN `username` VARCHAR(30), IN `encrypted_password` VARCHAR(255), IN `visible` BOOLEAN, IN `subscribed` BOOLEAN)  NO SQL
UPDATE `user` SET user.username=COALESCE(username, user.username), user.encrypted_password=COALESCE(encrypted_password, user.encrypted_password), user.visible=COALESCE(visible, user.visible), user.subscribed=COALESCE(subscribed, user.subscribed) WHERE user.id=id$$

--
-- Functions
--
DROP FUNCTION IF EXISTS `is_ready_for_message_email`$$
CREATE DEFINER=`root`@`localhost` FUNCTION `is_ready_for_message_email` (`to` INT) RETURNS TINYINT(1) NO SQL
return COALESCE((SELECT TIMESTAMPDIFF(MINUTE, sent_time, CURRENT_TIMESTAMP) > 5 FROM message_email WHERE message_email.user = `to`), 1)$$

DROP FUNCTION IF EXISTS `is_valid_reset_code`$$
CREATE DEFINER=`root`@`localhost` FUNCTION `is_valid_reset_code` (`email` VARCHAR(320), `code` VARCHAR(255)) RETURNS TINYINT(1) NO SQL
return (SELECT TIMESTAMPDIFF(MINUTE, issue_time, CURRENT_TIMESTAMP) < 15 FROM reset_code WHERE reset_code.email = email AND reset_code.code = code)$$

DROP FUNCTION IF EXISTS `is_valid_verification_code`$$
CREATE DEFINER=`root`@`localhost` FUNCTION `is_valid_verification_code` (`email` VARCHAR(320), `code` VARCHAR(255)) RETURNS TINYINT(1) NO SQL
return (SELECT 1 FROM verification_code WHERE verification_code.email = email AND verification_code.code = code)$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `gift`
--

DROP TABLE IF EXISTS `gift`;
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
-- Table structure for table `message`
--

DROP TABLE IF EXISTS `message`;
CREATE TABLE IF NOT EXISTS `message` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `to` int(11) NOT NULL,
  `from` int(11) DEFAULT NULL,
  `body` text NOT NULL,
  `sent_time` timestamp NOT NULL DEFAULT current_timestamp(),
  `guest_name` varchar(100) DEFAULT NULL,
  `unread` tinyint(1) NOT NULL DEFAULT 1,
  `deleted` tinyint(1) NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`),
  KEY `fk-message-from` (`from`),
  KEY `index-message-to-from-sent_time` (`to`,`from`,`sent_time`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `message_email`
--

DROP TABLE IF EXISTS `message_email`;
CREATE TABLE IF NOT EXISTS `message_email` (
  `user` int(11) NOT NULL,
  `sent_time` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`user`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `reset_code`
--

DROP TABLE IF EXISTS `reset_code`;
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

DROP TABLE IF EXISTS `user`;
CREATE TABLE IF NOT EXISTS `user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(30) NOT NULL,
  `email` varchar(320) NOT NULL,
  `encrypted_password` varchar(255) NOT NULL,
  `verified` tinyint(1) NOT NULL DEFAULT 0,
  `visible` tinyint(1) NOT NULL DEFAULT 0,
  `subscribed` tinyint(1) NOT NULL DEFAULT 1,
  PRIMARY KEY (`id`),
  UNIQUE KEY `unique-user-email` (`email`) USING BTREE,
  UNIQUE KEY `unique-user-username` (`username`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `verification_code`
--

DROP TABLE IF EXISTS `verification_code`;
CREATE TABLE IF NOT EXISTS `verification_code` (
  `email` varchar(320) NOT NULL,
  `code` varchar(255) NOT NULL,
  `issue_time` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `gift`
--
ALTER TABLE `gift`
  ADD CONSTRAINT `fk-gift-user` FOREIGN KEY (`user`) REFERENCES `user` (`id`);

--
-- Constraints for table `message`
--
ALTER TABLE `message`
  ADD CONSTRAINT `fk-message-from` FOREIGN KEY (`from`) REFERENCES `user` (`id`),
  ADD CONSTRAINT `fk-message-to` FOREIGN KEY (`to`) REFERENCES `user` (`id`);

--
-- Constraints for table `message_email`
--
ALTER TABLE `message_email`
  ADD CONSTRAINT `fk-message_email-user` FOREIGN KEY (`user`) REFERENCES `user` (`id`);
SET FOREIGN_KEY_CHECKS=1;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
