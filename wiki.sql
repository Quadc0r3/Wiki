-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 04, 2023 at 03:32 PM
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
  `Titel` tinytext NOT NULL,
  `Thema` varchar(11) NOT NULL,
  `Edit Time` timestamp NOT NULL DEFAULT current_timestamp(),
  `Creation Time` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `artikel`
--

INSERT INTO `artikel` (`ArtikelID`, `Titel`, `Thema`, `Edit Time`, `Creation Time`) VALUES
(0, 'NESESSARY', 'SO THAT THE', '2023-01-04 14:20:08', '2023-01-04 14:20:08'),
(11, 'Silveroak 1', '', '2023-01-03 18:30:11', '2022-12-31 23:00:00'),
(12, 'Foolshope', '', '2023-01-01 14:22:55', '2022-12-31 23:00:00'),
(13, 'Discworld', '', '2022-12-29 18:46:45', '2022-12-31 23:00:00'),
(14, 'Leerwick', '', '2022-12-30 11:49:21', '2022-12-31 23:00:00'),
(15, 'Vuswil', '', '2023-01-03 19:11:44', '2022-12-31 23:00:00'),
(16, 'Test', '', '2023-01-01 17:10:27', '2023-01-01 15:02:15'),
(17, 'Tit', '', '2023-01-04 13:40:16', '2023-01-01 17:07:14'),
(23, '19', '', '2023-01-04 14:13:14', '2023-01-04 13:54:21'),
(24, '23', '', '2023-01-04 14:16:55', '2023-01-04 14:16:55');

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
(12, 'admin', 'admin'),
(14, 'Michelle', '123456'),
(15, 'Cassi', 'Melloy'),
(20, 'Felix', 'Minecraft');

-- --------------------------------------------------------

--
-- Table structure for table `autor-text hilfstabelle`
--

