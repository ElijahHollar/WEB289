-- phpMyAdmin SQL Dump
-- version 5.1.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: May 03, 2021 at 01:40 AM
-- Server version: 5.7.32-35-log
-- PHP Version: 7.3.27

-- Member Logon Credentials:
-- Username: member-user
-- Password: 123abc!@#ABC

-- Admin Logon Credentials:
-- Username: admin-user
-- Password: abc123ABC!@#

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `dbrvy4tqsit434`
--
CREATE DATABASE IF NOT EXISTS `dbrvy4tqsit434` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `dbrvy4tqsit434`;

-- --------------------------------------------------------

--
-- Table structure for table `bookshelf_item`
--

DROP TABLE IF EXISTS `bookshelf_item`;
CREATE TABLE `bookshelf_item` (
  `bookshelf_item_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `bookshelf_item_isbn` char(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `category`
--

DROP TABLE IF EXISTS `category`;
CREATE TABLE `category` (
  `category_id` int(11) NOT NULL,
  `category_name` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `review`
--

DROP TABLE IF EXISTS `review`;
CREATE TABLE `review` (
  `review_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `review_isbn` varchar(13) NOT NULL,
  `review_text` text NOT NULL,
  `review_date` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

DROP TABLE IF EXISTS `user`;
CREATE TABLE `user` (
  `user_id` int(11) NOT NULL,
  `user_username` varchar(20) NOT NULL,
  `user_password` varchar(255) NOT NULL,
  `user_email_address` varchar(50) NOT NULL,
  `user_level` enum('m','a') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `bookshelf_item`
--
ALTER TABLE `bookshelf_item`
  ADD PRIMARY KEY (`bookshelf_item_id`),
  ADD KEY `bookshelf_fk_user` (`user_id`);

--
-- Indexes for table `category`
--
ALTER TABLE `category`
  ADD PRIMARY KEY (`category_id`);

--
-- Indexes for table `review`
--
ALTER TABLE `review`
  ADD PRIMARY KEY (`review_id`),
  ADD KEY `review_fk_user` (`user_id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `bookshelf_item`
--
ALTER TABLE `bookshelf_item`
  MODIFY `bookshelf_item_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `category`
--
ALTER TABLE `category`
  MODIFY `category_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `review`
--
ALTER TABLE `review`
  MODIFY `review_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `bookshelf_item`
--
ALTER TABLE `bookshelf_item`
  ADD CONSTRAINT `bookshelf_fk_user` FOREIGN KEY (`user_id`) REFERENCES `user` (`user_id`);

--
-- Constraints for table `review`
--
ALTER TABLE `review`
  ADD CONSTRAINT `review_fk_user` FOREIGN KEY (`user_id`) REFERENCES `user` (`user_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

-- Initial content for table `category`

INSERT INTO `category`(`category_name`) VALUES ('Fantasy');
INSERT INTO `category`(`category_name`) VALUES ('Science Fiction');
INSERT INTO `category`(`category_name`) VALUES ('Historical');

-- Initial content for table `user`

INSERT INTO `user`(`user_username`, `user_password`, `user_email_address`, `user_level`) VALUES ('member-user','$2y$10$B2KDrkuYnLgL7LU/GsKDVOxso34yc8bCMmYhRh/A3gpff8mCjfWbC','test@gmail.com','m');
INSERT INTO `user`(`user_username`, `user_password`, `user_email_address`, `user_level`) VALUES ('admin-user','$2y$10$yIbyPifntFfTogonKGaSE.3CwMUrF/BAv3i6mVSNRADrP9CV1PfV2','test@gmail.com','a');

-- Initial content for table `bookshelf_item`

INSERT INTO `bookshelf_item`(`user_id`, `bookshelf_item_isbn`) VALUES ('1','0307796116');
INSERT INTO `bookshelf_item`(`user_id`, `bookshelf_item_isbn`) VALUES ('2','0794444121');
