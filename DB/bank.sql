-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:8111
-- Generation Time: Sep 20, 2023 at 07:16 PM
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
-- Database: `bank`
--

-- --------------------------------------------------------

--
-- Table structure for table `credentials`
--

CREATE TABLE `credentials` (
  `userID` int(10) NOT NULL,
  `username` char(20) NOT NULL,
  `passhash` char(32) NOT NULL,
  `accountID` char(9) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `credentials`
--

INSERT INTO `credentials` (`userID`, `username`, `passhash`, `accountID`) VALUES
(1, 'ariel123', 'afdd0b4ad2ec172c586e2150770fbf9e', '962175047'),
(2, 'test', '098f6bcd4621d373cade4e832627b4f6', '341326423');

-- --------------------------------------------------------

--
-- Table structure for table `totalmoney`
--

CREATE TABLE `totalmoney` (
  `userID` int(10) NOT NULL,
  `accountID` char(9) CHARACTER SET utf8 NOT NULL,
  `total` float NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `totalmoney`
--

INSERT INTO `totalmoney` (`userID`, `accountID`, `total`) VALUES
(1, '962175047', 0),
(2, '341326423', 0);

-- --------------------------------------------------------

--
-- Table structure for table `transfers`
--

CREATE TABLE `transfers` (
  `TransferID` int(11) NOT NULL,
  `accountFromID` char(9) NOT NULL,
  `accountToID` char(9) NOT NULL,
  `type` char(10) DEFAULT NULL,
  `amount` int(9) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `credentials`
--
ALTER TABLE `credentials`
  ADD PRIMARY KEY (`userID`),
  ADD UNIQUE KEY `accountID` (`accountID`),
  ADD UNIQUE KEY `username` (`username`);

--
-- Indexes for table `totalmoney`
--
ALTER TABLE `totalmoney`
  ADD PRIMARY KEY (`userID`),
  ADD UNIQUE KEY `accountID` (`accountID`),
  ADD KEY `userID` (`userID`);

--
-- Indexes for table `transfers`
--
ALTER TABLE `transfers`
  ADD PRIMARY KEY (`TransferID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `credentials`
--
ALTER TABLE `credentials`
  MODIFY `userID` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `totalmoney`
--
ALTER TABLE `totalmoney`
  MODIFY `userID` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `transfers`
--
ALTER TABLE `transfers`
  MODIFY `TransferID` int(11) NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `totalmoney`
--
ALTER TABLE `totalmoney`
  ADD CONSTRAINT `totalmoney_ibfk_1` FOREIGN KEY (`userID`) REFERENCES `credentials` (`userID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `totalmoney_ibfk_2` FOREIGN KEY (`accountID`) REFERENCES `credentials` (`accountID`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