CREATE TABLE `autor-text hilfstabelle` (
  `HID` int(11) NOT NULL,
  `TextID` int(11) NOT NULL,
  `AutorID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `autor-text hilfstabelle`
--

INSERT INTO `autor-text hilfstabelle` (`HID`, `TextID`, `AutorID`) VALUES
(1, 1, 12),
(2, 2, 12),
(3, 3, 12),
(4, 4, 12),
(5, 5, 1),
(6, 6, 1),
(7, 7, 12),
(8, 8, 12),
(9, 9, 12),
(10, 10, 15),
(11, 11, 15),
(12, 12, 12),
(13, 13, 12),
(14, 14, 12),
(15, 15, 12),
(16, 16, 12),
(17, 17, 12),
(20, 20, 12),
(21, 21, 12),
(22, 22, 15),
(23, 23, 15),
(24, 24, 12),
(25, 25, 12),
(26, 26, 12);

-- --------------------------------------------------------

--
-- Table structure for table `bild`
--

CREATE TABLE `bild` (
  `BildID` int(11) NOT NULL,
  `ArtikelID` int(11) DEFAULT NULL,
  `Alt Text` text NOT NULL,
  `Image` text NOT NULL COMMENT 'TODO. Image support'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `bild`
--

INSERT INTO `bild` (`BildID`, `ArtikelID`, `Alt Text`, `Image`) VALUES
(1, 11, 'Bild1', 'Pic1');

-- --------------------------------------------------------

--
-- Table structure for table `text`
--

CREATE TABLE `text` (
  `TextID` int(11) NOT NULL,
  `ArtikelID` int(11) NOT NULL,
  `Title` text NOT NULL COMMENT 'Überschrift',
  `Inhalt` mediumtext NOT NULL COMMENT 'Text des Artikels'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `text`
--

INSERT INTO `text` (`TextID`, `ArtikelID`, `Title`, `Inhalt`) VALUES
(1, 11, 'aa', 'aaa'),
(2, 11, 'bb', 'bbb'),
(3, 12, 'William Montagu', 'Questgiver and thanks to us a dead man'),
(4, 12, 'William Montagu', 'Questgiver and thanks to us a dead man'),
(5, 13, 'Mort', 'Book 1 of the Death Series'),
(6, 13, 'Reaper Man', 'Book 2 of the Death Series'),
(7, 14, 'Namensherkunft', 'Der Name \"Leerwick\" entstand durch die Belagerung des Bauerndorfes der Hexe. Da dieses Dorf sehr nahe an dem Covencona Forest liegt, nutzte die Hexe dessen Schutz und versteckte sich dort bei Tag. Es leitet sich von \"Lurking Witch\" ab.'),
(8, 14, 'Überfälle', 'In letzter Zeit wurden immer mehr verschollene Wertgegenstände gemeldet. Jedoch weiß niemand, wo diese sind.'),
(9, 14, 'Bürgermeister', 'Der Bürgermeister konnte erfolgreich die Anschuldigungen über das Verschwenden des Dorfgeldes widerlegen, da er nicht einmal in Besitz des Schlüssels zum Zeitpunkt des Ereignisses war'),
(10, 15, 'Vuswil', 'Vuswil is a region in the south-west of Geran. It has a temperate climate and access to the sea. It'),
(11, 15, 'Society', 'Government: Monarchy Unlike many other monarchies, Vuswil'),
(12, 16, 'a', 'aa'),
(13, 16, 'b', 'bb'),
(14, 16, 'c', 'cc'),
(15, 17, 'a', 'aa'),
(16, 17, 'b', 'bb'),
(17, 17, 'c', 'cc'),
(20, 11, 'ccs', 'cccs'),
(21, 11, 'dds', 'ddds'),
(22, 15, 'History', 'About 4 years ago, Vuswil lost their old king, who was heavily influenced by the god Taas and banned the worship of various gods, including Rabu. Now king Charles rules over Vuswil but hasn'),
(23, 15, 'Locations', 'Cities Edofast Oregate Whitebay Orkrin Belfort Foolshope Silveroak Merrihill Leerwick Deepmarsh Lochfog Tow Mirestone Geographic Locations Covencona Forest Calm Woods Starpeak'),
(24, 23, 'a', ''),
(25, 23, 'b', ''),
(26, 24, 'a', '');

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
  ADD PRIMARY KEY (`HID`),
  ADD KEY `TextID` (`TextID`),
  ADD KEY `AutorID` (`AutorID`);

--
-- Indexes for table `bild`
--
ALTER TABLE `bild`
  ADD PRIMARY KEY (`BildID`),
  ADD KEY `ArtikelID` (`ArtikelID`);

--
-- Indexes for table `text`
--
ALTER TABLE `text`
  ADD PRIMARY KEY (`TextID`),
  ADD KEY `ArtikelID` (`ArtikelID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `artikel`
--
ALTER TABLE `artikel`
  MODIFY `ArtikelID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT for table `autor`
--
ALTER TABLE `autor`
  MODIFY `AutorID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `bild`
--
ALTER TABLE `bild`
  MODIFY `BildID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `autor-text hilfstabelle`
--
ALTER TABLE `autor-text hilfstabelle`
  ADD CONSTRAINT `autor-text hilfstabelle_ibfk_1` FOREIGN KEY (`TextID`) REFERENCES `text` (`TextID`),
  ADD CONSTRAINT `autor-text hilfstabelle_ibfk_2` FOREIGN KEY (`AutorID`) REFERENCES `autor` (`AutorID`);

--
-- Constraints for table `bild`
--
ALTER TABLE `bild`
  ADD CONSTRAINT `bild_ibfk_1` FOREIGN KEY (`ArtikelID`) REFERENCES `artikel` (`ArtikelID`);

--
-- Constraints for table `text`
--
ALTER TABLE `text`
  ADD CONSTRAINT `text_ibfk_1` FOREIGN KEY (`ArtikelID`) REFERENCES `artikel` (`ArtikelID`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
