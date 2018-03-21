-- phpMyAdmin SQL Dump
-- version 4.7.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 21, 2018 at 11:26 AM
-- Server version: 10.1.30-MariaDB
-- PHP Version: 7.2.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `cww`
--

-- --------------------------------------------------------

--
-- Table structure for table `clocker_records`
--

CREATE TABLE `clocker_records` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `punch_in` timestamp NULL DEFAULT NULL,
  `punch_out` timestamp NULL DEFAULT NULL,
  `break_in` timestamp NULL DEFAULT NULL,
  `break_out` timestamp NULL DEFAULT NULL,
  `status` enum('verified','canceled','stop','simple','pending') DEFAULT NULL,
  `crypt_code` varchar(255) NOT NULL,
  `date_created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `data` longtext
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `clocker_records`
--

INSERT INTO `clocker_records` (`id`, `user_id`, `punch_in`, `punch_out`, `break_in`, `break_out`, `status`, `crypt_code`, `date_created`, `data`) VALUES
(1, 2, '2018-02-20 08:16:42', NULL, NULL, NULL, NULL, '6814f51220ec1be3f7ae2e59a4a3e0d113630dd25a7bbbbde5841004215901fa838c98424335a814bbdee0f90c0ac7424d73e9793d6aef8fb817f8be861125be10hEUB7hbsmMiF9r1i6UHJQcXEXNxJe0Oxe7G6x6IyR48uWoF108lZ4i5ELYE5mk', '2018-02-20 08:16:42', NULL),
(2, 3, '2018-02-20 08:44:14', '2018-02-20 08:50:25', '2018-02-20 08:49:37', '2018-02-20 08:49:35', NULL, '36447c201e7c7f2b55d192a6e43ad2a5745179429819a5612ddc651960c52e6bdcca7b165f0d1dafcb842257117bf96957e1b2a7ae9dcfdd80d5134d1e300b069wRvUjUOzc4yRaiiYAKtrgceB22LNApa8Xxw0vKCi3FKgmUAzJl92UCZ0PNsq1Uq', '2018-02-20 08:44:14', NULL),
(3, 3, '2018-02-20 08:50:28', '2018-02-20 08:50:30', NULL, NULL, NULL, '97ba7a637ac9a13debebd90e6a0255c6ba54fbad2c8a36bd5047491d01da41885ffac246464ffc4aec517a1ecdac74b541c4b2ee9798930b7a010056da02278fpypI0i4zIGobFgahPNwfJCRh4v7QWI3Dx7ufyaGPkQVe8yThh1MGOUfcp4ufIliU', '2018-02-20 08:50:28', NULL),
(4, 1, '2018-02-25 08:22:14', NULL, '2018-03-18 04:25:03', '2018-03-17 08:39:57', NULL, '1336034f7084040ccdde0ac23eb314e006a69283ed935783cf1be084c798323f0cf44fe44e28db669065f428c6084b4eb9df617d1951869c516159937ad1fda1/l3aMCl6WKGI5UInjzIwrTTvbzto/dlwQSluBjEcJCjdP6e9DvpEwCin0KEjIWAu', '2018-02-25 08:22:14', NULL),
(5, 3, '2018-02-25 08:29:10', NULL, NULL, NULL, NULL, '5e781e79f45cb9135a97264f658a2a47dfa6e6c8f64c0c6fb8310b7a8f5ff30f81c16594ccee3f58cc9013d76c187d0513b411f79eb0d5ac2afbe7af79422c9bixCM52e7wrVPM/5YnZOB/2dTdAEcBIA42lB7IukfiBOa81NoBtppuh5DP71EaORE', '2018-02-25 08:29:10', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `options`
--

CREATE TABLE `options` (
  `option_id` int(11) NOT NULL,
  `owner_id` int(11) NOT NULL,
  `option_name` varchar(255) NOT NULL,
  `option_value` longtext NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `options`
--

INSERT INTO `options` (`option_id`, `owner_id`, `option_name`, `option_value`) VALUES
(1, 1, 'clocker_timezone', '\"UM95\"');

-- --------------------------------------------------------

--
-- Table structure for table `plugins`
--

CREATE TABLE `plugins` (
  `plugin_id` int(11) NOT NULL,
  `system_name` varchar(150) NOT NULL,
  `name` varchar(150) NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `uri` varchar(255) DEFAULT NULL,
  `version` varchar(10) NOT NULL,
  `description` varchar(255) DEFAULT NULL,
  `author` varchar(50) DEFAULT NULL,
  `author_uri` varchar(255) DEFAULT NULL,
  `data` longtext
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `plugins`
--

INSERT INTO `plugins` (`plugin_id`, `system_name`, `name`, `status`, `uri`, `version`, `description`, `author`, `author_uri`, `data`) VALUES
(10, 'clocker', 'Clocker', 1, 'http://johnabelardom.epizy.com/clocker', '0.0.1', 'Display current time, record time-in time-out of the user', 'John Abelardo Manangan II', 'http://johnabelardom.epizy.com', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `user_login` varchar(255) NOT NULL,
  `user_password` varchar(255) NOT NULL,
  `user_nickname` varchar(255) NOT NULL,
  `user_email` varchar(255) NOT NULL,
  `user_registered` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `user_activation_key` varchar(255) NOT NULL,
  `user_status` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `user_login`, `user_password`, `user_nickname`, `user_email`, `user_registered`, `user_activation_key`, `user_status`) VALUES
(1, 'jimbo', 'f52ee06ea2865014e7b4ecff99c06b423b41d168b10a245c67d3bf45b6b5ff12a1d718e4d7172f20fb3cc9a8e9fb894afddf4b173a958c095d84ac9335bbc7f419URHiE0M15qQzibIc2lCfBKNzOi/OMTkdtrtvYRMxc=', 'jimbo', 'abelardomanangan@gmail.com', '2018-02-03 10:13:49', '', 1),
(4, 'johnabeman', 'f6d60e33b66f206e231fab4691349d34a72993dfbcbde343eb4f8cbbde228a27167051695c41b1d10fac5561bc6fc11a4823189b44ac4658c6e22557c1c22bd3kATMUD4OG5jbnvAmGND3uHMq6oIECsOMpBJyTvbG4hY=', 'John Abe', 'johnabeman@gmail.com', '2018-03-17 09:06:47', '', 1);

-- --------------------------------------------------------

--
-- Table structure for table `user_meta`
--

CREATE TABLE `user_meta` (
  `id` bigint(20) NOT NULL,
  `user_id` bigint(20) NOT NULL,
  `meta_key` varchar(255) NOT NULL,
  `meta_value` longtext NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user_meta`
