-- phpMyAdmin SQL Dump
-- version 4.2.5
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Aug 08, 2014 at 12:00 PM
-- Server version: 5.6.19
-- PHP Version: 5.5.13

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `quizmantra`
--

-- --------------------------------------------------------

--
-- Table structure for table `adminlogin`
--

CREATE TABLE IF NOT EXISTS `adminlogin` (
  `admname` varchar(32) NOT NULL,
  `admpassword` varchar(32) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `adminlogin`
--

INSERT INTO `adminlogin` (`admname`, `admpassword`) VALUES
('root', '63a9f0ea7bb98050796b649e85481845');

-- --------------------------------------------------------

--
-- Table structure for table `question`
--

CREATE TABLE IF NOT EXISTS `question` (
  `testid` bigint(20) NOT NULL DEFAULT '0',
  `qnid` int(11) NOT NULL DEFAULT '0',
  `question` varchar(500) DEFAULT NULL,
  `optiona` varchar(100) DEFAULT NULL,
  `optionb` varchar(100) DEFAULT NULL,
  `optionc` varchar(100) DEFAULT NULL,
  `optiond` varchar(100) DEFAULT NULL,
  `correctanswer` enum('optiona','optionb','optionc','optiond') DEFAULT NULL,
  `marks` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `question`
--

INSERT INTO `question` (`testid`, `qnid`, `question`, `optiona`, `optionb`, `optionc`, `optiond`, `correctanswer`, `marks`) VALUES
(1, 1, 'what is light?', 'a', 'b', 'c', 'd', 'optionb', 2),
(1, 2, 'what is solar panel?', 'a', 'b', 'c', 'd', 'optiona', 1),
(1, 3, 'what is convex mirror?', 'a', 'b', 'c', 'd', 'optionc', 1),
(1, 4, 'what is liquid?', 'a', 'b', 'c', 'd', 'optiona', 1),
(1, 5, 'what is pressure?', 'a', 'b', 'c', 'd', 'optiona', 1),
(1, 6, 'what is torque?', 'a', 'b', 'c', 'd', 'optiona', 1),
(1, 7, 'what is moment of inertia?', 'a', 'b', 'c', 'd', 'optiona', 1),
(1, 8, 'what is projection?', 'a', 'b', 'c', 'd', 'optiona', 1),
(1, 9, 'what is surface tension?', 'a', 'b', 'c', 'd', 'optiona', 1),
(1, 10, 'what is gas?', 'a', 'b', 'c', 'd', 'optiona', 1),
(1, 11, 'what is form of water at -45 c? ', 'a', 'b', 'c', 'd', 'optiona', 1),
(1, 12, 'what is gravity?', 'a', 'b', 'c', 'd', 'optionc', 1),
(2, 1, 'The nucleus of an atom consists of', 'electrons and neutrons', 'electrons and protons', 'protons and neutrons', 'All of the above', 'optionc', 1),
(2, 2, 'The number of moles of solute present in 1 kg of a solvent is called its', ' 	molality', 'molarity', 'normality', 'formality', 'optiona', 1),
(2, 3, ' 	\r\n\r\nThe most electronegative element among the following is', 'sodium', 'bromine', 'fluorine', 'oxygen', 'optionc', 1),
(2, 4, 'The metal used to recover copper from a solution of copper sulphate is', 'Na', 'Ag', 'Hg', 'Fe', 'optiond', 1),
(2, 5, 'The number of d-electrons in Fe2+ (Z = 26) is not equal to that of', 'p-electrons in Ne(Z = 10)', 's-electrons in Mg(Z = 12)', 'd-electrons in Fe(Z = 26)', 'p-electrons in CI(Z = 17)', 'optiond', 1),
(2, 6, ' 	\r\n\r\nThe metallurgical process in which a metal is obtained in a fused state is called', 'smelting', 'roasting', 'calcinations', 'froth floatation', 'optiona', 1),
(2, 7, 'The molecules of which gas have highest speed?', 'H2 at -73oC', 'CH4 at 300 K', 'N2 at 1,027oC', 'O2 at 0oC', 'optiona', 1),
(2, 8, ' 	\r\n\r\nThe law which states that the amount of gas dissolved in a liquid is proportional to its partial pressure is', 'Dalton&#039;s law', 'Gay Lussac&#039;s law', 'Henry&#039;s law', 'Raoult&#039;s law', 'optionc', 1),
(2, 9, 'The main buffer system of the human blood is', 'H2CO3 - HCO3', 'H2CO3 - CO32-', 'CH3COOH - CH3COO-', 'NH2CONH2 - NH2CONH+', 'optiona', 1),
(2, 10, ' 	\r\n\r\nThe most commonly used bleaching agent is', 'alcohol', 'carbon dioxide', 'chlorine', 'sodium chlorine', 'optionc', 1);

-- --------------------------------------------------------

--
-- Table structure for table `student`
--

CREATE TABLE IF NOT EXISTS `student` (
  `stdid` bigint(20) NOT NULL,
  `stdname` varchar(40) DEFAULT NULL,
  `stdpassword` varchar(40) DEFAULT NULL,
  `emailid` varchar(40) DEFAULT NULL,
  `contactno` varchar(20) DEFAULT NULL,
  `address` varchar(40) DEFAULT NULL,
  `city` varchar(40) DEFAULT NULL,
  `pincode` varchar(20) DEFAULT NULL,
  `tc` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `student`
--

INSERT INTO `student` (`stdid`, `stdname`, `stdpassword`, `emailid`, `contactno`, `address`, `city`, `pincode`, `tc`) VALUES
(0, 'root', 'root', NULL, NULL, NULL, NULL, NULL, 0),
(1, 'krishna', '.»Å+', 'krishna@gmail.com', '9555558423', 'g-231 alpha2', 'noida', '201308', 1),
(2, 'jai', '111111', 'jai@vidyamantra.com', '123456789', 'delhi 6', 'noida', '210901', 1),
(3, 'vaibhav', '123456', 'vaibhav@yahoo.com', '8266954654', 'paudi', 'uk', '300020', 0);

-- --------------------------------------------------------

--
-- Table structure for table `studentquestion`
--

CREATE TABLE IF NOT EXISTS `studentquestion` (
  `stdid` bigint(20) NOT NULL DEFAULT '0',
  `testid` bigint(20) NOT NULL DEFAULT '0',
  `qnid` int(11) NOT NULL DEFAULT '0',
  `answered` enum('answered','unanswered','review') DEFAULT NULL,
  `stdanswer` enum('optiona','optionb','optionc','optiond') DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `studentquestion`
--

INSERT INTO `studentquestion` (`stdid`, `testid`, `qnid`, `answered`, `stdanswer`) VALUES
(1, 2, 1, 'answered', 'optiona'),
(1, 2, 2, 'answered', 'optionb'),
(1, 2, 3, 'answered', 'optionb'),
(1, 2, 4, 'review', 'optionc'),
(1, 2, 5, 'answered', 'optiona'),
(1, 2, 6, 'answered', 'optionb'),
(1, 2, 7, 'answered', 'optionc'),
(1, 2, 8, 'answered', 'optiona'),
(1, 2, 9, 'answered', 'optiona'),
(1, 2, 10, 'answered', 'optiona');

-- --------------------------------------------------------

--
-- Table structure for table `studenttest`
--

CREATE TABLE IF NOT EXISTS `studenttest` (
  `stdid` bigint(20) NOT NULL DEFAULT '0',
  `testid` bigint(20) NOT NULL DEFAULT '0',
  `starttime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `endtime` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `correctlyanswered` int(11) DEFAULT NULL,
  `status` enum('over','inprogress') DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `studenttest`
--

INSERT INTO `studenttest` (`stdid`, `testid`, `starttime`, `endtime`, `correctlyanswered`, `status`) VALUES
(1, 2, '2014-08-04 11:26:13', '2014-08-04 11:56:13', 0, 'over');

-- --------------------------------------------------------

--
-- Table structure for table `subject`
--

CREATE TABLE IF NOT EXISTS `subject` (
  `subid` int(11) NOT NULL,
  `subname` varchar(40) DEFAULT NULL,
  `subdesc` varchar(100) DEFAULT NULL,
  `teacherid` bigint(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `subject`
--

INSERT INTO `subject` (`subid`, `subname`, `subdesc`, `teacherid`) VALUES
(1, 'physics', 'it is a part of science.', 0),
(2, 'chemistry', 'it contains chemical theory and practical based problems.', 0),
(3, 'PHP', 'PHP', 0),
(4, 'computers', 'computers based problems', 2),
(5, 'history', 'history related questions', 2);

-- --------------------------------------------------------

--
-- Table structure for table `test`
--

CREATE TABLE IF NOT EXISTS `test` (
  `testid` bigint(20) NOT NULL,
  `testname` varchar(30) NOT NULL,
  `testdesc` varchar(100) DEFAULT NULL,
  `testdate` date DEFAULT NULL,
  `testtime` time DEFAULT NULL,
  `subid` int(11) DEFAULT NULL,
  `testfrom` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `testto` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `duration` int(11) DEFAULT NULL,
  `totalquestions` int(11) DEFAULT NULL,
  `attemptedstudents` bigint(20) DEFAULT NULL,
  `testcode` varchar(40) NOT NULL,
  `teacherid` bigint(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `test`
--

INSERT INTO `test` (`testid`, `testname`, `testdesc`, `testdate`, `testtime`, `subid`, `testfrom`, `testto`, `duration`, `totalquestions`, `attemptedstudents`, `testcode`, `teacherid`) VALUES
(1, 'science1', 'it contains 10 questions and each of have one right answer.', '2014-08-04', '10:29:51', 1, '2014-08-02 09:58:30', '2015-08-05 18:29:59', 30, 10, 0, 'ú\\', NULL),
(2, 'science2', 'it contains organic and inorganic questions', '2014-08-04', '10:59:12', 2, '2014-08-04 09:52:56', '2015-08-07 18:29:59', 30, 10, 0, 'úù', NULL),
(3, 'php1', 'php', '2014-08-06', '12:13:58', 4, '2014-08-07 11:46:33', '2014-08-15 18:29:59', 30, 10, 0, 'p1', 2),
(4, 'software', 'contains only software related questions', '2014-08-08', '16:55:38', 4, '2014-08-08 11:25:38', '2014-08-31 18:29:59', 20, 5, 0, 'c1', 2);

-- --------------------------------------------------------

--
-- Table structure for table `testconductor`
--

CREATE TABLE IF NOT EXISTS `testconductor` (
  `tcid` bigint(20) NOT NULL,
  `tcname` varchar(40) DEFAULT NULL,
  `tcpassword` varchar(40) DEFAULT NULL,
  `emailid` varchar(40) DEFAULT NULL,
  `contactno` varchar(20) DEFAULT NULL,
  `address` varchar(40) DEFAULT NULL,
  `city` varchar(40) DEFAULT NULL,
  `pincode` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `testconductor`
--

INSERT INTO `testconductor` (`tcid`, `tcname`, `tcpassword`, `emailid`, `contactno`, `address`, `city`, `pincode`) VALUES
(1, 'krishna', '.»Å+', 'krishna@gmail.com', '9555558424', 'g.noida', 'g.noida', '201308');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `adminlogin`
--
ALTER TABLE `adminlogin`
 ADD PRIMARY KEY (`admname`);

--
-- Indexes for table `question`
--
ALTER TABLE `question`
 ADD PRIMARY KEY (`testid`,`qnid`);

--
-- Indexes for table `student`
--
ALTER TABLE `student`
 ADD PRIMARY KEY (`stdid`), ADD UNIQUE KEY `stdname` (`stdname`), ADD UNIQUE KEY `emailid` (`emailid`);

--
-- Indexes for table `studentquestion`
--
ALTER TABLE `studentquestion`
 ADD PRIMARY KEY (`stdid`,`testid`,`qnid`), ADD KEY `testid` (`testid`,`qnid`);

--
-- Indexes for table `studenttest`
--
ALTER TABLE `studenttest`
 ADD PRIMARY KEY (`stdid`,`testid`), ADD KEY `testid` (`testid`);

--
-- Indexes for table `subject`
--
ALTER TABLE `subject`
 ADD PRIMARY KEY (`subid`), ADD UNIQUE KEY `subname` (`subname`);

--
-- Indexes for table `test`
--
ALTER TABLE `test`
 ADD PRIMARY KEY (`testid`), ADD UNIQUE KEY `testname` (`testname`), ADD KEY `test_fk1` (`subid`), ADD KEY `test_fk2` (`teacherid`);

--
-- Indexes for table `testconductor`
--
ALTER TABLE `testconductor`
 ADD PRIMARY KEY (`tcid`), ADD UNIQUE KEY `stdname` (`tcname`), ADD UNIQUE KEY `emailid` (`emailid`);

--
-- Constraints for dumped tables
--

--
-- Constraints for table `question`
--
ALTER TABLE `question`
ADD CONSTRAINT `question_ibfk_1` FOREIGN KEY (`testid`) REFERENCES `test` (`testid`);

--
-- Constraints for table `studentquestion`
--
ALTER TABLE `studentquestion`
ADD CONSTRAINT `studentquestion_ibfk_1` FOREIGN KEY (`stdid`) REFERENCES `student` (`stdid`),
ADD CONSTRAINT `studentquestion_ibfk_2` FOREIGN KEY (`testid`, `qnid`) REFERENCES `question` (`testid`, `qnid`);

--
-- Constraints for table `studenttest`
--
ALTER TABLE `studenttest`
ADD CONSTRAINT `studenttest_ibfk_1` FOREIGN KEY (`stdid`) REFERENCES `student` (`stdid`),
ADD CONSTRAINT `studenttest_ibfk_2` FOREIGN KEY (`testid`) REFERENCES `test` (`testid`);

--
-- Constraints for table `test`
--
ALTER TABLE `test`
ADD CONSTRAINT `test_fk1` FOREIGN KEY (`subid`) REFERENCES `subject` (`subid`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
