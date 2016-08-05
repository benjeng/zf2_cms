-- MySQL dump 10.13  Distrib 5.5.28, for osx10.6 (i386)
--
-- Host: localhost    Database: symfony
-- ------------------------------------------------------
-- Server version	5.5.28

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
-- Table structure for table `cms_article`
--

DROP TABLE IF EXISTS `cms_article`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `cms_article` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `type` varchar(30) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'article',
  `cms_title` varchar(50) COLLATE utf8_unicode_ci DEFAULT '',
  `cms_template` varchar(30) COLLATE utf8_unicode_ci DEFAULT NULL,
  `cms_url` varchar(255) COLLATE utf8_unicode_ci DEFAULT '',
  `cms_slug` varchar(255) COLLATE utf8_unicode_ci DEFAULT '',
  `cms_module` varchar(30) COLLATE utf8_unicode_ci DEFAULT NULL,
  `cms_controller` varchar(128) COLLATE utf8_unicode_ci DEFAULT NULL,
  `publish_from` datetime DEFAULT NULL,
  `publish_to` datetime DEFAULT NULL,
  `is_enabled` tinyint(1) NOT NULL DEFAULT '0',
  `is_deleted` tinyint(1) NOT NULL DEFAULT '0',
  `is_locked` tinyint(1) NOT NULL DEFAULT '0',
  `json` text COLLATE utf8_unicode_ci,
  `btime` datetime DEFAULT NULL,
  `ctime` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=72 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cms_article`
--

LOCK TABLES `cms_article` WRITE;
/*!40000 ALTER TABLE `cms_article` DISABLE KEYS */;
INSERT INTO `cms_article` VALUES (26,'article','TEST2','test','test2','test2','test2','test2','0000-00-00 00:00:00',NULL,1,0,0,NULL,'0000-00-00 00:00:00','2013-07-24 22:55:04'),(34,'article','TEST22','test','test22','test2','test2','test2','0000-00-00 00:00:00',NULL,1,0,0,'{\"test2\":\"asassa\",\"submit\":\"Save\",\"test44\":\"\\/dollhouse.jpg\"}','0000-00-00 00:00:00','2013-08-20 08:10:06'),(41,'article','asdasdasd123','default','/asdasdasd123','test','test','test','2013-01-01 00:00:00',NULL,0,0,0,'{\"submit\":\"Save\",\"test2\":\"55444\",\"test44\":\"\\/tree_data2.json\",\"content\":\"\"}','0000-00-00 00:00:00','2013-08-04 11:37:46'),(49,'article','TEST','home','test','test','test','test','0000-00-00 00:00:00',NULL,1,0,0,'{\"submit\":\"Save\",\"test2\":\"\",\"test44\":\"\"}','0000-00-00 00:00:00','2013-08-04 11:37:44'),(71,'article','BenJeng','default','',NULL,NULL,NULL,NULL,NULL,0,0,0,'{\"submit\":\"Save\"}',NULL,'2013-08-04 11:37:46');
/*!40000 ALTER TABLE `cms_article` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cms_category`
--

DROP TABLE IF EXISTS `cms_category`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `cms_category` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `type` varchar(50) NOT NULL DEFAULT '',
  `title` varchar(100) NOT NULL DEFAULT '',
  `parent_id` int(11) DEFAULT NULL,
  `json` text,
  `sortorder` int(11) DEFAULT NULL,
  `is_enabled` tinyint(1) NOT NULL,
  `is_deleted` tinyint(1) NOT NULL,
  `is_locked` tinyint(1) NOT NULL,
  `btime` datetime DEFAULT NULL,
  `ctime` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cms_category`
--

LOCK TABLES `cms_category` WRITE;
/*!40000 ALTER TABLE `cms_category` DISABLE KEYS */;
INSERT INTO `cms_category` VALUES (2,'product','TEST',0,'{\"submit\":\"Save\"}',NULL,0,0,0,NULL,NULL);
/*!40000 ALTER TABLE `cms_category` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cms_node`
--

