-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 02, 2025 at 12:22 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `cw_web1`
--

-- --------------------------------------------------------

--
-- Table structure for table `comment`
--

CREATE TABLE `comment` (
  `id` int(11) NOT NULL,
  `content` varchar(255) NOT NULL,
  `date` date NOT NULL,
  `questionid` int(11) NOT NULL,
  `userid` int(11) NOT NULL,
  `moduleid` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `comment`
--

INSERT INTO `comment` (`id`, `content`, `date`, `questionid`, `userid`, `moduleid`) VALUES
(14, 'Good job boys !!!', '2025-11-28', 19, 15, 4),
(15, 'Hello', '2025-11-28', 19, 15, 4),
(17, 'YESSSSIR BOI kkk', '2025-11-28', 27, 15, 4),
(20, 'Like and share @All', '2025-11-29', 27, 15, 4);

-- --------------------------------------------------------

--
-- Table structure for table `email`
--

CREATE TABLE `email` (
  `id` int(11) NOT NULL,
  `date` date NOT NULL,
  `content` varchar(255) NOT NULL,
  `userid` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `email`
--

INSERT INTO `email` (`id`, `date`, `content`, `userid`) VALUES
(14, '2025-11-27', 'Hi, can you help me to find my password? I have forgot it :(((', 15);

-- --------------------------------------------------------

--
-- Table structure for table `module`
--

CREATE TABLE `module` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `module`
--

INSERT INTO `module` (`id`, `name`) VALUES
(1, 'Web Development 1'),
(2, 'Database Systems'),
(3, 'Network Security'),
(4, 'Else'),
(6, 'Academic');

-- --------------------------------------------------------

--
-- Table structure for table `question`
--

CREATE TABLE `question` (
  `id` int(11) NOT NULL,
  `content` text NOT NULL,
  `date` date NOT NULL,
  `image_path` varchar(255) DEFAULT NULL,
  `userid` int(11) NOT NULL,
  `moduleid` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `question`
--

INSERT INTO `question` (`id`, `content`, `date`, `image_path`, `userid`, `moduleid`) VALUES
(19, 'ỨNG DỤNG AI TRONG Y TẾ CỦA NHÓM SINH VIÊN GREENWICH GÓP MẶT TẠI HỘI THẢO QUỐC TẾ FETC 2025 🌍\r\n\r\nFETC 2025 (FPT International Conference on Emerging Trends in Computing 2025) là hội thảo quốc tế về xu hướng mới nổi trong lĩnh vực Điện toán do Trường Đại học FPT – Phân hiệu Cần Thơ tổ chức, diễn ra trong hai ngày 25 & 26/10/2025.', '2025-11-27', '1764224022_572485815_1271958374965673_4057160998648447464_n.jpg', 4, 4),
(27, 'Great start in second year kkk :>', '2025-11-28', '1764331831_584427708_1280807680732810_2947449779848668640_n.jpg', 15, 4);

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id` int(10) NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` varchar(50) DEFAULT NULL,
  `user_image` varchar(255) DEFAULT NULL,
  `description` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `name`, `email`, `password`, `role`, `user_image`, `description`) VALUES
(4, 'LK', 'khangledoandeptrai@gmail.com', '$2y$10$uKou6eoi0khbI57p0JUAr.u/ntFD6jI9qbmFfZC9f5ZzG2lhSl7X.', 'admin', NULL, NULL),
(15, 'Kevin Doan', 'lekhangdoan3@gmail.com', '$2y$10$BUzLcYieT3Dln.YETrVYDe1HkGZUrhByfjboMH7QRpaYAlrmKIL0C', 'user', 'avatar_692bd0c2c6e85_gheyeu2.jpg', 'Kevin here guy !'),
(18, 'taimai', 'anhtai210406@gmail.com', '$2y$10$qtnENwpsHlNvlyegHgNwMuD4wCYLXoYba5vmh2IbxL7we6APe4J7u', 'user', NULL, NULL),
(20, 'LK2', 'milizelena0310@gmail.com', '$2y$10$g9c0tb7NtdH7ExO.uVMyUO/.lmel6fVcnlAC6wbxvTCKQC0r.xLyy', 'user', NULL, '');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `comment`
--
ALTER TABLE `comment`
  ADD PRIMARY KEY (`id`),
  ADD KEY `questionid` (`questionid`),
  ADD KEY `userid` (`userid`),
  ADD KEY `moduleid` (`moduleid`);

--
-- Indexes for table `email`
--
ALTER TABLE `email`
  ADD PRIMARY KEY (`id`),
  ADD KEY `userid` (`userid`);

--
-- Indexes for table `module`
--
ALTER TABLE `module`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `question`
--
ALTER TABLE `question`
  ADD PRIMARY KEY (`id`),
  ADD KEY `userid` (`userid`),
  ADD KEY `moduleid` (`moduleid`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `comment`
--
ALTER TABLE `comment`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT for table `email`
--
ALTER TABLE `email`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `module`
--
ALTER TABLE `module`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `question`
--
ALTER TABLE `question`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=39;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `comment`
--
ALTER TABLE `comment`
  ADD CONSTRAINT `comment_ibfk_1` FOREIGN KEY (`questionid`) REFERENCES `question` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `comment_ibfk_2` FOREIGN KEY (`moduleid`) REFERENCES `module` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `comment_ibfk_3` FOREIGN KEY (`userid`) REFERENCES `user` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `email`
--
ALTER TABLE `email`
  ADD CONSTRAINT `email_ibfk_1` FOREIGN KEY (`userid`) REFERENCES `user` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `question`
--
ALTER TABLE `question`
  ADD CONSTRAINT `question_ibfk_1` FOREIGN KEY (`userid`) REFERENCES `user` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `question_ibfk_2` FOREIGN KEY (`moduleid`) REFERENCES `module` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
