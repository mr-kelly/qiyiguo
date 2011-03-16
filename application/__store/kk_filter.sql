# Sequel Pro dump
# Version 2210
# http://code.google.com/p/sequel-pro
#
# Host: 61.143.38.147 (MySQL 5.1.55)
# Database: kiwiguo
# Generation Time: 2011-03-15 13:35:33 +0800
# ************************************************************

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


# Dump of table kk_filter
# ------------------------------------------------------------

DROP TABLE IF EXISTS `kk_filter`;

CREATE TABLE `kk_filter` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `keyword` varchar(255) DEFAULT NULL,
  `filter` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=30 DEFAULT CHARSET=utf8;

LOCK TABLES `kk_filter` WRITE;
/*!40000 ALTER TABLE `kk_filter` DISABLE KEYS */;
INSERT INTO `kk_filter` (`id`,`keyword`,`filter`)
VALUES
	(1,'和谐','水产'),
	(2,'党','派对'),
	(3,'俯卧撑','运动'),
	(4,'共产党','派对'),
	(5,'SB','文明用语'),
	(6,'妈的','文明用语'),
	(11,'粪','代谢产物'),
	(10,'妈逼','文明用语'),
	(9,'妈B','文明用语'),
	(12,'屎','代谢产物'),
	(13,'放屁','文明用语'),
	(14,'社会主义','初级阶段'),
	(15,'人木又','好五倍的权利'),
	(16,'政府','gov'),
	(17,'无界','无边'),
	(18,'GFW','wall'),
	(19,'煤矿','黑色燃料基地'),
	(20,'坦克','打炮车'),
	(21,'独裁','一把剪刀'),
	(22,'领导人','擎天柱'),
	(23,'垃圾','废品'),
	(24,'lj','废品'),
	(25,'公安','平平安安'),
	(26,'警察','平平安安'),
	(27,'藏','hide'),
	(28,'网监','太监'),
	(29,'人大','议会');

/*!40000 ALTER TABLE `kk_filter` ENABLE KEYS */;
UNLOCK TABLES;





/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
