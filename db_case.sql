-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Feb 15, 2018 at 04:11 PM
-- Server version: 10.1.16-MariaDB
-- PHP Version: 5.6.24

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
  `time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `t_assign`
--

INSERT INTO `t_assign` (`id`, `uid`, `cid`, `time`) VALUES
(12, 5, 8, '2018-02-07 10:53:04'),
(11, 5, 9, '2017-04-22 08:03:55'),
(10, 3, 7, '2017-04-22 07:08:32'),
(13, 5, 10, '2018-02-06 12:31:59'),
(14, 5, 11, '2018-02-12 04:45:09');

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
(8, 7, 'Test Case 2', 'Lab-1', 'LJM101023', 'PHP Not Installed', 'Not Installed', 'Normal', '2017-04-22 07:06:38', NULL, 'Resolved'),
(9, 7, 'Test Case 3', 'Lab-1', 'LJM101022', 'php not installed', 'Not Installed', 'Normal', '2017-04-22 07:22:38', NULL, 'Answered'),
(10, 13, 'Test 1', 'Lab-2', 'HC-01', 'Just For test', 'Not Installed', 'Normal', '2018-02-06 12:24:41', NULL, 'Assigned'),
(11, 16, 'Monitor display gone', 'Lab-1', '15', 'mdg', 'Damaged', 'High', '2018-02-12 04:44:15', NULL, 'Resolved'),
(12, 7, 'f', 'Lab-1', '1', 'f', 'Missing Hardware', 'Normal', '2018-02-12 05:07:15', NULL, 'Opened'),
(13, 7, 'q', 'Lab-1', 'q', 'q', 'Missing Hardware', 'Normal', '2018-02-12 05:07:44', NULL, 'Opened'),
(14, 7, 'g', 'Lab-1', 'g', 'g', 'Missing Hardware', 'Normal', '2018-02-12 05:07:53', NULL, 'Opened'),
(15, 7, '1', 'Lab-3', '1', '1', 'Missing Hardware', 'Normal', '2018-02-12 05:08:25', NULL, 'Opened'),
(16, 7, 'r', 'Lab-2', 'r', 'r', 'Missing Hardware', 'Normal', '2018-02-12 05:09:18', NULL, 'Opened');

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
(20, 8, 'test', 'Nazir', 'LabAssistant', '2017-04-22 08:40:30'),
(21, 8, 'Solved', 'Devarsh', 'Admin', '2018-02-07 10:53:29'),
(22, 11, 'q', 'Manish', 'LabAssistant', '2018-02-12 04:46:25');

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
(2, 'Lab-2'),
(3, 'Lab-3');

-- --------------------------------------------------------

--
-- Table structure for table `t_log`
--

CREATE TABLE `t_log` (
  `id` int(11) NOT NULL,
  `uid` varchar(255) NOT NULL,
  `des` text NOT NULL,
  `createdAt` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
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
(21, '1', 'Case 9 Assigned to Manish', '2017-04-22 08:03:55'),
(22, '5', 'Case 10 Assigned to Manish', '2018-02-06 12:31:59'),
(23, '13', 'Case 8 Assigned to Manish', '2018-02-07 10:52:48'),
(24, '13', 'Case 8 Assigned to Vinay', '2018-02-07 10:52:56'),
(25, '13', 'Case 8 Assigned to Manish', '2018-02-07 10:53:04'),
(26, '5', 'Case 11 Assigned to Manish', '2018-02-12 04:45:09');

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
  `createdAt` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updatedAt` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `t_student`
--

INSERT INTO `t_student` (`id`, `uid`, `gender`, `dept`, `divs`, `enroll`, `createdAt`, `updatedAt`) VALUES
(11, 2, 'm', 'MCA', 'ICA', '175183693004', '2018-02-15 04:58:31', '2018-02-15 04:58:31'),
(10, 1, 'm', 'MCA', 'ICA', '175183693003', '2018-02-15 04:31:30', '2018-02-15 04:31:30');

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
(1, 'Devarsh', '9033333333', 'devarsh@hotmail.com', 'e6e061838856bf47e1de730719fb2609', 1, 0, '2018-02-15 04:31:30', '2018-02-15 04:31:30'),
(2, 'Kanti', '7575757575', 'kanti@gmail.com', 'e6e061838856bf47e1de730719fb2609', 0, 0, '2018-02-15 04:58:31', '2018-02-15 04:58:31'),
(3, 'Dhaval', '7575757595', 'dhaval@gmail.com', 'e6e061838856bf47e1de730719fb2609', 2, 0, '2018-02-15 05:09:17', '2018-02-15 05:09:17');

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;
--
-- AUTO_INCREMENT for table `t_cases`
--
ALTER TABLE `t_cases`
  MODIFY `cid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;
--
-- AUTO_INCREMENT for table `t_case_answers`
--
ALTER TABLE `t_case_answers`
  MODIFY `answerID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;
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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `t_log`
--
ALTER TABLE `t_log`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;
--
-- AUTO_INCREMENT for table `t_student`
--
ALTER TABLE `t_student`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;
--
-- AUTO_INCREMENT for table `t_user`
--
ALTER TABLE `t_user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
