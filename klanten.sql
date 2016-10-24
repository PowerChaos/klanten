/*
Navicat MariaDB Data Transfer

Target Server Type    : MariaDB
Target Server Version : 100118
File Encoding         : 65001

Date: 2016-10-24 09:39:22
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for details
-- ----------------------------
DROP TABLE IF EXISTS `details`;
CREATE TABLE `details` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `pid` int(11) NOT NULL,
  `naam` tinytext NOT NULL,
  `info` tinytext NOT NULL,
  `lid` tinytext NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of details
-- ----------------------------

-- ----------------------------
-- Table structure for gebruikers
-- ----------------------------
DROP TABLE IF EXISTS `gebruikers`;
CREATE TABLE `gebruikers` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'id',
  `naam` varchar(32) COLLATE utf8_bin NOT NULL COMMENT 'gebruiker naam',
  `wachtwoord` tinytext COLLATE utf8_bin NOT NULL COMMENT 'hash',
  `rechten` varchar(1) COLLATE utf8_bin NOT NULL COMMENT 'Rechten',
  `groep` varchar(3) COLLATE utf8_bin NOT NULL COMMENT 'Groep',
  PRIMARY KEY (`id`),
  UNIQUE KEY `id` (`id`,`naam`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='gebruikers Tabel';

-- ----------------------------
-- Records of gebruikers
-- ----------------------------
INSERT INTO `gebruikers` VALUES ('1', 'admin', 0x736861313A36343030303A31383A78316845396F397363515375444F4E6C344239647831757347424C2B764B4C613A4A4167557A5A6D304A6C696947732F52504652766845494D, '3', '');

-- ----------------------------
-- Table structure for groep
-- ----------------------------
DROP TABLE IF EXISTS `groep`;
CREATE TABLE `groep` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'id',
  `user` text COLLATE utf8_bin NOT NULL COMMENT 'user id',
  `naam` tinytext COLLATE utf8_bin NOT NULL COMMENT 'groepnaam',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='Groep Tabel';

-- ----------------------------
-- Records of groep
-- ----------------------------

-- ----------------------------
-- Table structure for klanten
-- ----------------------------
DROP TABLE IF EXISTS `klanten`;
CREATE TABLE `klanten` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `naam` tinytext NOT NULL,
  `straat` text NOT NULL,
  `nummer` tinytext NOT NULL,
  `postcode` tinytext NOT NULL,
  `gemeente` tinytext NOT NULL,
  `stad` tinytext NOT NULL,
  `land` tinytext NOT NULL,
  `telefoon` tinytext NOT NULL,
  `email` tinytext NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of klanten
-- ----------------------------

-- ----------------------------
-- Table structure for producten
-- ----------------------------
DROP TABLE IF EXISTS `producten`;
CREATE TABLE `producten` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `naam` tinytext NOT NULL,
  `info` tinytext NOT NULL,
  `klant` tinyint(6) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of producten
-- ----------------------------
