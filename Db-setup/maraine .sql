-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Sep 12, 2020 at 02:45 AM
-- Server version: 10.4.11-MariaDB
-- PHP Version: 7.4.5

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `maraine`
--

-- --------------------------------------------------------

--
-- Table structure for table `assign_given`
--

CREATE TABLE `assign_given` (
  `id` int(11) NOT NULL,
  `Course` varchar(256) NOT NULL,
  `Lecturer` varchar(256) NOT NULL,
  `Submissiondate` date NOT NULL,
  `assign_title` longtext NOT NULL,
  `Filename` varchar(256) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `assign_given`
--

INSERT INTO `assign_given` (`id`, `Course`, `Lecturer`, `Submissiondate`, `assign_title`, `Filename`) VALUES
(2, 'business studies', 'Chukwuweike Jephthah', '2020-08-18', 'The effect of chemosynthesis on the appearance of speed on the roads of Nigeria', 'Chemosyntheis 2.839914837'),
(3, 'transport management', 'Amuwa Dones', '2020-08-20', 'This is a title', 'Assignment.1945821304'),
(4, 'transport management', 'Amuwa Dones', '2020-08-20', 'The effect Of modern day Vehicles on the health of the public', 'Modern Age.1680254');

-- --------------------------------------------------------

--
-- Table structure for table `courses`
--

CREATE TABLE `courses` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `useremail` varchar(256) NOT NULL,
  `courses` text NOT NULL,
  `empty` varchar(256) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `courses`
--

INSERT INTO `courses` (`id`, `user_id`, `useremail`, `courses`, `empty`) VALUES
(1, 1, 'Jane@gmail.com', 'General Study,Mainframe Computing', 'empty'),
(2, 2, 'John@gmail.com', 'General Study,Mainframe Computing', 'empty'),
(3, 14, 'Profviceo@yahoo.com', 'business studies,project management,business administration,transport management', 'Empty');

-- --------------------------------------------------------

--
-- Table structure for table `submit`
--

CREATE TABLE `submit` (
  `id` int(11) NOT NULL,
  `Assign_Id` int(11) NOT NULL,
  `Username` varchar(256) NOT NULL,
  `Course` varchar(256) NOT NULL,
  `Short_Note` text NOT NULL,
  `FileName` text NOT NULL,
  `DateSubmitted` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `submit`
--

INSERT INTO `submit` (`id`, `Assign_Id`, `Username`, `Course`, `Short_Note`, `FileName`, `DateSubmitted`) VALUES
(3, 2, 'profviceo', 'Course', 'this is just a test', 'profviceo20202309583.2.doc', '2020-08-19 10:13:47'),
(4, 4, 'profviceo', 'Transport Management', 'this is also a tet', 'profviceo20202309583.4.doc', '2020-08-19 11:39:49');

-- --------------------------------------------------------

--
-- Table structure for table `tickets`
--

CREATE TABLE `tickets` (
  `id` int(11) NOT NULL,
  `User_id` int(11) NOT NULL,
  `Subject` text NOT NULL,
  `Related` tinytext NOT NULL,
  `Urgency` tinytext NOT NULL,
  `Message` text NOT NULL,
  `is_active` tinytext NOT NULL,
  `FileName` varchar(256) NOT NULL,
  `Date` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tickets`
--

INSERT INTO `tickets` (`id`, `User_id`, `Subject`, `Related`, `Urgency`, `Message`, `is_active`, `FileName`, `Date`) VALUES
(4, 14, 'Profile Update Issues', 'Profile', 'Low', 'Please, i have been trying to update my profile for the past two weeks and i just saw the notice that you can only update your profile once. Please i made a typo in my name and would love it to be corrected.\r\n\r\nThe typo was some how embarrassing', '0', 'Profile Update Issues.profviceo.jpg', '2020-08-21 13:04:19'),
(5, 14, 'Payment Issues', 'Payments', 'High', 'I have been having issues paying for my current course that will soon start. Please i urgently need help', '0', 'Payment Issues.profviceo.jpg', '2020-08-21 13:47:40'),
(6, 14, 'Unable to submit assignment', 'Assignments', 'High', 'Dear, Suppot Team,\r\n i have being trying to submit my assignment, but it has been all to no avail. I need help urgently.\r\n\r\n\r\n\r\nhttps://localhost/maraine/subticket.php', '0', 'Unable to submit assignment.profviceo.jpg', '2020-08-21 22:48:35');

-- --------------------------------------------------------

--
-- Table structure for table `ticket_replies`
--

CREATE TABLE `ticket_replies` (
  `id` int(11) NOT NULL,
  `User_id` int(11) NOT NULL,
  `Ticket_id` int(11) NOT NULL,
  `Message` text NOT NULL,
  `Position` tinytext NOT NULL,
  `Date` datetime NOT NULL DEFAULT current_timestamp(),
  `is_active` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `ticket_replies`
--

INSERT INTO `ticket_replies` (`id`, `User_id`, `Ticket_id`, `Message`, `Position`, `Date`, `is_active`) VALUES
(1, 14, 5, 'Why is it taking to long to get a reply', 'student', '2020-08-21 19:03:17', 1),
(3, 14, 5, 'I am still waiting for a reply and i have not gotten any yet. The deadline for my course registration is almost up and i am not still able to rectify the issue', 'student', '2020-08-21 20:42:43', 1),
(4, 15, 5, 'We have recieved your message and we are working on it, please help us with a screen shot of the error message you are getting.\r\n\r\nThank you for you understanding', 'admin', '2020-08-21 20:45:52', 2),
(5, 14, 5, 'Ok, thank you very much, i would really love it, if you would help me as fast as possible', 'student', '2020-08-21 20:51:08', 2),
(6, 14, 4, 'Thank you for your time, the issue has been resolved', 'student', '2020-08-21 21:57:40', 2),
(7, 14, 6, 'I got you email. Please i am waiting for the changes to take effect\r\n', 'student', '2020-08-21 22:51:48', 2);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `FullName` text NOT NULL,
  `Username` varchar(256) NOT NULL,
  `Email` varchar(256) NOT NULL,
  `Password` longtext NOT NULL,
  `Phone` varchar(256) NOT NULL,
  `DOB` date NOT NULL,
  `State` tinytext NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `FullName`, `Username`, `Email`, `Password`, `Phone`, `DOB`, `State`) VALUES
(14, 'Victor Okonkwo', 'Profviceo', 'Profviceo@yahoo.com', '$2y$10$RYr4HMuWdVic4JV6rySRHes2rkQuQhBHap5e0a9jOykcvAb7dZeNC', '08142077283', '2002-02-02', 'anambra'),
(15, 'Victor Okonkwo', 'Admin', 'admin@maraine.com', '$2y$10$YzmU0YlbSrmS.u9nq6WFOOwJ3tefPCMyvWhlvjzs5KZociTbIYQeW', '09017480005', '1994-02-02', 'akwa ibom'),
(16, 'Shinji Nanon', 'shinji', 'shinji@yahoo.com', '$2y$10$EX/XwXqIRCnrp5.C5MNoIuf2Xwzo95oSMZixiUIA1HGOgpvCUqpPi', '08142077210', '1998-08-20', 'cross river'),
(23, 'victor ebube', 'victor', 'profviceo@gmail.com', '$2y$10$w.igo5vxhwb6CJoqxh5I1e3wVz4BeDKgfWw0VUTQCAD6clRFEdBkO', 'Not Set', '2020-08-21', 'not set');

-- --------------------------------------------------------

--
-- Table structure for table `user_profile`
--

CREATE TABLE `user_profile` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `Profile_img_stat` int(11) NOT NULL,
  `Reg_No` varchar(256) NOT NULL,
  `profilestatus` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `user_profile`
--

INSERT INTO `user_profile` (`id`, `user_id`, `Profile_img_stat`, `Reg_No`, `profilestatus`) VALUES
(1, 14, 0, '20202309583', 1),
(2, 15, 0, '20202308536', 0),
(3, 16, 0, '20202300162', 0),
(12, 23, 1, '20202336534', 0);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `assign_given`
--
ALTER TABLE `assign_given`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `courses`
--
ALTER TABLE `courses`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `submit`
--
ALTER TABLE `submit`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tickets`
--
ALTER TABLE `tickets`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `ticket_replies`
--
ALTER TABLE `ticket_replies`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user_profile`
--
ALTER TABLE `user_profile`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `assign_given`
--
ALTER TABLE `assign_given`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `courses`
--
ALTER TABLE `courses`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `submit`
--
ALTER TABLE `submit`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `tickets`
--
ALTER TABLE `tickets`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `ticket_replies`
--
ALTER TABLE `ticket_replies`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT for table `user_profile`
--
ALTER TABLE `user_profile`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
