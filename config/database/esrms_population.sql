-- phpMyAdmin SQL Dump
-- version 4.6.6deb5
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Dec 05, 2019 at 11:57 PM
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
CREATE DATABASE IF NOT EXISTS `student_record_management` DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci;
USE `student_record_management`;

--
-- Dumping data for table `ASSIGNMENT`
--

INSERT INTO `ASSIGNMENT` (`Class`, `SubjectID`, `DateOfAssignment`, `DeadlineDate`, `Title`, `Description`) VALUES
('1A', 1, '2019-11-22', '2019-11-27', 'Next lecture assignments', 'Brief description 333'),
('1A', 4, '2019-11-19', '2019-11-20', 'Daily Homeworks', 'Very funny description 1'),
('1A', 4, '2019-11-19', '2019-11-26', 'Short project', 'Very funny description 2'),
('1A', 5, '2019-11-25', '2019-11-26', 'Daily Homeworks', 'Very funny description 1000'),
('1A', 6, '2019-11-19', '2019-11-28', 'Short project', 'Very nerd description hf83@hs9#fh$*!(hd^gd)');

--
-- Dumping data for table `ATTENDANCE`
--

INSERT INTO `ATTENDANCE` (`StudentSSN`, `Date`, `Presence`, `ExitHour`) VALUES
('PNCRCR02C13L219K', '2019-11-19', 'ABSENT', 6),
('PNCRCR02C13L219K', '2019-11-21', '10_MIN_LATE', 6),
('PNCRCR02C13L219K', '2019-11-22', '1_HOUR_LATE', 6),
('MNDGPP04E14L219U', '2019-11-20', 'ABSENT', 6),
('MNDGPP04E14L219U', '2019-11-22', '1_HOUR_LATE', 6),
('PNCRCR02C13L219K', '2019-11-07', '1_HOUR_LATE', 3),
('PNCRCR02C13L219K', '2019-11-13', 'ABSENT', 6),
('PNCRCR02C13L219K', '2019-11-18', '10_MIN_LATE', 6);

--
-- Dumping data for table `CHILD`
--

INSERT INTO `CHILD` (`SSN`, `Name`, `Surname`, `SSNParent1`, `SSNParent2`, `Class`) VALUES
('BRBSMN04A24L219R', 'Simone', 'Barbero', 'BRBGPP57M04L219W', NULL, '1B'),
('MNDGPP04E14L219U', 'Giuseppe', 'Mandini', 'MNDFPP68C16L219N', 'PLLMRT70E68L219Q', '1A'),
('PNCRCR02C13L219K', 'Riccardo', 'Ponci', 'PNCMSM75D20L219X', 'FLCRRT77B43L219Q', '1A');

--
-- Dumping data for table `CLASS`
--

INSERT INTO `CLASS` (`Name`) VALUES
('1A'),
('1B');

--
-- Dumping data for table `MARK`
--

INSERT INTO `MARK` (`StudentSSN`, `SubjectID`, `Date`, `Class`, `Score`) VALUES
('PNCRCR02C13L219K', 1, '2019-11-04', '1A', '8.75'),
('PNCRCR02C13L219K', 2, '2019-11-07', '1A', '6.50'),
('PNCRCR02C13L219K', 3, '2019-11-07', '1A', '7.25'),
('PNCRCR02C13L219K', 4, '2019-11-11', '1A', '8.00'),
('PNCRCR02C13L219K', 5, '2019-11-08', '1A', '6.75');

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

--
-- Dumping data for table `TEACHER_SUBJECT`
--

INSERT INTO `TEACHER_SUBJECT` (`TeacherSSN`, `SubjectID`, `Class`) VALUES
('LNGMRN58M51L219R', 1, '1A'),
('LNGMRN58M51L219R', 2, '1A'),
('BRBGPP57M04L219W', 3, '1A'),
('FNLTRS72H50L219Z', 4, '1A'),
('FNLTRS72H50L219Z', 5, '1A'),
('BRBGPP57M04L219W', 6, '1A');

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

--
-- Dumping data for table `USER`
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

--
-- Dumping data for table `USER_TYPE`
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

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