DROP TABLE IF EXISTS `cms_node`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `cms_node` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `obj_id` int(11) DEFAULT NULL,
  `obj_table` varchar(30) DEFAULT NULL,
  `root_id` int(11) DEFAULT NULL,
  `type` varchar(30) DEFAULT NULL,
  `cms_template` varchar(30) DEFAULT NULL,
  `json` text,
  `is_enabled` tinyint(1) DEFAULT NULL,
  `sortorder` int(11) DEFAULT NULL,
  `btime` datetime DEFAULT NULL,
  `ctime` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=57 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cms_node`
--

LOCK TABLES `cms_node` WRITE;
/*!40000 ALTER TABLE `cms_node` DISABLE KEYS */;
INSERT INTO `cms_node` VALUES (4,41,'article',0,'test',NULL,NULL,1,NULL,'2013-07-29 22:26:45',NULL),(48,49,'article',0,NULL,NULL,NULL,1,NULL,'2013-08-04 13:07:13',NULL),(49,41,'article',4,'test','test','{\"title\":\"asasdasd\",\"submit\":\"Save\"}',1,NULL,NULL,NULL),(50,71,'article',0,NULL,NULL,NULL,1,NULL,'2013-08-22 02:54:23',NULL),(51,3,'article',0,NULL,NULL,NULL,1,NULL,'2013-08-24 21:17:23',NULL),(52,71,'article',50,'article','article','{\"title\":\"aa\",\"submit\":\"Save\"}',1,NULL,NULL,NULL),(53,71,'article',50,'article','article','{\"title\":\"bbb\",\"submit\":\"Save\"}',1,NULL,NULL,NULL),(54,34,'article',0,NULL,NULL,NULL,1,NULL,'2014-10-24 04:40:56',NULL),(55,34,'article',54,'test','test','{\"title\":\"haa\",\"submit\":\"Save\",\"node_field1\":\"\",\"node_field2\":\"\\/card3.jpg\"}',1,NULL,NULL,NULL),(56,26,'article',0,NULL,NULL,NULL,1,NULL,'2014-10-25 11:06:28',NULL);
/*!40000 ALTER TABLE `cms_node` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cms_page_template`
--

DROP TABLE IF EXISTS `cms_page_template`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `cms_page_template` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(40) DEFAULT NULL,
  `project` varchar(40) DEFAULT NULL,
  `btime` datetime DEFAULT NULL,
  `ctime` datetime DEFAULT NULL,
  `buser` varchar(40) DEFAULT NULL,
  `cuser` varchar(40) DEFAULT NULL,
  `json` text,
  `sortorder` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cms_page_template`
--

LOCK TABLES `cms_page_template` WRITE;
/*!40000 ALTER TABLE `cms_page_template` DISABLE KEYS */;
INSERT INTO `cms_page_template` VALUES (1,'default',NULL,NULL,NULL,NULL,NULL,NULL,NULL);
/*!40000 ALTER TABLE `cms_page_template` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cms_product`
--

DROP TABLE IF EXISTS `cms_product`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `cms_product` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(200) DEFAULT NULL,
  `type` varchar(30) DEFAULT NULL,
  `sub_type` varchar(30) DEFAULT NULL,
  `rrp` decimal(11,2) DEFAULT NULL,
  `url` varchar(200) DEFAULT NULL,
  `json` text,
  `is_enabled` tinyint(1) DEFAULT NULL,
  `is_deleted` tinyint(1) DEFAULT NULL,
  `is_locked` tinyint(1) DEFAULT NULL,
  `btime` datetime DEFAULT NULL,
  `ctime` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cms_product`
--

LOCK TABLES `cms_product` WRITE;
/*!40000 ALTER TABLE `cms_product` DISABLE KEYS */;
INSERT INTO `cms_product` VALUES (1,'MBP 2012','product',NULL,1002.00,'/mbp-2012','{\"note\":\"\",\"submit\":\"Save\",\"capacity\":\"\",\"pic1\":\"\\/dollhouse.jpg\"}',1,0,0,NULL,'2013-08-20 08:10:43'),(3,'HelloKitty','combine',NULL,NULL,'','{\"submit\":\"Save\"}',0,0,0,NULL,'2013-08-24 21:17:41');
/*!40000 ALTER TABLE `cms_product` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cms_user`
--

