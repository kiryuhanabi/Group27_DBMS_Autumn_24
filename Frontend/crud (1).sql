-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 17, 2024 at 08:39 PM
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
-- Table structure for table `tblbatchcertification`
--

CREATE TABLE `tblbatchcertification` (
  `Batch Barcode` int(11) NOT NULL,
  `Certification` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tblbatchinspection`
--

CREATE TABLE `tblbatchinspection` (
  `Batch Barcode` int(7) NOT NULL,
  `Inspector ID` int(7) NOT NULL,
  `Affected Quantity` int(10) NOT NULL,
  `Unaffected Quality Grade` text NOT NULL,
  `Date` date NOT NULL
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
-- Table structure for table `tblfarminspection`
--

CREATE TABLE `tblfarminspection` (
  `Inspector ID` int(7) NOT NULL,
  `Farm ID` int(7) NOT NULL,
  `Maintenance Grade` text NOT NULL,
  `Fertilizer Grade` text NOT NULL,
  `Soil Quality Grade` text NOT NULL,
  `Date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tblfarminspection`
--

INSERT INTO `tblfarminspection` (`Inspector ID`, `Farm ID`, `Maintenance Grade`, `Fertilizer Grade`, `Soil Quality Grade`, `Date`) VALUES
(2222181, 215, 'Poor', 'Acceptable', 'Decent', '2024-12-18');

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
-- Table structure for table `tblinspector`
--

CREATE TABLE `tblinspector` (
  `Inspector ID` int(7) NOT NULL,
  `First Name` text NOT NULL,
  `Last Name` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tbllotinspection`
--

CREATE TABLE `tbllotinspection` (
  `Inspector ID` int(7) NOT NULL,
  `Lot Number` int(7) NOT NULL,
  `Date` date NOT NULL,
  `Package Quality Grade` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbllotinspection`
--

INSERT INTO `tbllotinspection` (`Inspector ID`, `Lot Number`, `Date`, `Package Quality Grade`) VALUES
(2222181, 168631, '2024-12-18', 'Perfect');

-- --------------------------------------------------------

--
-- Table structure for table `tblorder`
--

CREATE TABLE `tblorder` (
  `Order ID` int(7) NOT NULL,
  `Shipment ID` int(7) NOT NULL,
  `Retailer ID` int(7) NOT NULL,
  `Product Name` text NOT NULL,
  `Quantity` int(10) NOT NULL,
  `Date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tblpiotdevicehumidity`
--

CREATE TABLE `tblpiotdevicehumidity` (
  `pIoT ID` int(7) NOT NULL,
  `Humidity` varchar(6) NOT NULL,
  `Date` date NOT NULL,
  `Time` time NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tblplotdevicetemperature`
--

CREATE TABLE `tblplotdevicetemperature` (
  `pIoT ID` int(7) NOT NULL,
  `Temperature` varchar(5) NOT NULL,
  `Date` date NOT NULL,
  `Time` time NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tblprocessingcenter`
--

CREATE TABLE `tblprocessingcenter` (
  `Center ID` int(7) NOT NULL,
  `Type` varchar(20) NOT NULL,
  `Location` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tblprocessinginspection`
--

CREATE TABLE `tblprocessinginspection` (
  `Center ID` int(7) NOT NULL,
  `Inspector ID` int(7) NOT NULL,
  `Machine Quality Grade` text NOT NULL,
  `Processing Quality Grade` text NOT NULL,
  `Center Hygene Grade` text NOT NULL,
  `Staff Safety Grade` text NOT NULL,
  `Date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tblprocessingiot`
--

CREATE TABLE `tblprocessingiot` (
  `pIoT ID` int(7) NOT NULL,
  `Center ID` int(7) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tblprocessinglot`
--

CREATE TABLE `tblprocessinglot` (
  `Lot Number` int(7) NOT NULL,
  `Date` date NOT NULL,
  `Time` time NOT NULL,
  `Manufactured Date` date NOT NULL,
  `Expirey Date` date NOT NULL,
  `stTransport ID` int(7) NOT NULL,
  `Center ID` int(7) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tblprocessingshipmentquantity`
--

CREATE TABLE `tblprocessingshipmentquantity` (
  `Shipment ID` int(7) NOT NULL,
  `Lot Number` int(7) NOT NULL,
  `Quantity` varchar(6) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tblprocessingtransport`
--

CREATE TABLE `tblprocessingtransport` (
  `pTransport ID` int(7) NOT NULL,
  `Date` date NOT NULL,
  `Type` varchar(10) NOT NULL,
  `Transport Type` varchar(10) NOT NULL,
  `Temperature Range` varchar(10) NOT NULL,
  `Load Weight` int(10) NOT NULL
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
-- Table structure for table `tblretailer`
--

CREATE TABLE `tblretailer` (
  `Retailer ID` int(7) NOT NULL,
  `First Name` text NOT NULL,
  `Last Name` text NOT NULL,
  `Phone` varchar(20) NOT NULL,
  `Email` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tblshipment`
--

CREATE TABLE `tblshipment` (
  `Shipment ID` int(7) NOT NULL,
  `shTransport ID` int(7) NOT NULL,
  `Retailer ID` int(7) NOT NULL,
  `Shipment Date` date NOT NULL,
  `Shipment Quantity` int(6) NOT NULL,
  `Operating Temperature` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tblshipmenttransport`
--

CREATE TABLE `tblshipmenttransport` (
  `shTransport ID` int(7) NOT NULL,
  `Type` int(7) NOT NULL,
  `Transport Type` text NOT NULL,
  `Temperature Range` varchar(10) NOT NULL,
  `Storage ID` int(7) NOT NULL
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
-- Table structure for table `tblsiottemperature`
--

CREATE TABLE `tblsiottemperature` (
  `sIoT ID` int(7) NOT NULL,
  `Temperature` int(5) NOT NULL,
  `Date` date NOT NULL,
  `Time` time NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tblstorage`
--

CREATE TABLE `tblstorage` (
  `Storage ID` int(7) NOT NULL,
  `Storage Type` text NOT NULL,
  `Storage Duration` int(8) NOT NULL,
  `Location` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tblstorageinspection`
--

CREATE TABLE `tblstorageinspection` (
  `Storage ID` int(7) NOT NULL,
  `Inspector ID` int(7) NOT NULL,
  `Storage Maintenance Grade` text NOT NULL,
  `Pest Control Grade` text NOT NULL,
  `Storage Hygene Grade` text NOT NULL,
  `date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tblstorageinspection`
--

INSERT INTO `tblstorageinspection` (`Storage ID`, `Inspector ID`, `Storage Maintenance Grade`, `Pest Control Grade`, `Storage Hygene Grade`, `date`) VALUES
(5343200, 2222181, 'Acceptable', 'Decent', 'Excellent', '2024-12-18');

-- --------------------------------------------------------

--
-- Table structure for table `tblstorageiot`
--

CREATE TABLE `tblstorageiot` (
  `sIoT ID` int(7) NOT NULL,
  `Storage ID` int(7) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tblstorageiothumidity`
--

CREATE TABLE `tblstorageiothumidity` (
  `sIoT ID` int(7) NOT NULL,
  `Humidity` varchar(5) NOT NULL,
  `Date` date NOT NULL,
  `Time` time NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tblstoragetransport`
--

CREATE TABLE `tblstoragetransport` (
  `stTransport ID` int(7) NOT NULL,
  `Storage ID` int(7) NOT NULL,
  `Transport Storage Type` text NOT NULL,
  `Date` date NOT NULL,
  `Transport Type` text NOT NULL,
  `Temperature Range` varchar(10) NOT NULL,
  `Load Weight` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tbltiotdevicehumidity`
--

CREATE TABLE `tbltiotdevicehumidity` (
  `tIoT ID` int(7) NOT NULL,
  `Humidity` varchar(5) NOT NULL,
  `Date` date NOT NULL,
  `Time` time NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tbltiotdevicetemperature`
--

CREATE TABLE `tbltiotdevicetemperature` (
  `tIoT ID` int(7) NOT NULL,
  `Temperature` varchar(5) NOT NULL,
  `Date` date NOT NULL,
  `Time` time NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tbltransportoitdevice`
--

CREATE TABLE `tbltransportoitdevice` (
  `shTransport ID` int(7) NOT NULL,
  `tIoT ID` int(7) NOT NULL
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
-- Indexes for table `tblbatchcertification`
--
ALTER TABLE `tblbatchcertification`
  ADD KEY `bb_fk` (`Batch Barcode`);

--
-- Indexes for table `tblbatchinspection`
--
ALTER TABLE `tblbatchinspection`
  ADD KEY `Batch Barcode` (`Batch Barcode`),
  ADD KEY `Inspector ID` (`Inspector ID`);

--
-- Indexes for table `tblfarm`
--
ALTER TABLE `tblfarm`
  ADD KEY `farmID_fk` (`farm ID`);

--
-- Indexes for table `tblfarminspection`
--
ALTER TABLE `tblfarminspection`
  ADD KEY `Inspector ID` (`Inspector ID`),
  ADD KEY `Farm ID` (`Farm ID`);

--
-- Indexes for table `tblfarmtype`
--
ALTER TABLE `tblfarmtype`
  ADD KEY `farmid_fk` (`farm ID`);

--
-- Indexes for table `tblinspector`
--
ALTER TABLE `tblinspector`
  ADD PRIMARY KEY (`Inspector ID`);

--
-- Indexes for table `tbllotinspection`
--
ALTER TABLE `tbllotinspection`
  ADD KEY `Inspector ID` (`Inspector ID`),
  ADD KEY `Lot Number` (`Lot Number`);

--
-- Indexes for table `tblorder`
--
ALTER TABLE `tblorder`
  ADD PRIMARY KEY (`Order ID`),
  ADD KEY `Shipment ID` (`Shipment ID`),
  ADD KEY `Retailer ID` (`Retailer ID`);

--
-- Indexes for table `tblpiotdevicehumidity`
--
ALTER TABLE `tblpiotdevicehumidity`
  ADD PRIMARY KEY (`Date`,`Time`),
  ADD KEY `pIoT ID` (`pIoT ID`);

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
