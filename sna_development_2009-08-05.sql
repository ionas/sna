# Sequel Pro dump
# Version 1147
# http://code.google.com/p/sequel-pro
#
# Host: localhost (MySQL 5.0.67)
# Database: sna_development
# Generation Time: 2009-08-05 02:22:57 +0200
# ************************************************************

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


# Dump of table messages
# ------------------------------------------------------------

DROP TABLE IF EXISTS `messages`;

CREATE TABLE `messages` (
  `id` char(36) NOT NULL,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  `user_id` char(36) NOT NULL,
  `form_user_id` char(36) NOT NULL,
  `subject` varchar(100) NOT NULL,
  `body` text NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

LOCK TABLES `messages` WRITE;
/*!40000 ALTER TABLE `messages` DISABLE KEYS */;
INSERT INTO `messages` (`id`,`created`,`modified`,`user_id`,`form_user_id`,`subject`,`body`)
VALUES
	('4a6c45fa-6200-47bb-aac7-02378784ca84','2009-07-26 14:03:06','2009-07-26 14:03:06','4a648ce4-08a4-46e2-91f8-024a8784ca84','4a648ce4-08a4-46e2-91f8-024a8784ca84','Thats a Message From X to Y','Hai!');

/*!40000 ALTER TABLE `messages` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table shouts
# ------------------------------------------------------------

DROP TABLE IF EXISTS `shouts`;

CREATE TABLE `shouts` (
  `id` char(36) NOT NULL,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  `user_id` char(36) NOT NULL,
  `from_user_id` char(36) NOT NULL,
  `text` text NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

LOCK TABLES `shouts` WRITE;
/*!40000 ALTER TABLE `shouts` DISABLE KEYS */;
INSERT INTO `shouts` (`id`,`created`,`modified`,`user_id`,`from_user_id`,`text`)
VALUES
	('4a6c45fa-6200-47bb-aac7-02378784ca83','0000-00-00 00:00:00','0000-00-00 00:00:00','4a6c45fa-6200-47bb-aac7-02378784ca84','4a6c45fa-6200-47bb-aac7-02378784ca84','Hio');

/*!40000 ALTER TABLE `shouts` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table user_options
# ------------------------------------------------------------

DROP TABLE IF EXISTS `user_options`;

CREATE TABLE `user_options` (
  `id` int(11) NOT NULL auto_increment,
  `modified` datetime NOT NULL,
  `user_id` char(36) NOT NULL,
  `key` varchar(255) NOT NULL,
  `value` varchar(1000) NOT NULL,
  PRIMARY KEY  (`id`),
  UNIQUE KEY `UNIQUE_KEY_PER_USER` (`user_id`,`key`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

LOCK TABLES `user_options` WRITE;
/*!40000 ALTER TABLE `user_options` DISABLE KEYS */;
INSERT INTO `user_options` (`id`,`modified`,`user_id`,`key`,`value`)
VALUES
	(1,'2009-07-28 17:43:20','4a648ce4-08a4-46e2-91f8-024a8784ca84','landingPage',''),
	(2,'2009-07-28 17:53:07','4a6c68a7-7b94-4370-8b37-02378784ca84','landingPage','controller=>users, action=>view, somebody'),
	(3,'0000-00-00 00:00:00','4a76e294-2b98-4913-a931-03a08784ca84','landingPage','controller=>messages');

/*!40000 ALTER TABLE `user_options` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table users
# ------------------------------------------------------------

DROP TABLE IF EXISTS `users`;

CREATE TABLE `users` (
  `id` char(36) NOT NULL,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  `has_accepted_tos` tinyint(1) NOT NULL default '0',
  `is_hidden` tinyint(1) NOT NULL default '0',
  `is_disabled` tinyint(1) NOT NULL default '0',
  `is_deleted` tinyint(1) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` char(64) NOT NULL,
  `nickname` varchar(20) NOT NULL,
  `email` varchar(200) NOT NULL,
  `activation_key` varchar(64) NOT NULL,
  PRIMARY KEY  (`id`),
  UNIQUE KEY `UNIQUE_USERNAME` (`username`),
  KEY `UNIQUE_NICKNAME` (`nickname`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` (`id`,`created`,`modified`,`has_accepted_tos`,`is_hidden`,`is_disabled`,`is_deleted`,`username`,`password`,`nickname`,`email`,`activation_key`)
VALUES
	('4a648ce4-08a4-46e2-91f8-024a8784ca84','0000-00-00 00:00:00','2009-08-04 17:15:22',1,0,0,0,'ionas','d234c827a80548e868cac076365c483fcdfadb80050a682fffd67a42e1dd012b','Jonas','foo@bar.com',''),
	('4a6c68a7-7b94-4370-8b37-02378784ca84','2009-07-26 16:31:03','2009-07-26 16:31:03',1,0,0,0,'somebody','d234c827a80548e868cac076365c483fcdfadb80050a682fffd67a42e1dd012b','Some Guy','',''),
	('4a78d032-6504-46ec-b122-04498784ca84','2009-08-05 02:20:02','2009-08-05 02:20:02',1,0,0,0,'abc','2313ebdda36736a7ad439bf21f5c6544ec2f457dd10939e28db48ef1ab2f29b1','abc','abc@abc.abc','c41bd6a47ae4848601353620cd71c65bcb92b061866149457ab0183fd95f8882');

/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;





/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
