-- phpMyAdmin SQL Dump
-- version 4.2.11
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Mar 30, 2017 at 03:43 PM
-- Server version: 5.6.21
-- PHP Version: 5.6.14

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `practice_wordpress_dev`
--

-- --------------------------------------------------------

--
-- Table structure for table `wp_bpc_appointment_setting_standard`
--

CREATE TABLE IF NOT EXISTS `wp_bpc_appointment_setting_standard` (
`id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `partner_id` int(11) NOT NULL,
  `monday_open_from` varchar(5) NOT NULL,
  `monday_open_to` varchar(5) NOT NULL,
  `monday_morning` varchar(5) NOT NULL,
  `monday_afternoon` varchar(5) NOT NULL,
  `monday_evening` varchar(5) NOT NULL,
  `monday_close` varchar(5) NOT NULL,
  `monday_break` text NOT NULL,
  `tuesday_open_from` varchar(5) NOT NULL,
  `tuesday_open_to` varchar(5) NOT NULL,
  `tuesday_morning` varchar(5) NOT NULL,
  `tuesday_afternoon` varchar(5) NOT NULL,
  `tuesday_evening` varchar(5) NOT NULL,
  `tuesday_close` varchar(5) NOT NULL,
  `tuesday_break` text NOT NULL,
  `wednesday_open_from` varchar(5) NOT NULL,
  `wednesday_open_to` varchar(5) NOT NULL,
  `wednesday_morning` varchar(5) NOT NULL,
  `wednesday_afternoon` varchar(5) NOT NULL,
  `wednesday_evening` varchar(5) NOT NULL,
  `wednesday_close` varchar(5) NOT NULL,
  `wednesday_break` text NOT NULL,
  `thursday_open_from` varchar(5) NOT NULL,
  `thursday_open_to` varchar(5) NOT NULL,
  `thursday_morning` varchar(5) NOT NULL,
  `thursday_afternoon` varchar(5) NOT NULL,
  `thursday_evening` varchar(5) NOT NULL,
  `thursday_close` varchar(5) NOT NULL,
  `thursday_break` text NOT NULL,
  `friday_open_from` varchar(5) NOT NULL,
  `friday_open_to` varchar(5) NOT NULL,
  `friday_morning` varchar(5) NOT NULL,
  `friday_afternoon` varchar(5) NOT NULL,
  `friday_evening` varchar(5) NOT NULL,
  `friday_close` varchar(5) NOT NULL,
  `friday_break` text NOT NULL,
  `saturday_open_from` varchar(5) NOT NULL,
  `saturday_open_to` varchar(5) NOT NULL,
  `saturday_morning` varchar(5) NOT NULL,
  `saturday_afternoon` varchar(5) NOT NULL,
  `saturday_evening` varchar(5) NOT NULL,
  `saturday_close` varchar(5) NOT NULL,
  `saturday_break` text NOT NULL,
  `sunday_open_from` varchar(5) NOT NULL,
  `sunday_open_to` varchar(5) NOT NULL,
  `sunday_morning` varchar(5) NOT NULL,
  `sunday_afternoon` varchar(5) NOT NULL,
  `sunday_evening` varchar(5) NOT NULL,
  `sunday_close` varchar(5) NOT NULL,
  `sunday_break` text NOT NULL,
  `call_back_delay` varchar(10) NOT NULL,
  `call_back_length` varchar(10) NOT NULL,
  `book_time_type` varchar(50) NOT NULL,
  `updated_at` datetime NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=latin1;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `wp_bpc_appointment_setting_standard`
--
ALTER TABLE `wp_bpc_appointment_setting_standard`
 ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `wp_bpc_appointment_setting_standard`
--
ALTER TABLE `wp_bpc_appointment_setting_standard`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=8;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
