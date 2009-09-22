# Sequel Pro dump
# Version 1341
# http://code.google.com/p/sequel-pro
#
# Host: mysql5.jonashartmann.com (MySQL 5.0.51b-log)
# Database: db252380_2
# Generation Time: 2009-09-22 15:04:19 +0200
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
  `parent_message_id` char(36) default NULL,
  `profile_id` char(36) NOT NULL,
  `from_profile_id` char(36) NOT NULL,
  `to_profile_id` char(36) NOT NULL,
  `subject` varchar(100) NOT NULL,
  `body` text NOT NULL,
  `is_read` tinyint(1) NOT NULL default '0',
  `is_replied` tinyint(1) NOT NULL default '0',
  `is_trashed` tinyint(1) NOT NULL default '0',
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

LOCK TABLES `messages` WRITE;
/*!40000 ALTER TABLE `messages` DISABLE KEYS */;
INSERT INTO `messages` (`id`,`created`,`modified`,`user_id`,`parent_message_id`,`profile_id`,`from_profile_id`,`to_profile_id`,`subject`,`body`,`is_read`,`is_replied`,`is_trashed`)
VALUES
	('4a4c45fa-6200-47bb-aac7-02378784ca84','2009-07-26 14:03:06','2009-08-21 20:34:55','4a648ce4-08a4-46e2-91f8-024a8784ca84',NULL,'4a8f0408-6568-49bc-9b81-017a8784ca84','4a93f845-c860-40d4-81ec-00e68784ca84','4a8f0408-6568-49bc-9b81-017a8784ca84','Thats a Message From X to Y','Trojanerschutz für Behördencomputer\nLandesverwaltungsnetz unter Druck durch gezielte Angriffe\n\nIn Baden-Württemberg kämpfen Behörden mit Trojanerangriffen, die gezielt auf bestimmte Mitarbeiter zugeschnitten sind. Angeblich sollen die Urheber in China sitzen.\nBaden-Württemberg benötigt als erstes Bundesland einen besonderen Schutz der Behördencomputer vor Spionage-Angriffen durch Trojaner. Das berichtet das der Spiegel unter Berufung auf einem internen Bericht des Landesverfassungsschutzes aus der Abteilung für Spionageabwehr. Das Landesverwaltungsnetz sei nach Geheimdienstangaben Angriffen aus China ausgesetzt.\n\nDie Trojaner kämen meist per E-Mail und seien gezielt auf bestimmte Adressaten und Arbeitsbereiche zugeschnitten. Besonders Mitarbeiter aus dem Behördenmittelbau würden angegriffen. Chinesische Spionageprogramme seien bereits im Kanzleramt und im Auswärtigen Amt, im Bundeswirtschafts- und im Bundesforschungsministerium gefunden worden.\n\nDeutschland ist nicht nur Opfer im Cyberkrieg der Geheimdienste: Der deutsche Auslandsdienst BND hatte Ende März 2009 in 90 Fällen Computer in Afghanistan und im Kongo mit Trojanern angegriffen. Das hatte der BND-Vizechef dem Parlamentarischen Kontrollgremium erklärt. (asa) ',1,0,0),
	('4a6c45fa-6200-47bb-aac7-02378784c224','2009-07-26 14:03:06','2009-08-21 20:34:55','4a648ce4-08a4-46e2-91f8-024a8784ca84',NULL,'4a8f0408-6568-49bc-9b81-017a8784ca84','4a8f0408-6568-49bc-9b81-017a8784ca84','4a93f845-c860-40d4-81ec-00e68784ca84','Thats a Message From X to Y','TOR will be WoW in space.\n\nYou kids go enjoy your Star Wows. SWG is MUCH improved from when LA forced NGE on SOE. TOR has now these LA devs responsable for NGE.\n\nJust listen to the devs explain how in their New Game Experience players will have ICONIC characters that make them feel HEROIC from the start.\n\nThere will be NO valid crafting, or crafting professions, no entertainers, or non combat options, no player housing in the open world, no spaceship game. TOR is NOT the sandbox your looking for. \n\nYea Star WoWs will have more subs, but that\'s because they are vocally going for the WoW crowd.\n\nAS FOR THE LAZY COMMENT...\n\nBioware DID NOT even make their own GAME ENGINE. THEY SIMPLY ARE USING HEROS JOURNEYs engine.\n\nSOE made SWG from the ground up. With MANY more sandbox elements then TOR will ever have.',1,1,1),
	('4a6c45fa-6200-47bb-aac7-02378784c284','2009-07-26 14:03:06','2009-08-21 20:34:55','4a648ce4-08a4-46e2-91f8-024a8784ca84',NULL,'4a8f0408-6568-49bc-9b81-017a8784ca84','4a8f0408-6568-49bc-9b81-017a8784ca84','4a93f845-c860-40d4-81ec-00e68784ca84','Thats a Message From X to Y','Alongside yesterday\'s announcement that it will be bringing MMS to the iPhone on September 25th, AT&T released a video clip featuring \"Seth the Blogger Guy\" explaining the explosion in data growth over the past several years and how AT&T has been working to expand its infrastructure to handle the demands on its network.\n\nIn particular, Seth briefly addresses the steps AT&T has undertaken to prepare for the launch of MMS on the iPhone, noting that the company wanted to ensure that the feature works properly from the start.\n\nWe\'ve been working for months to prepare the radio access controllers in our network to support this launch. That means calibrating base stations all over the country, and frankly that\'s a very time-consuming process. MMS for the iPhone will be coming on September 25th. We wanted to make sure that when MMS for the iPhone launches, the experience was great. We wanted to get it right.\nSeth then addresses the broader investments AT&T has made in its network, totaling $38 billion over the past two years, to increase capacity and deploy coverage based on the 850 MHz spectrum, which offers improved capacity and in-building coverage. Finally, Seth points to AT&T\'s ongoing work to deploy technology to improve data transfer speeds and the expansion of 3G to additional markets.',1,1,0),
	('4a6c45fa-6200-47bb-aac7-02378784c684','2009-07-26 14:03:06','2009-08-21 20:34:55','4a648ce4-08a4-46e2-91f8-024a8784ca84',NULL,'4a8f0408-6568-49bc-9b81-017a8784ca84','4a93f845-c860-40d4-81ec-00e68784ca84','4a8f0408-6568-49bc-9b81-017a8784ca84','Thats a Message From X to Y','The nerf to armor pen in 3.2.2 is intentional. Compared to the recent buff where we increased the value of armor rating to 125%, this nerf would take it back down to 110%. While we are still evaluating the effects of this change in the 3.2.2 build, we did want to let you know of the possibility in case you were about to spend a lot on armor pen gems.\n\nIn fact, this was really the point. Several melee specs (and Marksman hunters) had begun to focus on armor pen at the expense of all other stats. Gear without armor pen was being passed over and gem sockets were increasingly being filled with just this one stat. While every spec has stats that are more valuable than others, this one felt like it was starting to trump everything. Not coincidentally, characters stacking lots of armor pen were starting to do more damage than their peers and more damage than we were comfortable with.\n\nThis change is largely for PvE reasons, though we won\'t cry at all if melee damage in PvP drops a little as a result.\n\nWe\'re letting you know now so that this doesn\'t feel like a stealth nerf, assuming it goes live. While you might disagree or be frustrated by the change (though I also suspect it won\'t come as a surprise to many players), we ask that you try and keep your response to something appropriate for these forums.',1,1,1),
	('4a6c45fa-6200-47bb-aac7-02378784ca84','2009-07-26 14:03:06','2009-08-21 20:34:55','4a648ce4-08a4-46e2-91f8-024a8784ca84',NULL,'4a8f0408-6568-49bc-9b81-017a8784ca84','4a93f845-c860-40d4-81ec-00e68784ca84','4a8f0408-6568-49bc-9b81-017a8784ca84','Thats a Message From X to Y','esque eget, sodales vel nunc. Cras sodales egestas eleifend. Quisque nec eros lacus. Etiam vehicula risus eget tellus interdum dignissim. Duis vulputate molestie ante ut facilisis. Praesent fermentum facilisis vehicula.\n\nPellentesque non nulla felis. Duis est neque, eleifend nec ultricies non, viverra non urna. Donec augue massa, rutrum sit amet rutrum tempor, vehicula ac elit. Mauris ultrices lobortis ante, id convallis sem elementum malesuada. Donec congue dolor a magna volutpat elementum tristique elit ultrices. Proin sollicitudin sapien non nunc hendrerit fringilla. Maecenas accumsan ante et felis fringilla sodales. Donec nec diam dolor. Cras est elit, pretium id vulputate at, dapibus eu nibh. Pellentesque at mi et sapien consequat blandit. Mauris sodales, nisl vel aliquam viverra, augue ipsum vulputate est, non sodales orci nulla eget neque. Donec arcu neque, rutrum at iaculis nec, interdum ut eros. Curabitur nisi dolor, faucibus eget congue vitae, congue vitae mi.\n\nVivamus arcu enim, dignissim quis sollicitudin eget, accumsan quis quam. Nam diam eros, semper sit amet tempor eget, sodales viverra massa. Curabitur vel posuere urna. Proin non sapien quis ipsum dapibus adipiscing quis a est. Praesent eu blandit ligula. Praesent interdum est a nunc porttitor euismod. Pellentesque ut magna id erat posuere pulvinar. In ante mauris, sollicitudin eget sodales vitae, lacinia nec ligula. Etiam eget ligula nulla. Suspendisse eget blandit est. Sed vehicula lacinia massa, sit amet interdum lorem volutpat at. Nunc ac laoreet erat. Duis eget lacus quis orci pharetra eleifend. Donec turpis dolor, egestas eget placerat sed, dapibus ut turpis. In et ante ut urna dictum euismod. Suspendisse tincidunt mi vitae magna accumsan non suscipit dui eleifend. Phasellus dui tellus, posuere nec ullamcorper ac, fermentum vitae magna. Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia Curae;\n\nVestibulum mi justo, euismod at tincidunt ut, bibendum molestie leo. Vivamus lacus ante, molestie eget porttitor vitae, sagittis ut tellus. Integer eu neque et urna interdum dictum vel a nisl. Aliquam vitae purus eget magna pharetra interdum. Sed ac nibh sem. Quisque dictum bibendum ullamcorper. Nunc ullamcorper blandit nulla id rutrum. Duis id libero et erat sollicitudin aliquet id in sapien. Vivamus fringilla, metus semper blandit scelerisque, risus massa faucibus metus, at laoreet augue metus et nunc. In hac habitasse platea dictumst. Cras dolor velit, ultricies sed commodo nec, dignissim gravida arcu. Morbi sit amet elit ante. Suspendisse arcu ligula, malesuada sit amet euismod a, adipiscing at turpis. Mauris bibendum, nisi eget condimentum rutrum, sem lorem placerat arcu, sed tincidunt nisl nunc lacinia felis. Duis rhoncus gravida accumsan. Vestibulum dignissim quam in velit rhoncus ut interdum nisl consequat. Praesent dignissim vulputate dapibus. Mauris orci sapien, consequat a viverra et, hendrerit non dui.\n\nDuis scelerisque feugiat risus quis eleifend. Aliquam id dolor leo. Duis tellus risus, ornare et laoreet eget, volutpat eu risus. Duis pharetra lorem eget nibh dignissim sit amet molestie est egestas. Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos. Cras arcu dolor, tincidunt eget tristique vel, ultricies ac magna. Nulla vitae lacus sed dolor dignissim sollicitudin a sit amet metus. Ut ac nisl non urna aliquam lobortis id sed diam',0,0,0),
	('4a8c45fa-6200-47bb-aac7-02378784c684','2009-07-26 14:03:06','2009-08-21 20:34:55','4a648ce4-08a4-46e2-91f8-024a8784ca84',NULL,'4a8f0408-6568-49bc-9b81-017a8784ca84','4a93f845-c860-40d4-81ec-00e68784ca84','4a8f0408-6568-49bc-9b81-017a8784ca84','Thats a Message From X to Y',' Brigitte Zypries (Foto: picture-alliance/ dpa)\n\nJustizministerin Zypries galt in den vergangenen vier Jahren als die große Gegenspielerin von Innenminister Schäuble. Doch die SPD-Ministerin als bloßes Korrektiv zum Law-und-Order-Mann der CDU zu verstehen, hieße die Rechtspolitik, als zentrales Element des Regierungshandelns, zu verkennen. [mehr]',1,1,1),
	('4a8f041b-54ac-49fd-8c8e-01008784ca84','2009-08-21 22:31:23','2009-08-21 22:31:23','4a648ce4-08a4-46e2-91f8-024a8784ca84',NULL,'4a8f0408-6568-49bc-9b81-017a8784ca84','4a93f845-c860-40d4-81ec-00e68784ca84','4a8f0408-6568-49bc-9b81-017a8784ca84','bar','et laoreet eget, volutpat eu risus. Duis pharetra lorem eget nibh dignissim sit amet molestie est egestas. Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos. Cras arcu dolor, tincidunt eget tristique vel, ultricies ac magna. Nulla vitae lacus sed dolor dignissim sollicitudin a sit amet metus. Ut ac nisl non urna aliquam lobortis id sed diam. Donec accumsan ipsum vitae nunc dignissim nec imperdiet leo mollis. Praesent ac ante magna. Aliquam iaculis iaculis malesuada. Praesent vestibulum tincidunt nunc at dapibus. Vestibulum pharetra lobortis odio pretium gravida. Fusce ac sapien nulla. Morbi non lorem ut lectus pretium sollicitudibatz',0,0,0),
	('4a93f7d8-c8f0-48e3-a7f7-01778784c284','2009-08-25 16:40:24','2009-08-25 16:40:24','4a648ce4-08a4-46e2-91f8-024a8784ca84',NULL,'4a8f0408-6568-49bc-9b81-017a8784ca84','4a93f845-c860-40d4-81ec-00e68784ca84','4a8f0408-6568-49bc-9b81-017a8784ca84','batz','EU zieht ernüchternde Afghanistan-Bilanz\n\nZu wenig Kooperation, kaum Motivation und zu viel Korruption - die EU räumt beim Außenministertreffen in Stockholm ein, bisher \"nur begrenzte Fortschritte\" beim Wiederaufbau in Afghanistan erzielt zu haben. Die Kritik an dem von der Bundeswehr angeforderten Luftangriff wird derweil schärfer. [mehr]',0,0,0),
	('4a93f7d8-c8f0-48e3-a7f7-01778784ca84','2009-08-25 16:40:24','2009-08-25 16:40:24','4a648ce4-08a4-46e2-91f8-024a8784ca84',NULL,'4a8f0408-6568-49bc-9b81-017a8784ca84','4a93f845-c860-40d4-81ec-00e68784ca84','4a8f0408-6568-49bc-9b81-017a8784ca84','batz','\"Apple Insider has an interesting perspective on the MS Exchange support built into Mac OS X 10.6 and how it essentially frees Apple from all things Microsoft: \'Windows Enthusiasts like to spin Apple\'s support for Exchange on the iPhone and in Snow Leopard as endorsement of Microsoft in the server space. From another angle, Apple is reducing its dependence upon Microsoft\'s client software, weakening Microsoft\'s ability to hold back and dumb down its Mac offerings at Apple\'s expense. More importantly, Apple is providing its users with additional options that benefit both Mac users and the open source community.\'\"bar',0,0,0),
	('4aad8bf3-0d2c-4a3e-a86b-01c58784ca84','2009-09-14 02:18:59','2009-09-14 02:18:59','4a648ce4-08a4-46e2-91f8-024a8784ca84',NULL,'4a8f0408-6568-49bc-9b81-017a8784ca84','4a8f0408-6568-49bc-9b81-017a8784ca84','4a93f845-c860-40d4-81ec-00e68784ca84','Re: Thats a Message From X to Y','FACK\r\n \r\nOn 2009-07-26, at 14:03, TheAbcGuy wrote:\r\n> The nerf to armor pen in 3.2.2 is intentional. Compared to the recent buff where we increased the value of armor rating to 125%, this nerf would take it back down to 110%. While we are still evaluating the effects of this change in the 3.2.2 build, we did want to let you know of the possibility in case you were about to spend a lot on armor pen gems.\r\n> \r\n> In fact, this was really the point. Several melee specs (and Marksman hunters) had begun to focus on armor pen at the expense of all other stats. Gear without armor pen was being passed over and gem sockets were increasingly being filled with just this one stat. While every spec has stats that are more valuable than others, this one felt like it was starting to trump everything. Not coincidentally, characters stacking lots of armor pen were starting to do more damage than their peers and more damage than we were comfortable with.\r\n> \r\n> This change is largely for PvE reasons, though we won\'t cry at all if melee damage in PvP drops a little as a result.\r\n> \r\n> We\'re letting you know now so that this doesn\'t feel like a stealth nerf, assuming it goes live. While you might disagree or be frustrated by the change (though I also suspect it won\'t come as a surprise to many players), we ask that you try and keep your response to something appropriate for these forums.',0,0,0),
	('4aad8bf3-276c-45d1-8d36-01c58784ca84','2009-09-14 02:18:59','2009-09-14 02:18:59','4a841aaa-6be4-4851-a666-00e38784ca84',NULL,'4a841aaa-6be4-4851-a666-00e38784ca84','4a8f0408-6568-49bc-9b81-017a8784ca84','4a93f845-c860-40d4-81ec-00e68784ca84','Re: Thats a Message From X to Y','FACK\r\n \r\nOn 2009-07-26, at 14:03, TheAbcGuy wrote:\r\n> The nerf to armor pen in 3.2.2 is intentional. Compared to the recent buff where we increased the value of armor rating to 125%, this nerf would take it back down to 110%. While we are still evaluating the effects of this change in the 3.2.2 build, we did want to let you know of the possibility in case you were about to spend a lot on armor pen gems.\r\n> \r\n> In fact, this was really the point. Several melee specs (and Marksman hunters) had begun to focus on armor pen at the expense of all other stats. Gear without armor pen was being passed over and gem sockets were increasingly being filled with just this one stat. While every spec has stats that are more valuable than others, this one felt like it was starting to trump everything. Not coincidentally, characters stacking lots of armor pen were starting to do more damage than their peers and more damage than we were comfortable with.\r\n> \r\n> This change is largely for PvE reasons, though we won\'t cry at all if melee damage in PvP drops a little as a result.\r\n> \r\n> We\'re letting you know now so that this doesn\'t feel like a stealth nerf, assuming it goes live. While you might disagree or be frustrated by the change (though I also suspect it won\'t come as a surprise to many players), we ask that you try and keep your response to something appropriate for these forums.',0,0,0),
	('4aad91c3-9260-4ce3-9884-01c98784ca84','2009-09-14 02:43:47','2009-09-14 02:43:47','4a841aaa-6be4-4851-a666-00e38784ca84',NULL,'4a93f845-c860-40d4-81ec-00e68784ca84','4a93f845-c860-40d4-81ec-00e68784ca84','4a8f0408-6568-49bc-9b81-017a8784ca84','Re: Re: Thats a Message From X to Y','Yeah, what the FACK?\r\n \r\nOn 2009-09-14, at 02:18, Jones wrote:\r\n> FACK\r\n>  \r\n> On 2009-07-26, at 14:03, TheAbcGuy wrote:\r\n> > The nerf to armor pen in 3.2.2 is intentional. Compared to the recent buff where we increased the value of armor rating to 125%, this nerf would take it back down to 110%. While we are still evaluating the effects of this change in the 3.2.2 build, we did want to let you know of the possibility in case you were about to spend a lot on armor pen gems.\r\n> > \r\n> > In fact, this was really the point. Several melee specs (and Marksman hunters) had begun to focus on armor pen at the expense of all other stats. Gear without armor pen was being passed over and gem sockets were increasingly being filled with just this one stat. While every spec has stats that are more valuable than others, this one felt like it was starting to trump everything. Not coincidentally, characters stacking lots of armor pen were starting to do more damage than their peers and more damage than we were comfortable with.\r\n> > \r\n> > This change is largely for PvE reasons, though we won\'t cry at all if melee damage in PvP drops a little as a result.\r\n> > \r\n> > We\'re letting you know now so that this doesn\'t feel like a stealth nerf, assuming it goes live. While you might disagree or be frustrated by the change (though I also suspect it won\'t come as a surprise to many players), we ask that you try and keep your response to something appropriate for these forums.',0,0,0),
	('4aad91c4-dfcc-440d-958c-01c98784ca84','2009-09-14 02:43:48','2009-09-14 02:43:48','4a648ce4-08a4-46e2-91f8-024a8784ca84',NULL,'4a8f0408-6568-49bc-9b81-017a8784ca84','4a93f845-c860-40d4-81ec-00e68784ca84','4a8f0408-6568-49bc-9b81-017a8784ca84','Re: Re: Thats a Message From X to Y','Yeah, what the FACK?\r\n \r\nOn 2009-09-14, at 02:18, Jones wrote:\r\n> FACK\r\n>  \r\n> On 2009-07-26, at 14:03, TheAbcGuy wrote:\r\n> > The nerf to armor pen in 3.2.2 is intentional. Compared to the recent buff where we increased the value of armor rating to 125%, this nerf would take it back down to 110%. While we are still evaluating the effects of this change in the 3.2.2 build, we did want to let you know of the possibility in case you were about to spend a lot on armor pen gems.\r\n> > \r\n> > In fact, this was really the point. Several melee specs (and Marksman hunters) had begun to focus on armor pen at the expense of all other stats. Gear without armor pen was being passed over and gem sockets were increasingly being filled with just this one stat. While every spec has stats that are more valuable than others, this one felt like it was starting to trump everything. Not coincidentally, characters stacking lots of armor pen were starting to do more damage than their peers and more damage than we were comfortable with.\r\n> > \r\n> > This change is largely for PvE reasons, though we won\'t cry at all if melee damage in PvP drops a little as a result.\r\n> > \r\n> > We\'re letting you know now so that this doesn\'t feel like a stealth nerf, assuming it goes live. While you might disagree or be frustrated by the change (though I also suspect it won\'t come as a surprise to many players), we ask that you try and keep your response to something appropriate for these forums.',0,0,0),
	('4aad9287-8370-451d-bdd9-01a98784ca84','2009-09-14 02:47:03','2009-09-14 02:47:03','4a841aaa-6be4-4851-a666-00e38784ca84',NULL,'4a93f845-c860-40d4-81ec-00e68784ca84','4a93f845-c860-40d4-81ec-00e68784ca84','4a8f0408-6568-49bc-9b81-017a8784ca84','Foo','Quux',0,0,0),
	('4aad9287-8b94-4515-a0a8-01a98784ca84','2009-09-14 02:47:03','2009-09-14 02:47:03','4a648ce4-08a4-46e2-91f8-024a8784ca84',NULL,'4a8f0408-6568-49bc-9b81-017a8784ca84','4a93f845-c860-40d4-81ec-00e68784ca84','4a8f0408-6568-49bc-9b81-017a8784ca84','Foo','Quux',0,0,0),
	('4aad9294-8f14-49dc-a048-01c58784ca84','2009-09-14 02:47:16','2009-09-14 02:47:16','4a648ce4-08a4-46e2-91f8-024a8784ca84',NULL,'4a8f0408-6568-49bc-9b81-017a8784ca84','4a93f845-c860-40d4-81ec-00e68784ca84','4a8f0408-6568-49bc-9b81-017a8784ca84','ManGEHENDLICH','Quux',0,0,0),
	('4aad9294-f474-4ac5-9031-01c58784ca84','2009-09-14 02:47:16','2009-09-14 02:47:16','4a841aaa-6be4-4851-a666-00e38784ca84',NULL,'4a93f845-c860-40d4-81ec-00e68784ca84','4a93f845-c860-40d4-81ec-00e68784ca84','4a8f0408-6568-49bc-9b81-017a8784ca84','ManGEHENDLICH','Quux',0,0,0),
	('4aad92b2-55b4-4b10-8ed6-017b8784ca84','2009-09-14 02:47:46','2009-09-14 02:47:46','4a648ce4-08a4-46e2-91f8-024a8784ca84',NULL,'4a8f0408-6568-49bc-9b81-017a8784ca84','4a8f0408-6568-49bc-9b81-017a8784ca84','4a93f845-c860-40d4-81ec-00e68784ca84','Re: ManGEHENDLICH','Geht Doch!\r\n \r\nOn 2009-09-14, at 02:47, TheAbcGuy wrote:\r\n> Quux',0,0,0),
	('4aad92b2-aa04-4ce9-baa9-017b8784ca84','2009-09-14 02:47:46','2009-09-14 02:47:46','4a841aaa-6be4-4851-a666-00e38784ca84',NULL,'4a93f845-c860-40d4-81ec-00e68784ca84','4a8f0408-6568-49bc-9b81-017a8784ca84','4a93f845-c860-40d4-81ec-00e68784ca84','Re: ManGEHENDLICH','Geht Doch!\r\n \r\nOn 2009-09-14, at 02:47, TheAbcGuy wrote:\r\n> Quux',0,0,0),
	('4aad92cf-5ab8-491f-8983-01a68784ca84','2009-09-14 02:48:15','2009-09-14 02:48:15','4a841aaa-6be4-4851-a666-00e38784ca84',NULL,'4a93f845-c860-40d4-81ec-00e68784ca84','4a93f845-c860-40d4-81ec-00e68784ca84','4a8f0408-6568-49bc-9b81-017a8784ca84','Re: Re: ManGEHENDLICH','SchÃ¶n :)\r\n \r\nOn 2009-09-14, at 02:47, Jones wrote:\r\n> Geht Doch!\r\n>  \r\n> On 2009-09-14, at 02:47, TheAbcGuy wrote:\r\n> > Quux',0,0,0),
	('4aad92cf-7470-4684-b3e2-01a68784ca84','2009-09-14 02:48:15','2009-09-14 02:48:15','4a648ce4-08a4-46e2-91f8-024a8784ca84',NULL,'4a8f0408-6568-49bc-9b81-017a8784ca84','4a93f845-c860-40d4-81ec-00e68784ca84','4a8f0408-6568-49bc-9b81-017a8784ca84','Re: Re: ManGEHENDLICH','SchÃ¶n :)\r\n \r\nOn 2009-09-14, at 02:47, Jones wrote:\r\n> Geht Doch!\r\n>  \r\n> On 2009-09-14, at 02:47, TheAbcGuy wrote:\r\n> > Quux',0,0,0),
	('4aada4a4-7c14-41b0-9963-01a98784ca84','2009-09-14 04:04:20','2009-09-14 04:04:20','4a648ce4-08a4-46e2-91f8-024a8784ca84',NULL,'4a8f0408-6568-49bc-9b81-017a8784ca84','4a8f0408-6568-49bc-9b81-017a8784ca84','4a93f845-c860-40d4-81ec-00e68784ca84','Re: Thats a Message From X to Y','gnar\r\n \r\nOn 2009-07-26, at 14:03, TheAbcGuy wrote:\r\n> esque eget, sodales vel nunc. Cras sodales egestas eleifend. Quisque nec eros lacus. Etiam vehicula risus eget tellus interdum dignissim. Duis vulputate molestie ante ut facilisis. Praesent fermentum facilisis vehicula.\r\n> \r\n> Pellentesque non nulla felis. Duis est neque, eleifend nec ultricies non, viverra non urna. Donec augue massa, rutrum sit amet rutrum tempor, vehicula ac elit. Mauris ultrices lobortis ante, id convallis sem elementum malesuada. Donec congue dolor a magna volutpat elementum tristique elit ultrices. Proin sollicitudin sapien non nunc hendrerit fringilla. Maecenas accumsan ante et felis fringilla sodales. Donec nec diam dolor. Cras est elit, pretium id vulputate at, dapibus eu nibh. Pellentesque at mi et sapien consequat blandit. Mauris sodales, nisl vel aliquam viverra, augue ipsum vulputate est, non sodales orci nulla eget neque. Donec arcu neque, rutrum at iaculis nec, interdum ut eros. Curabitur nisi dolor, faucibus eget congue vitae, congue vitae mi.\r\n> \r\n> Vivamus arcu enim, dignissim quis sollicitudin eget, accumsan quis quam. Nam diam eros, semper sit amet tempor eget, sodales viverra massa. Curabitur vel posuere urna. Proin non sapien quis ipsum dapibus adipiscing quis a est. Praesent eu blandit ligula. Praesent interdum est a nunc porttitor euismod. Pellentesque ut magna id erat posuere pulvinar. In ante mauris, sollicitudin eget sodales vitae, lacinia nec ligula. Etiam eget ligula nulla. Suspendisse eget blandit est. Sed vehicula lacinia massa, sit amet interdum lorem volutpat at. Nunc ac laoreet erat. Duis eget lacus quis orci pharetra eleifend. Donec turpis dolor, egestas eget placerat sed, dapibus ut turpis. In et ante ut urna dictum euismod. Suspendisse tincidunt mi vitae magna accumsan non suscipit dui eleifend. Phasellus dui tellus, posuere nec ullamcorper ac, fermentum vitae magna. Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia Curae;\r\n> \r\n> Vestibulum mi justo, euismod at tincidunt ut, bibendum molestie leo. Vivamus lacus ante, molestie eget porttitor vitae, sagittis ut tellus. Integer eu neque et urna interdum dictum vel a nisl. Aliquam vitae purus eget magna pharetra interdum. Sed ac nibh sem. Quisque dictum bibendum ullamcorper. Nunc ullamcorper blandit nulla id rutrum. Duis id libero et erat sollicitudin aliquet id in sapien. Vivamus fringilla, metus semper blandit scelerisque, risus massa faucibus metus, at laoreet augue metus et nunc. In hac habitasse platea dictumst. Cras dolor velit, ultricies sed commodo nec, dignissim gravida arcu. Morbi sit amet elit ante. Suspendisse arcu ligula, malesuada sit amet euismod a, adipiscing at turpis. Mauris bibendum, nisi eget condimentum rutrum, sem lorem placerat arcu, sed tincidunt nisl nunc lacinia felis. Duis rhoncus gravida accumsan. Vestibulum dignissim quam in velit rhoncus ut interdum nisl consequat. Praesent dignissim vulputate dapibus. Mauris orci sapien, consequat a viverra et, hendrerit non dui.\r\n> \r\n> Duis scelerisque feugiat risus quis eleifend. Aliquam id dolor leo. Duis tellus risus, ornare et laoreet eget, volutpat eu risus. Duis pharetra lorem eget nibh dignissim sit amet molestie est egestas. Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos. Cras arcu dolor, tincidunt eget tristique vel, ultricies ac magna. Nulla vitae lacus sed dolor dignissim sollicitudin a sit amet metus. Ut ac nisl non urna aliquam lobortis id sed diam',0,0,0),
	('4aada4a4-bb4c-4ecf-8400-01a98784ca84','2009-09-14 04:04:20','2009-09-14 04:04:20','4a841aaa-6be4-4851-a666-00e38784ca84',NULL,'4a93f845-c860-40d4-81ec-00e68784ca84','4a8f0408-6568-49bc-9b81-017a8784ca84','4a93f845-c860-40d4-81ec-00e68784ca84','Re: Thats a Message From X to Y','gnar\r\n \r\nOn 2009-07-26, at 14:03, TheAbcGuy wrote:\r\n> esque eget, sodales vel nunc. Cras sodales egestas eleifend. Quisque nec eros lacus. Etiam vehicula risus eget tellus interdum dignissim. Duis vulputate molestie ante ut facilisis. Praesent fermentum facilisis vehicula.\r\n> \r\n> Pellentesque non nulla felis. Duis est neque, eleifend nec ultricies non, viverra non urna. Donec augue massa, rutrum sit amet rutrum tempor, vehicula ac elit. Mauris ultrices lobortis ante, id convallis sem elementum malesuada. Donec congue dolor a magna volutpat elementum tristique elit ultrices. Proin sollicitudin sapien non nunc hendrerit fringilla. Maecenas accumsan ante et felis fringilla sodales. Donec nec diam dolor. Cras est elit, pretium id vulputate at, dapibus eu nibh. Pellentesque at mi et sapien consequat blandit. Mauris sodales, nisl vel aliquam viverra, augue ipsum vulputate est, non sodales orci nulla eget neque. Donec arcu neque, rutrum at iaculis nec, interdum ut eros. Curabitur nisi dolor, faucibus eget congue vitae, congue vitae mi.\r\n> \r\n> Vivamus arcu enim, dignissim quis sollicitudin eget, accumsan quis quam. Nam diam eros, semper sit amet tempor eget, sodales viverra massa. Curabitur vel posuere urna. Proin non sapien quis ipsum dapibus adipiscing quis a est. Praesent eu blandit ligula. Praesent interdum est a nunc porttitor euismod. Pellentesque ut magna id erat posuere pulvinar. In ante mauris, sollicitudin eget sodales vitae, lacinia nec ligula. Etiam eget ligula nulla. Suspendisse eget blandit est. Sed vehicula lacinia massa, sit amet interdum lorem volutpat at. Nunc ac laoreet erat. Duis eget lacus quis orci pharetra eleifend. Donec turpis dolor, egestas eget placerat sed, dapibus ut turpis. In et ante ut urna dictum euismod. Suspendisse tincidunt mi vitae magna accumsan non suscipit dui eleifend. Phasellus dui tellus, posuere nec ullamcorper ac, fermentum vitae magna. Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia Curae;\r\n> \r\n> Vestibulum mi justo, euismod at tincidunt ut, bibendum molestie leo. Vivamus lacus ante, molestie eget porttitor vitae, sagittis ut tellus. Integer eu neque et urna interdum dictum vel a nisl. Aliquam vitae purus eget magna pharetra interdum. Sed ac nibh sem. Quisque dictum bibendum ullamcorper. Nunc ullamcorper blandit nulla id rutrum. Duis id libero et erat sollicitudin aliquet id in sapien. Vivamus fringilla, metus semper blandit scelerisque, risus massa faucibus metus, at laoreet augue metus et nunc. In hac habitasse platea dictumst. Cras dolor velit, ultricies sed commodo nec, dignissim gravida arcu. Morbi sit amet elit ante. Suspendisse arcu ligula, malesuada sit amet euismod a, adipiscing at turpis. Mauris bibendum, nisi eget condimentum rutrum, sem lorem placerat arcu, sed tincidunt nisl nunc lacinia felis. Duis rhoncus gravida accumsan. Vestibulum dignissim quam in velit rhoncus ut interdum nisl consequat. Praesent dignissim vulputate dapibus. Mauris orci sapien, consequat a viverra et, hendrerit non dui.\r\n> \r\n> Duis scelerisque feugiat risus quis eleifend. Aliquam id dolor leo. Duis tellus risus, ornare et laoreet eget, volutpat eu risus. Duis pharetra lorem eget nibh dignissim sit amet molestie est egestas. Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos. Cras arcu dolor, tincidunt eget tristique vel, ultricies ac magna. Nulla vitae lacus sed dolor dignissim sollicitudin a sit amet metus. Ut ac nisl non urna aliquam lobortis id sed diam',0,0,0),
	('4aada577-5a70-4ae4-9f45-287a50431c29','2009-09-14 04:07:51','2009-09-14 04:07:51','4a648ce4-08a4-46e2-91f8-024a8784ca84',NULL,'4a8f0408-6568-49bc-9b81-017a8784ca84','4a8f0408-6568-49bc-9b81-017a8784ca84','4a93f845-c860-40d4-81ec-00e68784ca84','Re: Thats a Message From X to Y','This works, YIPPI!!!',0,0,0),
	('4aada577-994c-407e-ba56-287a50431c29','2009-09-14 04:07:51','2009-09-14 04:07:51','4a841aaa-6be4-4851-a666-00e38784ca84',NULL,'4a93f845-c860-40d4-81ec-00e68784ca84','4a8f0408-6568-49bc-9b81-017a8784ca84','4a93f845-c860-40d4-81ec-00e68784ca84','Re: Thats a Message From X to Y','This works, YIPPI!!!',0,0,0);

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
	('4a8f0408-6568-49bc-9b81-017a8784ca84','2009-08-21 22:31:04','2009-08-25 16:42:38','4a648ce4-08a4-46e2-91f8-024a8784ca84',0,0,'Jones','1984-06-15 00:00:00','InTheBar'),
	('4a93f845-c860-40d4-81ec-00e68784ca84','2009-08-25 16:42:13','2009-08-25 16:42:28','4a841aaa-6be4-4851-a666-00e38784ca84',0,0,'TheAbcGuy','1984-06-15 00:00:00','ABC');

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
  `last_login` datetime default NULL,
  `email` varchar(200) NOT NULL,
  `activation_key` varchar(19) NOT NULL default '',
  `password_reset_key` varchar(19) default '',
  PRIMARY KEY  (`id`),
  UNIQUE KEY `UNIQUE_USERNAME` (`username`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` (`id`,`created`,`modified`,`is_deleted`,`is_disabled`,`has_accepted_tos`,`username`,`password`,`last_login`,`email`,`activation_key`,`password_reset_key`)
VALUES
	('4a648ce4-08a4-46e2-91f8-024a8784ca84','2009-08-03 16:15:22','2009-09-14 04:07:03',0,0,1,'ionas','d234c827a80548e868cac076365c483fcdfadb80050a682fffd67a42e1dd012b','2009-09-14 04:07:03','ionas@sna.dev','',''),
	('4a841aaa-6be4-4851-a666-00e38784ca84','2009-08-13 15:52:42','2009-09-14 02:47:59',0,0,1,'abc','d234c827a80548e868cac076365c483fcdfadb80050a682fffd67a42e1dd012b','2009-09-14 02:47:59','sna@mailinator.com','','');

/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;





/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
