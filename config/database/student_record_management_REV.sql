-- phpMyAdmin SQL Dump
-- version 4.9.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Creato il: Dic 06, 2019 alle 19:37
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

-- --------------------------------------------------------

--
-- Struttura della tabella `ASSIGNMENT`
--

CREATE TABLE `ASSIGNMENT` (
  `Class` char(2) COLLATE utf8_unicode_ci NOT NULL,
  `SubjectID` int(11) NOT NULL,
  `DateOfAssignment` date NOT NULL,
  `DeadlineDate` date NOT NULL,
  `Title` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `Description` varchar(400) COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Struttura della tabella `ATTENDANCE`
--

CREATE TABLE `ATTENDANCE` (
  `StudentSSN` char(16) COLLATE utf8_unicode_ci NOT NULL,
  `Date` date NOT NULL,
  `Presence` enum('PRESENT','10_MIN_LATE','1_HOUR_LATE','ABSENT') COLLATE utf8_unicode_ci DEFAULT NULL,
  `ExitHour` int(11) NOT NULL DEFAULT 6
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Struttura della tabella `CHILD`
--

CREATE TABLE `CHILD` (
  `SSN` char(16) COLLATE utf8_unicode_ci NOT NULL,
  `Name` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `Surname` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `SSNParent1` char(16) COLLATE utf8_unicode_ci NOT NULL,
  `SSNParent2` char(16) COLLATE utf8_unicode_ci DEFAULT NULL,
  `Class` char(2) COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dump dei dati per la tabella `CHILD`
--

INSERT INTO `CHILD` (`SSN`, `Name`, `Surname`, `SSNParent1`, `SSNParent2`, `Class`) VALUES
('BRBSMN04A24L219R', 'Simone', 'Barbero', 'BRBGPP57M04L219W', NULL, '1B'),
('MNDGPP04E14L219U', 'Giuseppe', 'Mandini', 'MNDFPP68C16L219N', 'PLLMRT70E68L219Q', '1A'),
('PNCRCR02C13L219K', 'Riccardo', 'Ponci', 'PNCMSM75D20L219X', 'FLCRRT77B43L219Q', '1A');

-- --------------------------------------------------------

--
-- Struttura della tabella `CLASS`
--

CREATE TABLE `CLASS` (
  `Name` char(2) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dump dei dati per la tabella `CLASS`
--

INSERT INTO `CLASS` (`Name`) VALUES
('1A'),
('1B');

-- --------------------------------------------------------

--
-- Struttura della tabella `CLASS_TIMETABLE`
--

CREATE TABLE `CLASS_TIMETABLE` (
  `Class` char(2) COLLATE utf8_unicode_ci NOT NULL,
  `DayOfWeek` varchar(15) COLLATE utf8_unicode_ci NOT NULL,
  `Hour` int(11) NOT NULL,
  `SubjectID` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Struttura della tabella `COMMUNICATION`
--

CREATE TABLE `COMMUNICATION` (
  `id` int(11) NOT NULL,
  `Title` text NOT NULL,
  `Description` text NOT NULL,
  `Date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Struttura della tabella `MARK`
--

CREATE TABLE `MARK` (
  `StudentSSN` char(16) COLLATE utf8_unicode_ci NOT NULL,
  `SubjectID` int(11) NOT NULL,
  `Date` date NOT NULL,
  `Class` char(2) COLLATE utf8_unicode_ci NOT NULL,
  `Score` decimal(5,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dump dei dati per la tabella `MARK`
--

INSERT INTO `MARK` (`StudentSSN`, `SubjectID`, `Date`, `Class`, `Score`) VALUES
('PNCRCR02C13L219K', 1, '2019-11-04', '1A', '8.75'),
('PNCRCR02C13L219K', 2, '2019-11-07', '1A', '6.50'),
('PNCRCR02C13L219K', 3, '2019-11-07', '1A', '7.25'),
('PNCRCR02C13L219K', 4, '2019-11-11', '1A', '8.00'),
('PNCRCR02C13L219K', 5, '2019-11-08', '1A', '6.75');

-- --------------------------------------------------------

--
-- Struttura della tabella `SUBJECT`
--

CREATE TABLE `SUBJECT` (
  `ID` int(11) NOT NULL,
  `Name` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `HoursPerWeek` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

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

CREATE TABLE `SUPPORT_MATERIAL` (
  `ID` int(11) NOT NULL,
  `SubjectID` varchar(255) NOT NULL,
  `Class` varchar(255) NOT NULL,
  `Date` date NOT NULL,
  `Filename` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Struttura della tabella `TEACHER_SUBJECT`
--

CREATE TABLE `TEACHER_SUBJECT` (
  `TeacherSSN` char(16) COLLATE utf8_unicode_ci NOT NULL,
  `SubjectID` int(11) NOT NULL,
  `Class` char(2) COLLATE utf8_unicode_ci NOT NULL
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

CREATE TABLE `TIMETABLE` (
  `DayOfWeek` varchar(15) COLLATE utf8_unicode_ci NOT NULL,
  `Hour` int(11) NOT NULL
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

CREATE TABLE `TOPIC` (
  `Class` char(2) COLLATE utf8_unicode_ci NOT NULL,
  `Date` date NOT NULL,
  `StartHour` int(11) NOT NULL,
  `SubjectID` int(11) NOT NULL,
  `TeacherSSN` char(16) COLLATE utf8_unicode_ci NOT NULL,
  `Title` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `Description` varchar(400) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Struttura della tabella `USER`
--

CREATE TABLE `USER` (
  `SSN` char(16) COLLATE utf8_unicode_ci NOT NULL,
  `Name` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `Surname` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `Email` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `Password` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `AccountActivated` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dump dei dati per la tabella `USER`
--

INSERT INTO `USER` (`SSN`, `Name`, `Surname`, `Email`, `Password`, `AccountActivated`) VALUES
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
-- Struttura della tabella `USER_TYPE`
--

CREATE TABLE `USER_TYPE` (
  `SSN` char(16) COLLATE utf8_unicode_ci NOT NULL,
  `UserType` varchar(30) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dump dei dati per la tabella `USER_TYPE`
--

INSERT INTO `USER_TYPE` (`SSN`, `UserType`) VALUES
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
-- Indici per le tabelle scaricate
--

--
-- Indici per le tabelle `ASSIGNMENT`
--
ALTER TABLE `ASSIGNMENT`
  ADD PRIMARY KEY (`Class`,`SubjectID`,`DeadlineDate`),
  ADD KEY `SubjectID` (`SubjectID`);

--
-- Indici per le tabelle `ATTENDANCE`
--
ALTER TABLE `ATTENDANCE`
  ADD PRIMARY KEY (`StudentSSN`,`Date`),
  ADD KEY `ATTENDANCE_ibfk_1` (`StudentSSN`);

--
-- Indici per le tabelle `CHILD`
--
ALTER TABLE `CHILD`
  ADD PRIMARY KEY (`SSN`),
  ADD KEY `SSNParent1` (`SSNParent1`),
  ADD KEY `SSNParent2` (`SSNParent2`),
  ADD KEY `Class` (`Class`);

--
-- Indici per le tabelle `CLASS`
--
ALTER TABLE `CLASS`
  ADD PRIMARY KEY (`Name`);

--
-- Indici per le tabelle `CLASS_TIMETABLE`
--
ALTER TABLE `CLASS_TIMETABLE`
  ADD PRIMARY KEY (`Class`,`DayOfWeek`,`Hour`),
  ADD KEY `DayOfWeek` (`DayOfWeek`,`Hour`),
  ADD KEY `CLASS_TIMETABLE_ibfk_4` (`SubjectID`);

--
-- Indici per le tabelle `COMMUNICATION`
--
ALTER TABLE `COMMUNICATION`
  ADD PRIMARY KEY (`id`);

--
-- Indici per le tabelle `MARK`
--
ALTER TABLE `MARK`
  ADD PRIMARY KEY (`StudentSSN`,`SubjectID`,`Date`),
  ADD KEY `SubjectID` (`SubjectID`),
  ADD KEY `MARK_ibfk_2` (`Class`);

--
-- Indici per le tabelle `SUBJECT`
--
ALTER TABLE `SUBJECT`
  ADD PRIMARY KEY (`ID`);

--
-- Indici per le tabelle `SUPPORT_MATERIAL`
--
ALTER TABLE `SUPPORT_MATERIAL`
  ADD PRIMARY KEY (`ID`);

--
-- Indici per le tabelle `TEACHER_SUBJECT`
--
ALTER TABLE `TEACHER_SUBJECT`
  ADD PRIMARY KEY (`TeacherSSN`,`SubjectID`,`Class`),
  ADD KEY `SubjectID` (`SubjectID`);

--
-- Indici per le tabelle `TIMETABLE`
--
ALTER TABLE `TIMETABLE`
  ADD PRIMARY KEY (`DayOfWeek`,`Hour`);

--
-- Indici per le tabelle `TOPIC`
--
ALTER TABLE `TOPIC`
  ADD PRIMARY KEY (`Class`,`Date`,`StartHour`),
  ADD KEY `SubjectID` (`SubjectID`),
  ADD KEY `TeacherSSN` (`TeacherSSN`);

--
-- Indici per le tabelle `USER`
--
ALTER TABLE `USER`
  ADD PRIMARY KEY (`SSN`),
  ADD UNIQUE KEY `Email` (`Email`);

--
-- Indici per le tabelle `USER_TYPE`
--
ALTER TABLE `USER_TYPE`
  ADD PRIMARY KEY (`SSN`,`UserType`);

--
-- AUTO_INCREMENT per le tabelle scaricate
--

--
-- AUTO_INCREMENT per la tabella `COMMUNICATION`
--
ALTER TABLE `COMMUNICATION`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT per la tabella `SUBJECT`
--
ALTER TABLE `SUBJECT`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT per la tabella `SUPPORT_MATERIAL`
--
ALTER TABLE `SUPPORT_MATERIAL`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT;

--
-- Limiti per le tabelle scaricate
--

--
-- Limiti per la tabella `CHILD`
--
ALTER TABLE `CHILD`
  ADD CONSTRAINT `CHILD_ibfk_1` FOREIGN KEY (`SSNParent1`) REFERENCES `USER` (`SSN`),
  ADD CONSTRAINT `CHILD_ibfk_2` FOREIGN KEY (`SSNParent2`) REFERENCES `USER` (`SSN`),
  ADD CONSTRAINT `CHILD_ibfk_3` FOREIGN KEY (`Class`) REFERENCES `CLASS` (`Name`);

--
-- Limiti per la tabella `CLASS_TIMETABLE`
--
ALTER TABLE `CLASS_TIMETABLE`
  ADD CONSTRAINT `CLASS_TIMETABLE_ibfk_1` FOREIGN KEY (`Class`) REFERENCES `CLASS` (`Name`),
  ADD CONSTRAINT `CLASS_TIMETABLE_ibfk_2` FOREIGN KEY (`DayOfWeek`,`Hour`) REFERENCES `TIMETABLE` (`DayOfWeek`, `Hour`),
  ADD CONSTRAINT `CLASS_TIMETABLE_ibfk_4` FOREIGN KEY (`SubjectID`) REFERENCES `SUBJECT` (`ID`);

--
-- Limiti per la tabella `MARK`
--
ALTER TABLE `MARK`
  ADD CONSTRAINT `MARK_ibfk_1` FOREIGN KEY (`SubjectID`) REFERENCES `SUBJECT` (`ID`),
  ADD CONSTRAINT `MARK_ibfk_2` FOREIGN KEY (`Class`) REFERENCES `CLASS` (`Name`),
  ADD CONSTRAINT `MARK_ibfk_3` FOREIGN KEY (`StudentSSN`) REFERENCES `CHILD` (`SSN`);

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
