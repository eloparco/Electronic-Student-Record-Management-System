-- phpMyAdmin SQL Dump
-- version 4.6.6deb5
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Dec 07, 2019 at 06:06 PM
-- Server version: 5.7.28-0ubuntu0.19.04.2
-- PHP Version: 7.2.24-0ubuntu0.19.04.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `student_record_management_test`
--
CREATE DATABASE IF NOT EXISTS `student_record_management_test` DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci;
USE `student_record_management_test`;

-- --------------------------------------------------------

--
-- Table structure for table `ASSIGNMENT`
--

DROP TABLE IF EXISTS `ASSIGNMENT`;
CREATE TABLE IF NOT EXISTS `ASSIGNMENT` (
  `Class` char(2) COLLATE utf8_unicode_ci NOT NULL,
  `SubjectID` int(11) NOT NULL,
  `DateOfAssignment` date NOT NULL,
  `DeadlineDate` date NOT NULL,
  `Title` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `Description` varchar(400) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`Class`,`SubjectID`,`DeadlineDate`),
  KEY `SubjectID` (`SubjectID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `ATTENDANCE`
--

DROP TABLE IF EXISTS `ATTENDANCE`;
CREATE TABLE IF NOT EXISTS `ATTENDANCE` (
  `StudentSSN` char(16) COLLATE utf8_unicode_ci NOT NULL,
  `Date` date NOT NULL,
  `Presence` enum('PRESENT','10_MIN_LATE','1_HOUR_LATE','ABSENT') COLLATE utf8_unicode_ci DEFAULT NULL,
  `ExitHour` int(11) NOT NULL DEFAULT '6',
  KEY `ATTENDANCE_ibfk_1` (`StudentSSN`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `ATTENDANCE`
--

INSERT INTO `ATTENDANCE` (`StudentSSN`, `Date`, `Presence`, `ExitHour`) VALUES
('PNCRCR02C13L219K', '2019-11-07', '1_HOUR_LATE', 3),
('PNCRCR02C13L219K', '2019-11-13', 'ABSENT', 6),
('PNCRCR02C13L219K', '2019-11-18', '10_MIN_LATE', 6);

-- --------------------------------------------------------

--
-- Table structure for table `CHILD`
--

DROP TABLE IF EXISTS `CHILD`;
CREATE TABLE IF NOT EXISTS `CHILD` (
  `SSN` char(16) COLLATE utf8_unicode_ci NOT NULL,
  `Name` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `Surname` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `SSNParent1` char(16) COLLATE utf8_unicode_ci NOT NULL,
  `SSNParent2` char(16) COLLATE utf8_unicode_ci DEFAULT NULL,
  `Class` char(2) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`SSN`),
  KEY `SSNParent1` (`SSNParent1`),
  KEY `SSNParent2` (`SSNParent2`),
  KEY `Class` (`Class`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `CHILD`
--

INSERT INTO `CHILD` (`SSN`, `Name`, `Surname`, `SSNParent1`, `SSNParent2`, `Class`) VALUES
('MNDGPP04E14L219U', 'Giuseppe', 'Mandini', 'MNDFPP68C16L219N', 'PLLMRT70E68L219Q', '1A'),
('PNCRCR02C13L219K', 'Riccardo', 'Ponci', 'PNCMSM75D20L219X', 'FLCRRT77B43L219Q', '1A');

-- --------------------------------------------------------

--
-- Table structure for table `CLASS`
--

DROP TABLE IF EXISTS `CLASS`;
CREATE TABLE IF NOT EXISTS `CLASS` (
  `Name` char(2) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`Name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `CLASS`
--

INSERT INTO `CLASS` (`Name`) VALUES
('1A'),
('1B');

-- --------------------------------------------------------

--
-- Table structure for table `CLASS_TIMETABLE`
--

DROP TABLE IF EXISTS `CLASS_TIMETABLE`;
CREATE TABLE IF NOT EXISTS `CLASS_TIMETABLE` (
  `Class` char(2) COLLATE utf8_unicode_ci NOT NULL,
  `DayOfWeek` varchar(15) COLLATE utf8_unicode_ci NOT NULL,
  `Hour` int(11) NOT NULL,
  `SubjectID` int(11) DEFAULT NULL,
  PRIMARY KEY (`Class`,`DayOfWeek`,`Hour`),
  KEY `DayOfWeek` (`DayOfWeek`,`Hour`),
  KEY `CLASS_TIMETABLE_ibfk_4` (`SubjectID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `MARK`
--

DROP TABLE IF EXISTS `MARK`;
CREATE TABLE IF NOT EXISTS `MARK` (
  `StudentSSN` char(16) COLLATE utf8_unicode_ci NOT NULL,
  `SubjectID` int(11) NOT NULL,
  `Date` date NOT NULL,
  `Class` char(2) COLLATE utf8_unicode_ci NOT NULL,
  `Score` decimal(5,2) NOT NULL,
  PRIMARY KEY (`StudentSSN`,`SubjectID`,`Date`),
  KEY `SubjectID` (`SubjectID`),
  KEY `MARK_ibfk_2` (`Class`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `MARK`
--

INSERT INTO `MARK` (`StudentSSN`, `SubjectID`, `Date`, `Class`, `Score`) VALUES
('PNCRCR02C13L219K', 1, '2019-11-04', '1A', '8.75'),
('PNCRCR02C13L219K', 2, '2019-11-07', '1A', '6.50'),
('PNCRCR02C13L219K', 3, '2019-11-07', '1A', '7.25'),
('PNCRCR02C13L219K', 4, '2019-11-11', '1A', '8.00'),
('PNCRCR02C13L219K', 5, '2019-11-08', '1A', '6.75');

-- --------------------------------------------------------

--
-- Table structure for table `SUBJECT`
--

DROP TABLE IF EXISTS `SUBJECT`;
CREATE TABLE IF NOT EXISTS `SUBJECT` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `Name` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `HoursPerWeek` int(11) NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `SUBJECT`
--

INSERT INTO `SUBJECT` (`ID`, `Name`, `HoursPerWeek`) VALUES
(1, 'Geography', 3),
(2, 'History', 3),
(3, 'Italian', 6),
(4, 'Mathematics', 5),
(5, 'Physics', 4),
(6, 'Latin', 3),
(7, 'English', 4),
(8, 'Gym', 1),
(9, 'Art', 2),
(10, 'Science', 2),
(11, 'Religion', 1);

-- --------------------------------------------------------

--
-- Table structure for table `TEACHER_SUBJECT`
--

DROP TABLE IF EXISTS `TEACHER_SUBJECT`;
CREATE TABLE IF NOT EXISTS `TEACHER_SUBJECT` (
  `TeacherSSN` char(16) COLLATE utf8_unicode_ci NOT NULL,
  `SubjectID` int(11) NOT NULL,
  `Class` char(2) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`TeacherSSN`,`SubjectID`,`Class`),
  KEY `SubjectID` (`SubjectID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `TEACHER_SUBJECT`
--

INSERT INTO `TEACHER_SUBJECT` (`TeacherSSN`, `SubjectID`, `Class`) VALUES
('aaa111', 1, '1A'),
('aaa111', 2, '1B'),
('FNLTRS72H50L219Z', 4, '1A'),
('FNLTRS72H50L219Z', 5, '1A');

-- --------------------------------------------------------

--
-- Table structure for table `TIMETABLE`
--

DROP TABLE IF EXISTS `TIMETABLE`;
CREATE TABLE IF NOT EXISTS `TIMETABLE` (
  `DayOfWeek` varchar(15) COLLATE utf8_unicode_ci NOT NULL,
  `Hour` int(11) NOT NULL,
  PRIMARY KEY (`DayOfWeek`,`Hour`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `TIMETABLE`
--

INSERT INTO `TIMETABLE` (`DayOfWeek`, `Hour`) VALUES
('Friday', 1),
('Friday', 2),
('Friday', 3),
('Friday', 4),
('Friday', 5),
('Friday', 6),
('Monday', 1),
('Monday', 2),
('Monday', 3),
('Monday', 4),
('Monday', 5),
('Monday', 6),
('Thursday', 1),
('Thursday', 2),
('Thursday', 3),
('Thursday', 4),
('Thursday', 5),
('Thursday', 6),
('Tuesday', 1),
('Tuesday', 2),
('Tuesday', 3),
('Tuesday', 4),
('Tuesday', 5),
('Tuesday', 6),
('Wednesday', 1),
('Wednesday', 2),
('Wednesday', 3),
('Wednesday', 4),
('Wednesday', 5),
('Wednesday', 6);

-- --------------------------------------------------------

--
-- Table structure for table `TOPIC`
--

DROP TABLE IF EXISTS `TOPIC`;
CREATE TABLE IF NOT EXISTS `TOPIC` (
  `Class` char(2) COLLATE utf8_unicode_ci NOT NULL,
  `Date` date NOT NULL,
  `StartHour` int(11) NOT NULL,
  `SubjectID` int(11) NOT NULL,
  `TeacherSSN` char(16) COLLATE utf8_unicode_ci NOT NULL,
  `Title` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `Description` varchar(400) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`Class`,`Date`,`StartHour`),
  KEY `SubjectID` (`SubjectID`),
  KEY `TeacherSSN` (`TeacherSSN`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `TOPIC`
--

INSERT INTO `TOPIC` (`Class`, `Date`, `StartHour`, `SubjectID`, `TeacherSSN`, `Title`, `Description`) VALUES
('1A', '2019-11-13', 1, 1, 'aaa111', 'Test title', 'Test description');

-- --------------------------------------------------------

--
-- Table structure for table `USER`
--

DROP TABLE IF EXISTS `USER`;
CREATE TABLE IF NOT EXISTS `USER` (
  `SSN` char(16) COLLATE utf8_unicode_ci NOT NULL,
  `Name` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `Surname` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `Email` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `Password` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `AccountActivated` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`SSN`),
  UNIQUE KEY `Email` (`Email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `USER`
--

INSERT INTO `USER` (`SSN`, `Name`, `Surname`, `Email`, `Password`, `AccountActivated`) VALUES
('123aaa', 'aaa', 'bbb', 'enrico@gmail.com', '1111eeee?', 0),
('123q', 'ggg', 'ggg', 'enrico@gmail.it', 'a1a1a1a1', 1),
('aaa111', 'aaa', 'bbb', 'aaa@bbb.com', 'a1a1a1a1', 1),
('aaa111bbb', 'aaa', 'bbb', 'johnny@doe.it', 'a1a1a1a1', 1),
('ABC123', 'John', 'Doe', 'john@doe.it', 'pass123', 1),
('ABC456', 'Jane', 'Doe', 'jane@doe.it', 'pass456', 0),
('FLCRRT77B43L219Q', 'Roberta', 'Filicaro', 'r.filicaro@parent.esrmsystem.com', 'Roberta77', 1),
('FNLTRS72H50L219Z', 'Teresa', 'Fanelli', 't.fanelli@esrmsystem.com', 'Teresa72', 1),
('KKKFZL52M61I4KKK', 'Mamma', 'Mia', 'mamma@mia.it', 'Mamma', 1),
('LNGMRN58M51L219R', 'Marina', 'Longobardi', 'm.longobardi@esrmsystem.com', 'Marina58', 1),
('MNDFPP68C16L219N', 'Filippo', 'Mandini', 'f.mandini@parent.esrmsystem.com', 'Filippo68', 1),
('PLLMRT70E68L219Q', 'Marta', 'Pellegrino', 'm.pellegrino@parent.esrmsystem.com', 'Marta70', 1),
('PNCMSM75D20L219X', 'Massimiliano', 'Ponci', 'm.ponci@parent.esrmsystem.com', 'Massi75', 1),
('QFFFZL52M61I472B', 'Milo', 'Contini', 'milo@milo.it', 'Milo1', 1),
('RSSMRA70A01F205V', 'Mario', 'Rossi', 'mario.rossi@email.com', 'Mariorossi2', 1),
('STLRRT66T06L219L', 'Roberto', 'Stelluti', 'r.stelluti@parent.esrmsystem.com', 'Roberto66', 1),
('testSSN123', 'Mario', 'Rossi', 'mario@rossi.it', 'Mario12', 1);

-- --------------------------------------------------------

--
-- Table structure for table `USER_TYPE`
--

DROP TABLE IF EXISTS `USER_TYPE`;
CREATE TABLE IF NOT EXISTS `USER_TYPE` (
  `SSN` char(16) COLLATE utf8_unicode_ci NOT NULL,
  `UserType` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`SSN`,`UserType`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `USER_TYPE`
--

INSERT INTO `USER_TYPE` (`SSN`, `UserType`) VALUES
('123aaa', 'PARENT'),
('123q', 'PARENT'),
('aaa111', 'TEACHER'),
('aaa111bbb', 'TEACHER'),
('ABC123', 'PARENT'),
('ABC456', 'PARENT'),
('FLCRRT77B43L219Q', 'PARENT'),
('FNLTRS72H50L219Z', 'TEACHER'),
('KKKFZL52M61I4KKK', 'SYS_ADMIN'),
('LNGMRN58M51L219R', 'TEACHER'),
('MNDFPP68C16L219N', 'PARENT'),
('PLLMRT70E68L219Q', 'PARENT'),
('PNCMSM75D20L219X', 'PARENT'),
('QFFFZL52M61I472B', 'SECRETARY_OFFICER'),
('RSSMRA70A01F205V', 'PARENT'),
('STLRRT66T06L219L', 'PARENT'),
('testSSN123', 'STUDENT');

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
  ADD CONSTRAINT `CLASS_TIMETABLE_ibfk_2` FOREIGN KEY (`DayOfWeek`,`Hour`) REFERENCES `TIMETABLE` (`DayOfWeek`, `Hour`),
  ADD CONSTRAINT `CLASS_TIMETABLE_ibfk_4` FOREIGN KEY (`SubjectID`) REFERENCES `SUBJECT` (`ID`);

--
-- Constraints for table `MARK`
--
ALTER TABLE `MARK`
  ADD CONSTRAINT `MARK_ibfk_1` FOREIGN KEY (`SubjectID`) REFERENCES `SUBJECT` (`ID`),
  ADD CONSTRAINT `MARK_ibfk_2` FOREIGN KEY (`Class`) REFERENCES `CLASS` (`Name`),
  ADD CONSTRAINT `MARK_ibfk_3` FOREIGN KEY (`StudentSSN`) REFERENCES `CHILD` (`SSN`);

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

--
-- Constraints for table `USER_TYPE`
--
ALTER TABLE `USER_TYPE`
  ADD CONSTRAINT `USER_TYPE_ibfk_1` FOREIGN KEY (`SSN`) REFERENCES `USER` (`SSN`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
