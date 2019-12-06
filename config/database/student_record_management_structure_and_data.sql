-- phpMyAdmin SQL Dump
-- version 4.9.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Creato il: Dic 06, 2019 alle 18:35
-- Versione del server: 10.4.8-MariaDB
-- Versione PHP: 7.3.11

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
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
-- Struttura della tabella `assignment`
--

DROP TABLE IF EXISTS `assignment`;
CREATE TABLE IF NOT EXISTS `assignment` (
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
-- Struttura della tabella `attendance`
--

DROP TABLE IF EXISTS `attendance`;
CREATE TABLE IF NOT EXISTS `attendance` (
  `StudentSSN` char(16) COLLATE utf8_unicode_ci NOT NULL,
  `Date` date NOT NULL,
  `Presence` enum('PRESENT','10_MIN_LATE','1_HOUR_LATE','ABSENT') COLLATE utf8_unicode_ci DEFAULT NULL,
  `ExitHour` int(11) NOT NULL DEFAULT 6,
  KEY `ATTENDANCE_ibfk_1` (`StudentSSN`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Struttura della tabella `child`
--

DROP TABLE IF EXISTS `child`;
CREATE TABLE IF NOT EXISTS `child` (
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
-- Dump dei dati per la tabella `child`
--

INSERT INTO `child` (`SSN`, `Name`, `Surname`, `SSNParent1`, `SSNParent2`, `Class`) VALUES
('BRBSMN04A24L219R', 'Simone', 'Barbero', 'BRBGPP57M04L219W', NULL, '1B'),
('MNDGPP04E14L219U', 'Giuseppe', 'Mandini', 'MNDFPP68C16L219N', 'PLLMRT70E68L219Q', '1A'),
('PNCRCR02C13L219K', 'Riccardo', 'Ponci', 'PNCMSM75D20L219X', 'FLCRRT77B43L219Q', '1A');

-- --------------------------------------------------------

--
-- Struttura della tabella `class`
--

DROP TABLE IF EXISTS `class`;
CREATE TABLE IF NOT EXISTS `class` (
  `Name` char(2) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`Name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dump dei dati per la tabella `class`
--

INSERT INTO `class` (`Name`) VALUES
('1A'),
('1B');

-- --------------------------------------------------------

--
-- Struttura della tabella `class_timetable`
--

DROP TABLE IF EXISTS `class_timetable`;
CREATE TABLE IF NOT EXISTS `class_timetable` (
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
-- Struttura della tabella `mark`
--

DROP TABLE IF EXISTS `mark`;
CREATE TABLE IF NOT EXISTS `mark` (
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
-- Dump dei dati per la tabella `mark`
--

INSERT INTO `mark` (`StudentSSN`, `SubjectID`, `Date`, `Class`, `Score`) VALUES
('PNCRCR02C13L219K', 1, '2019-11-04', '1A', '8.75'),
('PNCRCR02C13L219K', 2, '2019-11-07', '1A', '6.50'),
('PNCRCR02C13L219K', 3, '2019-11-07', '1A', '7.25'),
('PNCRCR02C13L219K', 4, '2019-11-11', '1A', '8.00'),
('PNCRCR02C13L219K', 5, '2019-11-08', '1A', '6.75');

-- --------------------------------------------------------

--
-- Struttura della tabella `subject`
--

DROP TABLE IF EXISTS `subject`;
CREATE TABLE IF NOT EXISTS `subject` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `Name` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `HoursPerWeek` int(11) NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dump dei dati per la tabella `subject`
--

INSERT INTO `subject` (`ID`, `Name`, `HoursPerWeek`) VALUES
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
-- Struttura della tabella `support_material`
--

DROP TABLE IF EXISTS `support_material`;
CREATE TABLE IF NOT EXISTS `support_material` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `SubjectID` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `Class` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `Date` date NOT NULL,
  `Filename` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Struttura della tabella `teacher_subject`
--

DROP TABLE IF EXISTS `teacher_subject`;
CREATE TABLE IF NOT EXISTS `teacher_subject` (
  `TeacherSSN` char(16) COLLATE utf8_unicode_ci NOT NULL,
  `SubjectID` int(11) NOT NULL,
  `Class` char(2) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`TeacherSSN`,`SubjectID`,`Class`),
  KEY `SubjectID` (`SubjectID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dump dei dati per la tabella `teacher_subject`
--

INSERT INTO `teacher_subject` (`TeacherSSN`, `SubjectID`, `Class`) VALUES
('BRBGPP57M04L219W', 3, '1A'),
('BRBGPP57M04L219W', 6, '1A'),
('FNLTRS72H50L219Z', 4, '1A'),
('FNLTRS72H50L219Z', 5, '1A'),
('LNGMRN58M51L219R', 1, '1A'),
('LNGMRN58M51L219R', 2, '1A');

-- --------------------------------------------------------

--
-- Struttura della tabella `timetable`
--

DROP TABLE IF EXISTS `timetable`;
CREATE TABLE IF NOT EXISTS `timetable` (
  `DayOfWeek` varchar(15) COLLATE utf8_unicode_ci NOT NULL,
  `Hour` int(11) NOT NULL,
  PRIMARY KEY (`DayOfWeek`,`Hour`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dump dei dati per la tabella `timetable`
--

INSERT INTO `timetable` (`DayOfWeek`, `Hour`) VALUES
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
-- Struttura della tabella `topic`
--

DROP TABLE IF EXISTS `topic`;
CREATE TABLE IF NOT EXISTS `topic` (
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

-- --------------------------------------------------------

--
-- Struttura della tabella `user`
--

DROP TABLE IF EXISTS `user`;
CREATE TABLE IF NOT EXISTS `user` (
  `SSN` char(16) COLLATE utf8_unicode_ci NOT NULL,
  `Name` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `Surname` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `Email` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `Password` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `AccountActivated` tinyint(1) NOT NULL DEFAULT 0,
  PRIMARY KEY (`SSN`),
  UNIQUE KEY `Email` (`Email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dump dei dati per la tabella `user`
--

INSERT INTO `user` (`SSN`, `Name`, `Surname`, `Email`, `Password`, `AccountActivated`) VALUES
('BLLDRD66S07L219N', 'Edoardo', 'Bello', 'e.bello@esrmsystem.com', 'Edoardo66', 1),
('BRBGPP57M04L219W', 'Giuseppe', 'Barbero', 'g.barbero@esrmsystem.com', 'Giuseppe57', 1),
('FLCGNN62R19L219X', 'Giovanni', 'Felice', 'g.felice@esrmsystem.com', 'Giovanni62', 1),
('FLCRRT77B43L219Q', 'Roberta', 'Filicaro', 'parent@parent.it', 'parent1', 1),
('FNLTRS72H50L219Z', 'Teresa', 'Fanelli', 't.fanelli@esrmsystem.com', 'Teresa72', 1),
('LNGMRN58M51L219R', 'Marina', 'Longobardi', 'm.longobardi@esrmsystem.com', 'Marina58', 1),
('MNDFPP68C16L219N', 'Filippo', 'Mandini', 'f.mandini@parent.esrmsystem.com', 'Filippo68', 1),
('PLLMRT70E68L219Q', 'Marta', 'Pellegrino', 'm.pellegrino@parent.esrmsystem.com', 'Marta70', 1),
('PNCMSM75D20L219X', 'Massimiliano', 'Ponci', 'm.ponci@parent.esrmsystem.com', 'Massi75', 1),
('STLRRT66T06L219L', 'Roberto', 'Stelluti', 'r.stelluti@parent.esrmsystem.com', 'Roberto66', 1);

-- --------------------------------------------------------

--
-- Struttura della tabella `user_type`
--

DROP TABLE IF EXISTS `user_type`;
CREATE TABLE IF NOT EXISTS `user_type` (
  `SSN` char(16) COLLATE utf8_unicode_ci NOT NULL,
  `UserType` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`SSN`,`UserType`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dump dei dati per la tabella `user_type`
--

INSERT INTO `user_type` (`SSN`, `UserType`) VALUES
('BLLDRD66S07L219N', 'ADMIN'),
('BRBGPP57M04L219W', 'PARENT'),
('BRBGPP57M04L219W', 'TEACHER'),
('FLCGNN62R19L219X', 'SECRETARY_OFFICER'),
('FLCRRT77B43L219Q', 'PARENT'),
('FNLTRS72H50L219Z', 'TEACHER'),
('LNGMRN58M51L219R', 'TEACHER'),
('MNDFPP68C16L219N', 'PARENT'),
('PLLMRT70E68L219Q', 'PARENT'),
('PNCMSM75D20L219X', 'PARENT'),
('STLRRT66T06L219L', 'PARENT');

--
-- Limiti per le tabelle scaricate
--

--
-- Limiti per la tabella `child`
--
ALTER TABLE `child`
  ADD CONSTRAINT `CHILD_ibfk_1` FOREIGN KEY (`SSNParent1`) REFERENCES `user` (`SSN`),
  ADD CONSTRAINT `CHILD_ibfk_2` FOREIGN KEY (`SSNParent2`) REFERENCES `user` (`SSN`),
  ADD CONSTRAINT `CHILD_ibfk_3` FOREIGN KEY (`Class`) REFERENCES `class` (`Name`);

--
-- Limiti per la tabella `class_timetable`
--
ALTER TABLE `class_timetable`
  ADD CONSTRAINT `CLASS_TIMETABLE_ibfk_1` FOREIGN KEY (`Class`) REFERENCES `class` (`Name`),
  ADD CONSTRAINT `CLASS_TIMETABLE_ibfk_2` FOREIGN KEY (`DayOfWeek`,`Hour`) REFERENCES `timetable` (`DayOfWeek`, `Hour`),
  ADD CONSTRAINT `CLASS_TIMETABLE_ibfk_4` FOREIGN KEY (`SubjectID`) REFERENCES `subject` (`ID`);

--
-- Limiti per la tabella `mark`
--
ALTER TABLE `mark`
  ADD CONSTRAINT `MARK_ibfk_1` FOREIGN KEY (`SubjectID`) REFERENCES `subject` (`ID`),
  ADD CONSTRAINT `MARK_ibfk_2` FOREIGN KEY (`Class`) REFERENCES `class` (`Name`),
  ADD CONSTRAINT `MARK_ibfk_3` FOREIGN KEY (`StudentSSN`) REFERENCES `child` (`SSN`);

--
-- Limiti per la tabella `teacher_subject`
--
ALTER TABLE `teacher_subject`
  ADD CONSTRAINT `TEACHER_SUBJECT_ibfk_1` FOREIGN KEY (`SubjectID`) REFERENCES `subject` (`ID`),
  ADD CONSTRAINT `TEACHER_SUBJECT_ibfk_2` FOREIGN KEY (`TeacherSSN`) REFERENCES `user` (`SSN`);

--
-- Limiti per la tabella `topic`
--
ALTER TABLE `topic`
  ADD CONSTRAINT `TOPIC_ibfk_1` FOREIGN KEY (`Class`) REFERENCES `class` (`Name`),
  ADD CONSTRAINT `TOPIC_ibfk_2` FOREIGN KEY (`SubjectID`) REFERENCES `subject` (`ID`),
  ADD CONSTRAINT `TOPIC_ibfk_3` FOREIGN KEY (`TeacherSSN`) REFERENCES `user` (`SSN`);

--
-- Limiti per la tabella `user_type`
--
ALTER TABLE `user_type`
  ADD CONSTRAINT `USER_TYPE_ibfk_1` FOREIGN KEY (`SSN`) REFERENCES `user` (`SSN`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
