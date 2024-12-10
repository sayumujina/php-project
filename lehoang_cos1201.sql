-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 10, 2024 at 05:04 PM
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
-- Database: `lehoang_cos1201`
--

-- --------------------------------------------------------

--
-- Table structure for table `answers`
--

CREATE TABLE `answers` (
  `answer_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `username` text NOT NULL,
  `post_id` int(11) NOT NULL,
  `content` text NOT NULL,
  `answer_date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `answers`
--

INSERT INTO `answers` (`answer_id`, `user_id`, `username`, `post_id`, `content`, `answer_date`) VALUES
(1, 1, '', 17, 'sdsd', '0000-00-00 00:00:00'),
(2, 1, '', 17, '2343244', '0000-00-00 00:00:00'),
(3, 1, 'Anonymous', 19, 'sdfdsf', '0000-00-00 00:00:00'),
(4, 1, 'Anonymous', 19, 'hi chat', '0000-00-00 00:00:00'),
(5, 1, 'Anonymous', 17, 'gdfgdfg', '0000-00-00 00:00:00'),
(6, 1, 'Anonymous', 17, 'dasda', '2024-12-07 13:37:10'),
(7, 12, 'Anonymous', 19, 'sadsa', '2024-12-07 13:46:44'),
(8, 12, 'skibidi', 37, 'fdfd', '2024-12-08 09:44:06'),
(9, 12, 'skibidi', 37, '1234', '2024-12-08 09:44:09');

-- --------------------------------------------------------

--
-- Table structure for table `module`
--

CREATE TABLE `module` (
  `module_id` int(11) NOT NULL,
  `module_name` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `module`
--

INSERT INTO `module` (`module_id`, `module_name`) VALUES
(3, 'ui-ux'),
(4, 'Project Management'),
(5, 'module_5'),
(6, 'module_6'),
(8, 'OOP'),
(9, 'PHP');

-- --------------------------------------------------------

--
-- Table structure for table `posts`
--

CREATE TABLE `posts` (
  `post_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `username` text NOT NULL,
  `title` text NOT NULL,
  `content` text NOT NULL,
  `module_id` int(11) NOT NULL,
  `creation_date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `posts`
--

INSERT INTO `posts` (`post_id`, `user_id`, `username`, `title`, `content`, `module_id`, `creation_date`) VALUES
(53, 27, 'sayumujina123', 'test', '1234123', 3, '2024-12-10 16:45:04'),
(54, 27, 'sayumujina123', 'another test', '1', 8, '2024-12-10 16:47:25'),
(55, 27, 'sayumujina123', 'php question', '12345', 3, '2024-12-10 17:04:10');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `email` varchar(100) NOT NULL,
  `username` varchar(100) NOT NULL,
  `password` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `email`, `username`, `password`) VALUES
(1, 'imestellia@gmail.com', 'sayu', '$2y$10$eSfqlpxBHmXa.4UIZbBegeLaaAMxtkj4.qJ8qtBBP9rf5Kx8FdSom'),
(2, 'imestellia@gmail.com', 'sayu', '$2y$10$Z9o0AavqESwRNuS0R5Whv.5ktUykHyOmUHnBRosMpwTdaSnefy3Hu'),
(3, 'imestellia@gmail.com', 'sayu', '$2y$10$uyjb.bggHPSJjuh8uQiqgOHNS6hSVTsmb6r6DWQyvxyNy4xaNma8e'),
(4, 'gychorytplaysosu@gmail.com', 'sayu', '$2y$10$0tq9uBOQn9E09na0.Eo5Yerb4egOuw3xg1IQwxx5zzNtk/dzYxgwC'),
(5, 'gychorytplaysosu@gmail.com', 'sayu', '$2y$10$iYRObxVF6JMea/O6r1moR.3gw3PEAPKKUcFwSUM74SdPwGtfPMH0i'),
(6, 'gychorytplaysosu@gmail.com', 'sayu', '$2y$10$7OTn02ab1PbFIVgl73w60.i4q9dAVyFsKs.xfFZ2MW3gQmBKIUOKu'),
(7, 'hoanglgcs230365@fpt.edu.vn', 'sayu', '$2y$10$yL5TLwIQ/k0HeQiagdQZHOaYHbcHg9N14hk/fulLcYEz16JmytMNm'),
(8, 'hoanglgcs230365@fpt.edu.vn', 'sayu', '$2y$10$3l0B8jT71WXIw8r2tZuoeOh0FuhpdyRtMuglwrFeYatTYN5AVYP2S'),
(9, 'hoanglgcs230365@fpt.edu.vn', 'sayu', '$2y$10$/G8H1I4xKfyg9tiJFm.7..t7IB5s0X562xA/s0ZqdwulZYcK8vRuC'),
(14, 'd@gmail.cpom', 'skibidi', '$2y$10$AdmlFaiBj51fpPS4.JRSFee71YyZFC6lOnawX0WymCuX2HyGbbeOO'),
(18, '1234@gmail.commmm', 'sayumujina', '$2y$10$ie72UnOHrq39ZrVHpfdTSe6Q1BsuNIi8Pmnp.yarlrlE79CnTvrp2'),
(23, '1234@gmail.com', 'sayumujina', '$2y$10$I1VbY21ox19q1XhLtVdE2.ZyXvTOipCdcY2ApmRmZJpetSWG0F0Q.'),
(27, '123456789@gmail', 'sayumujina123', '$2y$10$1n2bBajk9DhQng3sd28npuwOmtc5g4/4T8QMH2sy8QZS2Awy5rapy');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `answers`
--
ALTER TABLE `answers`
  ADD PRIMARY KEY (`answer_id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `post_id` (`post_id`);

--
-- Indexes for table `module`
--
ALTER TABLE `module`
  ADD PRIMARY KEY (`module_id`);

--
-- Indexes for table `posts`
--
ALTER TABLE `posts`
  ADD PRIMARY KEY (`post_id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `module_id` (`module_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `answers`
--
ALTER TABLE `answers`
  MODIFY `answer_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `module`
--
ALTER TABLE `module`
  MODIFY `module_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `posts`
--
ALTER TABLE `posts`
  MODIFY `post_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=56;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `answers`
--
ALTER TABLE `answers`
  ADD CONSTRAINT `answers_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `answers_ibfk_2` FOREIGN KEY (`post_id`) REFERENCES `posts` (`post_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `posts`
--
ALTER TABLE `posts`
  ADD CONSTRAINT `posts_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `posts_ibfk_2` FOREIGN KEY (`module_id`) REFERENCES `module` (`module_id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