--

INSERT INTO `user_meta` (`id`, `user_id`, `meta_key`, `meta_value`) VALUES
(1, 1, 'first_name', ''),
(2, 1, 'last_name', ''),
(3, 1, 'middle_name', ''),
(4, 1, 'description', ''),
(5, 1, 'address', ''),
(6, 1, 'city', ''),
(7, 1, 'state', ''),
(8, 1, 'zip', ''),
(9, 1, 'cellphone', ''),
(10, 1, 'workphone', ''),
(11, 1, 'homephone', ''),
(12, 1, 'birthday', ''),
(13, 1, 'status', ''),
(72, 3, 'birthday', ''),
(15, 1, 'user_role', '\"admin\"'),
(71, 3, 'homephone', ''),
(70, 3, 'workphone', ''),
(69, 3, 'cellphone', ''),
(68, 3, 'zip', ''),
(67, 3, 'state', ''),
(42, 1, 'clocker_status', '2'),
(66, 3, 'city', ''),
(65, 3, 'address', ''),
(64, 3, 'description', ''),
(63, 3, 'middle_name', ''),
(62, 3, 'last_name', ''),
(61, 3, 'first_name', ''),
(60, 2, 'clocker_status', '1'),
(73, 3, 'status', ''),
(74, 3, 'user_role', '\"manager\"'),
(75, 3, 'clocker_status', '1'),
(76, 4, 'first_name', ''),
(77, 4, 'last_name', ''),
(78, 4, 'middle_name', ''),
(79, 4, 'description', ''),
(80, 4, 'address', ''),
(81, 4, 'city', ''),
(82, 4, 'state', ''),
(83, 4, 'zip', ''),
(84, 4, 'cellphone', ''),
(85, 4, 'workphone', ''),
(86, 4, 'homephone', ''),
(87, 4, 'birthday', ''),
(88, 4, 'status', ''),
(89, 4, 'user_role', '\"manager\"'),
(90, 4, 'clocker_status', '0');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `clocker_records`
--
ALTER TABLE `clocker_records`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `options`
--
ALTER TABLE `options`
  ADD PRIMARY KEY (`option_id`);

--
-- Indexes for table `plugins`
--
ALTER TABLE `plugins`
  ADD PRIMARY KEY (`plugin_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `user_login` (`user_login`),
  ADD UNIQUE KEY `user_email` (`user_email`);

--
-- Indexes for table `user_meta`
--
ALTER TABLE `user_meta`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `clocker_records`
--
ALTER TABLE `clocker_records`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `options`
--
ALTER TABLE `options`
  MODIFY `option_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `plugins`
--
ALTER TABLE `plugins`
  MODIFY `plugin_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `user_meta`
--
ALTER TABLE `user_meta`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=91;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
