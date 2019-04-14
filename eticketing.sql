-- phpMyAdmin SQL Dump
-- version 3.5.2.2
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Mar 24, 2017 at 11:05 AM
-- Server version: 5.5.27
-- PHP Version: 5.4.7

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `eticketing`
--

-- --------------------------------------------------------

--
-- Table structure for table `contact`
--

CREATE TABLE IF NOT EXISTS `contact` (
  `cid` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `phonenumber` varchar(255) NOT NULL,
  `message` text NOT NULL,
  `status` varchar(255) NOT NULL DEFAULT 'valid',
  PRIMARY KEY (`cid`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `contact`
--

INSERT INTO `contact` (`cid`, `name`, `email`, `phonenumber`, `message`, `status`) VALUES
(1, 'Justin', 'justin@gmail.com', '0725689784', 'What is the price of tickets?', 'valid');

-- --------------------------------------------------------

--
-- Table structure for table `payment`
--

CREATE TABLE IF NOT EXISTS `payment` (
  `pid` int(11) NOT NULL AUTO_INCREMENT,
  `paymentmethod` varchar(255) NOT NULL,
  `reference` varchar(255) NOT NULL,
  `amount` varchar(255) NOT NULL,
  `status` varchar(255) NOT NULL DEFAULT 'valid',
  PRIMARY KEY (`pid`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `payment`
--

INSERT INTO `payment` (`pid`, `paymentmethod`, `reference`, `amount`, `status`) VALUES
(1, 'mpesa', '0703175432', '2300', 'settled'),
(2, 'creditcard', '4478150315974368', '2300', 'settled');

-- --------------------------------------------------------

--
-- Table structure for table `seats`
--

CREATE TABLE IF NOT EXISTS `seats` (
  `sid` int(11) NOT NULL AUTO_INCREMENT,
  `seatlocation` varchar(255) NOT NULL,
  `number` varchar(255) NOT NULL,
  `price` varchar(255) NOT NULL,
  `user` varchar(255) NOT NULL,
  `creditnumber` varchar(255) NOT NULL,
  `credittype` varchar(255) NOT NULL,
  `datebooked` varchar(255) NOT NULL,
  `status` varchar(255) NOT NULL DEFAULT 'valid',
  PRIMARY KEY (`sid`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=222 ;

--
-- Dumping data for table `seats`
--

INSERT INTO `seats` (`sid`, `seatlocation`, `number`, `price`, `user`, `creditnumber`, `credittype`, `datebooked`, `status`) VALUES
(1, 'field', '101', '1000', '', '', '', '', 'valid'),
(2, 'field', '102', '1000', 'martinw950@gmail.com', '4478150031597478', 'visa', '10:22:07 AM 11/02/17', 'verified'),
(3, 'field', '103', '1000', 'martinw950@gmail.com', '4478150031597478', 'visa', '3:59:22 PM 13/02/17', 'verified'),
(4, 'field', '104', '1000', 'erickwarui28@gmail.com', '4478150031597478', 'visa', '8:53:16 AM 23/01/17', 'verified'),
(5, 'field', '105', '1000', 'martinw950@gmail.com', '4478150031597478', 'visa', '4:29:40 PM 13/03/17', 'canceled'),
(6, 'field', '106', '1000', '', '', '', '', 'valid'),
(7, 'field', '107', '1000', '', '', '', '', 'valid'),
(8, 'field', '108', '1000', 'erickwarui28@gmail.com', '4478150031597478', 'visa', '10:54:17 AM 01/02/17', 'verified'),
(9, 'field', '109', '1000', '', '', '', '', 'valid'),
(10, 'field', '110', '1000', '', '', '', '', 'valid'),
(11, 'field', '111', '1000', '', '', '', '', 'valid'),
(12, 'field', '112', '1000', '', '', '', '', 'valid'),
(13, 'field', '113', '1000', '', '', '', '', 'valid'),
(14, 'field', '114', '1000', '', '', '', '', 'valid'),
(15, 'field', '115', '1000', '', '', '', '', 'valid'),
(16, 'field', '116', '1000', '', '', '', '', 'valid'),
(17, 'field', '117', '1000', '', '', '', '', 'valid'),
(18, 'field', '118', '1000', '', '', '', '', 'valid'),
(19, 'field', '119', '1000', 'martinw950@gmail.com', '4478150315974368', 'visa', '3:26:25 PM 22/03/17', 'verified'),
(20, 'field', '120', '1000', 'martinw950@gmail.com', '0703175432', 'mpesa', '2:59:54 PM 22/03/17', 'canceled'),
(21, 'field', '121', '1000', '', '', '', '', 'valid'),
(22, 'field', '122', '1000', '', '', '', '', 'valid'),
(23, 'field', '123', '1000', '', '', '', '', 'valid'),
(24, 'field', '124', '1000', '', '', '', '', 'valid'),
(25, 'field', '125', '1000', '', '', '', '', 'valid'),
(26, 'field', '126', '1000', '', '', '', '', 'valid'),
(27, 'field', '127', '1000', '', '', '', '', 'valid'),
(28, 'field', '128', '1000', '', '', '', '', 'valid'),
(29, 'field', '129', '1000', '', '', '', '', 'valid'),
(30, 'field', '130', '1000', '', '', '', '', 'valid'),
(31, 'field', '131', '1000', '', '', '', '', 'valid'),
(32, 'field', '132', '1000', '', '', '', '', 'valid'),
(33, 'field', '133', '1000', '', '', '', '', 'valid'),
(34, 'field', '134', '1000', '', '', '', '', 'valid'),
(35, 'field', '135', '1000', '', '', '', '', 'valid'),
(36, 'field', '136', '1000', '', '', '', '', 'valid'),
(130, 'club', '201', '800', '', '', '', '', 'valid'),
(131, 'club', '202', '800', '', '', '', '', 'valid'),
(132, 'club', '203', '800', '', '', '', '', 'valid'),
(133, 'club', '204', '800', '', '', '', '', 'valid'),
(134, 'club', '205', '800', '', '', '', '', 'valid'),
(135, 'club', '206', '800', '', '', '', '', 'valid'),
(136, 'club', '207', '800', '', '', '', '', 'valid'),
(137, 'club', '208', '800', 'erickwarui28@gmail.com', '4478150031597478', 'visa', '10:49:41 AM 23/01/17', 'canceled'),
(138, 'club', '209', '800', '', '', '', '', 'valid'),
(139, 'club', '210', '800', '', '', '', '', 'valid'),
(140, 'club', '211', '800', '', '', '', '', 'valid'),
(141, 'club', '212', '800', '', '', '', '', 'valid'),
(142, 'club', '213', '800', 'erickwarui28@gmail.com', '4478150031597478', 'visa', '10:54:30 AM 01/02/17', 'verified'),
(143, 'club', '214', '800', '', '', '', '', 'valid'),
(144, 'club', '215', '800', '', '', '', '', 'valid'),
(145, 'club', '216', '800', '', '', '', '', 'valid'),
(146, 'club', '217', '800', '', '', '', '', 'valid'),
(147, 'club', '218', '800', '', '', '', '', 'valid'),
(148, 'club', '219', '800', 'martinw950@gmail.com', '4478150315974368', 'visa', '3:26:25 PM 22/03/17', 'verified'),
(149, 'club', '220', '800', 'martinw950@gmail.com', '0703175432', 'mpesa', '2:59:55 PM 22/03/17', 'verified'),
(150, 'club', '221', '800', '', '', '', '', 'valid'),
(151, 'club', '222', '800', '', '', '', '', 'valid'),
(152, 'club', '223', '800', '', '', '', '', 'valid'),
(153, 'club', '224', '800', '', '', '', '', 'valid'),
(154, 'club', '225', '800', '', '', '', '', 'valid'),
(155, 'club', '226', '800', '', '', '', '', 'valid'),
(156, 'club', '227', '800', '', '', '', '', 'valid'),
(157, 'club', '228', '800', '', '', '', '', 'valid'),
(158, 'club', '229', '800', '', '', '', '', 'valid'),
(159, 'club', '230', '800', '', '', '', '', 'valid'),
(160, 'club', '231', '800', '', '', '', '', 'valid'),
(161, 'club', '232', '800', '', '', '', '', 'valid'),
(162, 'club', '233', '800', '', '', '', '', 'valid'),
(163, 'club', '234', '800', '', '', '', '', 'valid'),
(164, 'club', '235', '800', '', '', '', '', 'valid'),
(165, 'club', '236', '800', '', '', '', '', 'valid'),
(166, 'club', '237', '800', '', '', '', '', 'valid'),
(167, 'club', '238', '800', '', '', '', '', 'valid'),
(168, 'club', '239', '800', '', '', '', '', 'valid'),
(169, 'club', '240', '800', '', '', '', '', 'valid'),
(170, 'club', '241', '800', '', '', '', '', 'valid'),
(171, 'club', '242', '800', '', '', '', '', 'valid'),
(172, 'club', '243', '800', '', '', '', '', 'valid'),
(173, 'club', '244', '800', '', '', '', '', 'valid'),
(174, 'club', '245', '800', '', '', '', '', 'valid'),
(175, 'club', '246', '800', '', '', '', '', 'valid'),
(176, 'upper', '301', '500', '', '', '', '', 'valid'),
(177, 'upper', '302', '500', '', '', '', '', 'valid'),
(178, 'upper', '303', '500', '', '', '', '', 'valid'),
(179, 'upper', '304', '500', '', '', '', '', 'valid'),
(180, 'upper', '305', '500', '', '', '', '', 'valid'),
(181, 'upper', '306', '500', '', '', '', '', 'valid'),
(182, 'upper', '307', '500', '', '', '', '', 'valid'),
(183, 'upper', '308', '500', '', '', '', '', 'valid'),
(184, 'upper', '309', '500', '', '', '', '', 'valid'),
(185, 'upper', '310', '500', '', '', '', '', 'valid'),
(186, 'upper', '311', '500', '', '', '', '', 'valid'),
(187, 'upper', '312', '500', '', '', '', '', 'valid'),
(188, 'upper', '313', '500', '', '', '', '', 'valid'),
(189, 'upper', '314', '500', '', '', '', '', 'valid'),
(190, 'upper', '315', '500', '', '', '', '', 'valid'),
(191, 'upper', '316', '500', '', '', '', '', 'valid'),
(192, 'upper', '317', '500', '', '', '', '', 'valid'),
(193, 'upper', '318', '500', '', '', '', '', 'valid'),
(194, 'upper', '319', '500', 'martinw950@gmail.com', '4478150315974368', 'visa', '3:26:25 PM 22/03/17', 'verified'),
(195, 'upper', '320', '500', 'martinw950@gmail.com', '0703175432', 'mpesa', '2:59:55 PM 22/03/17', 'verified'),
(196, 'upper', '321', '500', '', '', '', '', 'valid'),
(197, 'upper', '322', '500', '', '', '', '', 'valid'),
(198, 'upper', '323', '500', '', '', '', '', 'valid'),
(199, 'upper', '324', '500', '', '', '', '', 'valid'),
(200, 'upper', '325', '500', '', '', '', '', 'valid'),
(201, 'upper', '326', '500', '', '', '', '', 'valid'),
(202, 'upper', '327', '500', '', '', '', '', 'valid'),
(203, 'upper', '328', '500', '', '', '', '', 'valid'),
(204, 'upper', '329', '500', '', '', '', '', 'valid'),
(205, 'upper', '330', '500', '', '', '', '', 'valid'),
(206, 'upper', '331', '500', '', '', '', '', 'valid'),
(207, 'upper', '332', '500', '', '', '', '', 'valid'),
(208, 'upper', '333', '500', '', '', '', '', 'valid'),
(209, 'upper', '334', '500', '', '', '', '', 'valid'),
(210, 'upper', '335', '500', '', '', '', '', 'valid'),
(211, 'upper', '336', '500', '', '', '', '', 'valid'),
(212, 'upper', '337', '500', '', '', '', '', 'valid'),
(213, 'upper', '338', '500', '', '', '', '', 'valid'),
(214, 'upper', '339', '500', '', '', '', '', 'valid'),
(215, 'upper', '340', '500', '', '', '', '', 'valid'),
(216, 'upper', '341', '500', '', '', '', '', 'valid'),
(217, 'upper', '342', '500', '', '', '', '', 'valid'),
(218, 'upper', '343', '500', '', '', '', '', 'valid'),
(219, 'upper', '344', '500', 'erickwarui28@gmail.com', '4478150031597478', 'visa', '10:50:27 AM 23/01/17', 'invalid'),
(220, 'upper', '345', '500', '', '', '', '', 'valid'),
(221, 'upper', '346', '500', '', '', '', '', 'valid');

-- --------------------------------------------------------

--
-- Table structure for table `transactions`
--

CREATE TABLE IF NOT EXISTS `transactions` (
  `tid` int(11) NOT NULL AUTO_INCREMENT,
  `creditnumber` varchar(255) NOT NULL,
  `credittype` varchar(255) NOT NULL,
  `seatnumber` varchar(255) NOT NULL,
  `price` varchar(255) NOT NULL,
  `bookdate` varchar(255) NOT NULL,
  `user` varchar(255) NOT NULL,
  `status` varchar(255) NOT NULL,
  PRIMARY KEY (`tid`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=19 ;

--
-- Dumping data for table `transactions`
--

INSERT INTO `transactions` (`tid`, `creditnumber`, `credittype`, `seatnumber`, `price`, `bookdate`, `user`, `status`) VALUES
(1, '4478150031597478', 'visa', '104', '1000', '8:53:16 AM 23/01/17', 'erickwarui28@gmail.com', 'verified'),
(2, '4478150031597478', 'visa', '208', '500', '10:50:27 AM 23/01/17', 'erickwarui28@gmail.com', 'invalid'),
(7, '4478150031597478', 'visa', '101', '1000', '10:54:17 AM 01/02/17', 'erickwarui28@gmail.com', 'valid'),
(8, '4478150031597478', 'visa', '108', '1000', '10:54:17 AM 01/02/17', 'erickwarui28@gmail.com', 'verified'),
(9, '4478150031597478', 'visa', '213', '800', '10:54:30 AM 01/02/17', 'erickwarui28@gmail.com', 'verified'),
(10, '4478150031597478', 'visa', '102', '1000', '10:22:07 AM 11/02/17', 'martinw950@gmail.com', 'verified'),
(11, '4478150031597478', 'visa', '103', '1000', '3:59:22 PM 13/02/17', 'martinw950@gmail.com', 'verified'),
(12, '4478150031597478', 'visa', '105', '1000', '4:29:40 PM 13/03/17', 'martinw950@gmail.com', 'verified'),
(13, '0703175432', 'mpesa', '120', '1000', '2:59:54 PM 22/03/17', 'martinw950@gmail.com', 'verified'),
(14, '0703175432', 'mpesa', '220', '800', '2:59:55 PM 22/03/17', 'martinw950@gmail.com', 'verified'),
(15, '0703175432', 'mpesa', '320', '1000', '2:59:55 PM 22/03/17', 'martinw950@gmail.com', 'verified'),
(16, '4478150315974368', 'visa', '119', '1000', '3:26:25 PM 22/03/17', 'martinw950@gmail.com', 'verified'),
(17, '4478150315974368', 'visa', '219', '800', '3:26:25 PM 22/03/17', 'martinw950@gmail.com', 'verified'),
(18, '4478150315974368', 'visa', '319', '1000', '3:26:25 PM 22/03/17', 'martinw950@gmail.com', 'verified');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `uid` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  PRIMARY KEY (`uid`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`uid`, `name`, `email`, `password`) VALUES
(1, 'Martin Wanjiru', 'martinw950@gmail.com', 'password1'),
(2, 'Admin', 'admin', 'password1');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
