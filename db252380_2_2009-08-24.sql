# Sequel Pro dump
# Version 1245
# http://code.google.com/p/sequel-pro
#
# Host: mysql5.jonashartmann.com (MySQL 5.0.51b-log)
# Database: db252380_2
# Generation Time: 2009-08-24 02:19:40 +0200
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
  `profile_id` char(36) NOT NULL,
  `from_profile_id` char(36) NOT NULL,
  `subject` varchar(100) NOT NULL,
  `body` text NOT NULL,
  `is_read` tinyint(1) NOT NULL default '0',
  `is_replied` tinyint(1) NOT NULL default '0',
  `is_trashed` tinyint(1) NOT NULL default '0',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

LOCK TABLES `messages` WRITE;
/*!40000 ALTER TABLE `messages` DISABLE KEYS */;
INSERT INTO `messages` (`id`,`created`,`modified`,`user_id`,`profile_id`,`from_profile_id`,`subject`,`body`,`is_read`,`is_replied`,`is_trashed`)
VALUES
	('4a6c45fa-6200-47bb-aac7-02378784ca84','2009-07-26 14:03:06','2009-08-21 20:34:55','4a648ce4-08a4-46e2-91f8-024a8784ca84','4a648ce4-08a4-46e2-91f8-024a8784ca84','4a648ce4-08a4-46e2-91f8-024a8784ca84','Thats a Message From X to Y','Hai!',0,0,0),
	('4a8f041b-54ac-49fd-8c8e-01008784ca84','2009-08-21 22:31:23','2009-08-21 22:31:23','4a648ce4-08a4-46e2-91f8-024a8784ca84','4a8f0408-6568-49bc-9b81-017a8784ca84','4a8f0408-6568-49bc-9b81-017a8784ca84','bar','batz',1,1,0);

/*!40000 ALTER TABLE `messages` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table profiles
# ------------------------------------------------------------

DROP TABLE IF EXISTS `profiles`;

CREATE TABLE `profiles` (
  `id` char(36) NOT NULL,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  `user_id` char(36) NOT NULL,
  `is_deleted` tinyint(1) NOT NULL default '0',
  `is_hidden` tinyint(1) NOT NULL default '0',
  `nickname` varchar(20) NOT NULL,
  `birthday` datetime default NULL,
  `location` varchar(255) default NULL,
  PRIMARY KEY  (`id`),
  KEY `UNIQUE_PROFILE_PER_USER` (`user_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

LOCK TABLES `profiles` WRITE;
/*!40000 ALTER TABLE `profiles` DISABLE KEYS */;
INSERT INTO `profiles` (`id`,`created`,`modified`,`user_id`,`is_deleted`,`is_hidden`,`nickname`,`birthday`,`location`)
VALUES
	('4a8f0408-6568-49bc-9b81-017a8784ca84','2009-08-21 22:31:04','2009-08-21 22:31:04','4a648ce4-08a4-46e2-91f8-024a8784ca84',0,0,'foo','1984-06-15 00:00:00','bar');

/*!40000 ALTER TABLE `profiles` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table shouts
# ------------------------------------------------------------

DROP TABLE IF EXISTS `shouts`;

CREATE TABLE `shouts` (
  `id` char(36) NOT NULL,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  `user_id` char(36) NOT NULL,
  `profile_id` char(36) NOT NULL,
  `from_profile_id` char(36) NOT NULL,
  `body` text NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

LOCK TABLES `shouts` WRITE;
/*!40000 ALTER TABLE `shouts` DISABLE KEYS */;
INSERT INTO `shouts` (`id`,`created`,`modified`,`user_id`,`profile_id`,`from_profile_id`,`body`)
VALUES
	('4a6c45fa-6200-47bb-aac7-02378784ca83','0000-00-00 00:00:00','0000-00-00 00:00:00','','4a6c45fa-6200-47bb-aac7-02378784ca84','4a6c45fa-6200-47bb-aac7-02378784ca84','Hio'),
	('4a8eea17-bb54-417b-b0c5-00688784ca84','2009-08-21 20:40:23','2009-08-21 20:42:27','4a648ce4-08a4-46e2-91f8-024a8784ca84','','','asd');

/*!40000 ALTER TABLE `shouts` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table user_options
# ------------------------------------------------------------

DROP TABLE IF EXISTS `user_options`;

CREATE TABLE `user_options` (
  `id` int(11) NOT NULL auto_increment,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  `user_id` char(36) NOT NULL,
  `key` varchar(255) NOT NULL,
  `value` varchar(1000) NOT NULL,
  PRIMARY KEY  (`id`),
  UNIQUE KEY `UNIQUE_KEY_PER_USER` (`user_id`,`key`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

LOCK TABLES `user_options` WRITE;
/*!40000 ALTER TABLE `user_options` DISABLE KEYS */;
INSERT INTO `user_options` (`id`,`created`,`modified`,`user_id`,`key`,`value`)
VALUES
	(2,'0000-00-00 00:00:00','2009-07-28 17:53:07','4a648ce4-08a4-46e2-91f8-024a8784ca84','landingPage','/users/view/4a648ce4-08a4-46e2-91f8-024a8784ca84'),
	(3,'0000-00-00 00:00:00','0000-00-00 00:00:00','4a841aaa-6be4-4851-a666-00e38784ca84','landingPage','/messages');

/*!40000 ALTER TABLE `user_options` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table users
# ------------------------------------------------------------

DROP TABLE IF EXISTS `users`;

CREATE TABLE `users` (
  `id` char(36) NOT NULL,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  `is_deleted` tinyint(1) NOT NULL default '0',
  `is_disabled` tinyint(1) NOT NULL default '0',
  `has_accepted_tos` tinyint(1) NOT NULL default '0',
  `username` varchar(50) NOT NULL,
  `password` char(64) NOT NULL,
  `email` varchar(200) NOT NULL,
  `activation_key` varchar(19) NOT NULL default '',
  `last_login` datetime default NULL,
  `password_reset_key` varchar(19) default '',
  PRIMARY KEY  (`id`),
  UNIQUE KEY `UNIQUE_USERNAME` (`username`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` (`id`,`created`,`modified`,`is_deleted`,`is_disabled`,`has_accepted_tos`,`username`,`password`,`email`,`activation_key`,`last_login`,`password_reset_key`)
VALUES
	('4a648ce4-08a4-46e2-91f8-024a8784ca84','2009-08-03 16:15:22','2009-08-21 20:54:27',0,0,1,'ionas','d234c827a80548e868cac076365c483fcdfadb80050a682fffd67a42e1dd012b','ionas@sna.dev','','2009-08-21 20:54:27',''),
	('4a841aaa-6be4-4851-a666-00e38784ca84','2009-08-13 15:52:42','2009-08-14 21:49:30',0,0,0,'abc','d234c827a80548e868cac076365c483fcdfadb80050a682fffd67a42e1dd012b','sna@mailinator.com','','2009-08-14 21:49:30','');

/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;





/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
