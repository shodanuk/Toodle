# Sequel Pro dump
# Version 2492
# http://code.google.com/p/sequel-pro
#
# Host: 127.0.0.1 (MySQL 5.1.42)
# Database: toodle
# Generation Time: 2011-04-23 21:07:04 +0100
# ************************************************************

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


# Dump of table todos
# ------------------------------------------------------------

DROP TABLE IF EXISTS `todos`;

CREATE TABLE `todos` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `description` text NOT NULL,
  `due_date` datetime NOT NULL,
  `complete` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `date_added` datetime NOT NULL,
  `date_modified` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8;

LOCK TABLES `todos` WRITE;
/*!40000 ALTER TABLE `todos` DISABLE KEYS */;
INSERT INTO `todos` (`id`,`description`,`due_date`,`complete`,`date_added`,`date_modified`)
VALUES
	(1,'Where did my description go?','2011-04-23 16:30:00',0,'2011-04-21 22:47:48','0000-00-00 00:00:00'),
	(2,'Invade China','2011-04-24 07:30:00',0,'2011-04-21 22:47:48','0000-00-00 00:00:00'),
	(3,'Start astronaut training at NASA.','2011-04-24 07:30:00',0,'2011-04-21 22:47:48','0000-00-00 00:00:00'),
	(4,'Solve the riddle of the meaning of life. Post on Reddit. Sit back and relax as upvotes flood in.','2011-04-25 12:10:00',0,'2011-04-21 22:47:48','0000-00-00 00:00:00'),
	(5,'Find all missing socks','2011-04-25 13:08:00',0,'2011-04-21 22:47:48','0000-00-00 00:00:00'),
	(6,'Win Premier League with a team consisting only of Ali Dia clones.','2011-04-27 10:40:00',0,'2011-04-21 22:47:48','0000-00-00 00:00:00'),
	(7,'Learn the language of the ghetto.','2011-04-28 15:50:00',0,'2011-04-21 22:47:48','0000-00-00 00:00:00'),
	(8,'Rewrite Sesame Street to feature more cats and less spelling.','2011-04-29 23:07:00',0,'2011-04-21 22:47:48','0000-00-00 00:00:00'),
	(9,'Consume own body weight in red liquorice.','2011-05-30 10:45:00',0,'2011-04-21 22:47:48','0000-00-00 00:00:00'),
	(10,'Finish writing this bloody test data','2011-05-28 14:35:00',1,'2011-04-21 22:47:48','0000-00-00 00:00:00'),
	(11,'Im so bored of writing this now','2011-05-29 09:12:00',0,'2011-04-21 22:47:48','0000-00-00 00:00:00'),
	(12,'How many more of these do I have to do?','2011-06-03 11:00:00',0,'2011-04-21 22:47:48','0000-00-00 00:00:00'),
	(13,'Oh, 2 more.','2011-06-05 16:30:00',0,'2011-04-21 22:47:48','0000-00-00 00:00:00'),
	(14,'Almost there','2011-06-10 07:30:00',0,'2011-04-21 22:47:48','0000-00-00 00:00:00'),
	(15,'YYEESSS. It\'s finished. Finally.','2011-06-11 07:30:00',1,'2011-04-21 22:47:48','0000-00-00 00:00:00');

/*!40000 ALTER TABLE `todos` ENABLE KEYS */;
UNLOCK TABLES;





/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
