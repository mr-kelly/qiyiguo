# Sequel Pro dump
# Version 2210
# http://code.google.com/p/sequel-pro
#
# Host: 127.0.0.1 (MySQL 5.1.44)
# Database: kiwiguo_r
# Generation Time: 2011-03-31 21:58:26 +0800
# ************************************************************

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


# Dump of table kk_admin_users
# ------------------------------------------------------------

DROP TABLE IF EXISTS `kk_admin_users`;

CREATE TABLE `kk_admin_users` (
  `id` int(11) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;



# Dump of table kk_attach
# ------------------------------------------------------------

DROP TABLE IF EXISTS `kk_attach`;

CREATE TABLE `kk_attach` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `file` varchar(255) DEFAULT NULL,
  `type` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=12 DEFAULT CHARSET=utf8;

LOCK TABLES `kk_attach` WRITE;
/*!40000 ALTER TABLE `kk_attach` DISABLE KEYS */;
INSERT INTO `kk_attach` (`id`,`file`,`type`)
VALUES
	(1,'/2011/03/07/登记表-陈霈霖-奇异果社交网络系统.doc','file'),
	(2,'/2011/03/09/fb2d48898166d487e5b5166ab690c8b3.jpg','image'),
	(3,'/2011/03/15/c9cc0ff7597f3dba8ac8eea14472b568.jpg','image'),
	(4,'/2011/03/21/06e5e05ae4ece7831bfd6b71ab8466e9.png','image'),
	(5,'/2011/03/21/技术交底书模板.doc','file'),
	(6,'/2011/03/22/9ea1c908c347c99ac97b9dfdf119c174.jpg','image'),
	(7,'/2011/03/22/a8f04e6c140f90f6f67ce7d67139386b.jpg','image'),
	(8,'/2011/03/23/b759817531c34157ae0e7b909ed57144.gif','image'),
	(9,'/2011/03/28/eb67e1c91db3c667fdd90bb111572753.png','image'),
	(10,'/2011/03/28/奇异果网络群主使用协议.doc','file');

/*!40000 ALTER TABLE `kk_attach` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table kk_channel
# ------------------------------------------------------------

DROP TABLE IF EXISTS `kk_channel`;

CREATE TABLE `kk_channel` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL,
  `type` varchar(255) DEFAULT NULL,
  `parent_id` int(11) DEFAULT '0',
  `created` datetime DEFAULT NULL,
  `modified` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;



# Dump of table kk_chat
# ------------------------------------------------------------

DROP TABLE IF EXISTS `kk_chat`;

CREATE TABLE `kk_chat` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) DEFAULT NULL,
  `content` varchar(140) DEFAULT NULL,
  `parent_id` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `model` varchar(255) DEFAULT NULL,
  `model_id` int(11) DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  `modified` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;



# Dump of table kk_ci_sessions
# ------------------------------------------------------------

DROP TABLE IF EXISTS `kk_ci_sessions`;

CREATE TABLE `kk_ci_sessions` (
  `session_id` varchar(40) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL DEFAULT '0',
  `ip_address` varchar(16) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL DEFAULT '0',
  `user_agent` varchar(150) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `last_activity` int(10) unsigned NOT NULL DEFAULT '0',
  `user_data` text CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  PRIMARY KEY (`session_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

LOCK TABLES `kk_ci_sessions` WRITE;
/*!40000 ALTER TABLE `kk_ci_sessions` DISABLE KEYS */;
INSERT INTO `kk_ci_sessions` (`session_id`,`ip_address`,`user_agent`,`last_activity`,`user_data`)
VALUES
	('2b3bcba8aec07d8be9bdc2f1ac583a16','0.0.0.0','Mozilla/5.0 (Macintosh; U; Intel Mac OS X 10_6_6; ',1301579761,X'613A363A7B733A31353A2273657373696F6E5F6D657373616765223B4E3B733A373A22757365725F6964223B733A353A223130303030223B733A383A22757365726E616D65223B733A353A223130303030223B733A363A22737461747573223B733A313A2231223B733A31333A2275705F757365725F3130303030223B623A313B733A31343A2275705F67726F75705F3130303030223B623A313B7D');

/*!40000 ALTER TABLE `kk_ci_sessions` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table kk_dict_city
# ------------------------------------------------------------

DROP TABLE IF EXISTS `kk_dict_city`;

CREATE TABLE `kk_dict_city` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `city_name` varchar(30) NOT NULL,
  `city_id` int(11) DEFAULT NULL,
  `province_id` int(10) unsigned NOT NULL,
  `S_STATE` varchar(1) DEFAULT NULL COMMENT '0 - 禁用\r\n1 - 启用 \r\n',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=468 DEFAULT CHARSET=utf8;

LOCK TABLES `kk_dict_city` WRITE;
/*!40000 ALTER TABLE `kk_dict_city` DISABLE KEYS */;
INSERT INTO `kk_dict_city` (`id`,`city_name`,`city_id`,`province_id`,`S_STATE`)
VALUES
	(1,'东城区',1,11,NULL),
	(2,'西城区',2,11,NULL),
	(3,'崇文区',3,11,NULL),
	(4,'宣武区',4,11,NULL),
	(5,'朝阳区',5,11,NULL),
	(6,'丰台区',6,11,NULL),
	(7,'石景山区',7,11,NULL),
	(8,'海淀区',8,11,NULL),
	(9,'门头沟区',9,11,NULL),
	(10,'房山区',11,11,NULL),
	(11,'通州区',12,11,NULL),
	(12,'顺义区',13,11,NULL),
	(13,'昌平区',14,11,NULL),
	(14,'大兴区',15,11,NULL),
	(15,'怀柔区',16,11,NULL),
	(16,'平谷区',17,11,NULL),
	(17,'密云县',28,11,NULL),
	(18,'延庆县',29,11,NULL),
	(19,'和平区',1,12,NULL),
	(20,'河东区',2,12,NULL),
	(21,'河西区',3,12,NULL),
	(22,'南开区',4,12,NULL),
	(23,'河北区',5,12,NULL),
	(24,'红桥区',6,12,NULL),
	(25,'塘沽区',7,12,NULL),
	(26,'汉沽区',8,12,NULL),
	(27,'大港区',9,12,NULL),
	(28,'东丽区',10,12,NULL),
	(29,'西青区',11,12,NULL),
	(30,'津南区',12,12,NULL),
	(31,'北辰区',13,12,NULL),
	(32,'武清区',14,12,NULL),
	(33,'宝坻区',15,12,NULL),
	(34,'宁河县',21,12,NULL),
	(35,'静海县',23,12,NULL),
	(36,'蓟县',25,12,NULL),
	(37,'石家庄',1,13,NULL),
	(38,'唐山',2,13,NULL),
	(39,'秦皇岛',3,13,NULL),
	(40,'邯郸',4,13,NULL),
	(41,'邢台',5,13,NULL),
	(42,'保定',6,13,NULL),
	(43,'张家口',7,13,NULL),
	(44,'承德',8,13,NULL),
	(45,'沧州',9,13,NULL),
	(46,'廊坊',10,13,NULL),
	(47,'衡水',11,13,NULL),
	(48,'太原',1,14,NULL),
	(49,'大同',2,14,NULL),
	(50,'阳泉',3,14,NULL),
	(51,'长治',4,14,NULL),
	(52,'晋城',5,14,NULL),
	(53,'朔州',6,14,NULL),
	(54,'晋中',7,14,NULL),
	(55,'运城',8,14,NULL),
	(56,'忻州',9,14,NULL),
	(57,'临汾',10,14,NULL),
	(58,'吕梁',23,14,NULL),
	(59,'呼和浩特',1,15,NULL),
	(60,'包头',2,15,NULL),
	(61,'乌海',3,15,NULL),
	(62,'赤峰',4,15,NULL),
	(63,'通辽',5,15,NULL),
	(64,'鄂尔多斯',6,15,NULL),
	(65,'呼伦贝尔',7,15,NULL),
	(66,'兴安盟',22,15,NULL),
	(67,'锡林郭勒盟',25,15,NULL),
	(68,'乌兰察布盟',26,15,NULL),
	(69,'巴彦淖尔盟',28,15,NULL),
	(70,'阿拉善盟',29,15,NULL),
	(71,'沈阳',1,21,NULL),
	(72,'大连',2,21,NULL),
	(73,'鞍山',3,21,NULL),
	(74,'抚顺',4,21,NULL),
	(75,'本溪',5,21,NULL),
	(76,'丹东',6,21,NULL),
	(77,'锦州',7,21,NULL),
	(78,'营口',8,21,NULL),
	(79,'阜新',9,21,NULL),
	(80,'辽阳',10,21,NULL),
	(81,'盘锦',11,21,NULL),
	(82,'铁岭',12,21,NULL),
	(83,'朝阳',13,21,NULL),
	(84,'葫芦岛',14,21,NULL),
	(85,'长春',1,22,NULL),
	(86,'吉林',2,22,NULL),
	(87,'四平',3,22,NULL),
	(88,'辽源',4,22,NULL),
	(89,'通化',5,22,NULL),
	(90,'白山',6,22,NULL),
	(91,'松原',7,22,NULL),
	(92,'白城',8,22,NULL),
	(93,'延边朝鲜族自治州',24,22,NULL),
	(94,'哈尔滨',1,23,NULL),
	(95,'齐齐哈尔',2,23,NULL),
	(96,'鸡西',3,23,NULL),
	(97,'鹤岗',4,23,NULL),
	(98,'双鸭山',5,23,NULL),
	(99,'大庆',6,23,NULL),
	(100,'伊春',7,23,NULL),
	(101,'佳木斯',8,23,NULL),
	(102,'七台河',9,23,NULL),
	(103,'牡丹江',10,23,NULL),
	(104,'黑河',11,23,NULL),
	(105,'绥化',12,23,NULL),
	(106,'大兴安岭',27,23,NULL),
	(107,'黄浦区',1,31,NULL),
	(108,'卢湾区',3,31,NULL),
	(109,'徐汇区',4,31,NULL),
	(110,'长宁区',5,31,NULL),
	(111,'静安区',6,31,NULL),
	(112,'普陀区',7,31,NULL),
	(113,'闸北区',8,31,NULL),
	(114,'虹口区',9,31,NULL),
	(115,'杨浦区',10,31,NULL),
	(116,'闵行区',12,31,NULL),
	(117,'宝山区',13,31,NULL),
	(118,'嘉定区',14,31,NULL),
	(119,'浦东新区',15,31,NULL),
	(120,'金山区',16,31,NULL),
	(121,'松江区',17,31,NULL),
	(122,'青浦区',18,31,NULL),
	(123,'南汇区',19,31,NULL),
	(124,'奉贤区',20,31,NULL),
	(125,'崇明县',30,31,NULL),
	(126,'南京',1,32,NULL),
	(127,'无锡',2,32,NULL),
	(128,'徐州',3,32,NULL),
	(129,'常州',4,32,NULL),
	(130,'苏州',5,32,NULL),
	(131,'南通',6,32,NULL),
	(132,'连云港',7,32,NULL),
	(133,'淮安',8,32,NULL),
	(134,'盐城',9,32,NULL),
	(135,'扬州',10,32,NULL),
	(136,'镇江',11,32,NULL),
	(137,'泰州',12,32,NULL),
	(138,'宿迁',13,32,NULL),
	(139,'杭州',1,33,NULL),
	(140,'宁波',2,33,NULL),
	(141,'温州',3,33,NULL),
	(142,'嘉兴',4,33,NULL),
	(143,'湖州',5,33,NULL),
	(144,'绍兴',6,33,NULL),
	(145,'金华',7,33,NULL),
	(146,'衢州',8,33,NULL),
	(147,'舟山',9,33,NULL),
	(148,'台州',10,33,NULL),
	(149,'丽水',11,33,NULL),
	(150,'合肥',1,34,NULL),
	(151,'芜湖',2,34,NULL),
	(152,'蚌埠',3,34,NULL),
	(153,'淮南',4,34,NULL),
	(154,'马鞍山',5,34,NULL),
	(155,'淮北',6,34,NULL),
	(156,'铜陵',7,34,NULL),
	(157,'安庆',8,34,NULL),
	(158,'黄山',10,34,NULL),
	(159,'滁州',11,34,NULL),
	(160,'阜阳',12,34,NULL),
	(161,'宿州',13,34,NULL),
	(162,'巢湖',14,34,NULL),
	(163,'六安',15,34,NULL),
	(164,'亳州',16,34,NULL),
	(165,'池州',17,34,NULL),
	(166,'宣城',18,34,NULL),
	(167,'福州',1,35,NULL),
	(168,'厦门',2,35,NULL),
	(169,'莆田',3,35,NULL),
	(170,'三明',4,35,NULL),
	(171,'泉州',5,35,NULL),
	(172,'漳州',6,35,NULL),
	(173,'南平',7,35,NULL),
	(174,'龙岩',8,35,NULL),
	(175,'宁德',9,35,NULL),
	(176,'南昌',1,36,NULL),
	(177,'景德镇',2,36,NULL),
	(178,'萍乡',3,36,NULL),
	(179,'九江',4,36,NULL),
	(180,'新余',5,36,NULL),
	(181,'鹰潭',6,36,NULL),
	(182,'赣州',7,36,NULL),
	(183,'吉安',8,36,NULL),
	(184,'宜春',9,36,NULL),
	(185,'抚州',10,36,NULL),
	(186,'上饶',11,36,NULL),
	(187,'济南',1,37,NULL),
	(188,'青岛',2,37,NULL),
	(189,'淄博',3,37,NULL),
	(190,'枣庄',4,37,NULL),
	(191,'东营',5,37,NULL),
	(192,'烟台',6,37,NULL),
	(193,'潍坊',7,37,NULL),
	(194,'济宁',8,37,NULL),
	(195,'泰安',9,37,NULL),
	(196,'威海',10,37,NULL),
	(197,'日照',11,37,NULL),
	(198,'莱芜',12,37,NULL),
	(199,'临沂',13,37,NULL),
	(200,'德州',14,37,NULL),
	(201,'聊城',15,37,NULL),
	(202,'滨州',16,37,NULL),
	(203,'菏泽',17,37,NULL),
	(204,'郑州',1,41,NULL),
	(205,'开封',2,41,NULL),
	(206,'洛阳',3,41,NULL),
	(207,'平顶山',4,41,NULL),
	(208,'安阳',5,41,NULL),
	(209,'鹤壁',6,41,NULL),
	(210,'新乡',7,41,NULL),
	(211,'焦作',8,41,NULL),
	(212,'濮阳',9,41,NULL),
	(213,'许昌',10,41,NULL),
	(214,'漯河',11,41,NULL),
	(215,'三门峡',12,41,NULL),
	(216,'南阳',13,41,NULL),
	(217,'商丘',14,41,NULL),
	(218,'信阳',15,41,NULL),
	(219,'周口',16,41,NULL),
	(220,'驻马店',17,41,NULL),
	(221,'武汉',1,42,NULL),
	(222,'黄石',2,42,NULL),
	(223,'十堰',3,42,NULL),
	(224,'宜昌',5,42,NULL),
	(225,'襄樊',6,42,NULL),
	(226,'鄂州',7,42,NULL),
	(227,'荆门',8,42,NULL),
	(228,'孝感',9,42,NULL),
	(229,'荆州',10,42,NULL),
	(230,'黄冈',11,42,NULL),
	(231,'咸宁',12,42,NULL),
	(232,'随州',13,42,NULL),
	(233,'恩施土家族苗族自治州',28,42,NULL),
	(234,'长沙',1,43,NULL),
	(235,'株洲',2,43,NULL),
	(236,'湘潭',3,43,NULL),
	(237,'衡阳',4,43,NULL),
	(238,'邵阳',5,43,NULL),
	(239,'岳阳',6,43,NULL),
	(240,'常德',7,43,NULL),
	(241,'张家界',8,43,NULL),
	(242,'益阳',9,43,NULL),
	(243,'郴州',10,43,NULL),
	(244,'永州',11,43,NULL),
	(245,'怀化',12,43,NULL),
	(246,'娄底',13,43,NULL),
	(247,'湘西土家族苗族自治州',31,43,NULL),
	(248,'广州',1,44,NULL),
	(249,'韶关',2,44,NULL),
	(250,'深圳',3,44,NULL),
	(251,'珠海',4,44,NULL),
	(252,'汕头',5,44,NULL),
	(253,'佛山',6,44,NULL),
	(254,'江门',7,44,NULL),
	(255,'湛江',8,44,NULL),
	(256,'茂名',9,44,NULL),
	(257,'肇庆',12,44,NULL),
	(258,'惠州',13,44,NULL),
	(259,'梅州',14,44,NULL),
	(260,'汕尾',15,44,NULL),
	(261,'河源',16,44,NULL),
	(262,'阳江',17,44,NULL),
	(263,'清远',18,44,NULL),
	(264,'东莞',19,44,NULL),
	(265,'中山',20,44,NULL),
	(266,'潮州',51,44,NULL),
	(267,'揭阳',52,44,NULL),
	(268,'云浮',53,44,NULL),
	(269,'南宁',1,45,NULL),
	(270,'柳州',2,45,NULL),
	(271,'桂林',3,45,NULL),
	(272,'梧州',4,45,NULL),
	(273,'北海',5,45,NULL),
	(274,'防城港',6,45,NULL),
	(275,'钦州',7,45,NULL),
	(276,'贵港',8,45,NULL),
	(277,'玉林',9,45,NULL),
	(278,'百色',10,45,NULL),
	(279,'贺州',11,45,NULL),
	(280,'河池',12,45,NULL),
	(281,'南宁',21,45,NULL),
	(282,'柳州',22,45,NULL),
	(283,'海口',1,46,NULL),
	(284,'三亚',2,46,NULL),
	(285,'其他',90,46,NULL),
	(286,'万州区',1,50,NULL),
	(287,'涪陵区',2,50,NULL),
	(288,'渝中区',3,50,NULL),
	(289,'大渡口区',4,50,NULL),
	(290,'江北区',5,50,NULL),
	(291,'沙坪坝区',6,50,NULL),
	(292,'九龙坡区',7,50,NULL),
	(293,'南岸区',8,50,NULL),
	(294,'北碚区',9,50,NULL),
	(295,'万盛区',10,50,NULL),
	(296,'双桥区',11,50,NULL),
	(297,'渝北区',12,50,NULL),
	(298,'巴南区',13,50,NULL),
	(299,'黔江区',14,50,NULL),
	(300,'长寿区',15,50,NULL),
	(301,'綦江县',22,50,NULL),
	(302,'潼南县',23,50,NULL),
	(303,'铜梁县',24,50,NULL),
	(304,'大足县',25,50,NULL),
	(305,'荣昌县',26,50,NULL),
	(306,'璧山县',27,50,NULL),
	(307,'梁平县',28,50,NULL),
	(308,'城口县',29,50,NULL),
	(309,'丰都县',30,50,NULL),
	(310,'垫江县',31,50,NULL),
	(311,'武隆县',32,50,NULL),
	(312,'忠县',33,50,NULL),
	(313,'开县',34,50,NULL),
	(314,'云阳县',35,50,NULL),
	(315,'奉节县',36,50,NULL),
	(316,'巫山县',37,50,NULL),
	(317,'巫溪县',38,50,NULL),
	(318,'石柱土家族自治县',40,50,NULL),
	(319,'秀山土家族苗族自治县',41,50,NULL),
	(320,'酉阳土家族苗族自治县',42,50,NULL),
	(321,'彭水苗族土家族自治县',43,50,NULL),
	(322,'江津市',81,50,NULL),
	(323,'合川市',82,50,NULL),
	(324,'永川区',83,50,NULL),
	(325,'南川市',84,50,NULL),
	(326,'成都',1,51,NULL),
	(327,'自贡',3,51,NULL),
	(328,'攀枝花',4,51,NULL),
	(329,'泸州',5,51,NULL),
	(330,'德阳',6,51,NULL),
	(331,'绵阳',7,51,NULL),
	(332,'广元',8,51,NULL),
	(333,'遂宁',9,51,NULL),
	(334,'内江',10,51,NULL),
	(335,'乐山',11,51,NULL),
	(336,'南充',13,51,NULL),
	(337,'眉山',14,51,NULL),
	(338,'宜宾',15,51,NULL),
	(339,'广安',16,51,NULL),
	(340,'达州',17,51,NULL),
	(341,'雅安',18,51,NULL),
	(342,'巴中',19,51,NULL),
	(343,'资阳',20,51,NULL),
	(344,'阿坝',32,51,NULL),
	(345,'甘孜',33,51,NULL),
	(346,'凉山',34,51,NULL),
	(347,'贵阳',1,52,NULL),
	(348,'六盘水',2,52,NULL),
	(349,'遵义',3,52,NULL),
	(350,'安顺',4,52,NULL),
	(351,'铜仁',22,52,NULL),
	(352,'黔西南',23,52,NULL),
	(353,'毕节',24,52,NULL),
	(354,'黔东南',26,52,NULL),
	(355,'黔南',27,52,NULL),
	(356,'昆明',1,53,NULL),
	(357,'曲靖',3,53,NULL),
	(358,'玉溪',4,53,NULL),
	(359,'保山',5,53,NULL),
	(360,'昭通',6,53,NULL),
	(361,'楚雄',23,53,NULL),
	(362,'红河',25,53,NULL),
	(363,'文山',26,53,NULL),
	(364,'思茅',27,53,NULL),
	(365,'西双版纳',28,53,NULL),
	(366,'大理',29,53,NULL),
	(367,'德宏',31,53,NULL),
	(368,'丽江',32,53,NULL),
	(369,'怒江',33,53,NULL),
	(370,'迪庆',34,53,NULL),
	(371,'临沧',35,53,NULL),
	(372,'拉萨',1,54,NULL),
	(373,'昌都',21,54,NULL),
	(374,'山南',22,54,NULL),
	(375,'日喀则',23,54,NULL),
	(376,'那曲',24,54,NULL),
	(377,'阿里',25,54,NULL),
	(378,'林芝',26,54,NULL),
	(379,'西安',1,61,NULL),
	(380,'铜川',2,61,NULL),
	(381,'宝鸡',3,61,NULL),
	(382,'咸阳',4,61,NULL),
	(383,'渭南',5,61,NULL),
	(384,'延安',6,61,NULL),
	(385,'汉中',7,61,NULL),
	(386,'榆林',8,61,NULL),
	(387,'安康',9,61,NULL),
	(388,'商洛',10,61,NULL),
	(389,'兰州',1,62,NULL),
	(390,'嘉峪关',2,62,NULL),
	(391,'金昌',3,62,NULL),
	(392,'白银',4,62,NULL),
	(393,'天水',5,62,NULL),
	(394,'武威',6,62,NULL),
	(395,'张掖',7,62,NULL),
	(396,'平凉',8,62,NULL),
	(397,'酒泉',9,62,NULL),
	(398,'庆阳',10,62,NULL),
	(399,'定西',24,62,NULL),
	(400,'陇南',26,62,NULL),
	(401,'临夏',29,62,NULL),
	(402,'甘南',30,62,NULL),
	(403,'西宁',1,63,NULL),
	(404,'海东',21,63,NULL),
	(405,'海北',22,63,NULL),
	(406,'黄南',23,63,NULL),
	(407,'海南',25,63,NULL),
	(408,'果洛',26,63,NULL),
	(409,'玉树',27,63,NULL),
	(410,'海西',28,63,NULL),
	(411,'银川',1,64,NULL),
	(412,'石嘴山',2,64,NULL),
	(413,'吴忠',3,64,NULL),
	(414,'固原',4,64,NULL),
	(415,'乌鲁木齐',1,65,NULL),
	(416,'克拉玛依',2,65,NULL),
	(417,'吐鲁番',21,65,NULL),
	(418,'哈密',22,65,NULL),
	(419,'昌吉',23,65,NULL),
	(420,'博尔塔拉',27,65,NULL),
	(421,'巴音郭楞',28,65,NULL),
	(422,'阿克苏',29,65,NULL),
	(423,'克孜勒苏',30,65,NULL),
	(424,'喀什',31,65,NULL),
	(425,'和田',32,65,NULL),
	(426,'伊犁',40,65,NULL),
	(427,'塔城',42,65,NULL),
	(428,'阿勒泰',43,65,NULL),
	(429,'台北',1,71,NULL),
	(430,'高雄',2,71,NULL),
	(431,'其他',90,71,NULL),
	(432,'香港',1,81,NULL),
	(433,'澳门',1,82,NULL),
	(434,'美国',1,400,NULL),
	(435,'英国',2,400,NULL),
	(436,'法国',3,400,NULL),
	(437,'俄罗斯',4,400,NULL),
	(438,'加拿大',5,400,NULL),
	(439,'巴西',6,400,NULL),
	(440,'澳大利亚',7,400,NULL),
	(441,'印尼',8,400,NULL),
	(442,'泰国',9,400,NULL),
	(443,'马来西亚',10,400,NULL),
	(444,'新加坡',11,400,NULL),
	(445,'菲律宾',12,400,NULL),
	(446,'越南',13,400,NULL),
	(447,'印度',14,400,NULL),
	(448,'日本',15,400,NULL),
	(449,'其他',16,400,NULL),
	(450,'东城区',1,11,NULL),
	(451,'西城区',2,11,NULL),
	(452,'崇文区',3,11,NULL),
	(453,'宣武区',4,11,NULL),
	(454,'朝阳区',5,11,NULL),
	(455,'丰台区',6,11,NULL),
	(456,'石景山区',7,11,NULL),
	(457,'海淀区',8,11,NULL),
	(458,'门头沟区',9,11,NULL),
	(459,'房山区',11,11,NULL),
	(460,'通州区',12,11,NULL),
	(461,'顺义区',13,11,NULL),
	(462,'昌平区',14,11,NULL),
	(463,'大兴区',15,11,NULL),
	(464,'怀柔区',16,11,NULL),
	(465,'平谷区',17,11,NULL),
	(466,'密云县',28,11,NULL),
	(467,'延庆县',29,11,NULL);

/*!40000 ALTER TABLE `kk_dict_city` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table kk_dict_province
# ------------------------------------------------------------

DROP TABLE IF EXISTS `kk_dict_province`;

CREATE TABLE `kk_dict_province` (
  `id` int(10) unsigned NOT NULL DEFAULT '0',
  `province_name` varchar(30) NOT NULL,
  `S_TYPE` varchar(1) DEFAULT NULL COMMENT '1 - 直辖市\r\n2 - 行政省\r\n3 - 自治区\r\n4 - 特别行政区\r\n5 - 其他国家\r\n见全局数据字典[省份类型] \r\n',
  `S_STATE` varchar(1) DEFAULT NULL COMMENT '0 - 禁用\r\n1 - 启用',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

LOCK TABLES `kk_dict_province` WRITE;
/*!40000 ALTER TABLE `kk_dict_province` DISABLE KEYS */;
INSERT INTO `kk_dict_province` (`id`,`province_name`,`S_TYPE`,`S_STATE`)
VALUES
	(11,'北京',NULL,NULL),
	(12,'天津',NULL,NULL),
	(13,'河北',NULL,NULL),
	(14,'山西',NULL,NULL),
	(15,'内蒙古',NULL,NULL),
	(21,'辽宁',NULL,NULL),
	(22,'吉林',NULL,NULL),
	(23,'黑龙江',NULL,NULL),
	(31,'上海',NULL,NULL),
	(32,'江苏',NULL,NULL),
	(33,'浙江',NULL,NULL),
	(34,'安徽',NULL,NULL),
	(35,'福建',NULL,NULL),
	(36,'江西',NULL,NULL),
	(37,'山东',NULL,NULL),
	(41,'河南',NULL,NULL),
	(42,'湖北',NULL,NULL),
	(43,'湖南',NULL,NULL),
	(44,'广东',NULL,NULL),
	(45,'广西',NULL,NULL),
	(46,'海南',NULL,NULL),
	(50,'重庆',NULL,NULL),
	(51,'四川',NULL,NULL),
	(52,'贵州',NULL,NULL),
	(53,'云南',NULL,NULL),
	(54,'西藏',NULL,NULL),
	(61,'陕西',NULL,NULL),
	(62,'甘肃',NULL,NULL),
	(63,'青海',NULL,NULL),
	(64,'宁夏',NULL,NULL),
	(65,'新疆',NULL,NULL),
	(71,'台湾',NULL,NULL),
	(81,'香港',NULL,NULL),
	(82,'澳门',NULL,NULL),
	(100,'其他',NULL,NULL),
	(400,'海外',NULL,NULL);

/*!40000 ALTER TABLE `kk_dict_province` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table kk_event
# ------------------------------------------------------------

DROP TABLE IF EXISTS `kk_event`;

CREATE TABLE `kk_event` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `start` datetime DEFAULT NULL,
  `end` datetime DEFAULT NULL,
  `model` varchar(255) DEFAULT NULL,
  `model_id` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `content` text,
  `type_id` int(11) DEFAULT NULL,
  `join_mode` varchar(255) DEFAULT NULL,
  `province_id` int(11) DEFAULT NULL,
  `city_id` int(11) DEFAULT NULL,
  `location` varchar(255) DEFAULT NULL,
  `vouched` int(11) DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  `modified` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `page_view` int(11) DEFAULT '0',
  `attach_img_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;



# Dump of table kk_event_user
# ------------------------------------------------------------

DROP TABLE IF EXISTS `kk_event_user`;

CREATE TABLE `kk_event_user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `event_id` int(11) NOT NULL,
  `type` varchar(255) NOT NULL DEFAULT '',
  `created` datetime NOT NULL,
  `modified` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;



# Dump of table kk_filter
# ------------------------------------------------------------

DROP TABLE IF EXISTS `kk_filter`;

CREATE TABLE `kk_filter` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `keyword` varchar(255) DEFAULT NULL,
  `filter` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=31 DEFAULT CHARSET=utf8;

LOCK TABLES `kk_filter` WRITE;
/*!40000 ALTER TABLE `kk_filter` DISABLE KEYS */;
INSERT INTO `kk_filter` (`id`,`keyword`,`filter`)
VALUES
	(1,'共产','水产'),
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
	(29,'人大','议会'),
	(30,'jb','器官');

/*!40000 ALTER TABLE `kk_filter` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table kk_group
# ------------------------------------------------------------

DROP TABLE IF EXISTS `kk_group`;

CREATE TABLE `kk_group` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(45) NOT NULL DEFAULT '',
  `slug` varchar(45) NOT NULL DEFAULT '',
  `logo` varchar(45) NOT NULL DEFAULT '',
  `province_id` int(11) DEFAULT NULL,
  `city_id` int(11) DEFAULT NULL,
  `category_id` int(11) NOT NULL,
  `owner_id` int(11) DEFAULT NULL,
  `privacy` varchar(45) DEFAULT '',
  `verify` varchar(255) DEFAULT '',
  `website` varchar(255) DEFAULT '',
  `intro` text,
  `vouched` int(11) DEFAULT '0',
  `is_logo` int(1) DEFAULT '0',
  `is_approved` int(1) DEFAULT '0',
  `page_view` int(11) DEFAULT '0',
  `created` datetime DEFAULT NULL,
  `modified` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `admin_mode` int(11) DEFAULT '0',
  `noheader_mode` int(11) DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `id_UNIQUE` (`id`),
  KEY `fk_kk_group_kk_group_category1` (`category_id`)
) ENGINE=MyISAM AUTO_INCREMENT=10001 DEFAULT CHARSET=utf8;

LOCK TABLES `kk_group` WRITE;
/*!40000 ALTER TABLE `kk_group` DISABLE KEYS */;
INSERT INTO `kk_group` (`id`,`name`,`slug`,`logo`,`province_id`,`city_id`,`category_id`,`owner_id`,`privacy`,`verify`,`website`,`intro`,`vouched`,`is_logo`,`is_approved`,`page_view`,`created`,`modified`,`admin_mode`,`noheader_mode`)
VALUES
	(10000,'奇异果之家','','',44,251,1,10000,'public','everyone','http://qiyiguo.cc','奇异果官方群。',0,0,0,1,'2011-03-31 21:56:47','2011-03-31 21:57:53',NULL,NULL);

/*!40000 ALTER TABLE `kk_group` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table kk_group_category
# ------------------------------------------------------------

DROP TABLE IF EXISTS `kk_group_category`;

CREATE TABLE `kk_group_category` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(45) DEFAULT NULL,
  `slug` varchar(255) DEFAULT NULL,
  `parent_id` int(11) NOT NULL DEFAULT '0',
  `created` datetime DEFAULT NULL,
  `modified` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=45 DEFAULT CHARSET=utf8;

LOCK TABLES `kk_group_category` WRITE;
/*!40000 ALTER TABLE `kk_group_category` DISABLE KEYS */;
INSERT INTO `kk_group_category` (`id`,`name`,`slug`,`parent_id`,`created`,`modified`)
VALUES
	(3,'公益',NULL,0,NULL,'2011-03-15 21:50:04'),
	(14,'公司企业',NULL,0,NULL,'2011-03-15 11:39:01'),
	(1,'学校/校园组织','campus',0,NULL,'2011-03-15 21:50:59'),
	(4,'大学','university',3,NULL,'2011-03-04 13:07:37'),
	(5,'高中',NULL,3,NULL,'2011-02-18 13:30:07'),
	(6,'初中',NULL,3,NULL,'2011-02-18 13:30:18'),
	(7,'小学',NULL,3,NULL,'2011-02-18 13:30:27'),
	(8,'住宅小区',NULL,0,NULL,'2011-02-20 13:39:22'),
	(9,'商铺',NULL,0,NULL,'2011-02-20 13:39:29'),
	(10,'讨论组',NULL,0,NULL,'2011-02-26 01:47:04'),
	(11,'朋友圈',NULL,0,NULL,'2011-03-04 13:08:51'),
	(12,'城市',NULL,0,NULL,'2011-03-04 13:06:57'),
	(22,'社会组织',NULL,0,NULL,'2011-03-15 21:50:17'),
	(15,'其它',NULL,0,NULL,'2011-03-15 21:49:08');

/*!40000 ALTER TABLE `kk_group_category` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table kk_group_special_users
# ------------------------------------------------------------

DROP TABLE IF EXISTS `kk_group_special_users`;

CREATE TABLE `kk_group_special_users` (
  `id` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `group_id` int(11) DEFAULT NULL,
  `intro` varchar(255) DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  `modified` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=MyISAM DEFAULT CHARSET=utf8;



# Dump of table kk_group_t_sina
# ------------------------------------------------------------

DROP TABLE IF EXISTS `kk_group_t_sina`;

CREATE TABLE `kk_group_t_sina` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `group_id` int(11) NOT NULL,
  `t_sina_id` int(11) NOT NULL,
  `oauth_token` varchar(255) NOT NULL,
  `oauth_token_secret` varchar(255) NOT NULL,
  `created` datetime DEFAULT NULL,
  `modified` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;



# Dump of table kk_group_user
# ------------------------------------------------------------

DROP TABLE IF EXISTS `kk_group_user`;

CREATE TABLE `kk_group_user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `group_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `user_role` varchar(255) DEFAULT NULL,
  `group_nickname` varchar(45) DEFAULT NULL,
  `energy` int(11) DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  `modified` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `fk_kk_groups_has_kk_users_kk_groups1` (`group_id`),
  KEY `fk_kk_groups_has_kk_users_kk_users1` (`user_id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

LOCK TABLES `kk_group_user` WRITE;
/*!40000 ALTER TABLE `kk_group_user` DISABLE KEYS */;
INSERT INTO `kk_group_user` (`id`,`group_id`,`user_id`,`user_role`,`group_nickname`,`energy`,`created`,`modified`)
VALUES
	(1,10000,10000,'admin','',NULL,'2011-03-31 21:56:47','2011-03-31 21:56:47');

/*!40000 ALTER TABLE `kk_group_user` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table kk_like
# ------------------------------------------------------------

DROP TABLE IF EXISTS `kk_like`;

CREATE TABLE `kk_like` (
  `id` int(11) DEFAULT NULL,
  `model` varchar(255) DEFAULT NULL,
  `model_id` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;



# Dump of table kk_log
# ------------------------------------------------------------

DROP TABLE IF EXISTS `kk_log`;

CREATE TABLE `kk_log` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `url` varchar(255) DEFAULT NULL,
  `message` varchar(255) DEFAULT NULL,
  `ip` varchar(255) DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;



# Dump of table kk_login_attempts
# ------------------------------------------------------------

DROP TABLE IF EXISTS `kk_login_attempts`;

CREATE TABLE `kk_login_attempts` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `ip_address` varchar(40) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `login` varchar(50) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=98 DEFAULT CHARSET=utf8;

LOCK TABLES `kk_login_attempts` WRITE;
/*!40000 ALTER TABLE `kk_login_attempts` DISABLE KEYS */;
INSERT INTO `kk_login_attempts` (`id`,`ip_address`,`login`,`time`)
VALUES
	(97,'0.0.0.0','chepy.v@gmail.com','2011-03-31 13:42:22');

/*!40000 ALTER TABLE `kk_login_attempts` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table kk_notice
# ------------------------------------------------------------

DROP TABLE IF EXISTS `kk_notice`;

CREATE TABLE `kk_notice` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) DEFAULT NULL,
  `content` varchar(255) DEFAULT NULL,
  `link` varchar(255) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `from_user_id` int(11) DEFAULT NULL,
  `status` varchar(255) DEFAULT '0',
  `type` varchar(255) DEFAULT NULL,
  `model` varchar(255) DEFAULT NULL,
  `model_id` int(11) DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  `modified` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;



# Dump of table kk_option
# ------------------------------------------------------------

DROP TABLE IF EXISTS `kk_option`;

CREATE TABLE `kk_option` (
  `id` int(11) DEFAULT NULL,
  `option_key` varchar(255) DEFAULT NULL,
  `option_value` varchar(255) DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  `modified` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=MyISAM DEFAULT CHARSET=utf8;



# Dump of table kk_option_custom_website
# ------------------------------------------------------------

DROP TABLE IF EXISTS `kk_option_custom_website`;

CREATE TABLE `kk_option_custom_website` (
  `id` int(11) NOT NULL,
  `website_name` varchar(45) CHARACTER SET latin1 DEFAULT NULL,
  `website_slug` varchar(255) DEFAULT NULL,
  `website_url` varchar(45) CHARACTER SET latin1 DEFAULT NULL,
  `website_logo` varchar(45) CHARACTER SET latin1 DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;



# Dump of table kk_relation
# ------------------------------------------------------------

DROP TABLE IF EXISTS `kk_relation`;

CREATE TABLE `kk_relation` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `from_id` int(11) DEFAULT NULL,
  `to_id` int(11) DEFAULT NULL,
  `model` varchar(255) DEFAULT NULL,
  `model_id` int(11) DEFAULT NULL,
  `relation` varchar(255) DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  `modified` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `intro` varchar(255) DEFAULT '',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;



# Dump of table kk_relation_mutual
# ------------------------------------------------------------

DROP TABLE IF EXISTS `kk_relation_mutual`;

CREATE TABLE `kk_relation_mutual` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `model_id` int(11) DEFAULT NULL,
  `mutual_id` int(11) DEFAULT NULL,
  `model` varchar(255) DEFAULT NULL,
  `relation` varchar(255) DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  `modified` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;



# Dump of table kk_request
# ------------------------------------------------------------

DROP TABLE IF EXISTS `kk_request`;

CREATE TABLE `kk_request` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL,
  `model` varchar(255) DEFAULT NULL,
  `model_id` int(11) DEFAULT NULL,
  `message` varchar(255) DEFAULT NULL,
  `status` varchar(255) DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  `modified` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;



# Dump of table kk_request_friends
# ------------------------------------------------------------

DROP TABLE IF EXISTS `kk_request_friends`;

CREATE TABLE `kk_request_friends` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `from_user_id` int(11) DEFAULT NULL,
  `to_user_id` int(11) DEFAULT NULL,
  `message` varchar(255) DEFAULT NULL,
  `status` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;



# Dump of table kk_search
# ------------------------------------------------------------

DROP TABLE IF EXISTS `kk_search`;

CREATE TABLE `kk_search` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `string` varchar(255) DEFAULT NULL,
  `count` int(11) DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;



# Dump of table kk_topic
# ------------------------------------------------------------

DROP TABLE IF EXISTS `kk_topic`;

CREATE TABLE `kk_topic` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) DEFAULT '',
  `content` text,
  `model` varchar(255) DEFAULT NULL,
  `model_id` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `attach_img_id` int(11) DEFAULT NULL,
  `attach_file_id` int(11) DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  `modified` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `page_view` int(11) DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;



# Dump of table kk_user_autologin
# ------------------------------------------------------------

DROP TABLE IF EXISTS `kk_user_autologin`;

CREATE TABLE `kk_user_autologin` (
  `key_id` char(255) NOT NULL,
  `user_id` int(11) NOT NULL DEFAULT '0',
  `user_agent` varchar(150) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `last_ip` varchar(40) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `last_login` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`key_id`,`user_id`),
  KEY `u` (`user_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

LOCK TABLES `kk_user_autologin` WRITE;
/*!40000 ALTER TABLE `kk_user_autologin` DISABLE KEYS */;
INSERT INTO `kk_user_autologin` (`key_id`,`user_id`,`user_agent`,`last_ip`,`last_login`)
VALUES
	('0dc6d7f11590d9164375cf6a14ae1774',10000,'Mozilla/5.0 (Macintosh; U; Intel Mac OS X 10_6_6; en-US) AppleWebKit/534.16 (KHTML, like Gecko) Chrome/10.0.648.204 Safari/534.16','0.0.0.0','2011-03-31 21:51:07');

/*!40000 ALTER TABLE `kk_user_autologin` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table kk_user_avatars
# ------------------------------------------------------------

DROP TABLE IF EXISTS `kk_user_avatars`;

CREATE TABLE `kk_user_avatars` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL,
  `avatar_file` varchar(255) DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  `modified` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

LOCK TABLES `kk_user_avatars` WRITE;
/*!40000 ALTER TABLE `kk_user_avatars` DISABLE KEYS */;
INSERT INTO `kk_user_avatars` (`id`,`user_id`,`avatar_file`,`created`,`modified`)
VALUES
	(1,10000,'ba046d02d13f9bf9eb1829c3f381ff90.jpg','2011-03-31 21:52:26','2011-03-31 21:52:26');

/*!40000 ALTER TABLE `kk_user_avatars` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table kk_user_douban
# ------------------------------------------------------------

DROP TABLE IF EXISTS `kk_user_douban`;

CREATE TABLE `kk_user_douban` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL,
  `uid` varchar(255) DEFAULT NULL,
  `oauth_token` varchar(255) DEFAULT NULL,
  `oauth_token_secret` varchar(255) DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  `modified` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

LOCK TABLES `kk_user_douban` WRITE;
/*!40000 ALTER TABLE `kk_user_douban` DISABLE KEYS */;
INSERT INTO `kk_user_douban` (`id`,`user_id`,`uid`,`oauth_token`,`oauth_token_secret`,`created`,`modified`)
VALUES
	(1,10000,'50475912','96807afbc9effbffc38170f35dcff3fd','b84dd8cd4c0bb339','2011-03-31 21:50:10','2011-03-31 21:50:53');

/*!40000 ALTER TABLE `kk_user_douban` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table kk_user_education
# ------------------------------------------------------------

DROP TABLE IF EXISTS `kk_user_education`;

CREATE TABLE `kk_user_education` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `school_id` int(11) DEFAULT NULL,
  `year` int(11) DEFAULT NULL,
  `extra` varchar(255) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  `modified` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;



# Dump of table kk_user_job_unit
# ------------------------------------------------------------

DROP TABLE IF EXISTS `kk_user_job_unit`;

CREATE TABLE `kk_user_job_unit` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `job_unit_id` int(11) DEFAULT NULL,
  `year` int(11) DEFAULT NULL,
  `extra` varchar(255) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  `modified` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;



# Dump of table kk_user_mood
# ------------------------------------------------------------

DROP TABLE IF EXISTS `kk_user_mood`;

CREATE TABLE `kk_user_mood` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL,
  `text` varchar(255) DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  `modified` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;



# Dump of table kk_user_option
# ------------------------------------------------------------

DROP TABLE IF EXISTS `kk_user_option`;

CREATE TABLE `kk_user_option` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL,
  `options` text,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;



# Dump of table kk_user_profiles
# ------------------------------------------------------------

DROP TABLE IF EXISTS `kk_user_profiles`;

CREATE TABLE `kk_user_profiles` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `user_type` varchar(255) DEFAULT '',
  `slug` varchar(255) DEFAULT '',
  `realname` varchar(45) DEFAULT '',
  `nickname` varchar(45) NOT NULL DEFAULT '',
  `name_privacy` int(11) DEFAULT '1',
  `gender` varchar(255) DEFAULT '',
  `birth` date DEFAULT NULL,
  `birth_privacy` int(11) DEFAULT '3',
  `age` varchar(255) DEFAULT '',
  `constellation` varchar(255) DEFAULT '',
  `description` text,
  `description_privacy` int(11) DEFAULT '3',
  `country` varchar(20) DEFAULT '',
  `website` varchar(255) DEFAULT '',
  `website_privacy` int(11) DEFAULT '3',
  `qq` int(11) DEFAULT NULL,
  `qq_privacy` int(11) DEFAULT '3',
  `msn` varchar(255) DEFAULT '',
  `msn_privacy` int(11) DEFAULT '3',
  `gtalk` varchar(255) DEFAULT '',
  `gtalk_privacy` int(11) DEFAULT '3',
  `email_1` varchar(255) DEFAULT '',
  `email_2` varchar(255) DEFAULT '',
  `email_3` varchar(255) DEFAULT '',
  `email_privacy` tinyint(4) DEFAULT '3',
  `link_renren` varchar(255) DEFAULT '',
  `link_renren_privacy` int(11) DEFAULT '3',
  `love_status` varchar(255) DEFAULT '',
  `love_status_privacy` int(11) DEFAULT '3',
  `avatar_id` int(11) DEFAULT NULL,
  `hometown_province_id` int(11) DEFAULT NULL,
  `hometown_city_id` int(11) DEFAULT NULL,
  `province_id` int(11) DEFAULT NULL,
  `city_id` int(11) DEFAULT NULL,
  `vouched` int(11) DEFAULT NULL,
  `user_privacy` int(11) DEFAULT '3',
  `page_view` int(11) DEFAULT '0',
  `phone` int(11) DEFAULT NULL,
  `phone_privacy` int(11) DEFAULT '2',
  `hobby` varchar(255) DEFAULT NULL,
  `like_books` varchar(255) DEFAULT NULL,
  `like_music` varchar(255) DEFAULT NULL,
  `like_sports` varchar(255) DEFAULT NULL,
  `like_movies` varchar(255) DEFAULT NULL,
  `like_personages` varchar(255) DEFAULT NULL,
  `motto` varchar(255) DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  `modified` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`,`nickname`),
  KEY `fk_kk_user_profiles_kk_users1` (`user_id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

LOCK TABLES `kk_user_profiles` WRITE;
/*!40000 ALTER TABLE `kk_user_profiles` DISABLE KEYS */;
INSERT INTO `kk_user_profiles` (`id`,`user_id`,`user_type`,`slug`,`realname`,`nickname`,`name_privacy`,`gender`,`birth`,`birth_privacy`,`age`,`constellation`,`description`,`description_privacy`,`country`,`website`,`website_privacy`,`qq`,`qq_privacy`,`msn`,`msn_privacy`,`gtalk`,`gtalk_privacy`,`email_1`,`email_2`,`email_3`,`email_privacy`,`link_renren`,`link_renren_privacy`,`love_status`,`love_status_privacy`,`avatar_id`,`hometown_province_id`,`hometown_city_id`,`province_id`,`city_id`,`vouched`,`user_privacy`,`page_view`,`phone`,`phone_privacy`,`hobby`,`like_books`,`like_music`,`like_sports`,`like_movies`,`like_personages`,`motto`,`created`,`modified`)
VALUES
	(1,10000,'','mrkelly','陈霈霖','Kelly',1,'male','1990-06-26',3,'21','巨蟹座','KK..',3,'','http://mrkelly.cc',3,23110388,3,'chepy.v@gmail.com',3,'chepy.v@gmail.com',3,NULL,NULL,NULL,3,'245439977',3,'single',3,1,44,251,44,254,NULL,3,1,2147483647,2,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2011-03-31 21:49:57','2011-03-31 21:55:34');

/*!40000 ALTER TABLE `kk_user_profiles` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table kk_user_recommend
# ------------------------------------------------------------

DROP TABLE IF EXISTS `kk_user_recommend`;

CREATE TABLE `kk_user_recommend` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `recommend_user_id` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `relation` varchar(255) DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  `modified` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;



# Dump of table kk_user_special_relations
# ------------------------------------------------------------

DROP TABLE IF EXISTS `kk_user_special_relations`;

CREATE TABLE `kk_user_special_relations` (
  `id` int(11) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;



# Dump of table kk_user_status
# ------------------------------------------------------------

DROP TABLE IF EXISTS `kk_user_status`;

CREATE TABLE `kk_user_status` (
  `id` int(11) NOT NULL,
  `status` int(11) NOT NULL,
  `type` int(11) NOT NULL,
  `user_id` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;



# Dump of table kk_user_t_sina
# ------------------------------------------------------------

DROP TABLE IF EXISTS `kk_user_t_sina`;

CREATE TABLE `kk_user_t_sina` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL,
  `t_sina_id` int(255) DEFAULT NULL,
  `oauth_token` varchar(255) DEFAULT NULL,
  `oauth_token_secret` varchar(255) DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  `modified` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

LOCK TABLES `kk_user_t_sina` WRITE;
/*!40000 ALTER TABLE `kk_user_t_sina` DISABLE KEYS */;
INSERT INTO `kk_user_t_sina` (`id`,`user_id`,`t_sina_id`,`oauth_token`,`oauth_token_secret`,`created`,`modified`)
VALUES
	(1,10000,1215059564,'d8e6b1122e967439109f79bf932e4a04','c5897af63b7d2fcc8f1d7d5a321ae9d9','2011-03-31 21:50:05','2011-03-31 21:50:48');

/*!40000 ALTER TABLE `kk_user_t_sina` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table kk_user_website
# ------------------------------------------------------------

DROP TABLE IF EXISTS `kk_user_website`;

CREATE TABLE `kk_user_website` (
  `user_id` int(11) NOT NULL,
  `website_id` int(11) NOT NULL,
  `logo` varchar(45) CHARACTER SET utf8 COLLATE utf8_bin DEFAULT NULL,
  `url` varchar(45) CHARACTER SET utf8 COLLATE utf8_bin DEFAULT NULL,
  PRIMARY KEY (`user_id`,`website_id`),
  KEY `fk_kk_users_has_kk_option_custom_webiste_kk_users1` (`user_id`),
  KEY `fk_kk_users_has_kk_option_custom_webiste_kk_option_custom_web1` (`website_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;



# Dump of table kk_users
# ------------------------------------------------------------

DROP TABLE IF EXISTS `kk_users`;

CREATE TABLE `kk_users` (
  `id` int(11) NOT NULL,
  `username` varchar(50) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `email` varchar(100) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `role` varchar(255) NOT NULL DEFAULT '',
  `activated` tinyint(1) NOT NULL DEFAULT '1',
  `banned` tinyint(1) NOT NULL DEFAULT '0',
  `ban_reason` varchar(255) CHARACTER SET utf8 COLLATE utf8_bin DEFAULT NULL,
  `new_password_key` varchar(50) CHARACTER SET utf8 COLLATE utf8_bin DEFAULT NULL,
  `new_password_requested` datetime DEFAULT NULL,
  `new_email` varchar(100) CHARACTER SET utf8 COLLATE utf8_bin DEFAULT NULL,
  `new_email_key` varchar(50) CHARACTER SET utf8 COLLATE utf8_bin DEFAULT NULL,
  `last_ip` varchar(40) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `last_login` datetime DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  `modified` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `password` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

LOCK TABLES `kk_users` WRITE;
/*!40000 ALTER TABLE `kk_users` DISABLE KEYS */;
INSERT INTO `kk_users` (`id`,`username`,`email`,`role`,`activated`,`banned`,`ban_reason`,`new_password_key`,`new_password_requested`,`new_email`,`new_email_key`,`last_ip`,`last_login`,`created`,`modified`,`password`)
VALUES
	(10000,'10000','mrkelly@qiyiguo.cc','admin',1,0,NULL,NULL,NULL,NULL,NULL,'0.0.0.0','2011-03-31 21:51:07','2011-03-31 21:49:57','2011-03-31 21:51:36','$P$BX7Zqw9iFKj72TJQvoKcMGKiSnevBR/');

/*!40000 ALTER TABLE `kk_users` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table kk_vouched
# ------------------------------------------------------------

DROP TABLE IF EXISTS `kk_vouched`;

CREATE TABLE `kk_vouched` (
  `id` int(11) DEFAULT NULL,
  `model` varchar(255) DEFAULT NULL,
  `model_id` int(11) DEFAULT NULL,
  `vouched` int(11) DEFAULT NULL,
  `vouch_text` text
) ENGINE=MyISAM DEFAULT CHARSET=utf8;






/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
