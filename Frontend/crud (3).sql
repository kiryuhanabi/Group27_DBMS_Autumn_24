-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 21, 2024 at 07:09 PM
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
  `Expiry Date` date NOT NULL,
  `Quantity` int(7) NOT NULL,
  `Product ID` int(7) NOT NULL,
  `Farm ID` int(7) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tblbatch`
--

INSERT INTO `tblbatch` (`Batch Barcode`, `Harvest Date`, `Expiry Date`, `Quantity`, `Product ID`, `Farm ID`) VALUES
(4, '2024-12-19', '2024-12-28', 50, 9, 12),
(11, '2024-12-17', '2024-12-27', 50, 18, 16);

-- --------------------------------------------------------

--
-- Table structure for table `tblbatchcertification`
--

CREATE TABLE `tblbatchcertification` (
  `Batch Barcode` int(11) NOT NULL,
  `Certification` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tblbatchcertification`
--

INSERT INTO `tblbatchcertification` (`Batch Barcode`, `Certification`) VALUES
(10, 'Halal');

-- --------------------------------------------------------

--
-- Table structure for table `tblbatchinspection`
--

CREATE TABLE `tblbatchinspection` (
  `Batch Barcode` int(7) NOT NULL,
  `Inspector ID` int(7) NOT NULL,
  `Unaffected Quality Grade` text NOT NULL,
  `Date` date NOT NULL,
  `Certification` text NOT NULL
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

--
-- Dumping data for table `tblfarm`
--

INSERT INTO `tblfarm` (`farm ID`, `Farm Name`, `Street`, `City`, `No. of Fields`) VALUES
(12, 'Goldwing', '123 avenue', 'tangail', 1000),
(16, 'Abir Golf', '123 avenue', 'dhaka', 12);

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
(2222181, 12, 'Acceptable', 'Decent', 'Perfect', '2024-12-18');

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

-- --------------------------------------------------------

--
-- Table structure for table `tblorder`
--

CREATE TABLE `tblorder` (
  `Order ID` int(7) NOT NULL,
  `Retailer ID` int(7) NOT NULL,
  `Product Name` text NOT NULL,
  `Quantity` int(10) NOT NULL,
  `Date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tblorder`
--

INSERT INTO `tblorder` (`Order ID`, `Retailer ID`, `Product Name`, `Quantity`, `Date`) VALUES
(3, 55555, 'baked beet', 60, '2024-12-21'),
(4, 1213, 'sweet corn', 10, '2024-12-26');

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

--
-- Dumping data for table `tblprocessingcenter`
--

INSERT INTO `tblprocessingcenter` (`Center ID`, `Type`, `Location`) VALUES
(17, 'Big', 'Dhaka');

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

--
-- Dumping data for table `tblprocessinginspection`
--

INSERT INTO `tblprocessinginspection` (`Center ID`, `Inspector ID`, `Machine Quality Grade`, `Processing Quality Grade`, `Center Hygene Grade`, `Staff Safety Grade`, `Date`) VALUES
(0, 0, '', '', '', '', '0000-00-00');

-- --------------------------------------------------------

--
-- Table structure for table `tblprocessingiot`
--

CREATE TABLE `tblprocessingiot` (
  `pIoT ID` int(7) NOT NULL,
  `Center ID` int(7) NOT NULL,
  `Temperature` varchar(19) NOT NULL,
  `Humidity` varchar(10) NOT NULL,
  `Date` date NOT NULL,
  `Time` time NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tblprocessinglot`
--

CREATE TABLE `tblprocessinglot` (
  `Batch Barcode` int(13) NOT NULL,
  `Lot Number` int(7) NOT NULL,
  `Date` date NOT NULL,
  `Time` time NOT NULL,
  `Manufactured Date` date NOT NULL,
  `Expiry Date` date NOT NULL,
  `stTransport ID` int(7) NOT NULL,
  `Center ID` int(7) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tblprocessinglot`
--

INSERT INTO `tblprocessinglot` (`Batch Barcode`, `Lot Number`, `Date`, `Time`, `Manufactured Date`, `Expiry Date`, `stTransport ID`, `Center ID`) VALUES
(4, 3, '2024-12-21', '00:08:00', '2024-12-21', '2024-12-31', 0, 17),
(4, 4, '2024-12-21', '00:08:00', '2024-12-21', '2024-12-31', 18, 17),
(4, 5, '2024-12-21', '00:08:00', '2024-12-21', '2024-12-31', 18, 17),
(4, 6, '2024-12-21', '00:08:00', '2024-12-21', '2024-12-31', 18, 17),
(4, 7, '2024-12-21', '00:08:00', '2024-12-21', '2024-12-31', 18, 17),
(4, 8, '2024-12-21', '00:08:00', '2024-12-21', '2024-12-31', 18, 17),
(4, 9, '2024-12-21', '00:08:00', '2024-12-21', '2024-12-31', 18, 17),
(4, 10, '2024-12-21', '00:08:00', '2024-12-21', '2024-12-31', 18, 17),
(4, 11, '2024-12-21', '00:08:00', '2024-12-21', '2024-12-31', 18, 17);

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
  `Transport Type` varchar(10) NOT NULL,
  `Temperature Range` varchar(10) NOT NULL,
  `Load Weight` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tblprocessingtransport`
--

INSERT INTO `tblprocessingtransport` (`pTransport ID`, `Date`, `Transport Type`, `Temperature Range`, `Load Weight`) VALUES
(2210885, '2024-12-21', 'Road', '20-30', 40);

-- --------------------------------------------------------

--
-- Table structure for table `tblproduct`
--

CREATE TABLE `tblproduct` (
  `Product ID` int(7) NOT NULL,
  `Product Name` text NOT NULL,
  `Type` text NOT NULL,
  `Best Season` text NOT NULL,
  `Optimum Temperature` varchar(6) NOT NULL,
  `Optimum Humidity` varchar(6) NOT NULL,
  `Nutrition Value` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tblproduct`
--

INSERT INTO `tblproduct` (`Product ID`, `Product Name`, `Type`, `Best Season`, `Optimum Temperature`, `Optimum Humidity`, `Nutrition Value`) VALUES
(17, 'beet', 'dry', 'summer', '50-60', '30%', '100cal/g'),
(18, 'Apple', 'dry', 'summer', '50-60', '30%', '100cal/g');

-- --------------------------------------------------------

--
-- Table structure for table `tblretailer`
--

CREATE TABLE `tblretailer` (
  `Retailer ID` int(7) NOT NULL,
  `First Name` text NOT NULL,
  `Last Name` text NOT NULL,
  `Phone` varchar(20) NOT NULL,
  `Store Name` text NOT NULL,
  `Address` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tblretailer`
--

INSERT INTO `tblretailer` (`Retailer ID`, `First Name`, `Last Name`, `Phone`, `Store Name`, `Address`) VALUES
(15, 'Md . Abir Shahriar', 'Safowan', '01601874131', 'ka', 'Alif Tower, house no. 14, Road no. 6, Satmasjid Housing, Mohammadpur, Dhaka'),
(12345, 'Md . Abir Shahriar', 'Safowan', '01601874131', 'ga', 'Alif Tower, house no. 14, Road no. 6, Satmasjid Housing, Mohammadpur, Dhaka'),
(123456, 'MD. Nabil', 'Safowan', '01603481310', 'ba', 'Alif Tower, house no. 14, Road no. 6, Satmasjid Housing, Mohammadpur, Dhaka'),
(1234567, 'Md . Abir Shahriar', 'Shah', '01601874131', 'la', 'Alif Tower, house no. 14, Road no. 6, Satmasjid Housing, Mohammadpur, Dhaka\r\n4th floor(lift) , east side'),
(1234577, 'MD. Nabil', 'Safowan', '01603481310', 'ga', 'Alif Tower, house no. 14, Road no. 6, Satmasjid Housing, Mohammadpur, Dhaka');

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

--
-- Dumping data for table `tblshipment`
--

INSERT INTO `tblshipment` (`Shipment ID`, `shTransport ID`, `Retailer ID`, `Shipment Date`, `Shipment Quantity`, `Operating Temperature`) VALUES
(2410001, 2420001, 2430001, '2024-12-21', 20, '30');

-- --------------------------------------------------------

--
-- Table structure for table `tblshipmenttransport`
--

CREATE TABLE `tblshipmenttransport` (
  `shTransport ID` int(7) NOT NULL,
  `shTransport Type` text NOT NULL,
  `Transport Type` text NOT NULL,
  `Temperature Range` varchar(10) NOT NULL,
  `Storage ID` int(7) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tblshipmenttransport`
--

INSERT INTO `tblshipmenttransport` (`shTransport ID`, `shTransport Type`, `Transport Type`, `Temperature Range`, `Storage ID`) VALUES
(2218585, 'Dry', 'Road', '20-30', 2122885);

-- --------------------------------------------------------

--
-- Table structure for table `tblsignup`
--

CREATE TABLE `tblsignup` (
  `ID` int(7) NOT NULL,
  `First Name` varchar(30) NOT NULL,
  `Last Name` varchar(30) NOT NULL,
  `Email` varchar(30) NOT NULL,
  `Password` varchar(30) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `User` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tblsignup`
--

INSERT INTO `tblsignup` (`ID`, `First Name`, `Last Name`, `Email`, `Password`, `User`) VALUES
(8, 'Abir', 'Shahriar', 'ashariar414@gmail.com', '2222', 'farm'),
(10, 'nabil', 'safowan', 'ashariar414@gmail.com', '$2y$10$pfFM5tFNEMVaMQPAT/VTlOM', 'farm'),
(11, 'jamee', 'jamee', 'as@gmail.com', '666', 'farm'),
(13, 'Abir', 'Shah', 'ashariar414@gmail.com', 'abir27', 'farm'),
(14, 'Md . Abir Shahriar', 'Shahriar', 'ashariar414@gmail.com', 'abir28', 'farm'),
(15, 'Md . Abir Shahriar', 'Shahriar', 'ashariar414@gmail.com', 'abir33', 'retailer'),
(16, 'Abir', 'Emon', 'hanabiippo2@gmail.com', 'abiremon', 'farm'),
(17, 'Nabil', 'Safowan', 'nabil@gmail.com', 'nabil', 'processing_center'),
(18, 'Shahriar', 'Emon', 'emon@gmail.com', 'emon', 'inspector'),
(19, 'Jamee', 'Jamee', 'jamee@gmail.com', 'jamee', 'storage'),
(20, 'abid', 'hasan', 'abid@gmail.com', 'abid', 'transport');

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

--
-- Dumping data for table `tblstorage`
--

INSERT INTO `tblstorage` (`Storage ID`, `Storage Type`, `Storage Duration`, `Location`) VALUES
(19, 'dry', 20, 'Mohmmadpur,Dhaka');

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
  `Storage Type` text NOT NULL,
  `Date` date NOT NULL,
  `Transport Type` text NOT NULL,
  `Temperature Range` varchar(10) NOT NULL,
  `Load Weight` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tblstoragetransport`
--

INSERT INTO `tblstoragetransport` (`stTransport ID`, `Storage ID`, `Storage Type`, `Date`, `Transport Type`, `Temperature Range`, `Load Weight`) VALUES
(3123, 3123, 'dry', '2024-12-16', 'road', '20-30', 40),
(3124, 3124, 'Cold', '2024-12-21', 'Road', '20-30', 40);

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
-- Table structure for table `tbltransporttrucking`
--

CREATE TABLE `tbltransporttrucking` (
  `TransportID` int(11) NOT NULL,
  `ComingFrom` varchar(255) NOT NULL,
  `PresentLocation` varchar(255) NOT NULL,
  `Destination` varchar(255) NOT NULL,
  `ItemType` varchar(255) NOT NULL
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
  ADD PRIMARY KEY (`farm ID`);

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
-- Indexes for table `tblorder`
--
ALTER TABLE `tblorder`
  ADD PRIMARY KEY (`Order ID`),
  ADD KEY `Retailer ID` (`Retailer ID`);

--
-- Indexes for table `tblpiotdevicehumidity`
--
ALTER TABLE `tblpiotdevicehumidity`
  ADD PRIMARY KEY (`Date`,`Time`),
  ADD KEY `pIoT ID` (`pIoT ID`);

--
-- Indexes for table `tblplotdevicetemperature`
--
ALTER TABLE `tblplotdevicetemperature`
  ADD PRIMARY KEY (`Date`,`Time`),
  ADD KEY `pIoT ID` (`pIoT ID`);

--
-- Indexes for table `tblprocessingiot`
--
ALTER TABLE `tblprocessingiot`
  ADD PRIMARY KEY (`pIoT ID`);

--
-- Indexes for table `tblprocessinglot`
--
ALTER TABLE `tblprocessinglot`
  ADD PRIMARY KEY (`Lot Number`);

--
-- Indexes for table `tblprocessingshipmentquantity`
--
ALTER TABLE `tblprocessingshipmentquantity`
  ADD KEY `Shipment ID` (`Shipment ID`),
  ADD KEY `Lot Number` (`Lot Number`);

--
-- Indexes for table `tblproduct`
--
ALTER TABLE `tblproduct`
  ADD PRIMARY KEY (`Product ID`);

--
-- Indexes for table `tblretailer`
--
ALTER TABLE `tblretailer`
  ADD PRIMARY KEY (`Retailer ID`);

--
-- Indexes for table `tblsignup`
--
ALTER TABLE `tblsignup`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `tblsiottemperature`
--
ALTER TABLE `tblsiottemperature`
  ADD PRIMARY KEY (`Date`,`Time`),
  ADD KEY `sIoT ID` (`sIoT ID`);

--
-- Indexes for table `tblstorageiot`
--
ALTER TABLE `tblstorageiot`
  ADD PRIMARY KEY (`sIoT ID`),
  ADD KEY `Storage ID` (`Storage ID`);

--
-- Indexes for table `tblstorageiothumidity`
--
ALTER TABLE `tblstorageiothumidity`
  ADD PRIMARY KEY (`Date`,`Time`),
  ADD KEY `sIoT ID` (`sIoT ID`);

--
-- Indexes for table `tbltiotdevicehumidity`
--
ALTER TABLE `tbltiotdevicehumidity`
  ADD PRIMARY KEY (`Date`,`Time`),
  ADD KEY `tIoT ID` (`tIoT ID`);

--
-- Indexes for table `tbltiotdevicetemperature`
--
ALTER TABLE `tbltiotdevicetemperature`
  ADD PRIMARY KEY (`Date`,`Time`),
  ADD KEY `tIoT ID` (`tIoT ID`);

--
-- Indexes for table `tbltransporttrucking`
--
ALTER TABLE `tbltransporttrucking`
  ADD PRIMARY KEY (`TransportID`);

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
  MODIFY `Batch Barcode` int(13) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `tblfarmtype`
--
ALTER TABLE `tblfarmtype`
  MODIFY `farm ID` int(7) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tblinspector`
--
ALTER TABLE `tblinspector`
  MODIFY `Inspector ID` int(7) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tblorder`
--
ALTER TABLE `tblorder`
  MODIFY `Order ID` int(7) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `tblprocessingiot`
--
ALTER TABLE `tblprocessingiot`
  MODIFY `pIoT ID` int(7) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `tblprocessinglot`
--
ALTER TABLE `tblprocessinglot`
  MODIFY `Lot Number` int(7) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `tblproduct`
--
ALTER TABLE `tblproduct`
  MODIFY `Product ID` int(7) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `tblretailer`
--
ALTER TABLE `tblretailer`
  MODIFY `Retailer ID` int(7) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1234578;

--
-- AUTO_INCREMENT for table `tblsignup`
--
ALTER TABLE `tblsignup`
  MODIFY `ID` int(7) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `tblstorageiot`
--
ALTER TABLE `tblstorageiot`
  MODIFY `sIoT ID` int(7) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbltransporttrucking`
--
ALTER TABLE `tbltransporttrucking`
  MODIFY `TransportID` int(11) NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `tblbatch`
--
ALTER TABLE `tblbatch`
  ADD CONSTRAINT `tblbatch_ibfk_1` FOREIGN KEY (`Farm ID`) REFERENCES `tblfarm` (`farm ID`);

--
-- Constraints for table `tblpiotdevicehumidity`
--
ALTER TABLE `tblpiotdevicehumidity`
  ADD CONSTRAINT `tblpiotdevicehumidity_ibfk_1` FOREIGN KEY (`pIoT ID`) REFERENCES `tblprocessingiot` (`pIoT ID`);

--
-- Constraints for table `tblplotdevicetemperature`
--
ALTER TABLE `tblplotdevicetemperature`
  ADD CONSTRAINT `tblplotdevicetemperature_ibfk_1` FOREIGN KEY (`pIoT ID`) REFERENCES `tblprocessingiot` (`pIoT ID`);

--
-- Constraints for table `tblprocessingshipmentquantity`
--
ALTER TABLE `tblprocessingshipmentquantity`
  ADD CONSTRAINT `tblprocessingshipmentquantity_ibfk_1` FOREIGN KEY (`Lot Number`) REFERENCES `tblprocessinglot` (`Lot Number`),
  ADD CONSTRAINT `tblprocessingshipmentquantity_ibfk_2` FOREIGN KEY (`Shipment ID`) REFERENCES `tblshipment` (`Shipment ID`);

--
-- Constraints for table `tblsiottemperature`
--
ALTER TABLE `tblsiottemperature`
  ADD CONSTRAINT `tblsiottemperature_ibfk_1` FOREIGN KEY (`sIoT ID`) REFERENCES `tblstorageiot` (`sIoT ID`);

--
-- Constraints for table `tblstorageiot`
--
ALTER TABLE `tblstorageiot`
  ADD CONSTRAINT `tblstorageiot_ibfk_1` FOREIGN KEY (`Storage ID`) REFERENCES `tblstorage` (`Storage ID`);

--
-- Constraints for table `tblstorageiothumidity`
--
ALTER TABLE `tblstorageiothumidity`
  ADD CONSTRAINT `tblstorageiothumidity_ibfk_1` FOREIGN KEY (`sIoT ID`) REFERENCES `tblstorageiot` (`sIoT ID`);

--
-- Constraints for table `tbltiotdevicehumidity`
--
ALTER TABLE `tbltiotdevicehumidity`
  ADD CONSTRAINT `tbltiotdevicehumidity_ibfk_1` FOREIGN KEY (`tIoT ID`) REFERENCES `tbltransportoitdevice` (`tIoT ID`);

--
-- Constraints for table `tbltiotdevicetemperature`
--
ALTER TABLE `tbltiotdevicetemperature`
  ADD CONSTRAINT `tbltiotdevicetemperature_ibfk_1` FOREIGN KEY (`tIoT ID`) REFERENCES `tbltransportoitdevice` (`tIoT ID`);

--
-- Constraints for table `tbltransportoitdevice`
--
ALTER TABLE `tbltransportoitdevice`
  ADD CONSTRAINT `tbltransportoitdevice_ibfk_1` FOREIGN KEY (`shTransport ID`) REFERENCES `tblshipmenttransport` (`shTransport ID`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