DROP TABLE IF EXISTS `cms_user`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `cms_user` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `login` varchar(30) DEFAULT NULL,
  `username` varchar(40) DEFAULT NULL,
  `password` varchar(40) DEFAULT NULL,
  `roles` varchar(100) DEFAULT NULL,
  `json` text,
  `status` int(11) DEFAULT NULL,
  `btime` datetime DEFAULT NULL,
  `ctime` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cms_user`
--

LOCK TABLES `cms_user` WRITE;
/*!40000 ALTER TABLE `cms_user` DISABLE KEYS */;
INSERT INTO `cms_user` VALUES (1,'admin','Administrator','348162101fc6f7e624681b7400b085eeac6df7bd',NULL,'{\"name\":\"123\",\"description\":\"\",\"sidebar_is_enabled\":false,\"payment_is_enabled\":false,\"payment_amount\":10,\"payment_receiver\":\"ben@brownpaperbag.co.nz\",\"payment_submitter\":\"\",\"payment_remitter\":\"Daughter\'s name\",\"heading_image\":\"\",\"download_file_receiver\":\"\",\"download_file_asubmit\":\"\",\"download_file_asubmit_msg_1\":\"\",\"download_file_asubmit_msg_2\":\"\",\"email_content_pdf\":\"\",\"email_content_hardcopy\":\"\",\"email_content\":\"Dear  assad \\n\\nThank you for applying to Diocesan School for Girls. We look forward to meeting you and asdasdas. fdslkjdfslkjdfs\\n\\nKind regards\\nMartin Wong\",\"email_title\":\"Your application to Diocesan School for Girls\",\"email_receiver\":\"ben@brownpaperbag.co.nz\",\"email_bcc\":\"ben@brownpaperbag.co.nz; weezer77@seed.net.tw\",\"email_waiting\":\"now\",\"email_is_enabled\":true,\"fields\":[{\"type\":\"text\",\"title\":\"Name\",\"is_required\":false,\"instructions\":\"\",\"choices\":[],\"is_randomized\":null},{\"type\":\"email\",\"title\":\"Email 3\",\"is_required\":false,\"instructions\":\"\",\"choices\":[],\"is_randomized\":null},{\"type\":\"text\",\"title\":\"Daughter\'s name\",\"is_required\":false,\"instructions\":\"\",\"choices\":[],\"is_randomized\":null}],\"values\":{\"field0\":\"assad\",\"field1\":\"ben@brownpaperbag.co.nz\",\"field2\":\"asdasdas\",\"form_id\":\"\"}}',1,'0000-00-00 00:00:00',NULL);
/*!40000 ALTER TABLE `cms_user` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `seo`
--

DROP TABLE IF EXISTS `seo`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `seo` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `object` varchar(30) DEFAULT NULL,
  `obj_id` int(11) DEFAULT NULL,
  `seo_title` varchar(100) DEFAULT NULL,
  `seo_description` varchar(300) DEFAULT NULL,
  `seo_keywords` varchar(300) DEFAULT NULL,
  `btime` datetime DEFAULT NULL,
  `ctime` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=24 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `seo`
--

LOCK TABLES `seo` WRITE;
/*!40000 ALTER TABLE `seo` DISABLE KEYS */;
INSERT INTO `seo` VALUES (1,'article',65,'Hello','asjldkajsdl askdj alsdj alskjd asd jalskdj alsdj asdj ','abv, def, sdad','2013-07-28 16:19:07',NULL),(2,'article',33,NULL,NULL,NULL,'2013-07-28 16:42:13',NULL),(3,'article',41,'','','','2013-07-28 16:45:55',NULL),(4,'article',70,'This is a test','','','2013-07-28 17:06:39',NULL),(5,'article',69,NULL,NULL,NULL,'2013-07-29 10:52:37',NULL),(6,'article',71,NULL,NULL,NULL,'2013-07-30 20:24:51',NULL),(7,'article',49,NULL,NULL,NULL,'2013-07-30 20:58:58',NULL),(8,'article',50,NULL,NULL,NULL,'2013-08-01 01:01:15',NULL),(9,'article',35,NULL,NULL,NULL,'2013-08-01 01:01:21',NULL),(10,'article',26,NULL,NULL,NULL,'2013-08-03 11:29:15',NULL),(11,'article',27,NULL,NULL,NULL,'2013-08-03 11:29:31',NULL),(12,'article',29,NULL,NULL,NULL,'2013-08-03 11:30:08',NULL),(13,'article',43,NULL,NULL,NULL,'2013-08-03 21:14:11',NULL),(14,'article',34,NULL,NULL,NULL,'2013-08-03 21:14:18',NULL),(15,'article',45,NULL,NULL,NULL,'2013-08-20 08:09:04',NULL),(19,'product',3,'Hello Kitty','','','2013-08-24 21:57:37',NULL),(20,'product',1,NULL,NULL,NULL,'2013-09-12 08:55:24',NULL),(21,'product',4,NULL,NULL,NULL,'2013-09-12 09:47:05',NULL),(22,'category',1,NULL,NULL,NULL,'2013-09-12 09:48:49',NULL),(23,'category',2,NULL,NULL,NULL,'2013-09-12 10:43:52',NULL);
/*!40000 ALTER TABLE `seo` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2014-11-05  9:05:43
