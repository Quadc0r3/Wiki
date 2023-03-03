-- phpMyAdmin SQL Dump
-- version 5.1.1deb5ubuntu1
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Feb 25, 2023 at 12:59 PM
-- Server version: 8.0.32-0ubuntu0.22.04.2
-- PHP Version: 8.1.2-1ubuntu2.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `Wiki`
--

-- --------------------------------------------------------

--
-- Table structure for table `article`
--

DROP TABLE `article`;

CREATE TABLE `article` (
  `ArticleID` int NOT NULL,
  `Title` tinytext NOT NULL,
  `Edit Time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `Creation Time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `Creator` int NOT NULL,
  `Is_editable` tinyint(1) NOT NULL DEFAULT '1',
  `Accessed` int NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `article`
--

INSERT INTO `article` (`ArticleID`, `Title`, `Edit Time`, `Creation Time`, `Creator`, `Is_editable`, `Accessed`) VALUES
(0, 'Invalid Article', '2023-01-04 14:20:08', '2023-01-04 14:20:08', 12, 0, 9),
(12, 'Foolshope', '2023-02-23 18:58:49', '2022-12-31 23:00:00', 15, 1, 47),
(14, 'Leerwick', '2023-02-23 19:21:09', '2022-12-31 23:00:00', 15, 1, 9),
(23, '19', '2023-02-23 19:00:56', '2023-01-04 13:54:21', 12, 1, 252),
(27, 'Montagu Family', '2023-02-23 19:00:01', '2023-01-06 17:23:01', 15, 1, 25),
(28, 'Ascua', '2023-02-23 19:02:06', '2023-01-06 18:14:59', 15, 1, 36),
(29, 'Edofast', '2023-02-23 19:20:51', '2023-01-06 18:22:46', 15, 1, 16),
(37, 'Geography of Geran', '2023-02-23 19:20:35', '2023-01-08 17:24:58', 15, 1, 16),
(38, 'Laton', '2023-02-23 19:19:58', '2023-01-08 17:32:00', 15, 1, 7),
(39, 'Pantheon\'s Summit', '2023-02-23 19:04:50', '2023-01-08 17:33:58', 15, 1, 10),
(40, 'History', '2023-02-23 19:02:53', '2023-01-08 17:39:20', 15, 1, 16),
(41, 'Odem', '2023-02-23 19:01:32', '2023-01-08 17:41:08', 15, 1, 11),
(42, 'Gruran', '2023-02-23 19:04:03', '2023-01-08 17:42:43', 15, 1, 13),
(43, 'Xoana', '2023-02-23 19:32:15', '2023-01-08 17:46:42', 15, 1, 19),
(44, 'Faen', '2023-02-23 19:03:15', '2023-01-08 17:49:30', 15, 1, 12),
(46, 'Vuswil', '2023-02-23 19:02:35', '2023-01-10 19:33:53', 15, 1, 55),
(54, 'Campaign 3 - Adventures of the Titties', '2023-02-23 18:57:41', '2023-01-19 11:15:55', 24, 1, 41),
(55, 'S11: DnDie Apprentices', '2023-02-23 18:57:59', '2023-01-19 11:22:27', 24, 1, 29),
(56, 'S12: DnDer Krieger', '2023-02-24 16:34:30', '2023-01-27 02:39:54', 24, 1, 59),
(58, 'How To', '2023-02-05 21:56:33', '2023-02-02 12:24:59', 12, 0, 40),
(59, 'Titties Hut', '2023-02-23 19:00:23', '2023-02-09 14:51:14', 24, 1, 22),
(60, 'Feedback', '2023-02-23 19:00:40', '2023-02-10 15:06:45', 12, 1, 12),
(61, 'S13: DnDie Bibliothek', '2023-02-23 18:58:21', '2023-02-21 12:48:50', 24, 1, 18),
(62, 'Vardos', '2023-02-23 18:57:02', '2023-02-23 14:16:02', 24, 1, 6),
(63, 'C3S13 Dungeon', '2023-02-23 20:39:30', '2023-02-23 20:34:27', 24, 1, 9),
(64, 'Fabiano Igorim', '2023-02-23 20:42:25', '2023-02-23 20:40:24', 24, 1, 2),
(65, 'Lyra Igorim', '2023-02-23 20:50:10', '2023-02-23 20:45:04', 24, 1, 4),
(66, 'Finix Strong', '2023-02-23 20:51:54', '2023-02-23 20:51:47', 24, 1, 3),
(67, 'Fargrim', '2023-02-23 20:58:04', '2023-02-23 20:53:44', 24, 1, 2);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `article`
--
ALTER TABLE `article`
  ADD PRIMARY KEY (`ArticleID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `article`
--
ALTER TABLE `article`
  MODIFY `ArticleID` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=69;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
