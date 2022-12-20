-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 20, 2022 at 09:34 PM
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
-- Database: `wiki`
--

-- --------------------------------------------------------

--
-- Table structure for table `artikel`
--

CREATE TABLE `artikel` (
  `ArtikelID` int(11) NOT NULL,
  `TextID` int(11) NOT NULL,
  `BildIID` int(11) NOT NULL,
  `Titel` tinytext NOT NULL,
  `Thema` varchar(11) NOT NULL,
  `Edit Time` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `artikel`
--

INSERT INTO `artikel` (`ArtikelID`, `TextID`, `BildIID`, `Titel`, `Thema`, `Edit Time`) VALUES
(2, 0, 0, 'Insaner Titel', 'Thema1', '2022-12-19 16:33:12');

-- --------------------------------------------------------

--
-- Table structure for table `autor`
--

CREATE TABLE `autor` (
  `AutorID` int(11) NOT NULL,
  `Name` varchar(10) NOT NULL,
  `Passwort` varchar(32) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `autor`
--

INSERT INTO `autor` (`AutorID`, `Name`, `Passwort`) VALUES
(1, 'Test', '123456'),
(4, 'Test2', '123456');

-- --------------------------------------------------------

--
-- Table structure for table `autor-text hilfstabelle`
--

CREATE TABLE `autor-text hilfstabelle` (
  `HID` int(11) NOT NULL,
  `TextID` int(11) NOT NULL,
  `AutorID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `bild`
--

CREATE TABLE `bild` (
  `BildID` int(11) NOT NULL,
  `Alt Text` text NOT NULL,
  `Image` text NOT NULL COMMENT 'TODO. Image support'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `text`
--

CREATE TABLE `text` (
  `TextID` int(11) NOT NULL,
  `HID` int(11) NOT NULL,
  `Inhalt` mediumtext NOT NULL COMMENT 'Text des Artikels',
  `Title` text NOT NULL COMMENT 'Überschrift'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `artikel`
--
ALTER TABLE `artikel`
  ADD PRIMARY KEY (`ArtikelID`);

--
-- Indexes for table `autor`
--
ALTER TABLE `autor`
  ADD PRIMARY KEY (`AutorID`);

--
-- Indexes for table `autor-text hilfstabelle`
--
ALTER TABLE `autor-text hilfstabelle`
  ADD PRIMARY KEY (`HID`);

--
-- Indexes for table `bild`
--
ALTER TABLE `bild`
  ADD PRIMARY KEY (`BildID`);

--
-- Indexes for table `text`
--
ALTER TABLE `text`
  ADD PRIMARY KEY (`TextID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `artikel`
--
ALTER TABLE `artikel`
  MODIFY `ArtikelID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `autor`
--
ALTER TABLE `autor`
  MODIFY `AutorID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `autor-text hilfstabelle`
--
ALTER TABLE `autor-text hilfstabelle`
  MODIFY `HID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `bild`
--
ALTER TABLE `bild`
  MODIFY `BildID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `text`
--
ALTER TABLE `text`
  MODIFY `TextID` int(11) NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
