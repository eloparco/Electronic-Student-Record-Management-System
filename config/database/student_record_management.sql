-- phpMyAdmin SQL Dump
-- version 4.8.5
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Creato il: Nov 14, 2019 alle 00:13
-- Versione del server: 10.1.40-MariaDB
-- Versione PHP: 7.3.5

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
CREATE DATABASE IF NOT EXISTS `student_record_management` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci;
USE `student_record_management`;

-- --------------------------------------------------------

--
-- Struttura della tabella `child`
--

CREATE TABLE IF NOT EXISTS `child` (
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
-- Dump dei dati per la tabella `child`
--

INSERT INTO `child` (`SSN`, `Name`, `Surname`, `SSNParent1`, `SSNParent2`, `Class`) VALUES
('VRDLCA80L02G3035A', 'Luca', 'Demaio', 'BDTJHN80S11Z306F', 'XZDMLR60R69I950T', '1A');

-- --------------------------------------------------------

--
-- Struttura della tabella `class`
--

CREATE TABLE IF NOT EXISTS `class` (
  `Name` varchar(50) NOT NULL,
  PRIMARY KEY (`Name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

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

CREATE TABLE IF NOT EXISTS `class_timetable` (
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
-- Struttura della tabella `mark`
--

CREATE TABLE IF NOT EXISTS `mark` (
  `StudentSSN` varchar(50) NOT NULL,
  `SubjectID` int(11) NOT NULL,
  `Date` date NOT NULL,
  `Class` varchar(50) NOT NULL,
  `Score` decimal(5,2) NOT NULL,
  PRIMARY KEY (`StudentSSN`,`SubjectID`,`Date`),
  KEY `SubjectID` (`SubjectID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dump dei dati per la tabella `mark`
--

INSERT INTO `mark` (`StudentSSN`, `SubjectID`, `Date`, `Class`, `Score`) VALUES
('VRDLCA80L02G3035A', 1, '2019-11-04', '1A', '8.75'),
('VRDLCA80L02G3035A', 1, '2019-11-07', '1A', '7.25'),
('VRDLCA80L02G3035A', 2, '2019-11-07', '1A', '6.50');

-- --------------------------------------------------------

--
-- Struttura della tabella `subject`
--

CREATE TABLE IF NOT EXISTS `subject` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `Name` varchar(50) NOT NULL,
  `HoursPerWeek` int(11) NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

--
-- Dump dei dati per la tabella `subject`
--

INSERT INTO `subject` (`ID`, `Name`, `HoursPerWeek`) VALUES
(1, 'Math', 5),
(2, 'Algebra', 5);

-- --------------------------------------------------------

--
-- Struttura della tabella `teacher_subject`
--

CREATE TABLE IF NOT EXISTS `teacher_subject` (
  `TeacherSSN` varchar(50) NOT NULL,
  `SubjectID` int(11) NOT NULL,
  `Class` varchar(50) NOT NULL,
  PRIMARY KEY (`TeacherSSN`,`SubjectID`,`Class`),
  KEY `SubjectID` (`SubjectID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dump dei dati per la tabella `teacher_subject`
--

INSERT INTO `teacher_subject` (`TeacherSSN`, `SubjectID`, `Class`) VALUES
('WHRDHF59H46H847L', 1, '1A'),
('ZTZLPP85P22A761V', 2, '1B');

-- --------------------------------------------------------

--
-- Struttura della tabella `timetable`
--

CREATE TABLE IF NOT EXISTS `timetable` (
  `DayOfWeek` varchar(50) NOT NULL,
  `StartHour` int(11) NOT NULL,
  `EndHour` int(11) NOT NULL,
  PRIMARY KEY (`DayOfWeek`,`StartHour`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Struttura della tabella `topic`
--

CREATE TABLE IF NOT EXISTS `topic` (
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
-- Dump dei dati per la tabella `topic`
--

INSERT INTO `topic` (`Class`, `Date`, `StartHour`, `SubjectID`, `TeacherSSN`, `Title`, `Description`) VALUES
('1B', '2019-11-13', 8, 2, 'ZTZLPP85P22A761V', 'Equation', 'Linear equation chapter 9'),
('1B', '2019-11-15', 10, 2, 'ZTZLPP85P22A761V', 'Equation', 'Linear equation');

-- --------------------------------------------------------

--
-- Struttura della tabella `user`
--

CREATE TABLE IF NOT EXISTS `user` (
  `SSN` varchar(50) NOT NULL,
  `Name` varchar(50) NOT NULL,
  `Surname` varchar(50) NOT NULL,
  `Email` varchar(50) NOT NULL,
  `Password` varchar(50) NOT NULL,
  `UserType` varchar(50) NOT NULL,
  `AccountActivated` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (`SSN`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dump dei dati per la tabella `user`
--

INSERT INTO `user` (`SSN`, `Name`, `Surname`, `Email`, `Password`, `UserType`, `AccountActivated`) VALUES
('BDTJHN80S11Z306F', 'Pino', 'Demaio', 'pino@pino.it', 'Pino', 'PARENT', 0),
('MFNDGR47C43F966B', 'Luca', 'Detti', 'luca@luca.it', 'Luca', 'SECRETARY_OFFICER', 0),
('QFFFZL52M61I472B', 'Milo', 'Contini', 'milo@milo.it', 'Milo', 'SECRETARY_OFFICER', 0),
('QMBPSK98B27F656N', 'Alfredo', 'Ponci', 'alfredo@alfredo.it', 'Alfredo', 'TEACHER', 0),
('QMGQXG36P17G905Y', 'Marco', 'Canta', 'marco@marco.it', 'Marco', 'PARENT', 0),
('RSSMRA70A01F205V', 'Mario', 'Rossi', 'mario.rossi@email.com', 'Mariorossi2', 'TEACHER', 1),
('WHRDHF59H46H847L', 'Carmela', 'Genova', 'carmela@carmela.it', 'Carmela', 'TEACHER', 0),
('XCNWPJ80P55A703P', 'Mauro', 'Compi', 'mauro@mauro.it', 'Mauro', 'SECRETARY_OFFICER', 0),
('XZDMLR60R69I950T', 'Giulia', 'Casale', 'giulia@giulia.it', 'Giulia', 'PARENT', 0),
('ZTZLPP85P22A761V', 'Antonio', 'Sallutti', 'antonio@antonio.it', 'Antonio', 'TEACHER', 0);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
