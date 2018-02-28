-- phpMyAdmin SQL Dump
-- version 4.6.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 22, 2017 at 03:30 PM
-- Server version: 5.7.14
-- PHP Version: 7.0.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db_case`
--

-- --------------------------------------------------------

--
-- Table structure for table `t_assign`
--

CREATE TABLE `t_assign` (
  `id` int(11) NOT NULL,
  `uid` int(11) NOT NULL,
  `cid` int(11) NOT NULL,
  `time` timestamp NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `t_assign`
--

INSERT INTO `t_assign` (`id`, `uid`, `cid`, `time`) VALUES
(12, 3, 8, '2017-04-22 07:47:06'),
(11, 5, 9, '2017-04-22 08:03:55'),
(10, 3, 7, '2017-04-22 07:08:32');

-- --------------------------------------------------------

--
-- Table structure for table `t_cases`
--

CREATE TABLE `t_cases` (
  `cid` int(11) NOT NULL,
  `creatorAccountID` int(11) NOT NULL,
  `title` varchar(62) NOT NULL,
  `lab` varchar(32) NOT NULL,
  `pc` varchar(32) NOT NULL,
  `content` text NOT NULL,
  `reason` varchar(32) NOT NULL,
  `priority` char(10) NOT NULL DEFAULT 'Normal',
  `added` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `assigned` timestamp NULL DEFAULT NULL,
  `status` varchar(35) NOT NULL DEFAULT 'Opened'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `t_cases`
--

INSERT INTO `t_cases` (`cid`, `creatorAccountID`, `title`, `lab`, `pc`, `content`, `reason`, `priority`, `added`, `assigned`, `status`) VALUES
(7, 7, 'Test Case 1', 'Lab-1', 'LJM101022', 'Mouse Not Working', 'Not Working', 'Normal', '2017-04-22 07:06:23', NULL, 'Answered'),
(8, 7, 'Test Case 2', 'Lab-1', 'LJM101023', 'PHP Not Installed', 'Not Installed', 'Normal', '2017-04-22 07:06:38', NULL, 'Answered'),
(9, 7, 'Test Case 3', 'Lab-1', 'LJM101022', 'php not installed', 'Not Installed', 'Normal', '2017-04-22 07:22:38', NULL, 'Answered');

-- --------------------------------------------------------

--
-- Table structure for table `t_case_answers`
--

CREATE TABLE `t_case_answers` (
  `answerID` int(11) NOT NULL,
  `cid` int(11) NOT NULL DEFAULT '0',
  `answer` text NOT NULL,
  `answerBy` varchar(32) DEFAULT NULL,
  `answerHighlight` varchar(255) DEFAULT NULL,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `t_case_answers`
--

INSERT INTO `t_case_answers` (`answerID`, `cid`, `answer`, `answerBy`, `answerHighlight`, `date`) VALUES
(16, 7, 'Requested Materiel', 'Nazir', 'LabAssistant', '2017-04-22 07:11:39'),
(17, 9, 'php has beed installed', 'Nazir', 'LabAssistant', '2017-04-22 07:27:05'),
(18, 9, 'pdo module not working\r\n', 'Divyank Munjapara', 'User', '2017-04-22 07:28:20'),
(19, 9, 'test', 'Nazir', 'LabAssistant', '2017-04-22 08:35:50'),
(20, 8, 'test', 'Nazir', 'LabAssistant', '2017-04-22 08:40:30');

-- --------------------------------------------------------

--
-- Table structure for table `t_case_attachments`
--

CREATE TABLE `t_case_attachments` (
  `aid` int(11) NOT NULL,
  `cid` int(11) NOT NULL,
  `attachment` text NOT NULL,
  `addedBy` int(11) NOT NULL,
  `added` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `t_case_attachments`
--

INSERT INTO `t_case_attachments` (`aid`, `cid`, `attachment`, `addedBy`, `added`) VALUES
(3, 9, 'Attachments/ab6836812f0878b832bd8e132d07c0f0.png', 7, '2017-04-22 07:22:39');

-- --------------------------------------------------------

--
-- Table structure for table `t_dept`
--

CREATE TABLE `t_dept` (
  `id` int(11) NOT NULL,
  `type` varchar(255) NOT NULL,
  `val` varchar(255) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `t_labs`
--

CREATE TABLE `t_labs` (
  `id` int(11) NOT NULL,
  `lab` varchar(32) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `t_labs`
--

INSERT INTO `t_labs` (`id`, `lab`) VALUES
(1, 'Lab-1'),
(2, 'Lab-2');

-- --------------------------------------------------------

--
-- Table structure for table `t_log`
--

CREATE TABLE `t_log` (
  `id` int(11) NOT NULL,
  `uid` varchar(255) NOT NULL,
  `des` text NOT NULL,
  `createdAt` timestamp NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `t_log`
--

INSERT INTO `t_log` (`id`, `uid`, `des`, `createdAt`) VALUES
(1, '1', 'Case 1 Assigned to Nazir', '2017-04-19 15:37:22'),
(2, '1', 'Case 1 Assigned to Manish', '2017-04-19 15:37:34'),
(3, '1', 'Case 1 Assigned to Vinay', '2017-04-19 15:37:46'),
(4, '1', 'Case 2 Assigned to Manish', '2017-04-20 09:19:43'),
(5, '1', 'Case 2 Assigned to Vinay', '2017-04-20 09:19:56'),
(6, '1', 'Case 2 Assigned to Nazir', '2017-04-20 14:14:30'),
(7, '1', 'Case 2 Assigned to Nazir', '2017-04-20 14:19:00'),
(8, '1', 'Case 2 Assigned to Manish', '2017-04-20 14:26:20'),
(9, '1', 'Case 2 Assigned to Vinay', '2017-04-20 14:26:37'),
(10, '1', 'Case 1 Assigned to Nazir', '2017-04-20 14:31:29'),
(11, '1', 'Case 3 Assigned to Manish', '2017-04-21 10:13:37'),
(12, '1', 'Case 3 Assigned to Vinay', '2017-04-21 10:13:43'),
(13, '1', 'Case 3 Assigned to Manish', '2017-04-21 10:14:03'),
(14, '3', 'Case 3 Assigned to Nazir', '2017-04-22 03:21:43'),
(15, '3', 'Case 2 Assigned to Nazir', '2017-04-22 03:52:48'),
(16, '3', 'Case 7 Assigned to Nazir', '2017-04-22 07:08:32'),
(17, '3', 'Case 9 Assigned to Nazir', '2017-04-22 07:25:41'),
(18, '3', 'Case 8 Assigned to Nazir', '2017-04-22 07:42:32'),
(19, '1', 'Case 8 Assigned to Manish', '2017-04-22 07:42:58'),
(20, '1', 'Case 8 Assigned to Nazir', '2017-04-22 07:47:06'),
(21, '1', 'Case 9 Assigned to Manish', '2017-04-22 08:03:55');

-- --------------------------------------------------------

--
-- Table structure for table `t_student`
--

CREATE TABLE `t_student` (
  `id` int(11) NOT NULL,
  `uid` int(11) NOT NULL,
  `gender` char(1) NOT NULL,
  `dept` varchar(10) NOT NULL,
  `divs` varchar(10) NOT NULL,
  `enroll` varchar(15) NOT NULL,
  `createdAt` timestamp NOT NULL,
  `updatedAt` timestamp NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `t_student`
--

INSERT INTO `t_student` (`id`, `uid`, `gender`, `dept`, `divs`, `enroll`, `createdAt`, `updatedAt`) VALUES
(7, 12, 'm', 'MCA', 'ICA', '155183693025', '2017-04-22 09:14:25', '2017-04-22 09:14:25'),
(6, 11, 'm', 'MBA', '', '155183693027', '2017-04-22 09:10:30', '2017-04-22 09:10:30'),
(5, 0, 'm', 'MBA', '', '155183693028', '2017-04-22 09:07:39', '2017-04-22 09:07:39');

-- --------------------------------------------------------

--
-- Table structure for table `t_user`
--

CREATE TABLE `t_user` (
  `id` int(11) NOT NULL,
  `name` varchar(32) NOT NULL,
  `phone` varchar(13) DEFAULT NULL,
  `email` varchar(255) NOT NULL,
  `pwd` varchar(32) NOT NULL,
  `pv` tinyint(1) NOT NULL,
  `tcApproved` tinyint(1) NOT NULL DEFAULT '0',
  `createdAt` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updatedAt` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `t_user`
