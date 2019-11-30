-- phpMyAdmin SQL Dump
-- version 4.6.6deb5
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Nov 24, 2019 at 10:05 PM
-- Server version: 5.7.28-0ubuntu0.19.04.2
-- PHP Version: 7.2.24-0ubuntu0.19.04.1
DROP DATABASE  student_record_management_test;
SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `student_record_management_test`
--
CREATE DATABASE IF NOT EXISTS `student_record_management_test` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci;
USE `student_record_management_test`;

-- --------------------------------------------------------

--
-- Table structure for table `ATTENDANCE`
--

DROP TABLE IF EXISTS `ATTENDANCE`;
CREATE TABLE IF NOT EXISTS `ATTENDANCE` (
  `StudentSSN` char(16) COLLATE utf8_unicode_ci NOT NULL,
  `Date` date NOT NULL,
  `Presence` enum('PRESENT','10_MIN_LATE','1_HOUR_LATE','ABSENT') COLLATE utf8_unicode_ci DEFAULT NULL,
  `ExitHour` int(11) NOT NULL DEFAULT '6'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

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
  `SSN` varchar(50) NOT NULL,
  `Name` varchar(50) NOT NULL,
  `Surname` varchar(50) NOT NULL,
  `SSNParent1` varchar(50) NOT NULL,
  `SSNParent2` varchar(50) NOT NULL,
  `Class` varchar(30) NOT NULL,
  PRIMARY KEY (`SSN`),
  KEY `SSNParent1` (`SSNParent1`),
  KEY `SSNParent2` (`SSNParent2`),
  KEY `Class` (`Class`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `CHILD`
--

INSERT INTO `CHILD` (`SSN`, `Name`, `Surname`, `SSNParent1`, `SSNParent2`, `Class`) VALUES
('MNDGPP04E14L219U', 'Giuseppe', 'Mandini', 'MNDFPP68C16L219N', 'PLLMRT70E68L219Q', '1A'),
('MNDLRT04E14L219I', 'Alberto', 'Mandini', 'MNDFPP68C16L219N', 'PLLMRT70E68L219Q', ''),
('PNCRCR02C13L219K', 'Riccardo', 'Ponci', 'PNCMSM75D20L219X', 'FLCRRT77B43L219Q', '1A');

-- --------------------------------------------------------

--
-- Table structure for table `CLASS`
--

DROP TABLE IF EXISTS `CLASS`;
CREATE TABLE IF NOT EXISTS `CLASS` (
  `Name` varchar(50) NOT NULL,
  PRIMARY KEY (`Name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

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
  `Class` varchar(50) NOT NULL,
  `DayOfWeek` varchar(50) NOT NULL,
  `StartHour` int(11) NOT NULL,
  `SubjectID` int(11) NOT NULL,
  `TeacherSSN` varchar(50) NOT NULL,
  PRIMARY KEY (`Class`,`DayOfWeek`,`StartHour`),
  KEY `DayOfWeek` (`DayOfWeek`,`StartHour`),
  KEY `TeacherSSN` (`TeacherSSN`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `MARK`
--

DROP TABLE IF EXISTS `MARK`;
CREATE TABLE IF NOT EXISTS `MARK` (
  `StudentSSN` varchar(50) NOT NULL,
  `SubjectID` int(11) NOT NULL,
  `Date` date NOT NULL,
  `Class` varchar(50) NOT NULL,
  `Score` decimal(5,2) NOT NULL,
  PRIMARY KEY (`StudentSSN`,`SubjectID`,`Date`),
  KEY `SubjectID` (`SubjectID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

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
  `Name` varchar(50) NOT NULL,
  `HoursPerWeek` int(11) NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `SUBJECT`
--

INSERT INTO `SUBJECT` (`ID`, `Name`, `HoursPerWeek`) VALUES
(1, 'Geography', 3),
(2, 'History', 3),
(3, 'Italian', 6),
(4, 'Mathematics', 5),
(5, 'Physics', 4);

-- --------------------------------------------------------

--
-- Table structure for table `TEACHER_SUBJECT`
--

DROP TABLE IF EXISTS `TEACHER_SUBJECT`;
CREATE TABLE IF NOT EXISTS `TEACHER_SUBJECT` (
  `TeacherSSN` varchar(50) NOT NULL,
  `SubjectID` int(11) NOT NULL,
  `Class` varchar(50) NOT NULL,
  PRIMARY KEY (`TeacherSSN`,`SubjectID`,`Class`),
  KEY `SubjectID` (`SubjectID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

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
  `DayOfWeek` varchar(50) NOT NULL,
  `StartHour` int(11) NOT NULL,
  `EndHour` int(11) NOT NULL,
  PRIMARY KEY (`DayOfWeek`,`StartHour`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `TOPIC`
--

DROP TABLE IF EXISTS `TOPIC`;
CREATE TABLE IF NOT EXISTS `TOPIC` (
  `Class` varchar(50) NOT NULL,
  `Date` date NOT NULL,
  `StartHour` int(11) NOT NULL,
  `SubjectID` int(11) NOT NULL,
  `TeacherSSN` varchar(50) NOT NULL,
  `Title` varchar(50) NOT NULL,
  `Description` varchar(50) NOT NULL,
  PRIMARY KEY (`Class`,`Date`,`StartHour`),
  KEY `SubjectID` (`SubjectID`),
  KEY `TeacherSSN` (`TeacherSSN`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

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
  `SSN` char(16) NOT NULL,
  `Name` varchar(50) NOT NULL,
  `Surname` varchar(50) NOT NULL,
  `Email` varchar(50) UNIQUE NOT NULL,
  `Password` varchar(50) NOT NULL,
  `AccountActivated` tinyint(1) NOT NULL DEFAULT FALSE,
  PRIMARY KEY (`SSN`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `USER_TYPE`;
CREATE TABLE IF NOT EXISTS `USER_TYPE` (
  `SSN` char(16) NOT NULL,
  `UserType` varchar(30) NOT NULL,
  PRIMARY KEY (`SSN`,`UserType`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
--
-- Dumping data for table `USER`
--

INSERT INTO `USER` (`SSN`, `Name`, `Surname`, `Email`, `Password`, `AccountActivated`) VALUES
('123aaa', 'aaa', 'bbb', 'enrico@gmail.com', '1111eeee?', NULL),
('123q', 'ggg', 'ggg', 'enrico@gmail.it', 'a1a1a1a1', 1),
('aaa111', 'aaa', 'bbb', 'aaa@bbb.com', 'a1a1a1a1', 1),
('aaa111bbb', 'aaa', 'bbb', 'johnny@doe.it', 'a1a1a1a1', 1),
('ABC123', 'John', 'Doe', 'john@doe.it', 'pass123', 1),
('ABC456', 'Jane', 'Doe', 'jane@doe.it', 'pass456', 0),
('FLCRRT77B43L219Q', 'Roberta', 'Filicaro', 'r.filicaro@parent.esrmsystem.com', 'Roberta77', 1),
('FNLTRS72H50L219Z', 'Teresa', 'Fanelli', 't.fanelli@esrmsystem.com', 'Teresa72', 1),
('LNGMRN58M51L219R', 'Marina', 'Longobardi', 'm.longobardi@esrmsystem.com', 'Marina58', 1),
('MNDFPP68C16L219N', 'Filippo', 'Mandini', 'f.mandini@parent.esrmsystem.com', 'Filippo68', 1),
('PLLMRT70E68L219Q', 'Marta', 'Pellegrino', 'm.pellegrino@parent.esrmsystem.com', 'Marta70', 1),
('PNCMSM75D20L219X', 'Massimiliano', 'Ponci', 'm.ponci@parent.esrmsystem.com', 'Massi75', 1),
('QFFFZL52M61I472B', 'Milo', 'Contini', 'milo@milo.it', 'Milo1', 1),
('RSSMRA70A01F205V', 'Mario', 'Rossi', 'mario.rossi@email.com', 'Mariorossi2', 1),
('STLRRT66T06L219L', 'Roberto', 'Stelluti', 'r.stelluti@parent.esrmsystem.com', 'Roberto66', 1),
('testSSN123', 'Mario', 'Rossi', 'mario@rossi.it', 'Mario12', 1),
('KKKFZL52M61I4KKK', 'Mamma', 'Mia', 'mamma@mia.it', 'Mamma', 1);



INSERT INTO `USER_TYPE`(`SSN`,`UserType`) VALUES ('123aaa', 'PARENT');
INSERT INTO `USER_TYPE`(`SSN`,`UserType`) VALUES ('123q', 'PARENT');
INSERT INTO `USER_TYPE`(`SSN`,`UserType`) VALUES ('aaa111', 'TEACHER');
INSERT INTO `USER_TYPE`(`SSN`,`UserType`) VALUES ('aaa111bbb', 'TEACHER');
INSERT INTO `USER_TYPE`(`SSN`,`UserType`) VALUES ('ABC123', 'PARENT');
INSERT INTO `USER_TYPE`(`SSN`,`UserType`) VALUES ('ABC456', 'PARENT');
INSERT INTO `USER_TYPE`(`SSN`,`UserType`) VALUES ('FLCRRT77B43L219Q', 'PARENT');
INSERT INTO `USER_TYPE`(`SSN`,`UserType`) VALUES ('FNLTRS72H50L219Z', 'TEACHER');
INSERT INTO `USER_TYPE`(`SSN`,`UserType`) VALUES ('LNGMRN58M51L219R', 'TEACHER');
INSERT INTO `USER_TYPE`(`SSN`,`UserType`) VALUES ('MNDFPP68C16L219N', 'PARENT');
INSERT INTO `USER_TYPE`(`SSN`,`UserType`) VALUES ('PLLMRT70E68L219Q', 'PARENT');
INSERT INTO `USER_TYPE`(`SSN`,`UserType`) VALUES ('PNCMSM75D20L219X', 'PARENT');
INSERT INTO `USER_TYPE`(`SSN`,`UserType`) VALUES ('QFFFZL52M61I472B', 'SECRETARY_OFFICER');
INSERT INTO `USER_TYPE`(`SSN`,`UserType`) VALUES ('RSSMRA70A01F205V', 'PARENT');
INSERT INTO `USER_TYPE`(`SSN`,`UserType`) VALUES ('STLRRT66T06L219L', 'PARENT');
INSERT INTO `USER_TYPE`(`SSN`,`UserType`) VALUES ('testSSN123', 'STUDENT');
INSERT INTO `USER_TYPE`(`SSN`,`UserType`) VALUES ('KKKFZL52M61I4KKK', 'SYS_ADMIN');

ALTER TABLE `USER_TYPE`
  ADD CONSTRAINT `USER_TYPE_ibfk_1` FOREIGN KEY (`SSN`) REFERENCES `USER` (`SSN`);
--
-- Constraints for dumped tables
--

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
