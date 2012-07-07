-- VirtualTrader default SQL Database

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;


CREATE TABLE IF NOT EXISTS `activitylog` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `date` datetime NOT NULL,
  `username` varchar(30) NOT NULL,
  `action` varchar(100) NOT NULL,
  `additionalinfo` varchar(500) NOT NULL DEFAULT 'none',
  `ip` varchar(15) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

CREATE TABLE IF NOT EXISTS `attempts` (
  `ip` varchar(15) NOT NULL,
  `count` int(11) NOT NULL,
  `expiredate` datetime NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

CREATE TABLE IF NOT EXISTS `sessions` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uid` int(11) NOT NULL,
  `username` varchar(30) NOT NULL,
  `hash` varchar(32) NOT NULL,
  `expiredate` datetime NOT NULL,
  `ip` varchar(15) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

CREATE TABLE IF NOT EXISTS `stocks` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `code` varchar(10) NOT NULL,
  `price` float NOT NULL,
  `diff` float NOT NULL,
  `diff_perc` float NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=41 ;

INSERT INTO `stocks` (`id`, `name`, `code`, `price`, `diff`, `diff_perc`) VALUES
(1, '', 'GOOG', 0, 0, 0),
(2, '', 'MSFT', 0, 0, 0),
(3, '', 'AAPL', 0, 0, 0),
(4, '', 'INTC', 0, 0, 0),
(5, '', 'IBM', 0, 0, 0),
(6, '', 'ORCL', 0, 0, 0),
(7, '', 'PXLW', 0, 0, 0),
(8, '', 'RIMM', 0, 0, 0),
(9, '', 'WDC', 0, 0, 0),
(10, '', 'FB', 0, 0, 0),
(11, '', 'SNDK', 0, 0, 0),
(12, '', 'SI', 0, 0, 0),
(13, '', 'HPQ', 0, 0, 0),
(14, '', 'CSCO', 0, 0, 0),
(15, '', 'TSM', 0, 0, 0),
(16, '', 'QCOM', 0, 0, 0),
(17, '', 'SAP', 0, 0, 0),
(18, '', 'DELL', 0, 0, 0),
(19, '', 'ABB', 0, 0, 0),
(20, '', 'CAJ', 0, 0, 0),
(21, '', 'GLW', 0, 0, 0),
(22, '', 'EMC', 0, 0, 0),
(23, '', 'EMR', 0, 0, 0),
(24, '', 'TXN', 0, 0, 0),
(25, '', 'XRX', 0, 0, 0),
(26, '', 'SYMC', 0, 0, 0),
(27, '', 'ATVI', 0, 0, 0),
(28, '', 'BRCM', 0, 0, 0),
(29, '', 'ALU', 0, 0, 0),
(30, '', 'ADBE', 0, 0, 0),
(31, '', 'MSI', 0, 0, 0),
(32, '', 'VMW', 0, 0, 0),
(33, '', 'MRVL', 0, 0, 0),
(34, '', 'NVDA', 0, 0, 0),
(35, '', 'GRMN', 0, 0, 0),
(36, '', 'STX', 0, 0, 0),
(37, '', 'AMD', 0, 0, 0),
(38, '', 'JNPR', 0, 0, 0),
(39, '', 'CTXS', 0, 0, 0),
(40, '', 'LXK', 0, 0, 0);

CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(30) NOT NULL,
  `password` varchar(128) NOT NULL,
  `email` varchar(100) NOT NULL,
  `isactive` tinyint(1) NOT NULL DEFAULT '0',
  `activekey` varchar(15) NOT NULL DEFAULT '0',
  `resetkey` varchar(15) NOT NULL DEFAULT '0',
  `balance` float NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

CREATE TABLE IF NOT EXISTS `userstocks` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `code` varchar(10) NOT NULL,
  `username` varchar(30) NOT NULL,
  `quantity` int(11) NOT NULL,
  `p_price` float NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;