--

INSERT INTO `t_user` (`id`, `name`, `phone`, `email`, `pwd`, `pv`, `tcApproved`, `createdAt`, `updatedAt`) VALUES
(1, 'DV', '9909343988', 'dvmunjapara@gmail.com', '098f6bcd4621d373cade4e832627b4f6', 1, 0, '2016-10-24 08:56:01', '2016-10-24 08:56:01'),
(2, 'Raj', '9999999999', 'Raj@soni.com', '098f6bcd4621d373cade4e832627b4f6', 0, 0, '2016-10-24 08:56:01', '2016-10-24 08:56:01'),
(3, 'Nazir', '9999999999', 'nazir@gmail.com', '098f6bcd4621d373cade4e832627b4f6', 2, 0, '2016-10-24 08:56:01', '2016-10-24 08:56:01'),
(5, 'Manish', '9999999999', 'manish@gmail.com', '098f6bcd4621d373cade4e832627b4f6', 2, 0, '2016-10-24 08:56:01', '2016-10-24 08:56:01'),
(6, 'Vinay', '9999999999', 'vinay@gmail.com', '098f6bcd4621d373cade4e832627b4f6', 2, 0, '2016-10-24 08:56:01', '2016-10-24 08:56:01'),
(7, 'Divyank Munjapara', '09909343988', 'munjaparadivyank@gmail.com', '96e79218965eb72c92a549dd5a330112', 0, 0, '2017-04-20 18:50:53', '2017-04-20 18:50:53'),
(8, 'Divyank Munjapara', '09909343988', 'munjaparadivyank@gmail.com', '96e79218965eb72c92a549dd5a330112', 0, 0, '2017-04-20 18:54:53', '2017-04-20 18:54:53'),
(9, 'Divyank Munjapara', '09909343988', 'munjaparadivyank@gmail.com', '96e79218965eb72c92a549dd5a330112', 0, 0, '2017-04-20 18:54:56', '2017-04-20 18:54:56'),
(10, 'Divyank Munjapara', '09909343988', 'munjaparadivyank@gmail.com', '96e79218965eb72c92a549dd5a330112', 0, 0, '2017-04-20 18:57:34', '2017-04-20 18:57:34'),
(11, 'Divyank', '09909343988', 'munjaparadivyank@gmail.co', '96e79218965eb72c92a549dd5a330112', 0, 0, '2017-04-22 09:10:30', '2017-04-22 09:10:30'),
(12, 'Divyank', '09909343988', 'munjaparadivyank@gmail.co1', '96e79218965eb72c92a549dd5a330112', 0, 0, '2017-04-22 09:14:25', '2017-04-22 09:14:25');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `t_assign`
--
ALTER TABLE `t_assign`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `t_cases`
--
ALTER TABLE `t_cases`
  ADD PRIMARY KEY (`cid`);

