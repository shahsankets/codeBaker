-- phpMyAdmin SQL Dump
-- version 3.2.4
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: May 08, 2014 at 01:51 PM
-- Server version: 5.1.41
-- PHP Version: 5.3.1

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `rnmysqli`
--

-- --------------------------------------------------------

--
-- Table structure for table `tbl_admin`
--

CREATE TABLE IF NOT EXISTS `tbl_admin` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `type` varchar(255) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `address` text,
  `phone` varchar(255) DEFAULT NULL,
  `user_id` varchar(255) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `status` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=25 ;

--
-- Dumping data for table `tbl_admin`
--

INSERT INTO `tbl_admin` (`id`, `type`, `name`, `email`, `address`, `phone`, `user_id`, `password`, `status`) VALUES
(1, 'User', 'Kaushal', 'Kaushal', '999090909', 'kaushal@gmail.com', 'admin', 'admin', 1),
(12, 'User', 'Sripat', 'Kaushal', 'kaushal@gmail.com', 'sonia''s date with "s \\more', 'vivek', 'vivek', 1),
(21, 'Administrator', 'Kaushal', 'Kaushal@gmail.com', 'sonia''s date with ', 'Kaushal', 'sona', 'sona', 1),
(22, 'User', 'vivek', 'vivek@gmail.com', '', '', 'vivek123', 'vivek123', 1),
(23, 'User', 'aryan', 'abc@gmail.cis', 'noida', '9540051981', 'aryan123', 'aaaa111', 1),
(24, 'User', 'Abhay', 'abc@gmail.ciw', 'aaaaaa', 'aaaaaa', 'aaaaaa', 'aaaaaa', 1);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_products`
--

CREATE TABLE IF NOT EXISTS `tbl_products` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `product_code` varchar(60) NOT NULL,
  `product_name` varchar(60) NOT NULL,
  `product_desc` text,
  `image` varchar(255) DEFAULT NULL,
  `price` decimal(10,2) NOT NULL,
  `added_by` bigint(20) unsigned DEFAULT NULL,
  `added_date` date DEFAULT NULL,
  `datetime` datetime DEFAULT NULL,
  `status` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `product_code` (`product_code`),
  KEY `fk_added_by2` (`added_by`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `tbl_products`
--

INSERT INTO `tbl_products` (`id`, `product_code`, `product_name`, `product_desc`, `image`, `price`, `added_by`, `added_date`, `datetime`, `status`) VALUES
(1, '12s2sda81', 'dasdasd', '<p>aDAS</p>', '1396811955teddy.png', '13212.00', 1, '2014-04-21', '2014-04-16 11:08:00', 1),
(2, 'fsdf', 'fdsfrsd', '<p>fsdfd</p>', NULL, '423.00', 1, '0000-00-00', '0000-00-00 00:00:00', 0),
(3, '2423', 'asfasf', 'fsafa', 'sff', '2131.00', 1, '0000-00-00', '0000-00-00 00:00:00', 1);

--
-- Constraints for dumped tables
--

--
-- Constraints for table `tbl_products`
--
ALTER TABLE `tbl_products`
  ADD CONSTRAINT `fk_added_by2` FOREIGN KEY (`added_by`) REFERENCES `tbl_admin` (`id`) ON DELETE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
