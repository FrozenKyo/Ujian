-- phpMyAdmin SQL Dump
-- version 4.0.9
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Jul 08, 2014 at 02:47 PM
-- Server version: 5.6.14
-- PHP Version: 5.5.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `ujian`
--

-- --------------------------------------------------------

--
-- Table structure for table `buku`
--

CREATE TABLE IF NOT EXISTS `buku` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nama` varchar(100) DEFAULT NULL,
  `stok` int(11) DEFAULT NULL,
  `harga` decimal(10,2) DEFAULT NULL,
  `status` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=29 ;

--
-- Dumping data for table `buku`
--

INSERT INTO `buku` (`id`, `nama`, `stok`, `harga`, `status`) VALUES
(1, 'Detective Conan 1', 89, '7500.00', 1),
(2, 'Detective Conan 2', 28, '7500.00', 1),
(4, 'Detective Conan 4', 29, '7500.00', 1),
(5, 'Detective Conan 5', 30, '7500.00', 1),
(6, 'Detective Conan 6', 25, '7500.00', 1),
(7, 'Detective Conan 7', 30, '7500.00', 1),
(12, 'Boku no pico 1', 4, '10500.00', 1),
(21, 'Boku No Pico 3', 123, '4035.00', 1),
(27, 'Detective Conan 1', 89, '7500.00', 1),
(28, 'Boku No Pico 5', 10, '10000.00', 1);

-- --------------------------------------------------------

--
-- Table structure for table `djual`
--

CREATE TABLE IF NOT EXISTS `djual` (
  `id` int(11) NOT NULL DEFAULT '0',
  `buku` int(11) NOT NULL DEFAULT '0',
  `harga` decimal(10,0) DEFAULT NULL,
  `qty` int(11) DEFAULT NULL,
  `subtotal` decimal(10,0) DEFAULT NULL,
  PRIMARY KEY (`id`,`buku`),
  KEY `buku` (`buku`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `djual`
--

INSERT INTO `djual` (`id`, `buku`, `harga`, `qty`, `subtotal`) VALUES
(16, 1, '7500', 3, '22500'),
(16, 5, '7500', 3, '22500'),
(16, 7, '7500', 3, '22500'),
(17, 1, '1', 7500, '7500'),
(17, 2, '2', 7500, '15000'),
(17, 4, '1', 7500, '7500'),
(19, 1, '7500', 10, '75000'),
(19, 6, '7500', 5, '37500'),
(19, 12, '10500', 1, '10500');

--
-- Triggers `djual`
--
DROP TRIGGER IF EXISTS `check_ins_djual`;
DELIMITER //
CREATE TRIGGER `check_ins_djual` AFTER INSERT ON `djual`
 FOR EACH ROW BEGIN
	UPDATE buku
	SET stok = (stok - NEW.qty)
	WHERE id = NEW.buku;
END
//
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `hjual`
--

CREATE TABLE IF NOT EXISTS `hjual` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `tgl` datetime DEFAULT NULL,
  `kasir` int(11) DEFAULT NULL,
  `customer` varchar(50) DEFAULT NULL,
  `total` decimal(10,0) DEFAULT NULL,
  `status` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `kasir` (`kasir`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=20 ;

--
-- Dumping data for table `hjual`
--

INSERT INTO `hjual` (`id`, `tgl`, `kasir`, `customer`, `total`, `status`) VALUES
(16, '2014-07-07 00:00:00', 1, 'Henry', '67500', 1),
(17, '2014-07-08 00:00:00', 1, 'Reno', '30000', 1),
(18, '0000-00-00 00:00:00', 1, '', '0', 1),
(19, '2014-07-08 00:00:00', 1, 'Hhhh', '123000', 1);

-- --------------------------------------------------------

--
-- Table structure for table `kasir`
--

CREATE TABLE IF NOT EXISTS `kasir` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(20) DEFAULT NULL,
  `password` varchar(70) DEFAULT NULL,
  `nama` varchar(50) DEFAULT NULL,
  `status` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `kasir`
--

INSERT INTO `kasir` (`id`, `username`, `password`, `nama`, `status`) VALUES
(1, 'henry', 'henry', 'Henry', 1);

--
-- Constraints for dumped tables
--

--
-- Constraints for table `djual`
--
ALTER TABLE `djual`
  ADD CONSTRAINT `djual_ibfk_1` FOREIGN KEY (`id`) REFERENCES `hjual` (`id`),
  ADD CONSTRAINT `djual_ibfk_2` FOREIGN KEY (`buku`) REFERENCES `buku` (`id`);

--
-- Constraints for table `hjual`
--
ALTER TABLE `hjual`
  ADD CONSTRAINT `hjual_ibfk_1` FOREIGN KEY (`kasir`) REFERENCES `kasir` (`id`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
