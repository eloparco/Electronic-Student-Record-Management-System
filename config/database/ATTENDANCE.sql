-- phpMyAdmin SQL Dump
-- version 4.6.6deb5
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Nov 22, 2019 at 06:05 PM
-- Server version: 5.7.28-0ubuntu0.19.04.2
-- PHP Version: 7.2.24-0ubuntu0.19.04.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `student_record_management`
--

-- --------------------------------------------------------

--
-- Table structure for table `ATTENDANCE`
--

DROP TABLE IF EXISTS `ATTENDANCE`;
CREATE TABLE IF NOT EXISTS `ATTENDANCE` (
  `StudentSSN` varchar(50) NOT NULL,
  `Date` date NOT NULL,
  `Presence` varchar(50) NOT NULL,
  `Exit_Hour` int(11) DEFAULT NULL,
  PRIMARY KEY (`StudentSSN`,`Date`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `ATTENDANCE`
--

INSERT INTO `ATTENDANCE` (`StudentSSN`, `Date`, `Presence`, `Exit_Hour`) VALUES
('MDUHPG46H50I748J', '2019-11-13', 'ABSENT', NULL),
('MDUHPG46H50I748J', '2019-11-18', '15_MIN_LATE', NULL);

--
-- Constraints for dumped tables
--

--
-- Constraints for table `ATTENDANCE`
--
ALTER TABLE `ATTENDANCE`
  ADD CONSTRAINT `ATTENDANCE_ibfk_1` FOREIGN KEY (`StudentSSN`) REFERENCES `CHILD` (`SSN`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