--
-- Indexes for table `t_case_answers`
--
ALTER TABLE `t_case_answers`
  ADD PRIMARY KEY (`answerID`);

--
-- Indexes for table `t_case_attachments`
--
ALTER TABLE `t_case_attachments`
  ADD PRIMARY KEY (`aid`);

--
-- Indexes for table `t_dept`
--
ALTER TABLE `t_dept`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `t_labs`
--
ALTER TABLE `t_labs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `t_log`
--
ALTER TABLE `t_log`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `t_student`
--
ALTER TABLE `t_student`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `t_user`
--
ALTER TABLE `t_user`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `t_assign`
--
ALTER TABLE `t_assign`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;
--
-- AUTO_INCREMENT for table `t_cases`
--
ALTER TABLE `t_cases`
  MODIFY `cid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;
--
-- AUTO_INCREMENT for table `t_case_answers`
--
ALTER TABLE `t_case_answers`
  MODIFY `answerID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;
--
-- AUTO_INCREMENT for table `t_case_attachments`
--
ALTER TABLE `t_case_attachments`
  MODIFY `aid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `t_dept`
--
ALTER TABLE `t_dept`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `t_labs`
--
ALTER TABLE `t_labs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `t_log`
--
ALTER TABLE `t_log`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;
--
-- AUTO_INCREMENT for table `t_student`
--
ALTER TABLE `t_student`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
--
-- AUTO_INCREMENT for table `t_user`
--
ALTER TABLE `t_user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
