-- phpMyAdmin SQL Dump
-- version 4.2.11
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Jan 18, 2017 at 02:05 AM
-- Server version: 5.6.21
-- PHP Version: 5.6.14

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `practice_wordpress`
--

-- --------------------------------------------------------

--
-- Table structure for table `wp_bpc_appointment_settings`
--

CREATE TABLE IF NOT EXISTS `wp_bpc_appointment_settings` (
`id` bigint(20) NOT NULL,
  `user_id` bigint(20) NOT NULL,
  `partner_id` bigint(20) NOT NULL,
  `open_from` varchar(50) COLLATE utf8mb4_unicode_520_ci NOT NULL,
  `open_to` varchar(50) COLLATE utf8mb4_unicode_520_ci NOT NULL,
  `call_back_length` varchar(50) COLLATE utf8mb4_unicode_520_ci NOT NULL,
  `call_back_delay` varchar(50) COLLATE utf8mb4_unicode_520_ci NOT NULL,
  `morning` varchar(50) COLLATE utf8mb4_unicode_520_ci NOT NULL,
  `afternoon` varchar(50) COLLATE utf8mb4_unicode_520_ci NOT NULL,
  `evening` varchar(50) COLLATE utf8mb4_unicode_520_ci NOT NULL,
  `close` varchar(50) COLLATE utf8mb4_unicode_520_ci NOT NULL,
  `book_time_type` varchar(50) COLLATE utf8mb4_unicode_520_ci NOT NULL,
  `day` varchar(50) COLLATE utf8mb4_unicode_520_ci NOT NULL,
  `date` varchar(50) COLLATE utf8mb4_unicode_520_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB AUTO_INCREMENT=73 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_520_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `wp_bpc_appointment_settings`
--
ALTER TABLE `wp_bpc_appointment_settings`
 ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `wp_bpc_appointment_settings`
--
ALTER TABLE `wp_bpc_appointment_settings`
MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=73;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
