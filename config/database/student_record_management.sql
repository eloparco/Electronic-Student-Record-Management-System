-- phpMyAdmin SQL Dump
-- version 4.9.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Creato il: Gen 05, 2020 alle 19:21
-- Versione del server: 10.4.8-MariaDB
-- Versione PHP: 7.3.10

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
CREATE DATABASE IF NOT EXISTS `student_record_management` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;
USE `student_record_management`;

-- --------------------------------------------------------

--
-- Struttura della tabella `ASSIGNMENT`
--

DROP TABLE IF EXISTS `ASSIGNMENT`;
CREATE TABLE IF NOT EXISTS `ASSIGNMENT` (
  `Class` char(2) COLLATE utf8_unicode_ci NOT NULL,
  `SubjectID` int(11) NOT NULL,
  `DateOfAssignment` date NOT NULL,
  `DeadlineDate` date NOT NULL,
  `Title` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `Description` varchar(400) COLLATE utf8_unicode_ci DEFAULT NULL,
  `Attachment` text COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`Class`,`SubjectID`,`DeadlineDate`),
  KEY `SubjectID` (`SubjectID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dump dei dati per la tabella `ASSIGNMENT`
--

INSERT INTO `ASSIGNMENT` (`Class`, `SubjectID`, `DateOfAssignment`, `DeadlineDate`, `Title`, `Description`, `Attachment`) VALUES
('1A', 3, '2020-01-05', '2020-01-09', 'PROVA', 'PROVA', 'uploads/README.md'),
('1A', 3, '2020-01-05', '2020-01-30', 'title', 'subtitle', 'NULL'),
('1A', 4, '2019-12-15', '2019-12-16', 'Prova', 'Prova con file', 'uploads/ciao.txt');

-- --------------------------------------------------------

--
-- Struttura della tabella `ATTENDANCE`
--

DROP TABLE IF EXISTS `ATTENDANCE`;
CREATE TABLE IF NOT EXISTS `ATTENDANCE` (
  `StudentSSN` char(16) COLLATE utf8_unicode_ci NOT NULL,
  `Date` date NOT NULL,
  `Presence` enum('PRESENT','10_MIN_LATE','1_HOUR_LATE','ABSENT') COLLATE utf8_unicode_ci DEFAULT NULL,
  `ExitHour` int(11) NOT NULL DEFAULT 6,
  PRIMARY KEY (`StudentSSN`,`Date`),
  KEY `ATTENDANCE_ibfk_1` (`StudentSSN`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Struttura della tabella `CHILD`
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
-- Dump dei dati per la tabella `CHILD`
--

INSERT INTO `CHILD` (`SSN`, `Name`, `Surname`, `SSNParent1`, `SSNParent2`, `Class`) VALUES
('AAABBBCCC1234567', 'Giuseppe', 'Ponci', 'PNCMSM75D20L219X', NULL, '1A'),
('BRBSMN04A24L219R', 'Simone', 'Barbero', 'BRBGPP57M04L219W', NULL, '1O'),
('MNDGPP04E14L219U', 'Giuseppe', 'Mandini', 'MNDFPP68C16L219N', 'PLLMRT70E68L219Q', '1A'),
('PNCRCR02C13L219K', 'Riccardo', 'Ponci', 'PNCMSM75D20L219X', 'FLCRRT77B43L219Q', '1A');

-- --------------------------------------------------------

--
-- Struttura della tabella `CLASS`
--

DROP TABLE IF EXISTS `CLASS`;
CREATE TABLE IF NOT EXISTS `CLASS` (
  `Name` char(2) COLLATE utf8_unicode_ci NOT NULL,
  `Coordinator` char(16) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`Name`),
  KEY `fk_coordinator_user` (`Coordinator`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dump dei dati per la tabella `CLASS`
--

INSERT INTO `CLASS` (`Name`, `Coordinator`) VALUES
('1O', NULL),
('1A', 'BRBGPP57M04L219W'),
('1B', 'FNLTRS72H50L219Z');

--
-- Trigger `CLASS`
--
DROP TRIGGER IF EXISTS `check_coordinator_as_teacher`;
DELIMITER $$
CREATE TRIGGER `check_coordinator_as_teacher` BEFORE INSERT ON `CLASS` FOR EACH ROW BEGIN
        DECLARE var int;
       
  		SELECT COUNT(*) INTO var FROM USER_TYPE WHERE SSN = NEW.Coordinator AND USER_TYPE.UserType = "TEACHER";
       
        IF (var = 0 AND NEW.Coordinator != NULL) THEN
			SIGNAL sqlstate '45000' set message_text = 'Error! Coordinator must be a teacher!';
        END IF;
	END
$$
DELIMITER ;
DROP TRIGGER IF EXISTS `check_coordinator_as_teacher_update`;
DELIMITER $$
CREATE TRIGGER `check_coordinator_as_teacher_update` BEFORE UPDATE ON `CLASS` FOR EACH ROW BEGIN
        DECLARE var int;
       
  		SELECT COUNT(*) INTO var FROM USER_TYPE WHERE SSN = NEW.Coordinator AND USER_TYPE.UserType = "TEACHER";
       
        IF (var = 0 ) THEN
			SIGNAL sqlstate '45000' set message_text = 'Error! Coordinator must be a teacher!';
        END IF;
	END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Struttura della tabella `CLASS_TIMETABLE`
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

--
-- Dump dei dati per la tabella `CLASS_TIMETABLE`
--

INSERT INTO `CLASS_TIMETABLE` (`Class`, `DayOfWeek`, `Hour`, `SubjectID`) VALUES
('1A', 'Monday', 6, NULL),
('1A', 'Thursday', 6, NULL),
('1A', 'Wednesday', 6, NULL),
('1A', 'Thursday', 2, 2),
('1A', 'Tuesday', 1, 2),
('1A', 'Monday', 2, 3),
('1A', 'Tuesday', 2, 3),
('1A', 'Wednesday', 1, 3),
('1A', 'Wednesday', 2, 3),
('1A', 'Friday', 5, 4),
('1A', 'Monday', 1, 4),
('1A', 'Thursday', 3, 4),
('1A', 'Thursday', 4, 4),
('1A', 'Tuesday', 5, 4),
('1A', 'Friday', 1, 5),
('1A', 'Tuesday', 6, 5),
('1A', 'Friday', 3, 6),
('1A', 'Monday', 4, 6),
('1A', 'Monday', 5, 6),
('1A', 'Wednesday', 5, 6),
('1A', 'Thursday', 1, 7),
('1A', 'Tuesday', 3, 7),
('1A', 'Wednesday', 3, 7),
('1A', 'Friday', 2, 8),
('1A', 'Tuesday', 4, 8),
('1A', 'Friday', 6, 9),
('1A', 'Monday', 3, 9),
('1A', 'Friday', 4, 10),
('1A', 'Wednesday', 4, 10),
('1A', 'Thursday', 5, 11);

-- --------------------------------------------------------

--
-- Struttura della tabella `COMMUNICATION`
--

DROP TABLE IF EXISTS `COMMUNICATION`;
CREATE TABLE IF NOT EXISTS `COMMUNICATION` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `Title` text NOT NULL,
  `Description` text NOT NULL,
  `Date` date NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;

--
-- Dump dei dati per la tabella `COMMUNICATION`
--

INSERT INTO `COMMUNICATION` (`id`, `Title`, `Description`, `Date`) VALUES
(1, '
Maintenance stop', 'Service stop notice for maintenance on Sunday, January 4 ', '2019-12-05'),
(2, 'Call for scholarship for students born in 2005', 'The deadline for the scholarship application is open until January 31', '2019-12-11'),
(3, 'School trip to Milano', 'Students who wish to attend must submit the corresponding authorization signed by their parents before December 18', '2019-12-08'),
(4, 'Opening of the 2019-2020 Course', 'Dear user, we proceeded to the opening of the virtual campus.', '2019-09-08');

-- --------------------------------------------------------

--
-- Struttura della tabella `FINAL_MARK`
--

DROP TABLE IF EXISTS `FINAL_MARK`;
CREATE TABLE IF NOT EXISTS `FINAL_MARK` (
  `Student` char(16) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `Subject` int(11) NOT NULL,
  `Mark` int(11) NOT NULL DEFAULT 6,
  PRIMARY KEY (`Student`,`Subject`),
  KEY `fk_fm_sb` (`Subject`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dump dei dati per la tabella `FINAL_MARK`
--

INSERT INTO `FINAL_MARK` (`Student`, `Subject`, `Mark`) VALUES
('BRBSMN04A24L219R', 3, 9);

-- --------------------------------------------------------

--
-- Struttura della tabella `MARK`
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
-- Dump dei dati per la tabella `MARK`
--

INSERT INTO `MARK` (`StudentSSN`, `SubjectID`, `Date`, `Class`, `Score`) VALUES
('AAABBBCCC1234567', 3, '2020-01-01', '1A', '1.00'),
('BRBSMN04A24L219R', 3, '2020-01-02', '1A', '5.50'),
('BRBSMN04A24L219R', 6, '2020-01-03', '1A', '9.50'),
('MNDGPP04E14L219U', 3, '2020-01-01', '1A', '1.25'),
('PNCRCR02C13L219K', 1, '2019-11-04', '1A', '8.75'),
('PNCRCR02C13L219K', 2, '2019-11-07', '1A', '6.50'),
('PNCRCR02C13L219K', 3, '2019-11-07', '1A', '7.25'),
('PNCRCR02C13L219K', 3, '2020-01-01', '1A', '6.50'),
('PNCRCR02C13L219K', 4, '2019-11-11', '1A', '8.00'),
('PNCRCR02C13L219K', 5, '2019-11-08', '1A', '6.75');

-- --------------------------------------------------------

--
-- Struttura della tabella `NOTE`
--

DROP TABLE IF EXISTS `NOTE`;
CREATE TABLE IF NOT EXISTS `NOTE` (
  `StudentSSN` char(16) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `SubjectID` int(11) NOT NULL,
  `Description` varchar(500) NOT NULL,
  `Date` date NOT NULL,
  PRIMARY KEY (`StudentSSN`,`SubjectID`,`Date`),
  KEY `SubjectID` (`SubjectID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dump dei dati per la tabella `NOTE`
--

INSERT INTO `NOTE` (`StudentSSN`, `SubjectID`, `Description`, `Date`) VALUES
('BRBSMN04A24L219R', 3, 'The student is making noise.', '2019-12-18'),
('MNDGPP04E14L219U', 3, 'The student chat with other classmates.', '2019-12-18'),
('PNCRCR02C13L219K', 3, 'The student is making noise and using his smartphone during the lesson.', '2019-12-15'),
('PNCRCR02C13L219K', 4, 'The student has not completed his homework. Moreover, he does not seem interested in the lesson. ', '2019-12-17');

-- --------------------------------------------------------

--
-- Struttura della tabella `SUBJECT`
--

DROP TABLE IF EXISTS `SUBJECT`;
CREATE TABLE IF NOT EXISTS `SUBJECT` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `Name` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `HoursPerWeek` int(11) NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dump dei dati per la tabella `SUBJECT`
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
-- Struttura della tabella `SUPPORT_MATERIAL`
--

DROP TABLE IF EXISTS `SUPPORT_MATERIAL`;
CREATE TABLE IF NOT EXISTS `SUPPORT_MATERIAL` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `SubjectID` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `Class` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `Date` date NOT NULL,
  `Filename` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Struttura della tabella `TEACHER_SUBJECT`
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
-- Dump dei dati per la tabella `TEACHER_SUBJECT`
--

INSERT INTO `TEACHER_SUBJECT` (`TeacherSSN`, `SubjectID`, `Class`) VALUES
('BRBGPP57M04L219W', 3, '1A'),
('BRBGPP57M04L219W', 6, '1A'),
('FNLTRS72H50L219Z', 4, '1A'),
('FNLTRS72H50L219Z', 5, '1A'),
('LNGMRN58M51L219R', 1, '1A'),
('LNGMRN58M51L219R', 2, '1A');

-- --------------------------------------------------------

--
-- Struttura della tabella `TIMETABLE`
--

DROP TABLE IF EXISTS `TIMETABLE`;
CREATE TABLE IF NOT EXISTS `TIMETABLE` (
  `DayOfWeek` varchar(15) COLLATE utf8_unicode_ci NOT NULL,
  `Hour` int(11) NOT NULL,
  PRIMARY KEY (`DayOfWeek`,`Hour`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dump dei dati per la tabella `TIMETABLE`
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
-- Struttura della tabella `TOPIC`
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
-- Dump dei dati per la tabella `TOPIC`
--

INSERT INTO `TOPIC` (`Class`, `Date`, `StartHour`, `SubjectID`, `TeacherSSN`, `Title`, `Description`) VALUES
('1A', '2020-01-01', 1, 3, 'BRBGPP57M04L219W', 'title', 'subasd');

-- --------------------------------------------------------

--
-- Struttura della tabella `USER`
--

DROP TABLE IF EXISTS `USER`;
CREATE TABLE IF NOT EXISTS `USER` (
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
-- Dump dei dati per la tabella `USER`
--

INSERT INTO `USER` (`SSN`, `Name`, `Surname`, `Email`, `Password`, `AccountActivated`) VALUES
('BLLDRD66S07L219N', 'Edoardo', 'Bello', 'e.bello@esrmsystem.com', 'Edoardo66', 1),
('BRBGPP57M04L219W', 'Giuseppe', 'Barbero', 'g.barbero@esrmsystem.com', 'Giuseppe57', 1),
('FLCGNN62R19L219X', 'Giovanni', 'Felice', 'sec@sec.it', 'Password1', 1),
('FLCRRT77B43L219Q', 'Roberta', 'Filicaro', 'parent@parent.it', 'parent1', 1),
('FNLTRS72H50L219Z', 'Teresa', 'Fanelli', 't.fanelli@esrmsystem.com', 'Teresa72', 1),
('LNGMRN58M51L219R', 'Marina', 'Longobardi', 'm.longobardi@esrmsystem.com', 'Marina58', 0),
('MNDFPP68C16L219N', 'Filippo', 'Mandini', 'f.mandini@parent.esrmsystem.com', 'Filippo68', 1),
('PLLMRT70E68L219Q', 'Marta', 'Pellegrino', 'm.pellegrino@parent.esrmsystem.com', 'Marta70', 1),
('PNCMSM75D20L219X', 'Massimiliano', 'Ponci', 'm.ponci@parent.esrmsystem.com', 'Massi75', 1),
('STLRRT66T06L219L', 'Roberto', 'Stelluti', 'r.stelluti@parent.esrmsystem.com', 'Roberto66', 1);

-- --------------------------------------------------------

--
-- Struttura della tabella `USER_TYPE`
--

DROP TABLE IF EXISTS `USER_TYPE`;
CREATE TABLE IF NOT EXISTS `USER_TYPE` (
  `SSN` char(16) COLLATE utf8_unicode_ci NOT NULL,
  `UserType` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`SSN`,`UserType`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dump dei dati per la tabella `USER_TYPE`
--

INSERT INTO `USER_TYPE` (`SSN`, `UserType`) VALUES
('BLLDRD66S07L219N', 'SYS_ADMIN'),
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
-- Constraints for table `ASSIGNMENT`
--
ALTER TABLE `ASSIGNMENT`
  ADD CONSTRAINT `assignment_ibfk_1` FOREIGN KEY (`Class`) REFERENCES `CLASS` (`Name`),
  ADD CONSTRAINT `assignment_ibfk_2` FOREIGN KEY (`SubjectID`) REFERENCES `SUBJECT` (`ID`);

--
-- Constraints for table `ATTENDANCE`
--
ALTER TABLE `ATTENDANCE`
  ADD CONSTRAINT `attendance_ibfk_1` FOREIGN KEY (`StudentSSN`) REFERENCES `CHILD` (`SSN`);

--
-- Limiti per la tabella `CHILD`
--
ALTER TABLE `CHILD`
  ADD CONSTRAINT `CHILD_ibfk_1` FOREIGN KEY (`SSNParent1`) REFERENCES `USER` (`SSN`),
  ADD CONSTRAINT `CHILD_ibfk_2` FOREIGN KEY (`SSNParent2`) REFERENCES `USER` (`SSN`),
  ADD CONSTRAINT `CHILD_ibfk_3` FOREIGN KEY (`Class`) REFERENCES `CLASS` (`Name`);

--
-- Limiti per la tabella `CLASS`
--
ALTER TABLE `CLASS`
  ADD CONSTRAINT `fk_coordinator_user` FOREIGN KEY (`Coordinator`) REFERENCES `USER` (`SSN`);

--
-- Limiti per la tabella `CLASS_TIMETABLE`
--
ALTER TABLE `CLASS_TIMETABLE`
  ADD CONSTRAINT `CLASS_TIMETABLE_ibfk_1` FOREIGN KEY (`Class`) REFERENCES `CLASS` (`Name`),
  ADD CONSTRAINT `CLASS_TIMETABLE_ibfk_2` FOREIGN KEY (`DayOfWeek`,`Hour`) REFERENCES `TIMETABLE` (`DayOfWeek`, `Hour`),
  ADD CONSTRAINT `CLASS_TIMETABLE_ibfk_4` FOREIGN KEY (`SubjectID`) REFERENCES `SUBJECT` (`ID`);

--
-- Limiti per la tabella `FINAL_MARK`
--
ALTER TABLE `FINAL_MARK`
  ADD CONSTRAINT `fk_fm_s` FOREIGN KEY (`Student`) REFERENCES `CHILD` (`SSN`),
  ADD CONSTRAINT `fk_fm_sb` FOREIGN KEY (`Subject`) REFERENCES `SUBJECT` (`ID`);

--
-- Limiti per la tabella `MARK`
--
ALTER TABLE `MARK`
  ADD CONSTRAINT `MARK_ibfk_1` FOREIGN KEY (`SubjectID`) REFERENCES `SUBJECT` (`ID`),
  ADD CONSTRAINT `MARK_ibfk_2` FOREIGN KEY (`Class`) REFERENCES `CLASS` (`Name`),
  ADD CONSTRAINT `MARK_ibfk_3` FOREIGN KEY (`StudentSSN`) REFERENCES `CHILD` (`SSN`);

--
-- Limiti per la tabella `NOTE`
--
ALTER TABLE `NOTE`
  ADD CONSTRAINT `NOTE_ibfk_1` FOREIGN KEY (`SubjectID`) REFERENCES `SUBJECT` (`ID`),
  ADD CONSTRAINT `NOTE_ibfk_2` FOREIGN KEY (`StudentSSN`) REFERENCES `CHILD` (`SSN`);

--
-- Limiti per la tabella `TEACHER_SUBJECT`
--
ALTER TABLE `TEACHER_SUBJECT`
  ADD CONSTRAINT `TEACHER_SUBJECT_ibfk_1` FOREIGN KEY (`SubjectID`) REFERENCES `SUBJECT` (`ID`),
  ADD CONSTRAINT `TEACHER_SUBJECT_ibfk_2` FOREIGN KEY (`TeacherSSN`) REFERENCES `USER` (`SSN`);

--
-- Limiti per la tabella `TOPIC`
--
ALTER TABLE `TOPIC`
  ADD CONSTRAINT `TOPIC_ibfk_1` FOREIGN KEY (`Class`) REFERENCES `CLASS` (`Name`),
  ADD CONSTRAINT `TOPIC_ibfk_2` FOREIGN KEY (`SubjectID`) REFERENCES `SUBJECT` (`ID`),
  ADD CONSTRAINT `TOPIC_ibfk_3` FOREIGN KEY (`TeacherSSN`) REFERENCES `USER` (`SSN`);

--
-- Limiti per la tabella `USER_TYPE`
--
ALTER TABLE `USER_TYPE`
  ADD CONSTRAINT `USER_TYPE_ibfk_1` FOREIGN KEY (`SSN`) REFERENCES `USER` (`SSN`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
