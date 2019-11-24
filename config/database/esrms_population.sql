USE `student_record_management`;
INSERT INTO `SUBJECT`(`Name`, `HoursPerWeek`) VALUES ('Geography',3);
INSERT INTO `SUBJECT`(`Name`, `HoursPerWeek`) VALUES ('History',3);
INSERT INTO `SUBJECT`(`Name`, `HoursPerWeek`) VALUES ('Italian',6);
INSERT INTO `SUBJECT`(`Name`, `HoursPerWeek`) VALUES ('Mathematics',5);
INSERT INTO `SUBJECT`(`Name`, `HoursPerWeek`) VALUES ('Physics',4);
INSERT INTO `SUBJECT`(`Name`, `HoursPerWeek`) VALUES ('Latin',3);
INSERT INTO `CLASS`(`Name`) VALUES ('1A');
INSERT INTO `CLASS`(`Name`) VALUES ('1B');
INSERT INTO `USER`(`SSN`, `Name`, `Surname`, `Email`, `Password`, `AccountActivated`) VALUES ('PNCMSM75D20L219X', 'Massimiliano', 'Ponci', 'm.ponci@parent.esrmsystem.com', 'Massi75', 1);
INSERT INTO `USER`(`SSN`, `Name`, `Surname`, `Email`, `Password`, `AccountActivated`) VALUES ('STLRRT66T06L219L', 'Roberto', 'Stelluti', 'r.stelluti@parent.esrmsystem.com', 'Roberto66', 1);
INSERT INTO `USER`(`SSN`, `Name`, `Surname`, `Email`, `Password`, `AccountActivated`) VALUES ('MNDFPP68C16L219N', 'Filippo', 'Mandini', 'f.mandini@parent.esrmsystem.com', 'Filippo68', 1);
INSERT INTO `USER`(`SSN`, `Name`, `Surname`, `Email`, `Password`, `AccountActivated`) VALUES ('FLCRRT77B43L219Q', 'Roberta', 'Filicaro', 'r.filicaro@parent.esrmsystem.com', 'Roberta77', 1);
INSERT INTO `USER`(`SSN`, `Name`, `Surname`, `Email`, `Password`, `AccountActivated`) VALUES ('PLLMRT70E68L219Q', 'Marta', 'Pellegrino', 'm.pellegrino@parent.esrmsystem.com', 'Marta70', 1);
INSERT INTO `USER`(`SSN`, `Name`, `Surname`, `Email`, `Password`, `AccountActivated`) VALUES ('LNGMRN58M51L219R', 'Marina', 'Longobardi', 'm.longobardi@esrmsystem.com', 'Marina58', 1);
INSERT INTO `USER`(`SSN`, `Name`, `Surname`, `Email`, `Password`, `AccountActivated`) VALUES ('FNLTRS72H50L219Z', 'Teresa', 'Fanelli', 't.fanelli@esrmsystem.com', 'Teresa72', 1);
INSERT INTO `USER`(`SSN`, `Name`, `Surname`, `Email`, `Password`, `AccountActivated`) VALUES ('BRBGPP57M04L219W', 'Giuseppe', 'Barbero', 'g.barbero@esrmsystem.com', 'Giuseppe57', 1);
INSERT INTO `USER`(`SSN`, `Name`, `Surname`, `Email`, `Password`, `AccountActivated`) VALUES ('FLCGNN62R19L219X', 'Giovanni', 'Felice', 'g.felice@esrmsystem.com', 'Giovanni62', 1);
INSERT INTO `USER`(`SSN`, `Name`, `Surname`, `Email`, `Password`, `AccountActivated`) VALUES ('BLLDRD66S07L219N', 'Edoardo', 'Bello', 'e.bello@esrmsystem.com', 'Edoardo66', 1);
INSERT INTO `USER_TYPE`(`SSN`,`UserType`) VALUES ('PNCMSM75D20L219X', 'PARENT');
INSERT INTO `USER_TYPE`(`SSN`,`UserType`) VALUES ('STLRRT66T06L219L', 'PARENT');
INSERT INTO `USER_TYPE`(`SSN`,`UserType`) VALUES ('MNDFPP68C16L219N', 'PARENT');
INSERT INTO `USER_TYPE`(`SSN`,`UserType`) VALUES ('FLCRRT77B43L219Q', 'PARENT');
INSERT INTO `USER_TYPE`(`SSN`,`UserType`) VALUES ('PLLMRT70E68L219Q', 'PARENT');
INSERT INTO `USER_TYPE`(`SSN`,`UserType`) VALUES ('LNGMRN58M51L219R', 'TEACHER');
INSERT INTO `USER_TYPE`(`SSN`,`UserType`) VALUES ('FNLTRS72H50L219Z', 'TEACHER');
INSERT INTO `USER_TYPE`(`SSN`,`UserType`) VALUES ('BRBGPP57M04L219W', 'TEACHER');
INSERT INTO `USER_TYPE`(`SSN`,`UserType`) VALUES ('BRBGPP57M04L219W', 'PARENT');
INSERT INTO `USER_TYPE`(`SSN`,`UserType`) VALUES ('FLCGNN62R19L219X', 'SECRETARY_OFFICER');
INSERT INTO `USER_TYPE`(`SSN`,`UserType`) VALUES ('BLLDRD66S07L219N', 'SYS_ADMIN');
INSERT INTO `CHILD`(`SSN`, `Name`, `Surname`, `SSNParent1`, `SSNParent2`, `Class`) VALUES ('PNCRCR02C13L219K', 'Riccardo', 'Ponci', 'PNCMSM75D20L219X', 'FLCRRT77B43L219Q', '1A');
INSERT INTO `CHILD`(`SSN`, `Name`, `Surname`, `SSNParent1`, `SSNParent2`, `Class`) VALUES ('MNDGPP04E14L219U', 'Giuseppe', 'Mandini', 'MNDFPP68C16L219N', 'PLLMRT70E68L219Q', '1A');
INSERT INTO `CHILD`(`SSN`, `Name`, `Surname`, `SSNParent1`, `Class`) VALUES ('BRBSMN04A24L219R', 'Simone', 'Barbero', 'BRBGPP57M04L219W', '1B');
INSERT INTO `TEACHER_SUBJECT`(`TeacherSSN`, `SubjectID`, `Class`) VALUES ('LNGMRN58M51L219R', 1, '1A');
INSERT INTO `TEACHER_SUBJECT`(`TeacherSSN`, `SubjectID`, `Class`) VALUES ('LNGMRN58M51L219R', 2, '1A');
INSERT INTO `TEACHER_SUBJECT`(`TeacherSSN`, `SubjectID`, `Class`) VALUES ('FNLTRS72H50L219Z', 4, '1A');
INSERT INTO `TEACHER_SUBJECT`(`TeacherSSN`, `SubjectID`, `Class`) VALUES ('FNLTRS72H50L219Z', 5, '1A');
INSERT INTO `TEACHER_SUBJECT`(`TeacherSSN`, `SubjectID`, `Class`) VALUES ('BRBGPP57M04L219W', 3, '1A');
INSERT INTO `TEACHER_SUBJECT`(`TeacherSSN`, `SubjectID`, `Class`) VALUES ('BRBGPP57M04L219W', 6, '1A');
INSERT INTO `MARK`(`StudentSSN`, `SUBJECTID`, `Date`, `Class`, `Score`) VALUES ('PNCRCR02C13L219K', 1, '2019-11-04', '1A', 8.75);
INSERT INTO `MARK`(`StudentSSN`, `SUBJECTID`, `Date`, `Class`, `Score`) VALUES ('PNCRCR02C13L219K', 2, '2019-11-07', '1A', 6.5);
INSERT INTO `MARK`(`StudentSSN`, `SUBJECTID`, `Date`, `Class`, `Score`) VALUES ('PNCRCR02C13L219K', 3, '2019-11-07', '1A', 7.25);
INSERT INTO `MARK`(`StudentSSN`, `SUBJECTID`, `Date`, `Class`, `Score`) VALUES ('PNCRCR02C13L219K', 5, '2019-11-08', '1A', 6.75);
INSERT INTO `MARK`(`StudentSSN`, `SUBJECTID`, `Date`, `Class`, `Score`) VALUES ('PNCRCR02C13L219K', 4, '2019-11-11', '1A', 8);
INSERT INTO `ATTENDANCE`(`StudentSSN`, `Date`, `Presence`, `ExitHour`) VALUES ('PNCRCR02C13L219K', '2019-11-19', '1A', 'ABSENT');
INSERT INTO `ATTENDANCE`(`StudentSSN`, `Date`, `Presence`, `ExitHour`) VALUES ('PNCRCR02C13L219K', '2019-11-21', '1A', '10_MIN_LATE');
INSERT INTO `ATTENDANCE`(`StudentSSN`, `Date`, `Presence`, `ExitHour`) VALUES ('PNCRCR02C13L219K', '2019-11-22', '1A', '1_HOUR_LATE');
INSERT INTO `ATTENDANCE`(`StudentSSN`, `Date`, `Presence`, `ExitHour`) VALUES ('MNDGPP04E14L219U', '2019-11-20', '1A', 'ABSENT');
INSERT INTO `ATTENDANCE`(`StudentSSN`, `Date`, `Presence`, `ExitHour`) VALUES ('MNDGPP04E14L219U', '2019-11-22', '1A', '1_HOUR_LATE');
INSERT INTO `ASSIGNMENT`(`Class`, `SubjectID`, `DateOfAssignment`, `DeadlineDate`, `Title`, `Description`) VALUES ('1A', 4 , '2019-11-19', '2019-11-20', 'Daily Homeworks', 'Very funny description 1');
INSERT INTO `ASSIGNMENT`(`Class`, `SubjectID`, `DateOfAssignment`, `DeadlineDate`, `Title`, `Description`) VALUES ('1A', 4 , '2019-11-19', '2019-11-26', 'Short project', 'Very funny description 2');
INSERT INTO `ASSIGNMENT`(`Class`, `SubjectID`, `DateOfAssignment`, `DeadlineDate`, `Title`, `Description`) VALUES ('1A', 5 , '2019-11-25', '2019-11-26', 'Daily Homeworks', 'Very funny description 1000');
INSERT INTO `ASSIGNMENT`(`Class`, `SubjectID`, `DateOfAssignment`, `DeadlineDate`, `Title`, `Description`) VALUES ('1A', 1 , '2019-11-22', '2019-11-27', 'Next lecture assignments', 'Brief description 333');
INSERT INTO `ASSIGNMENT`(`Class`, `SubjectID`, `DateOfAssignment`, `DeadlineDate`, `Title`, `Description`) VALUES ('1A', 6 , '2019-11-19', '2019-11-28', 'Short project', 'Very nerd description hf83@hs9#fh$*!(hd^gd)');
