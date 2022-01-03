-- phpMyAdmin SQL Dump
-- version 4.9.7
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Jan 02, 2022 at 11:50 PM
-- Server version: 10.3.32-MariaDB-log-cll-lve
-- PHP Version: 7.3.32

SET FOREIGN_KEY_CHECKS=0;
SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `siftgafb_gift_data`
--

--
-- Dumping data for table `gift`
--

INSERT INTO `gift` (`id`, `active`, `name`, `url`, `notes`, `reserved`, `user`, `creation_time`) VALUES
(0, 0, 'test gift', 'https://www.amazon.ca/Unique-Ivory-White-Christmas-Stockings/dp/B0747BXLCD', '', 1, 1, '2021-12-24 08:14:07'),
(5, 1, 'Pure natural beeswax', 'https://www.meadowlilyfarm.com/product/beeswax-pounds/', '(in a form of bars, pellets or classic candles)', 0, 1, '2021-12-24 08:14:07'),
(6, 1, 'Flower press', 'https://themontessoriroom.com/products/wooden-flower-press?gclid=EAIaIQobChMIuon53OCQ9AIVxDY4Ch2ykgDHEAQYAiABEgKvSPD_BwE', 'or this: https://www.etsy.com/ca/listing/1085352945', 0, 1, '2021-12-24 08:14:07'),
(7, 1, 'Plant journal', 'https://www.amazon.ca/Herbarium-collect-flowers-inspired-analyzing/dp/B095MCP2CX/ref=mp_s_a_1_1?qid=1636649331', '', 1, 1, '2021-12-24 08:14:07'),
(8, 1, 'Reflector kit', 'https://www.amazon.ca/Portable-Collapsible-Photography-Lighting-Reflector/dp/B005M09B4E/ref=pd_aw_sbs_2/141-0187044-7002144?pd_rd_w=QW7PT', '', 1, 1, '2021-12-24 08:14:07'),
(9, 1, 'Ladle rest', 'https://www.amazon.ca/YAMAZAKI-home-Tosca-Ladle-Rest/dp/B00T71CIDK/ref=mp_s_a_1_102?dchild=1', '', 0, 1, '2021-12-24 08:14:07'),
(15, 1, 'Amazon gift card', '', '(no need to reserve)', 1, 2, '2021-12-24 08:14:07'),
(16, 1, 'Canada Computers gift card', '', '(no need to reserve)', 0, 2, '2021-12-24 08:14:07'),
(17, 1, 'Starbucks gift card', '', '(no need to reserve)', 0, 2, '2021-12-24 08:14:07'),
(18, 1, 'A chef\'s knife', '', '', 1, 2, '2021-12-24 08:14:07'),
(19, 1, 'Socks and underwear', '', '', 1, 2, '2021-12-24 08:14:07'),
(20, 1, 'Meyer Cast Iron 30cm/4.7L Kadai with lid', 'https://meyercanada.ca/products/meyer-cast-iron-30cm-4-7l-kadai-with-lid', 'currently on sale for $74.99 (half off)', 1, 2, '2021-12-24 08:14:07'),
(21, 1, 'Large wooden cutting board', '', '', 1, 2, '2021-12-24 08:14:07'),
(22, 1, 'Victorinox (or equivalent) paring knife', 'https://www.amazon.ca/Victorinox-Swiss-Classic-4-Inch-Paring/dp/B005LRYE36?th=1', 'a paring knife - preferably sharp and durable', 1, 2, '2021-12-24 08:14:07'),
(23, 1, 'Uninterruptible power supply', '', '', 1, 2, '2021-12-24 08:14:07'),
(24, 1, 'A set of steak knives', '', 'if you get me these then you can come over for steak', 1, 2, '2021-12-24 08:14:07'),
(26, 1, 'Saucepan', 'https://meyercanada.ca/collections/on-sale-now/products/meyer-nouvelle-stainless-steel-1-5l-saucepan-with-tempered-glass-lid-made-in-canada', '', 1, 1, '2021-12-24 08:14:07'),
(27, 1, 'Saute pan', 'https://meyercanada.ca/collections/on-sale-now/products/meyer-nouvelle-stainless-steel-24cm-saute-pan-made-in-canada', '', 1, 1, '2021-12-24 08:14:07'),
(28, 1, 'Sargent vol 8', 'https://www.amazon.ca/John-Singer-Sargent-Landscapes-1908-1913/dp/0300177364', '', 0, 1, '2021-12-24 08:14:07'),
(29, 1, 'Sargent vol 7', 'https://www.amazon.ca/John-Singer-Sargent-Landscapes-1900-1907/dp/0300177356', '', 0, 1, '2021-12-24 08:14:07'),
(30, 1, 'The Color of Pixar', 'https://www.amazon.ca/Color-Pixar-Tia-Kratter/dp/1452159203', '', 1, 1, '2021-12-24 08:14:07'),
(31, 1, 'Disney vol 1', 'https://www.amazon.ca/They-Drew-Pleased-Hidden-Disneys/dp/1452137439', '', 1, 1, '2021-12-24 08:14:07'),
(32, 1, 'Disney vol 2', 'https://www.amazon.ca/They-Drew-As-they-Pleased/dp/1452137447', '', 1, 1, '2021-12-24 08:14:07'),
(33, 1, 'Disney vol 3', 'https://www.amazon.ca/They-Drew-Pleased-Vol-Disneys/dp/1452151938', '', 0, 1, '2021-12-24 08:14:07'),
(34, 1, 'Disney vol 4', 'https://www.amazon.ca/They-Drew-Pleased-Vol-Mid-Century/dp/1452163855', '', 0, 1, '2021-12-24 08:14:07'),
(35, 1, 'Disney vol 5', 'https://www.amazon.ca/They-Drew-Pleased-Vol-Renaissance/dp/1452178704', '', 0, 1, '2021-12-24 08:14:07'),
(36, 1, 'Disney vol 6', 'https://www.amazon.ca/They-Drew-Pleased-Hidden-Disneys/dp/1797200933', '', 0, 1, '2021-12-24 08:14:07'),
(37, 0, 'BOOK 1: PORTRAIT SCULPTING: ANATOMY ', 'https://philippefaraut.com/collections/sculpting-books-dvds/products/book-1-portrait-sculpting-anatomy-expressions-in-clay', '10% off promo:\nSNOW21', 0, 1, '2021-12-24 08:14:07'),
(38, 0, 'BOOK 2: MASTERING PORTRAITURE: ADVANCED ANALYSES OF THE FACE SCULPTED IN CLAY', 'https://philippefaraut.com/collections/sculpting-books-dvds/products/book-2-mastering-portraiture-advanced-analyses-of-the-face-sculpted-in-clay', '10% off promo:\nSNOW21', 0, 1, '2021-12-24 08:14:07'),
(39, 0, 'BOOK 3: FIGURE SCULPTING VOLUME 1: PLANES ', 'https://philippefaraut.com/collections/sculpting-books-dvds/products/book-3-figure-sculpting-volume-i-planes-construction-techniques-in-clay', '10% off promo:\nSNOW21', 0, 1, '2021-12-24 08:14:07'),
(40, 0, 'BOOK 4: FIGURE SCULPTING VOLUME 2: GESTURE ', 'https://philippefaraut.com/collections/sculpting-books-dvds/products/book-4-figure-sculpting-volume-2-gesture-drapery-techniques-in-clay', '10% off promo:\nSNOW21', 0, 1, '2021-12-24 08:14:07'),
(41, 1, 'Amazon gift card', 'https://www.amazon.ca/gp/browse.html?node=9230166011', '', 0, 1, '2021-12-24 08:14:07'),
(42, 1, 'Chapters indigo gift card', 'https://www.chapters.indigo.ca/en-ca/giftcards/?ikredir=gift card#internal=1', '', 0, 1, '2021-12-24 08:14:07'),
(43, 1, 'Ikea gift card', 'https://www.ikea.com/ca/en/customer-service/ikea-gift-cards-puba64c3216', '', 0, 1, '2021-12-24 08:14:07'),
(44, 0, 'MONEY', '', '', 1, 2, '2021-12-24 08:14:07'),
(45, 1, ' CONVECTION BREAD MAKER', 'https://www.cuisinart.ca/CBK-200C.html?lang=en#lang=en', '', 0, 1, '2021-12-24 08:14:07'),
(46, 1, 'Suzanne The Corgi', 'https://namastedoggy.com/wp-content/uploads/2021/05/qweens-corgis-min.jpg', '', 1, 1, '2021-12-24 08:14:07'),
(47, 1, 'Electric toothbrush that tells you when you are brushing too hard', '', 'Recommended by Aunt Linda', 1, 2, '2021-12-24 08:14:07'),
(48, 1, 'Ukulele hanger', 'https://www.amazon.ca/dp/B07R4NXRV4/ref=sspa_mw_detail_1?psc=1', 'I have a ukulele which I have aspirations to learn how to play. Just missing a hanger. No excuses after >.<', 1, 1, '2021-12-24 08:14:07'),
(49, 1, 'Nifty Coffee Pod Mini Drawer, 24 Count', 'https://ecscoffee.com/products/nifty-coffee-pod-mini-drawer-24-count', '', 0, 2, '2021-12-24 08:14:07'),
(50, 0, 'Poop', 'https://poopsenders.com/', 'Don\'t actually buy this. Thanks.', 1, 2, '2021-12-24 08:14:07'),
(51, 1, 'Magnetic Stud Finder', 'https://www.homedepot.com/p/C-H-Hanson-Magnetic-Stud-Finder-03040/202563186', 'Any will do. Doesn\'t have to be the one linked.', 0, 2, '2022-01-03 03:49:35'),
(52, 1, 'Article gift card', 'https://www.article.com/giftcards/buy', '', 0, 2, '2022-01-03 03:49:47'),
(53, 0, 'Douk G5 100W Bluetooth Stereo Amplifier, Silver', 'https://www.amazon.ca/gp/product/B07X7YR9YW', '', 0, 2, '2022-01-03 03:49:58');

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `email`) VALUES
(2, '1bengardner@gmail.com'),
(1, 'yevgeniya.yussupova@gmail.com');
SET FOREIGN_KEY_CHECKS=1;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
