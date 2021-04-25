

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";

--
-- Database: `db_oap`
--

-- --------------------------------------------------------

--
-- Table structure for table `appointment`
--

CREATE TABLE IF NOT EXISTS `appointment` (
  `appId` bigint NOT NULL AUTO_INCREMENT,
  `icPatient` bigint NOT NULL,
  `scheduleId` bigint NOT NULL,
  `appSymptom` varchar(100) NOT NULL,
  `appComment` varchar(100) NOT NULL,
  `status` ENUM('scheduled', 'done'),
  `createdAt` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updatedAt` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `deletedAt` TIMESTAMP NULL,
  PRIMARY KEY (`appId`),
  INDEX (`icPatient`),
  INDEX (`scheduleId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `appointment`
--

-- INSERT INTO `appointment` (`icPatient`, `scheduleId`, `appSymptom`, `appComment`, `status`) VALUES
-- (1, 40, 'Pening Kepala', 'Bila doktor free?', 'done');

-- --------------------------------------------------------

--
-- Table structure for table `doctor`
--

CREATE TABLE IF NOT EXISTS `doctor` (
  `icDoctor` bigint NOT NULL AUTO_INCREMENT,
  `doctorId` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `doctorFirstName` varchar(50) NOT NULL,
  `doctorLastName` varchar(50) NOT NULL,
  `doctorAddress` varchar(255) NOT NULL,
  `doctorPhone` varchar(15) NOT NULL,
  `doctorEmail` varchar(255) NOT NULL,
  `doctorDOB` date NOT NULL,
  `isAdmin` tinyint(1) NOT NULL DEFAULT 0,
  `createdAt` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updatedAt` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `deletedAt` TIMESTAMP NULL,
  PRIMARY KEY (`icDoctor`),
  INDEX (`doctorId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `doctor`
--
-- password = admin
INSERT INTO `doctor` (`doctorId`, `password`,  `doctorFirstName`, `doctorLastName`, `doctorAddress`, `doctorPhone`, `doctorEmail`, `doctorDOB`, `isAdmin`) VALUES
('admin', '88bc91a49e1fc62b3b55bf1188aa45f5ea9ef008c8e7d61a73b6dc33af87473c', 'John', 'Smith', 'Hong Kong', '22222222', 'js@example.com', '1990-04-1', 1);

-- --------------------------------------------------------

--
-- Table structure for table `doctorschedule`
--

CREATE TABLE IF NOT EXISTS `doctorschedule` (
  `scheduleId` bigint NOT NULL AUTO_INCREMENT,
  `scheduleDate` date NOT NULL,
  -- `scheduleDay` varchar(15) NOT NULL,
  `startTime` time NOT NULL,
  `endTime` time NOT NULL,
  -- `bookAvail` varchar(10) NOT NULL
  `isAvailable` tinyint NOT NULL DEFAULT 1,
  `icDoctor` bigint NOT NULL,
  `createdAt` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updatedAt` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `deletedAt` TIMESTAMP NULL,
  PRIMARY KEY (`scheduleId`),
  INDEX(`icDoctor`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `doctorschedule`
--

INSERT INTO `doctorschedule` (`scheduleDate`, `startTime`, `endTime`, `isAvailable`, `icDoctor`) VALUES
('2021-04-23', '09:00:00', '10:00:00', 0, 1),
('2021-04-25', '11:00:00', '12:00:00', 1, 1),
('2021-04-24', '10:00:00', '11:00:00', 1, 1),
('2021-04-26', '01:00:00', '02:00:00', 1, 1),
('2021-04-27', '11:00:00', '12:00:00', 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `patient`
--

CREATE TABLE IF NOT EXISTS `patient` (
  `icPatient` bigint NOT NULL AUTO_INCREMENT,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `patientFirstName` varchar(50) NOT NULL,
  `patientLastName` varchar(50) NOT NULL,
  `patientMaritialStatus` ENUM('na','single', 'married', 'widowed', 'divorced', 'separated'),
  `patientDOB` date NOT NULL,
  `patientGender` ENUM('na', 'm', 'f'),
  `patientAddress` varchar(255) NOT NULL,
  `patientMediRecordNo` varchar(255) NOT NULL,
  `patientPhone` varchar(15) NOT NULL,
  `patientEmail` varchar(255) NOT NULL,
  `createdAt` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updatedAt` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `deletedAt` TIMESTAMP NULL,
  PRIMARY KEY (`icPatient`),
  INDEX (`username`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `patient`
--
-- password = 123
INSERT INTO `patient` (`username`, `password`, `patientFirstName`, `patientLastName`, `patientMaritialStatus`, `patientDOB`, `patientGender`, `patientAddress`, `patientPhone`, `patientEmail`) VALUES
('patient', '5902425b65a439680eaf3fe527e9228573ab9660db1ff596c8f502d30cc0d780', 'Mohd', 'Mazlan', 'single', '1992-05-17', 'm', 'NO 153 BLOK MURNI\r\nKOLEJ CANSELOR UNIVERSITI PUTRA MALAYSIA', '173567758', 'lan.psis@gmail.com');
