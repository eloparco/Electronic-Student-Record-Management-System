INSERT INTO `CLASS` (`Name`) VALUES ('1A'), ('1B');
INSERT INTO `USER` (`SSN`, `Name`, `Surname`, `Email`, `Password`, `UserType`, `AccountActivated`) VALUES
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
INSERT INTO `SUBJECT` (`ID`, `Name`, `HoursPerWeek`) VALUES (1, 'Math', 5), (2, 'Algebra', 5);
INSERT INTO `CHILD` (`SSN`, `Name`, `Surname`, `SSNParent1`, `SSNParent2`, `Class`) VALUES ('VRDLCA80L02G3035A', 'Luca', 'Demaio', 'BDTJHN80S11Z306F', 'XZDMLR60R69I950T', '1A');
INSERT INTO `TEACHER_SUBJECT` (`TeacherSSN`, `SubjectID`, `Class`) VALUES ('WHRDHF59H46H847L', 1, '1A'), ('ZTZLPP85P22A761V', 2, '1B');
INSERT INTO `TOPIC` (`Class`, `Date`, `StartHour`, `SubjectID`, `TeacherSSN`, `Title`, `Description`) VALUES
('1B', '2019-11-13', 8, 2, 'ZTZLPP85P22A761V', 'Equation', 'Linear equation chapter 9'),
('1B', '2019-11-15', 10, 2, 'ZTZLPP85P22A761V', 'Equation', 'Linear equation');
INSERT INTO `MARK` (`StudentSSN`, `SubjectID`, `Date`, `Class`, `Score`) VALUES
('VRDLCA80L02G3035A', 1, '2019-11-04', '1A', '8.75'),
('VRDLCA80L02G3035A', 1, '2019-11-07', '1A', '7.25'),
('VRDLCA80L02G3035A', 2, '2019-11-07', '1A', '6.50');
