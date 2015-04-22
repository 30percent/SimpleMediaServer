-- MySQL dump 10.13  Distrib 5.5.41, for debian-linux-gnu (x86_64)
--
-- Host: mysql1.cs.clemson.edu    Database: metube_u4an
-- ------------------------------------------------------
-- Server version	5.5.41-0ubuntu0.12.04.1

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `category`
--

DROP TABLE IF EXISTS `category`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `category` (
  `cid` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(25) DEFAULT NULL,
  PRIMARY KEY (`cid`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `mailbox`
--

DROP TABLE IF EXISTS `mailbox`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `mailbox` (
  `meid` int(11) NOT NULL AUTO_INCREMENT,
  `uid` int(11) DEFAULT NULL,
  `suid` int(11) DEFAULT NULL,
  `title` varchar(45) DEFAULT NULL,
  `date_sent` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `message` varchar(1000) DEFAULT NULL,
  `unread` int(11) DEFAULT '1',
  PRIMARY KEY (`meid`),
  KEY `User_idx` (`uid`),
  KEY `Sender_idx` (`suid`),
  CONSTRAINT `MailUser` FOREIGN KEY (`uid`) REFERENCES `user` (`uid`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `Sender` FOREIGN KEY (`suid`) REFERENCES `user` (`uid`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `media`
--

DROP TABLE IF EXISTS `media`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `media` (
  `mid` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(45) DEFAULT NULL,
  `description` varchar(300) DEFAULT NULL,
  `type` varchar(45) DEFAULT NULL,
  `date_created` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `viewcount` int(11) DEFAULT '0',
  `path` varchar(150) DEFAULT 'media/default.mp3',
  `uid` int(11) DEFAULT NULL,
  `cid` int(11) DEFAULT NULL,
  `imagepath` varchar(100) NOT NULL DEFAULT 'media/default.png',
  PRIMARY KEY (`mid`),
  KEY `uid_idx` (`uid`),
  KEY `Category_idx` (`cid`),
  CONSTRAINT `Category` FOREIGN KEY (`cid`) REFERENCES `category` (`cid`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `MediaUser` FOREIGN KEY (`uid`) REFERENCES `user` (`uid`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=28 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `mediacomment`
--

DROP TABLE IF EXISTS `mediacomment`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `mediacomment` (
  `cid` int(11) NOT NULL AUTO_INCREMENT,
  `mid` int(11) DEFAULT NULL,
  `uid` int(11) DEFAULT NULL,
  `date_sent` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `message` varchar(500) DEFAULT NULL,
  PRIMARY KEY (`cid`),
  KEY `Media_idx` (`mid`),
  KEY `User_idx` (`uid`),
  CONSTRAINT `ComMedia` FOREIGN KEY (`mid`) REFERENCES `media` (`mid`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `ComUser` FOREIGN KEY (`uid`) REFERENCES `user` (`uid`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `mediatag`
--

DROP TABLE IF EXISTS `mediatag`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `mediatag` (
  `tid` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(125) DEFAULT NULL,
  `mid` int(11) DEFAULT NULL,
  PRIMARY KEY (`tid`),
  KEY `Media_idx` (`mid`),
  CONSTRAINT `TagMedia` FOREIGN KEY (`mid`) REFERENCES `media` (`mid`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=20 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Temporary table structure for view `mediauser`
--

DROP TABLE IF EXISTS `mediauser`;
/*!50001 DROP VIEW IF EXISTS `mediauser`*/;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
/*!50001 CREATE TABLE `mediauser` (
  `mid` tinyint NOT NULL,
  `title` tinyint NOT NULL,
  `type` tinyint NOT NULL,
  `date_created` tinyint NOT NULL,
  `imagepath` tinyint NOT NULL,
  `username` tinyint NOT NULL,
  `uid` tinyint NOT NULL,
  `path` tinyint NOT NULL,
  `cid` tinyint NOT NULL
) ENGINE=MyISAM */;
SET character_set_client = @saved_cs_client;

--
-- Table structure for table `playlist`
--

DROP TABLE IF EXISTS `playlist`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `playlist` (
  `pid` int(11) NOT NULL AUTO_INCREMENT,
  `uid` int(11) DEFAULT NULL,
  `title` varchar(60) DEFAULT NULL,
  `share` int(11) DEFAULT NULL,
  PRIMARY KEY (`pid`),
  UNIQUE KEY `title` (`title`),
  KEY `PlaylistUser` (`uid`),
  CONSTRAINT `PlaylistUser` FOREIGN KEY (`uid`) REFERENCES `user` (`uid`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `playlistcontents`
--

DROP TABLE IF EXISTS `playlistcontents`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `playlistcontents` (
  `pid` int(11) NOT NULL,
  `mid` int(11) NOT NULL,
  `ordnum` int(11) DEFAULT NULL,
  PRIMARY KEY (`pid`,`mid`),
  KEY `Media_idx` (`mid`),
  CONSTRAINT `ContPlaylist` FOREIGN KEY (`pid`) REFERENCES `playlist` (`pid`) ON DELETE CASCADE ON UPDATE NO ACTION,
  CONSTRAINT `PlaylistMedia` FOREIGN KEY (`mid`) REFERENCES `media` (`mid`) ON DELETE CASCADE ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Temporary table structure for view `populartags`
--

DROP TABLE IF EXISTS `populartags`;
/*!50001 DROP VIEW IF EXISTS `populartags`*/;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
/*!50001 CREATE TABLE `populartags` (
  `Name` tinyint NOT NULL,
  `Count` tinyint NOT NULL
) ENGINE=MyISAM */;
SET character_set_client = @saved_cs_client;

--
-- Table structure for table `subscription`
--

DROP TABLE IF EXISTS `subscription`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `subscription` (
  `uid` int(11) NOT NULL,
  `subid` int(11) NOT NULL,
  PRIMARY KEY (`uid`,`subid`),
  KEY `Subscription_idx` (`subid`),
  CONSTRAINT `SubUser` FOREIGN KEY (`uid`) REFERENCES `user` (`uid`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `Subscription` FOREIGN KEY (`subid`) REFERENCES `user` (`uid`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `user`
--

DROP TABLE IF EXISTS `user`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `user` (
  `uid` int(11) NOT NULL AUTO_INCREMENT,
  `email` varchar(45) NOT NULL,
  `username` varchar(45) NOT NULL,
  `password` varchar(45) NOT NULL,
  PRIMARY KEY (`uid`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Final view structure for view `mediauser`
--

/*!50001 DROP TABLE IF EXISTS `mediauser`*/;
/*!50001 DROP VIEW IF EXISTS `mediauser`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8 */;
/*!50001 SET character_set_results     = utf8 */;
/*!50001 SET collation_connection      = utf8_general_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`metube_vcgu`@`%` SQL SECURITY DEFINER */
/*!50001 VIEW `mediauser` AS select `media`.`mid` AS `mid`,`media`.`title` AS `title`,`media`.`type` AS `type`,`media`.`date_created` AS `date_created`,`media`.`imagepath` AS `imagepath`,`user`.`username` AS `username`,`media`.`uid` AS `uid`,`media`.`path` AS `path`,`media`.`cid` AS `cid` from (`media` join `user` on((`user`.`uid` = `media`.`uid`))) */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `populartags`
--

/*!50001 DROP TABLE IF EXISTS `populartags`*/;
/*!50001 DROP VIEW IF EXISTS `populartags`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8 */;
/*!50001 SET character_set_results     = utf8 */;
/*!50001 SET collation_connection      = utf8_general_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`metube_vcgu`@`%` SQL SECURITY DEFINER */
/*!50001 VIEW `populartags` AS select `mediatag`.`name` AS `Name`,count(`mediatag`.`name`) AS `Count` from `mediatag` group by `mediatag`.`name` order by count(`mediatag`.`name`) desc */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2015-04-21 20:11:38
