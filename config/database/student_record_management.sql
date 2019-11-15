-- phpMyAdmin SQL Dump
-- version 4.6.6deb5
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Nov 10, 2019 at 06:04 PM
-- Server version: 5.7.27-0ubuntu0.19.04.1
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
CREATE DATABASE IF NOT EXISTS `student_record_management` DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci;
USE `student_record_management`;

-- --------------------------------------------------------

--
-- Add DROP statements to make changes to table definitions effective
--

DROP TABLE IF EXISTS `CHILD`;
DROP TABLE IF EXISTS `MARK`;
DROP TABLE IF EXISTS `TOPIC`;
DROP TABLE IF EXISTS `CLASS_TIMETABLE`;
DROP TABLE IF EXISTS `TEACHER_SUBJECT`;
DROP TABLE IF EXISTS `TIMETABLE`;
DROP TABLE IF EXISTS `SUBJECT`;
DROP TABLE IF EXISTS `CLASS`;
DROP TABLE IF EXISTS `USER`;

--
-- Table structure for table `CHILD`
--

CREATE TABLE IF NOT EXISTS `CHILD` (
  `SSN` char(16) NOT NULL,
  `Name` varchar(50) NOT NULL,
  `Surname` varchar(50) NOT NULL,
  `SSNParent1` char(16) NOT NULL,
  `SSNParent2` char(16) NOT NULL,
  `Class` char(2) NOT NULL,
  PRIMARY KEY (`SSN`),
  KEY `SSNParent1` (`SSNParent1`),
  KEY `SSNParent2` (`SSNParent2`),
  KEY `Class` (`Class`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `CLASS`
--

CREATE TABLE IF NOT EXISTS `CLASS` (
  `Name` char(2) NOT NULL,
  PRIMARY KEY (`Name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `CLASS_TIMETABLE`
--

CREATE TABLE IF NOT EXISTS `CLASS_TIMETABLE` (
  `Class` char(2) NOT NULL,
  `DayOfWeek` varchar(15) NOT NULL,
  `StartHour` int(11) NOT NULL,
  `SubjectID` int(11) NOT NULL,
  `TeacherSSN` char(16) NOT NULL,
  PRIMARY KEY (`Class`,`DayOfWeek`,`StartHour`),
  KEY `DayOfWeek` (`DayOfWeek`,`StartHour`),
  KEY `TeacherSSN` (`TeacherSSN`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `MARK`
--

CREATE TABLE IF NOT EXISTS `MARK` (
  `StudentSSN` char(16) NOT NULL,
  `SubjectID` int(11) NOT NULL,
  `Date` date NOT NULL,
  `Class` char(2) NOT NULL,
  `Score` decimal(5,2) NOT NULL,
  PRIMARY KEY (`StudentSSN`,`SubjectID`,`Date`),
  KEY `SubjectID` (`SubjectID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `SUBJECT`
--

CREATE TABLE IF NOT EXISTS `SUBJECT` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `Name` varchar(50) NOT NULL,
  `HoursPerWeek` int(11) NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `TEACHER_SUBJECT`
--

CREATE TABLE IF NOT EXISTS `TEACHER_SUBJECT` (
  `TeacherSSN` char(16) NOT NULL,
  `SubjectID` int(11) NOT NULL,
  `Class` char(2) NOT NULL,
  PRIMARY KEY (`TeacherSSN`,`SubjectID`,`Class`),
  KEY `SubjectID` (`SubjectID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `TIMETABLE`
--

CREATE TABLE IF NOT EXISTS `TIMETABLE` (
  `DayOfWeek` varchar(15) NOT NULL,
  `StartHour` int(11) NOT NULL,
  `EndHour` int(11) NOT NULL,
  PRIMARY KEY (`DayOfWeek`,`StartHour`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `TOPIC`
--

CREATE TABLE IF NOT EXISTS `TOPIC` (
  `Class` char(2) NOT NULL,
  `Date` date NOT NULL,
  `StartHour` int(11) NOT NULL,
  `SubjectID` int(11) NOT NULL,
  `TeacherSSN` char(2) NOT NULL,
  `Title` varchar(50) NOT NULL,
  `Description` varchar(400) NOT NULL,
  PRIMARY KEY (`Class`,`Date`,`StartHour`),
  KEY `SubjectID` (`SubjectID`),
  KEY `TeacherSSN` (`TeacherSSN`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `USER`
--

CREATE TABLE IF NOT EXISTS `USER` (
  `SSN` char(16) NOT NULL,
  `Name` varchar(50) NOT NULL,
  `Surname` varchar(50) NOT NULL,
  `Email` varchar(50) NOT NULL,
  `Password` varchar(50) NOT NULL,
  `UserType` varchar(30) NOT NULL,
  `AccountActivated` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (`SSN`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `CHILD`
--
ALTER TABLE `CHILD`
  ADD CONSTRAINT `CHILD_ibfk_1` FOREIGN KEY (`SSNParent1`) REFERENCES `USER` (`SSN`),
  ADD CONSTRAINT `CHILD_ibfk_2` FOREIGN KEY (`SSNParent2`) REFERENCES `USER` (`SSN`),
  ADD CONSTRAINT `CHILD_ibfk_3` FOREIGN KEY (`Class`) REFERENCES `CLASS` (`Name`);

--
-- Constraints for table `CLASS_TIMETABLE`
--
ALTER TABLE `CLASS_TIMETABLE`
  ADD CONSTRAINT `CLASS_TIMETABLE_ibfk_1` FOREIGN KEY (`Class`) REFERENCES `CLASS` (`Name`),
  ADD CONSTRAINT `CLASS_TIMETABLE_ibfk_2` FOREIGN KEY (`DayOfWeek`,`StartHour`) REFERENCES `TIMETABLE` (`DayOfWeek`, `StartHour`),
  ADD CONSTRAINT `CLASS_TIMETABLE_ibfk_3` FOREIGN KEY (`TeacherSSN`) REFERENCES `USER` (`SSN`);

--
-- Constraints for table `MARK`
--
ALTER TABLE `MARK`
  ADD CONSTRAINT `MARK_ibfk_1` FOREIGN KEY (`SubjectID`) REFERENCES `SUBJECT` (`ID`);

--
-- Constraints for table `TEACHER_SUBJECT`
--
ALTER TABLE `TEACHER_SUBJECT`
  ADD CONSTRAINT `TEACHER_SUBJECT_ibfk_1` FOREIGN KEY (`SubjectID`) REFERENCES `SUBJECT` (`ID`),
  ADD CONSTRAINT `TEACHER_SUBJECT_ibfk_2` FOREIGN KEY (`TeacherSSN`) REFERENCES `USER` (`SSN`);

--
-- Constraints for table `TOPIC`
--
ALTER TABLE `TOPIC`
  ADD CONSTRAINT `TOPIC_ibfk_1` FOREIGN KEY (`Class`) REFERENCES `CLASS` (`Name`),
  ADD CONSTRAINT `TOPIC_ibfk_2` FOREIGN KEY (`SubjectID`) REFERENCES `SUBJECT` (`ID`),
  ADD CONSTRAINT `TOPIC_ibfk_3` FOREIGN KEY (`TeacherSSN`) REFERENCES `USER` (`SSN`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;