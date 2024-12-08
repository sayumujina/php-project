-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 08, 2024 at 10:05 AM
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
(1, 'OOP'),
(2, 'PHP'),
(3, 'UI-UX'),
(4, 'Project Management'),
(5, '34');

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
  `module_id` text NOT NULL,
  `creation_date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `posts`
--

INSERT INTO `posts` (`post_id`, `user_id`, `username`, `title`, `content`, `module_id`, `creation_date`) VALUES
(34, 12, 'skibidi', 'hi hguiys', 'iii', 'Project Management', '2024-12-08 09:41:06'),
(35, 12, 'skibidi', 'data1', '334', 'Project Management', '2024-12-08 09:42:45'),
(38, 13, 'skibidi', 'sdsd', 'sdsdsds', '4', '2024-12-08 09:54:14');

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
(10, 'lh8081j@gre.ac.uk', 'sayu', '$2y$10$Y/LC.KGHo/sg4mMG/sASdebuJVuFNn6cFzLuP/zNsLEgvw9O883FO'),
(11, 'gychorytplaysosu@gmail.com', 'sayu', '$2y$10$ZjavX/7pQyoc9gok3/8nle3qVAF57ntpgpZSbMV8tsqfdRX6fUmAW'),
(13, 'lh8081j@gre.ac.uk', 'skibidi', '$2y$10$Fb21VurnsgUkk4TkgV0aGeXWwB/eH13c0X0pu4IZ3htXOX3uviQQ.'),
(14, 'd@gmail.cpom', 'skibidi', '$2y$10$AdmlFaiBj51fpPS4.JRSFee71YyZFC6lOnawX0WymCuX2HyGbbeOO'),
(15, 'hoanglgcs230365@fpt.edu.vn', 'skibidi', '$2y$10$YveBLbucm1eVTqKRBsaafuML6JxVaosN6c602h1OUc.p9AR/LJJLa');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `answers`
--
ALTER TABLE `answers`
  ADD PRIMARY KEY (`answer_id`);

--
-- Indexes for table `module`
--
ALTER TABLE `module`
  ADD PRIMARY KEY (`module_id`);

--
-- Indexes for table `posts`
--
ALTER TABLE `posts`
  ADD PRIMARY KEY (`post_id`);

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
  MODIFY `answer_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `module`
--
ALTER TABLE `module`
  MODIFY `module_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `posts`
--
ALTER TABLE `posts`
  MODIFY `post_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=39;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
