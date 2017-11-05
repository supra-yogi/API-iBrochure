-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Nov 05, 2017 at 03:15 PM
-- Server version: 10.1.9-MariaDB
-- PHP Version: 5.6.15

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `ibrochure`
--

-- --------------------------------------------------------

--
-- Table structure for table `category`
--

CREATE TABLE `category` (
  `Id` int(11) NOT NULL,
  `Code` varchar(10) NOT NULL,
  `Name` varchar(25) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `category`
--

INSERT INTO `category` (`Id`, `Code`, `Name`) VALUES
(1, 'C1', 'Makanan'),
(3, 'C2', 'Film');

-- --------------------------------------------------------

--
-- Table structure for table `customer`
--

CREATE TABLE `customer` (
  `Id` int(11) NOT NULL,
  `Name` varchar(25) DEFAULT NULL,
  `Contact` varchar(25) DEFAULT NULL,
  `Telp` varchar(25) DEFAULT NULL,
  `Address` varchar(100) DEFAULT NULL,
  `UseraccountId` int(11) NOT NULL,
  `RoleId` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `list_brochure`
--

CREATE TABLE `list_brochure` (
  `Id` int(11) NOT NULL,
  `Title` varchar(25) NOT NULL,
  `Telp` varchar(25) DEFAULT NULL,
  `Address` varchar(25) DEFAULT NULL,
  `Description` varchar(255) DEFAULT NULL,
  `CustomerId` int(11) DEFAULT NULL,
  `CategoryId` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `list_brochure_picture`
--

CREATE TABLE `list_brochure_picture` (
  `ListBrochureId` int(11) DEFAULT NULL,
  `PictureName` varchar(50) DEFAULT NULL,
  `PictureBase64` text
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `role`
--

CREATE TABLE `role` (
  `Id` int(11) NOT NULL,
  `Code` varchar(10) NOT NULL,
  `Name` varchar(25) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `role`
--

INSERT INTO `role` (`Id`, `Code`, `Name`) VALUES
(1, 'R001', 'Owner'),
(2, 'R002', 'Customer');

-- --------------------------------------------------------

--
-- Table structure for table `user_account`
--

CREATE TABLE `user_account` (
  `Id` int(11) NOT NULL,
  `Username` varchar(50) NOT NULL,
  `Email` varchar(50) NOT NULL,
  `Password` varchar(255) DEFAULT NULL,
  `Confirmed` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user_account`
--

INSERT INTO `user_account` (`Id`, `Username`, `Email`, `Password`, `Confirmed`) VALUES
(2, 'yogi42', 'hermawanyogi42@gmail.com', 'd8ca2cd2609740765c3c01ffb55b4411a8330bad', 0),
(4, 'tes', 'tes@mail.con', '40bd001563085fc35165329ea1ff5c5ecbdbbeef', 0),
(6, 'aan', 'aan@mail.com', '40bd001563085fc35165329ea1ff5c5ecbdbbeef', 0);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `category`
--
ALTER TABLE `category`
  ADD PRIMARY KEY (`Id`),
  ADD UNIQUE KEY `Code` (`Code`);

--
-- Indexes for table `customer`
--
ALTER TABLE `customer`
  ADD PRIMARY KEY (`Id`),
  ADD KEY `fk_customer_roleId` (`RoleId`),
  ADD KEY `fk_customer_useraccount` (`UseraccountId`);

--
-- Indexes for table `list_brochure`
--
ALTER TABLE `list_brochure`
  ADD PRIMARY KEY (`Id`),
  ADD KEY `fk_list_brochure_categoryId` (`CategoryId`),
  ADD KEY `fk_list_brochure_customerId` (`CustomerId`);

--
-- Indexes for table `list_brochure_picture`
--
ALTER TABLE `list_brochure_picture`
  ADD KEY `fk_list_brochure_picture_list_brochureId` (`ListBrochureId`);

--
-- Indexes for table `role`
--
ALTER TABLE `role`
  ADD PRIMARY KEY (`Id`);

--
-- Indexes for table `user_account`
--
ALTER TABLE `user_account`
  ADD PRIMARY KEY (`Id`),
  ADD UNIQUE KEY `Username` (`Username`),
  ADD UNIQUE KEY `Email` (`Email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `category`
--
ALTER TABLE `category`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT for table `customer`
--
ALTER TABLE `customer`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `list_brochure`
--
ALTER TABLE `list_brochure`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT for table `role`
--
ALTER TABLE `role`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `user_account`
--
ALTER TABLE `user_account`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
--
-- Constraints for dumped tables
--

--
-- Constraints for table `customer`
--
ALTER TABLE `customer`
  ADD CONSTRAINT `fk_customer_roleId` FOREIGN KEY (`RoleId`) REFERENCES `role` (`Id`),
  ADD CONSTRAINT `fk_customer_useraccount` FOREIGN KEY (`UseraccountId`) REFERENCES `customer` (`Id`);

--
-- Constraints for table `list_brochure`
--
ALTER TABLE `list_brochure`
  ADD CONSTRAINT `fk_list_brochure_categoryId` FOREIGN KEY (`CategoryId`) REFERENCES `category` (`Id`),
  ADD CONSTRAINT `fk_list_brochure_customerId` FOREIGN KEY (`CustomerId`) REFERENCES `customer` (`Id`);

--
-- Constraints for table `list_brochure_picture`
--
ALTER TABLE `list_brochure_picture`
  ADD CONSTRAINT `fk_list_brochure_picture_list_brochureId` FOREIGN KEY (`ListBrochureId`) REFERENCES `list_brochure` (`Id`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
