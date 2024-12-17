-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 17, 2024 at 03:12 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `crud`
--

-- --------------------------------------------------------

--
-- Table structure for table `tblaffectedbatch`
--

CREATE TABLE `tblaffectedbatch` (
  `Affected Batch Barcode` int(13) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tblbatch`
--

CREATE TABLE `tblbatch` (
  `Batch Barcode` int(13) NOT NULL,
  `Harvest Date` date NOT NULL,
  `Expirey Date` date NOT NULL,
  `Quantity` int(7) NOT NULL,
  `Product ID` int(7) NOT NULL,
  `Farm ID` int(7) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tblfarm`
--

CREATE TABLE `tblfarm` (
  `farm ID` int(7) NOT NULL,
  `Farm Name` varchar(20) NOT NULL,
  `Street` varchar(20) NOT NULL,
  `City` varchar(20) NOT NULL,
  `No. of Fields` int(5) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tblfarmtype`
--

CREATE TABLE `tblfarmtype` (
  `farm ID` int(7) NOT NULL,
  `Farm Type` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tblproduct`
--

CREATE TABLE `tblproduct` (
  `Product ID` int(7) NOT NULL,
  `Type` text NOT NULL,
  `Best Season` text NOT NULL,
  `Optimum Temperature` varchar(6) NOT NULL,
  `Optimum Humidity` varchar(6) NOT NULL,
  `Nutrition Value` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tblsignup`
--

CREATE TABLE `tblsignup` (
  `ID` int(7) NOT NULL,
  `First Name` varchar(30) NOT NULL,
  `Last Name` varchar(30) NOT NULL,
  `Email` varchar(30) NOT NULL,
  `Password` varchar(30) NOT NULL,
  `User` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tblunaffectedbatch`
--

CREATE TABLE `tblunaffectedbatch` (
  `Unaffected Batch Barcode` int(13) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tblaffectedbatch`
--
ALTER TABLE `tblaffectedbatch`
  ADD KEY `afb_fk` (`Affected Batch Barcode`);

--
-- Indexes for table `tblbatch`
--
ALTER TABLE `tblbatch`
  ADD PRIMARY KEY (`Batch Barcode`),
  ADD KEY `p_id_fk` (`Product ID`),
  ADD KEY `f_id_fk` (`Farm ID`);

--
-- Indexes for table `tblfarm`
--
ALTER TABLE `tblfarm`
  ADD KEY `farmID_fk` (`farm ID`);

--
-- Indexes for table `tblfarmtype`
--
ALTER TABLE `tblfarmtype`
  ADD KEY `farmid_fk` (`farm ID`);

--
-- Indexes for table `tblproduct`
--
ALTER TABLE `tblproduct`
  ADD PRIMARY KEY (`Product ID`);

--
-- Indexes for table `tblsignup`
--
ALTER TABLE `tblsignup`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `tblunaffectedbatch`
--
ALTER TABLE `tblunaffectedbatch`
  ADD KEY `ub_fk` (`Unaffected Batch Barcode`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tblbatch`
--
ALTER TABLE `tblbatch`
  MODIFY `Batch Barcode` int(13) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tblfarmtype`
--
ALTER TABLE `tblfarmtype`
  MODIFY `farm ID` int(7) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tblproduct`
--
ALTER TABLE `tblproduct`
  MODIFY `Product ID` int(7) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tblsignup`
--
ALTER TABLE `tblsignup`
  MODIFY `ID` int(7) NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `tblbatch`
--
ALTER TABLE `tblbatch`
  ADD CONSTRAINT `tblbatch_ibfk_1` FOREIGN KEY (`Farm ID`) REFERENCES `tblfarm` (`farm ID`),
  ADD CONSTRAINT `tblbatch_ibfk_2` FOREIGN KEY (`Product ID`) REFERENCES `tblproduct` (`Product ID`);

--
-- Constraints for table `tblfarm`
--
ALTER TABLE `tblfarm`
  ADD CONSTRAINT `tblfarm_ibfk_1` FOREIGN KEY (`farm ID`) REFERENCES `tblsignup` (`ID`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
