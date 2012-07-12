-- VirtualTrader SQL Dump

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `virtualtrader`
--

-- --------------------------------------------------------

--
-- Table structure for table `activitylog`
--

CREATE TABLE IF NOT EXISTS `activitylog` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `date` datetime NOT NULL,
  `username` varchar(30) NOT NULL,
  `action` varchar(100) NOT NULL,
  `additionalinfo` varchar(500) NOT NULL DEFAULT 'none',
  `ip` varchar(15) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=28 ;

-- --------------------------------------------------------

--
-- Table structure for table `attempts`
--

CREATE TABLE IF NOT EXISTS `attempts` (
  `ip` varchar(15) NOT NULL,
  `count` int(11) NOT NULL,
  `expiredate` datetime NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `sessions`
--

CREATE TABLE IF NOT EXISTS `sessions` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uid` int(11) NOT NULL,
  `username` varchar(30) NOT NULL,
  `hash` varchar(32) NOT NULL,
  `expiredate` datetime NOT NULL,
  `ip` varchar(15) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=10 ;

-- --------------------------------------------------------

--
-- Table structure for table `stocks`
--

CREATE TABLE IF NOT EXISTS `stocks` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `code` varchar(10) NOT NULL,
  `price` float NOT NULL,
  `diff` float NOT NULL,
  `diff_perc` float NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=41 ;

--
-- Dumping data for table `stocks`
--

INSERT INTO `stocks` (`id`, `name`, `code`, `price`, `diff`, `diff_perc`) VALUES
(1, 'Google Inc', 'GOOG', 586.01, 0.03, 0.01),
(2, 'Microsoft Corporation', 'MSFT', 30, -0.18, -0.61),
(3, 'Apple Inc.', 'AAPL', 613.89, 8.01, 1.32),
(4, 'Intel Corporation', 'INTC', 26.17, 0.01, 0.06),
(5, 'International Business Machines Corp.', 'IBM', 189.67, -1.74, -0.91),
(6, 'Oracle Corporation', 'ORCL', 29.1, -0.08, -0.27),
(7, 'Pixelworks, Inc.', 'PXLW', 2.69, 0.06, 2.28),
(8, 'Research In Motion Limited (USA)', 'RIMM', 7.67, -0.43, -5.31),
(9, 'Western Digital Corp.', 'WDC', 31.53, 0.51, 1.64),
(10, 'Facebook Inc', 'FB', 32.17, 0.44, 1.39),
(11, 'SanDisk Corporation', 'SNDK', 36.19, -0.52, -1.42),
(12, 'Siemens AG (ADR)', 'SI', 82.01, -0.19, -0.23),
(13, 'Hewlett-Packard Company', 'HPQ', 19.43, -0.14, -0.72),
(14, 'Cisco Systems, Inc.', 'CSCO', 16.65, -0.12, -0.72),
(15, 'Taiwan Semiconductor Mfg. Co. Ltd. (ADR)', 'TSM', 13.5, 0, 0),
(16, 'QUALCOMM, Inc.', 'QCOM', 55.32, 0.01, 0.02),
(17, 'SAP AG (ADR)', 'SAP', 55.5, -0.26, -0.47),
(18, 'Dell Inc.', 'DELL', 12.27, -0.29, -2.31),
(19, 'ABB Ltd (ADR)', 'ABB', 15.97, -0.14, -0.87),
(20, 'Canon Inc. (ADR)', 'CAJ', 38.43, -0.47, -1.21),
(21, 'Corning Incorporated', 'GLW', 12.67, -0.12, -0.94),
(22, 'EMC Corporation', 'EMC', 23.69, -0.38, -1.58),
(23, 'Emerson Electric Co.', 'EMR', 44.93, -0.23, -0.51),
(24, 'Texas Instruments Incorporated', 'TXN', 27.41, -0.31, -1.12),
(25, 'Xerox Corporation', 'XRX', 7.67, -0.12, -1.54),
(26, 'Symantec Corporation', 'SYMC', 13.92, -0.19, -1.38),
(27, 'Activision Blizzard, Inc.', 'ATVI', 12.08, 0.04, 0.33),
(28, 'Broadcom Corporation', 'BRCM', 31.64, -0.93, -2.86),
(29, 'Alcatel Lucent SA (ADR)', 'ALU', 1.49, -0.02, -1.32),
(30, 'Adobe Systems Incorporated', 'ADBE', 30.43, -0.94, -3),
(31, 'Motorola Solutions Inc', 'MSI', 46.71, -0.26, -0.55),
(32, 'VMware, Inc.', 'VMW', 83.08, -0.89, -1.06),
(33, 'Marvell Technology Group Ltd.', 'MRVL', 10.84, 0.05, 0.42),
(34, 'NVIDIA Corporation', 'NVDA', 13.22, -0.18, -1.34),
(35, 'Garmin Ltd.', 'GRMN', 37.46, 0.08, 0.21),
(36, 'Seagate Technology PLC', 'STX', 25.97, 1.01, 4.07),
(37, 'Advanced Micro Devices, Inc.', 'AMD', 5.62, -0.13, -2.26),
(38, 'Juniper Networks, Inc.', 'JNPR', 15.2, -0.38, -2.44),
(39, 'Citrix Systems, Inc.', 'CTXS', 76.56, -0.89, -1.15),
(40, 'Lexmark International Inc', 'LXK', 26.65, -0.4, -1.48);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(30) NOT NULL,
  `password` varchar(128) NOT NULL,
  `email` varchar(100) NOT NULL,
  `isactive` tinyint(1) NOT NULL DEFAULT '0',
  `activekey` varchar(15) NOT NULL DEFAULT '0',
  `resetkey` varchar(15) NOT NULL DEFAULT '0',
  `balance` float NOT NULL DEFAULT '200',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=75 ;

-- --------------------------------------------------------

--
-- Table structure for table `userstocks`
--

CREATE TABLE IF NOT EXISTS `userstocks` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `code` varchar(10) NOT NULL,
  `username` varchar(30) NOT NULL,
  `quantity` int(11) NOT NULL,
  `p_price` float NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
