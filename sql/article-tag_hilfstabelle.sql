-- phpMyAdmin SQL Dump
-- version 5.1.1deb5ubuntu1
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Feb 25, 2023 at 12:58 PM
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
-- Table structure for table `article-tag hilfstabelle`
--

CREATE TABLE `article-tag hilfstabelle` (
  `AKID` int NOT NULL,
  `ArticleID` int NOT NULL,
  `TagID` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `article-tag hilfstabelle`
--

INSERT INTO `article-tag hilfstabelle` (`AKID`, `ArticleID`, `TagID`) VALUES
(19, 62, 12),
(20, 62, 9),
(21, 54, 9),
(22, 55, 9),
(23, 55, 13),
(24, 61, 9),
(25, 61, 13),
(28, 12, 11),
(29, 12, 9),
(30, 12, 10),
(31, 27, 14),
(32, 27, 11),
(33, 59, 9),
(34, 60, 15),
(35, 23, 16),
(36, 41, 17),
(37, 41, 14),
(38, 28, 18),
(39, 46, 18),
(40, 46, 11),
(41, 46, 9),
(42, 40, 17),
(43, 44, 10),
(45, 42, 17),
(46, 42, 20),
(47, 39, 21),
(48, 39, 22),
(49, 38, 17),
(50, 38, 23),
(51, 37, 21),
(52, 29, 10),
(53, 14, 10),
(54, 14, 9),
(55, 43, 18),
(57, 63, 9),
(58, 64, 9),
(59, 64, 14),
(62, 65, 9),
(63, 65, 14),
(64, 66, 9),
(65, 67, 9),
(66, 67, 14),
(69, 56, 9),
(70, 56, 13);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `article-tag hilfstabelle`
--
ALTER TABLE `article-tag hilfstabelle`
  ADD PRIMARY KEY (`AKID`),
  ADD KEY `article-keyword hilfstabelle_article_ArticleID_fk` (`ArticleID`),
  ADD KEY `article-keyword hilfstabelle_keywords_KeyID_fk` (`TagID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `article-tag hilfstabelle`
--
ALTER TABLE `article-tag hilfstabelle`
  MODIFY `AKID` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=71;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `article-tag hilfstabelle`
--
ALTER TABLE `article-tag hilfstabelle`
  ADD CONSTRAINT `article-keyword hilfstabelle_article_ArticleID_fk` FOREIGN KEY (`ArticleID`) REFERENCES `article` (`ArticleID`) ON DELETE CASCADE,
  ADD CONSTRAINT `article-keyword hilfstabelle_keywords_KeyID_fk` FOREIGN KEY (`TagID`) REFERENCES `tags` (`TagID`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
