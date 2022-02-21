-- MySQL dump 10.13  Distrib 5.7.36, for Linux (x86_64)
--
-- Host: localhost    Database: bartosz-lauks-engineering-project_dev
-- ------------------------------------------------------
-- Server version	5.7.36

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
-- Table structure for table `advertising`
--

DROP TABLE IF EXISTS `advertising`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `advertising` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `file` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `due_date` datetime DEFAULT NULL,
  `url` longtext COLLATE utf8mb4_unicode_ci,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `advertising`
--

LOCK TABLES `advertising` WRITE;
/*!40000 ALTER TABLE `advertising` DISABLE KEYS */;
INSERT INTO `advertising` VALUES (1,'aeeb0a492562e1e0b8885e51d912d44d5631a2fe.gif','2022-01-31 17:56:28','2022-02-28 18:55:00','https://www.ujd.edu.pl/'),(2,'c2617b7e480ce32e05f631396421e6c48d3299c0.gif','2022-01-31 17:57:45','2022-02-28 18:57:00','https://www.ujd.edu.pl/'),(3,'4bd1270b57f5023e76a82e8c16848b5886e2e755.png','2022-01-31 17:58:21','2022-02-28 18:58:00','https://www.ujd.edu.pl/');
/*!40000 ALTER TABLE `advertising` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `brand`
--

DROP TABLE IF EXISTS `brand`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `brand` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` longtext COLLATE utf8mb4_unicode_ci,
  `created_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `brand`
--

LOCK TABLES `brand` WRITE;
/*!40000 ALTER TABLE `brand` DISABLE KEYS */;
INSERT INTO `brand` VALUES (12,'BMW',NULL,'2022-01-31 13:44:08'),(13,'Audi',NULL,'2022-01-31 13:44:16');
/*!40000 ALTER TABLE `brand` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `car_body`
--

DROP TABLE IF EXISTS `car_body`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `car_body` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `generation_id` int(11) DEFAULT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` longtext COLLATE utf8mb4_unicode_ci,
  `created_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_10C21F1E553A6EC4` (`generation_id`),
  CONSTRAINT `FK_10C21F1E553A6EC4` FOREIGN KEY (`generation_id`) REFERENCES `generation` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=24 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `car_body`
--

LOCK TABLES `car_body` WRITE;
/*!40000 ALTER TABLE `car_body` DISABLE KEYS */;
INSERT INTO `car_body` VALUES (8,11,'Cabrio E88',NULL,'2022-01-31 14:09:55'),(9,11,'Hatchback 3d E81',NULL,'2022-01-31 14:15:41'),(10,11,'M Coupe',NULL,'2022-01-31 14:15:55'),(11,12,'Hatchback 3d F20',NULL,'2022-01-31 15:24:47'),(12,12,'Hatchback 5d F20',NULL,'2022-01-31 15:25:08'),(13,13,'Hatchback F40',NULL,'2022-01-31 15:30:55'),(14,14,'Cabrio',NULL,'2022-01-31 16:11:06'),(15,14,'Coupe',NULL,'2022-01-31 16:11:14'),(20,15,'Active Tourer',NULL,'2022-01-31 16:20:07'),(22,15,'M Coupe CS',NULL,'2022-01-31 16:22:44'),(23,16,'Lang',NULL,'2022-01-31 16:33:09');
/*!40000 ALTER TABLE `car_body` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `car_body_property`
--

DROP TABLE IF EXISTS `car_body_property`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `car_body_property` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `property` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `car_body_property`
--

LOCK TABLES `car_body_property` WRITE;
/*!40000 ALTER TABLE `car_body_property` DISABLE KEYS */;
INSERT INTO `car_body_property` VALUES (1,'Number of doors','2022-01-31 16:37:04'),(2,'Number of seats','2022-01-31 16:37:38'),(3,'Length','2022-01-31 16:37:43'),(4,'Width','2022-01-31 16:37:47'),(5,'Height','2022-01-31 16:37:51'),(6,'Wheelbase','2022-01-31 16:38:03');
/*!40000 ALTER TABLE `car_body_property` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `car_body_value`
--

DROP TABLE IF EXISTS `car_body_value`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `car_body_value` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `car_body_id` int(11) DEFAULT NULL,
  `property_id` int(11) DEFAULT NULL,
  `value` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_8C4152EDC8C9E658` (`car_body_id`),
  KEY `IDX_8C4152ED549213EC` (`property_id`),
  CONSTRAINT `FK_8C4152ED549213EC` FOREIGN KEY (`property_id`) REFERENCES `car_body_property` (`id`),
  CONSTRAINT `FK_8C4152EDC8C9E658` FOREIGN KEY (`car_body_id`) REFERENCES `car_body` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=67 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `car_body_value`
--

LOCK TABLES `car_body_value` WRITE;
/*!40000 ALTER TABLE `car_body_value` DISABLE KEYS */;
INSERT INTO `car_body_value` VALUES (1,23,1,'4','2022-01-31 16:43:02'),(2,23,2,'4','2022-01-31 16:43:09'),(3,23,3,'5302 mm','2022-01-31 16:43:20'),(4,23,4,'1945 mm','2022-01-31 16:43:33'),(5,23,5,'1485 mm','2022-01-31 16:44:26'),(6,23,6,'3128 mm','2022-01-31 16:44:48'),(7,8,1,'2','2022-01-31 16:46:47'),(8,8,2,'4','2022-01-31 16:46:54'),(9,8,3,'4360 mm','2022-01-31 16:47:04'),(10,8,4,'1748 mm','2022-01-31 16:47:16'),(11,8,5,'1411 mm','2022-01-31 16:47:30'),(12,8,6,'2660 mm','2022-01-31 16:47:41'),(13,9,1,'3','2022-01-31 16:51:46'),(14,9,2,'4','2022-01-31 16:51:53'),(15,9,3,'4239 mm','2022-01-31 16:52:03'),(16,9,4,'1748 mm','2022-01-31 16:52:11'),(17,9,5,'1421 mm','2022-01-31 16:52:23'),(18,9,6,'2660 mm','2022-01-31 16:52:29'),(19,10,1,'2','2022-01-31 16:53:16'),(20,10,2,'4','2022-01-31 16:53:24'),(21,10,3,'4380 mm','2022-01-31 16:53:34'),(22,10,4,'1803 mm','2022-01-31 16:53:49'),(23,10,5,'1420 mm','2022-01-31 16:54:15'),(24,10,6,'2660 mm','2022-01-31 16:54:34'),(25,11,1,'3','2022-01-31 17:09:30'),(26,11,2,'5','2022-01-31 17:09:38'),(27,11,3,'4,324 mm','2022-01-31 17:09:47'),(28,11,4,'1765 mm','2022-01-31 17:09:56'),(29,11,5,'1421 mm','2022-01-31 17:10:07'),(30,11,6,'2690 mm','2022-01-31 17:10:18'),(31,12,1,'5','2022-01-31 17:15:51'),(32,12,2,'5','2022-01-31 17:16:05'),(33,12,3,'4,324 mm','2022-01-31 17:16:16'),(34,12,4,'1765 mm','2022-01-31 17:16:23'),(35,12,5,'1421 mm','2022-01-31 17:16:31'),(36,12,6,'2690 mm','2022-01-31 17:16:39'),(37,13,1,'5','2022-01-31 17:17:50'),(38,13,2,'5','2022-01-31 17:18:00'),(39,13,3,'4,319 mm','2022-01-31 17:18:10'),(40,13,4,'1799 mm','2022-01-31 17:18:22'),(41,13,5,'1434 mm','2022-01-31 17:18:33'),(42,13,6,'2670 mm','2022-01-31 17:18:38'),(43,14,1,'2','2022-01-31 17:28:27'),(44,14,2,'5','2022-01-31 17:28:34'),(45,14,3,'4432 mm','2022-01-31 17:28:43'),(46,14,4,'1774 mm','2022-01-31 17:28:52'),(47,14,5,'1413 mm','2022-01-31 17:29:00'),(48,14,6,'2690 mm','2022-01-31 17:29:08'),(49,15,1,'2','2022-01-31 17:29:44'),(50,15,2,'5','2022-01-31 17:29:51'),(51,15,3,'4432 mm','2022-01-31 17:30:05'),(52,15,4,'1774 mm','2022-01-31 17:30:16'),(53,15,5,'1418 mm','2022-01-31 17:30:27'),(54,15,6,'2690 mm','2022-01-31 17:30:39'),(55,22,1,'2','2022-01-31 17:37:24'),(56,22,2,'4','2022-01-31 17:37:33'),(57,22,3,'4454 mm','2022-01-31 17:37:45'),(58,22,4,'1774 mm','2022-01-31 17:37:55'),(59,22,5,'1408 mm','2022-01-31 17:38:22'),(60,22,6,'2690 mm','2022-01-31 17:38:35'),(61,20,1,'5','2022-01-31 17:39:23'),(62,20,2,'5','2022-01-31 17:39:31'),(63,20,3,'4386 mm','2022-01-31 17:40:04'),(64,20,4,'1824 mm','2022-01-31 17:40:14'),(65,20,5,'1576 mm','2022-01-31 17:40:25'),(66,20,6,'2670 mm','2022-01-31 17:40:41');
/*!40000 ALTER TABLE `car_body_value` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `comment`
--

DROP TABLE IF EXISTS `comment`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `comment` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL,
  `post_id` int(11) DEFAULT NULL,
  `content` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `create_at` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_9474526CA76ED395` (`user_id`),
  KEY `IDX_9474526C4B89032C` (`post_id`),
  CONSTRAINT `FK_9474526C4B89032C` FOREIGN KEY (`post_id`) REFERENCES `post` (`id`),
  CONSTRAINT `FK_9474526CA76ED395` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `comment`
--

LOCK TABLES `comment` WRITE;
/*!40000 ALTER TABLE `comment` DISABLE KEYS */;
INSERT INTO `comment` VALUES (1,4,5,'Ja nic takiego nie mam.','2022-01-31 18:19:40'),(2,4,5,'Mam to samo','2022-01-31 18:19:56'),(3,4,5,'To jest przypadłość tego modelu','2022-01-31 18:20:22'),(4,4,5,'Tak jak kolega mówił problem leży w komputerze.','2022-01-31 18:20:47'),(5,4,5,'Polecam jechać do dilera. Oni są w stanie to naprawić','2022-01-31 18:21:17'),(6,4,6,'Polecam zajrzeć do swojego mechanika.','2022-01-31 23:48:51');
/*!40000 ALTER TABLE `comment` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `doctrine_migration_versions`
--

DROP TABLE IF EXISTS `doctrine_migration_versions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `doctrine_migration_versions` (
  `version` varchar(191) COLLATE utf8_unicode_ci NOT NULL,
  `executed_at` datetime DEFAULT NULL,
  `execution_time` int(11) DEFAULT NULL,
  PRIMARY KEY (`version`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `doctrine_migration_versions`
--

LOCK TABLES `doctrine_migration_versions` WRITE;
/*!40000 ALTER TABLE `doctrine_migration_versions` DISABLE KEYS */;
INSERT INTO `doctrine_migration_versions` VALUES ('DoctrineMigrations\\Version20211104090705','2021-11-04 11:28:15',45),('DoctrineMigrations\\Version20211104112701','2021-11-04 11:28:18',28),('DoctrineMigrations\\Version20211105122727','2021-11-05 12:28:22',34),('DoctrineMigrations\\Version20211109105507','2021-11-09 10:55:17',189),('DoctrineMigrations\\Version20211214090031','2021-12-14 09:01:14',88),('DoctrineMigrations\\Version20211215213438','2021-12-15 21:35:05',73),('DoctrineMigrations\\Version20211216091328','2021-12-16 09:14:14',78),('DoctrineMigrations\\Version20211223183813','2021-12-23 18:38:40',40),('DoctrineMigrations\\Version20211224000649','2021-12-24 00:07:01',109),('DoctrineMigrations\\Version20211225154347','2021-12-25 16:11:30',194),('DoctrineMigrations\\Version20211225160950','2021-12-25 16:11:31',25),('DoctrineMigrations\\Version20211225164728','2021-12-25 16:47:37',46),('DoctrineMigrations\\Version20211225205057','2021-12-25 20:51:07',33),('DoctrineMigrations\\Version20211227233757','2021-12-27 23:38:18',120),('DoctrineMigrations\\Version20211228005028','2021-12-28 00:51:18',316),('DoctrineMigrations\\Version20211230000924','2021-12-30 00:09:35',178),('DoctrineMigrations\\Version20211230235901','2021-12-30 23:59:06',53),('DoctrineMigrations\\Version20220115161435','2022-01-15 16:14:43',138);
/*!40000 ALTER TABLE `doctrine_migration_versions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `engine`
--

DROP TABLE IF EXISTS `engine`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `engine` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` longtext COLLATE utf8mb4_unicode_ci,
  `created_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `engine`
--

LOCK TABLES `engine` WRITE;
/*!40000 ALTER TABLE `engine` DISABLE KEYS */;
INSERT INTO `engine` VALUES (1,'118d 143 KM',NULL,'2022-01-31 15:37:50'),(2,'118i 143 KM',NULL,'2022-01-31 15:38:47'),(3,'sDrive35iS 340 KM',NULL,'2022-01-31 15:19:33'),(4,'113d 95 KM',NULL,'2022-01-31 15:28:49'),(5,'114i 102 KM',NULL,'2022-01-31 15:29:08'),(6,'118d 100 KM',NULL,'2022-01-31 15:32:34'),(8,'218d 150KM',NULL,'2022-01-31 16:23:43'),(9,'218i 136 KM',NULL,'2022-01-31 16:24:02'),(10,'220d 190 KM',NULL,'2022-01-31 16:25:10'),(11,'M240i 374KM',NULL,'2022-01-31 16:25:29'),(12,'M3 450 KM',NULL,'2022-01-31 16:27:31'),(13,'50 TDI 256 KM',NULL,'2022-01-31 16:33:26');
/*!40000 ALTER TABLE `engine` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `engine_car_body`
--

DROP TABLE IF EXISTS `engine_car_body`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `engine_car_body` (
  `engine_id` int(11) NOT NULL,
  `car_body_id` int(11) NOT NULL,
  PRIMARY KEY (`engine_id`,`car_body_id`),
  KEY `IDX_CA309463E78C9C0A` (`engine_id`),
  KEY `IDX_CA309463C8C9E658` (`car_body_id`),
  CONSTRAINT `FK_CA309463C8C9E658` FOREIGN KEY (`car_body_id`) REFERENCES `car_body` (`id`) ON DELETE CASCADE,
  CONSTRAINT `FK_CA309463E78C9C0A` FOREIGN KEY (`engine_id`) REFERENCES `engine` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `engine_car_body`
--

LOCK TABLES `engine_car_body` WRITE;
/*!40000 ALTER TABLE `engine_car_body` DISABLE KEYS */;
INSERT INTO `engine_car_body` VALUES (1,8),(1,9),(2,8),(2,9),(3,10),(4,11),(4,12),(5,11),(5,12),(6,13),(8,14),(9,14),(10,15),(10,22),(11,15),(11,22),(12,20),(13,23);
/*!40000 ALTER TABLE `engine_car_body` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `engine_property`
--

DROP TABLE IF EXISTS `engine_property`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `engine_property` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `property` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `engine_property`
--

LOCK TABLES `engine_property` WRITE;
/*!40000 ALTER TABLE `engine_property` DISABLE KEYS */;
INSERT INTO `engine_property` VALUES (1,'Displacement','2022-01-31 16:38:55'),(2,'Engine type','2022-01-31 16:39:07'),(3,'Engine power','2022-01-31 16:39:13'),(4,'Number of cylinders','2022-01-31 16:39:20');
/*!40000 ALTER TABLE `engine_property` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `engine_value`
--

DROP TABLE IF EXISTS `engine_value`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `engine_value` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `engine_id` int(11) DEFAULT NULL,
  `property_id` int(11) DEFAULT NULL,
  `value` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_301F8C7FE78C9C0A` (`engine_id`),
  KEY `IDX_301F8C7F549213EC` (`property_id`),
  CONSTRAINT `FK_301F8C7F549213EC` FOREIGN KEY (`property_id`) REFERENCES `engine_property` (`id`),
  CONSTRAINT `FK_301F8C7FE78C9C0A` FOREIGN KEY (`engine_id`) REFERENCES `engine` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=49 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `engine_value`
--

LOCK TABLES `engine_value` WRITE;
/*!40000 ALTER TABLE `engine_value` DISABLE KEYS */;
INSERT INTO `engine_value` VALUES (1,13,1,'2967 cm³','2022-01-31 16:41:41'),(2,13,2,'diesel','2022-01-31 16:42:14'),(3,13,3,'286 hp (210 kW ) at 3700 rpm','2022-01-31 16:42:27'),(4,13,4,'6','2022-01-31 16:42:39'),(5,1,1,'1995 cm³','2022-01-31 16:48:50'),(6,1,2,'diesel','2022-01-31 16:49:01'),(7,1,3,'143 hp (105 kW ) at 4,000 rpm','2022-01-31 16:49:10'),(8,1,4,'6','2022-01-31 16:49:24'),(9,2,1,'1995 cm³','2022-01-31 16:50:15'),(10,2,2,'petrol','2022-01-31 16:50:27'),(11,2,3,'143 hp (105 kW ) at 6,000 rpm','2022-01-31 16:50:38'),(12,2,4,'6','2022-01-31 16:50:46'),(13,3,1,'2979 cm³','2022-01-31 16:54:47'),(14,3,2,'petrol','2022-01-31 16:54:55'),(15,3,3,'340 hp (250 kW ) at 5,800 rpm','2022-01-31 16:55:04'),(16,3,4,'6','2022-01-31 16:55:50'),(17,4,1,'1598 cm³','2022-01-31 17:10:54'),(18,4,2,'diesel','2022-01-31 17:11:03'),(19,4,3,'95 hp (70 kW ) at 4,000 rpm','2022-01-31 17:11:10'),(20,4,4,'4','2022-01-31 17:11:21'),(21,5,1,'1598 cm³','2022-01-31 17:14:40'),(22,5,2,'Petrol','2022-01-31 17:15:02'),(23,5,3,'102 hp (75 kW ) at 4,000 rpm','2022-01-31 17:15:14'),(24,5,4,'4','2022-01-31 17:15:26'),(25,6,1,'1496 cm³','2022-01-31 17:20:45'),(26,6,2,'diesel','2022-01-31 17:20:59'),(27,6,3,'116 hp (85 kW ) at 2,250 rpm','2022-01-31 17:21:05'),(28,6,4,'3','2022-01-31 17:21:15'),(29,8,1,'1995 cm³','2022-01-31 17:25:38'),(30,8,2,'diesel','2022-01-31 17:25:57'),(31,8,3,'150 KM (110 kW) przy 4000 obr/min','2022-01-31 17:26:10'),(32,8,4,'4','2022-01-31 17:26:21'),(33,9,1,'1499 cm³','2022-01-31 17:26:54'),(34,9,2,'Petrol','2022-01-31 17:27:04'),(35,9,3,'136 KM (100 kW) przy 4500 obr/min','2022-01-31 17:27:24'),(36,9,4,'3','2022-01-31 17:27:34'),(37,10,1,'1995 cm³','2022-01-31 17:31:13'),(38,10,2,'diesel','2022-01-31 17:31:21'),(39,10,3,'190 KM (140 kW) przy 4000 obr/min','2022-01-31 17:31:40'),(40,10,4,'4','2022-01-31 17:32:17'),(41,11,1,'1998 cm³','2022-01-31 17:34:12'),(42,11,2,'Petrol','2022-01-31 17:34:21'),(43,11,3,'240 KM (185 kW) przy 5200 obr/min','2022-01-31 17:34:37'),(44,11,4,'4','2022-01-31 17:34:46'),(45,12,1,'2998 cm³','2022-01-31 17:36:03'),(46,12,2,'Petrol','2022-01-31 17:36:13'),(47,12,3,'450 KM (331 kW) przy 5500 obr/min','2022-01-31 17:36:29'),(48,12,4,'6','2022-01-31 17:36:37');
/*!40000 ALTER TABLE `engine_value` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `gender`
--

DROP TABLE IF EXISTS `gender`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `gender` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `gender`
--

LOCK TABLES `gender` WRITE;
/*!40000 ALTER TABLE `gender` DISABLE KEYS */;
INSERT INTO `gender` VALUES (1,'Male',NULL),(2,'Female',NULL);
/*!40000 ALTER TABLE `gender` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `generation`
--

DROP TABLE IF EXISTS `generation`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `generation` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `model_id` int(11) DEFAULT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` longtext COLLATE utf8mb4_unicode_ci,
  `produced_from` int(11) NOT NULL,
  `produced_until` int(11) NOT NULL,
  `file` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_D3266C3B7975B7E7` (`model_id`),
  CONSTRAINT `FK_D3266C3B7975B7E7` FOREIGN KEY (`model_id`) REFERENCES `model` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `generation`
--

LOCK TABLES `generation` WRITE;
/*!40000 ALTER TABLE `generation` DISABLE KEYS */;
INSERT INTO `generation` VALUES (11,10,'E81-E87',NULL,2004,2013,'40d327fb3f31f11cc6561ea7c449dcd3056af8be.jpg','2022-01-31 13:57:46'),(12,10,'F20-F21',NULL,2004,0,'dda38e764e2f2401b2bbb7ba6255be806c28f9aa.jpg','2022-01-31 14:00:30'),(13,10,'F40',NULL,2019,0,'3aefc2c09553299e8718571e73fa9d5f1911466c.jpg','2022-01-31 14:01:29'),(14,11,'F22-F23-F45-F46',NULL,2013,0,'09ca8a95ee6c8deaf695f6b64dc34cb802c64c79.jpg','2022-01-31 16:10:07'),(15,11,'G42-U06',NULL,2021,0,'63eb11d7f6923960c0f12198b347f877cc5bb548.jpg','2022-01-31 16:10:38'),(16,12,'D5',NULL,2017,0,'722c1df23c4b77ee6bfa82097f5ce3050d01250a.jpg','2022-01-31 16:32:54');
/*!40000 ALTER TABLE `generation` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `model`
--

DROP TABLE IF EXISTS `model`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `model` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `brand_id` int(11) DEFAULT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` longtext COLLATE utf8mb4_unicode_ci,
  `created_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_D79572D944F5D008` (`brand_id`),
  CONSTRAINT `FK_D79572D944F5D008` FOREIGN KEY (`brand_id`) REFERENCES `brand` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `model`
--

LOCK TABLES `model` WRITE;
/*!40000 ALTER TABLE `model` DISABLE KEYS */;
INSERT INTO `model` VALUES (10,12,'Seria 1',NULL,'2022-01-31 13:52:43'),(11,12,'Seria 2',NULL,'2022-01-31 13:52:49'),(12,13,'A8',NULL,'2022-01-31 16:30:51');
/*!40000 ALTER TABLE `model` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `newses`
--

DROP TABLE IF EXISTS `newses`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `newses` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `context` longtext COLLATE utf8mb4_unicode_ci,
  `file` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` datetime NOT NULL,
  `url` longtext COLLATE utf8mb4_unicode_ci,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `newses`
--

LOCK TABLES `newses` WRITE;
/*!40000 ALTER TABLE `newses` DISABLE KEYS */;
INSERT INTO `newses` VALUES (1,'Nowa generacja !','Nowa generacja auta','8546a8bac54b80dd747e7c47d1e70a64cc0a1948.png','2022-01-31 18:00:04','https://www.ujd.edu.pl/'),(2,'News 2','Nowy news.','315264fbf087b09334ac27a16402dd33ad283e98.png','2022-01-31 18:00:40','https://www.ujd.edu.pl/'),(3,'Nowe auto','Nowe auto już teraz !','6ae346a715e6659d48c1156d7d8ca5dcfff89fab.png','2022-01-31 18:01:10','https://www.ujd.edu.pl/');
/*!40000 ALTER TABLE `newses` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `post`
--

DROP TABLE IF EXISTS `post`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `post` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `content` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` datetime NOT NULL,
  `brand_id` int(11) DEFAULT NULL,
  `model_id` int(11) DEFAULT NULL,
  `generation_id` int(11) DEFAULT NULL,
  `car_body_id` int(11) DEFAULT NULL,
  `engine_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_5A8A6C8DA76ED395` (`user_id`),
  KEY `IDX_5A8A6C8D44F5D008` (`brand_id`),
  KEY `IDX_5A8A6C8D7975B7E7` (`model_id`),
  KEY `IDX_5A8A6C8D553A6EC4` (`generation_id`),
  KEY `IDX_5A8A6C8DC8C9E658` (`car_body_id`),
  KEY `IDX_5A8A6C8DE78C9C0A` (`engine_id`),
  CONSTRAINT `FK_5A8A6C8D44F5D008` FOREIGN KEY (`brand_id`) REFERENCES `brand` (`id`),
  CONSTRAINT `FK_5A8A6C8D553A6EC4` FOREIGN KEY (`generation_id`) REFERENCES `generation` (`id`),
  CONSTRAINT `FK_5A8A6C8D7975B7E7` FOREIGN KEY (`model_id`) REFERENCES `model` (`id`),
  CONSTRAINT `FK_5A8A6C8DA76ED395` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`),
  CONSTRAINT `FK_5A8A6C8DC8C9E658` FOREIGN KEY (`car_body_id`) REFERENCES `car_body` (`id`),
  CONSTRAINT `FK_5A8A6C8DE78C9C0A` FOREIGN KEY (`engine_id`) REFERENCES `engine` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `post`
--

LOCK TABLES `post` WRITE;
/*!40000 ALTER TABLE `post` DISABLE KEYS */;
INSERT INTO `post` VALUES (1,4,'Jakie macie spalanie na 100 km ?','Jak w temacie. Moje auto to rocznik 2019','2022-01-31 18:14:38',12,10,11,8,1),(2,4,'Blokada kierownicy','Blokuje mi się kierownica przy skręcaniu tylko w jedną stronę. Co się dzieje  ? Jestem pierwszym właścicielem.','2022-01-31 18:16:46',12,10,11,8,1),(3,4,'Czy ten model nadaje się na auto dla rodziny?','Moja rodzina to 5 osób.','2022-01-31 18:17:27',12,10,11,8,1),(4,4,'Polecacie auto ?','Chcę kupić ten model. Jakieś sugestie ?','2022-01-31 18:18:11',12,10,11,8,1),(5,4,'Cały czas mam check engine.','Od zakupu mam problem z diodom od silnika. Byłem u mechanika mówi że wszystko ok. Co się dzieje ?','2022-01-31 18:19:15',12,10,11,8,1),(6,4,'Problem z prawą lampa.','Mam problem z lampom w tym  modelu. Ciągle spala mi się tylko prawa lama. Co z tym zrobić ?','2022-01-31 23:23:05',12,10,11,8,2);
/*!40000 ALTER TABLE `post` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `reset_password_request`
--

DROP TABLE IF EXISTS `reset_password_request`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `reset_password_request` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `selector` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `hashed_token` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `requested_at` datetime NOT NULL COMMENT '(DC2Type:datetime_immutable)',
  `expires_at` datetime NOT NULL COMMENT '(DC2Type:datetime_immutable)',
  PRIMARY KEY (`id`),
  KEY `IDX_7CE748AA76ED395` (`user_id`),
  CONSTRAINT `FK_7CE748AA76ED395` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `reset_password_request`
--

LOCK TABLES `reset_password_request` WRITE;
/*!40000 ALTER TABLE `reset_password_request` DISABLE KEYS */;
/*!40000 ALTER TABLE `reset_password_request` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sales_offers`
--

DROP TABLE IF EXISTS `sales_offers`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `sales_offers` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `brand_id` int(11) DEFAULT NULL,
  `model_id` int(11) DEFAULT NULL,
  `generation_id` int(11) DEFAULT NULL,
  `car_body_id` int(11) DEFAULT NULL,
  `engine_id` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `price` int(11) NOT NULL,
  `mileage` int(11) NOT NULL,
  `details` longtext COLLATE utf8mb4_unicode_ci,
  `created_at` datetime NOT NULL,
  `file` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `produced_at` date NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_F8B2562F44F5D008` (`brand_id`),
  KEY `IDX_F8B2562F7975B7E7` (`model_id`),
  KEY `IDX_F8B2562F553A6EC4` (`generation_id`),
  KEY `IDX_F8B2562FC8C9E658` (`car_body_id`),
  KEY `IDX_F8B2562FE78C9C0A` (`engine_id`),
  KEY `IDX_F8B2562FA76ED395` (`user_id`),
  CONSTRAINT `FK_F8B2562F44F5D008` FOREIGN KEY (`brand_id`) REFERENCES `brand` (`id`),
  CONSTRAINT `FK_F8B2562F553A6EC4` FOREIGN KEY (`generation_id`) REFERENCES `generation` (`id`),
  CONSTRAINT `FK_F8B2562F7975B7E7` FOREIGN KEY (`model_id`) REFERENCES `model` (`id`),
  CONSTRAINT `FK_F8B2562FA76ED395` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`),
  CONSTRAINT `FK_F8B2562FC8C9E658` FOREIGN KEY (`car_body_id`) REFERENCES `car_body` (`id`),
  CONSTRAINT `FK_F8B2562FE78C9C0A` FOREIGN KEY (`engine_id`) REFERENCES `engine` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sales_offers`
--

LOCK TABLES `sales_offers` WRITE;
/*!40000 ALTER TABLE `sales_offers` DISABLE KEYS */;
INSERT INTO `sales_offers` VALUES (1,12,10,11,8,1,4,123123,100000,'Super stan !','2022-01-31 18:23:03','c29f9da217de089414bdcb0ea5d96efb.jpg','2004-01-01'),(2,12,10,11,8,1,4,200000,123,'Nowe auto !','2022-01-31 18:26:08','92119aab7d41ec72eacdb7a0abc48c4b.jpg','2013-01-01'),(3,12,10,11,8,1,4,110000,15000,'Dobry stan. Auto większość czasu stało w garażu.','2022-01-31 18:28:05','47062d2450491f103eff54d6e619f6d8.jpg','2011-01-01'),(4,12,10,11,8,1,4,210000,12,'Całkiem nowy','2022-01-31 18:28:41','276b3cd35d194b50358deaeb5772f306.jpg','2013-01-01'),(5,12,10,11,8,1,4,161113,50000,'Stan dobry','2022-01-31 18:29:58','41804adcd4d6fa71a825a40ded482100.jpg','2010-01-01'),(6,12,10,11,8,2,4,20000,100000000,'Wysłużony model, ale nadal sprawny','2022-01-31 18:30:54','7f2ef8f611153198dc6ae91f5de8efe4.jpg','2005-01-01');
/*!40000 ALTER TABLE `sales_offers` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `specialist_comment`
--

DROP TABLE IF EXISTS `specialist_comment`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `specialist_comment` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL,
  `brand_id` int(11) DEFAULT NULL,
  `model_id` int(11) DEFAULT NULL,
  `generation_id` int(11) DEFAULT NULL,
  `body_id` int(11) DEFAULT NULL,
  `engine_id` int(11) DEFAULT NULL,
  `content` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_F21A0DA3A76ED395` (`user_id`),
  KEY `IDX_F21A0DA344F5D008` (`brand_id`),
  KEY `IDX_F21A0DA37975B7E7` (`model_id`),
  KEY `IDX_F21A0DA3553A6EC4` (`generation_id`),
  KEY `IDX_F21A0DA39B621D84` (`body_id`),
  KEY `IDX_F21A0DA3E78C9C0A` (`engine_id`),
  CONSTRAINT `FK_F21A0DA344F5D008` FOREIGN KEY (`brand_id`) REFERENCES `brand` (`id`),
  CONSTRAINT `FK_F21A0DA3553A6EC4` FOREIGN KEY (`generation_id`) REFERENCES `generation` (`id`),
  CONSTRAINT `FK_F21A0DA37975B7E7` FOREIGN KEY (`model_id`) REFERENCES `model` (`id`),
  CONSTRAINT `FK_F21A0DA39B621D84` FOREIGN KEY (`body_id`) REFERENCES `car_body` (`id`),
  CONSTRAINT `FK_F21A0DA3A76ED395` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`),
  CONSTRAINT `FK_F21A0DA3E78C9C0A` FOREIGN KEY (`engine_id`) REFERENCES `engine` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `specialist_comment`
--

LOCK TABLES `specialist_comment` WRITE;
/*!40000 ALTER TABLE `specialist_comment` DISABLE KEYS */;
INSERT INTO `specialist_comment` VALUES (1,4,12,10,11,8,1,'<div>Jak mawia mój mechanik</div><blockquote>Potwór !</blockquote>','2022-01-31 18:05:09'),(2,5,12,10,11,8,1,'<pre>Polecam</pre>','2022-01-31 19:08:13'),(3,12,12,10,11,8,1,'<div>Super auto, ale na pewno nie jest dla <del>każdego!</del></div>','2022-01-31 19:08:17'),(4,14,12,10,11,8,1,'<div>Najlepsza sprzedaż roki !</div>','2022-01-31 19:08:18'),(5,16,12,10,11,8,1,'<div><strong>Super model !</strong></div><ol><li>szbki</li><li>eko</li><li>tani</li></ol><div><strong><em>Polecam</em></strong></div>','2022-01-31 19:08:19'),(6,4,12,10,11,8,2,'<div><strong>Zdecydowanie nie polecam !</strong></div>','2022-01-31 18:12:10');
/*!40000 ALTER TABLE `specialist_comment` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `user`
--

DROP TABLE IF EXISTS `user`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `gender_id` int(11) DEFAULT NULL,
  `email` varchar(180) COLLATE utf8mb4_unicode_ci NOT NULL,
  `roles` json NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL,
  `surname` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL,
  `city` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL,
  `post_code` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `street` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL,
  `home_nr` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `create_at` datetime NOT NULL,
  `is_verified` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `UNIQ_8D93D649E7927C74` (`email`),
  KEY `IDX_8D93D649708A0E0` (`gender_id`),
  CONSTRAINT `FK_8D93D649708A0E0` FOREIGN KEY (`gender_id`) REFERENCES `gender` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `user`
--

LOCK TABLES `user` WRITE;
/*!40000 ALTER TABLE `user` DISABLE KEYS */;
INSERT INTO `user` VALUES (4,1,'bartosz.lauks@interia.pl','[\"ROLE_ADMIN\", \"ROLE_SUPER_ADMIN\", \"ROLE_JOURNALIST\", \"ROLE_MARKERING\", \"ROLE_SPECIALIST\"]','$2y$13$dK.u0UBBKgiIHY.JQvBg/uQZefxNPyi4TEq8qutBEeBSEMjqCPchO','Bartosz','Lauks','WK','99-999','W','123','123456789','2021-11-05 08:37:05',1),(5,1,'bartosz.lauksstu@interia.pl','[\"ROLE_ADMIN\", \"ROLE_JOURNALIST\"]','$2y$13$dK.u0UBBKgiIHY.JQvBg/uQZefxNPyi4TEq8qutBEeBSEMjqCPchO','Bartosz','Lauks','WK','99-999','W','123','123456789','2021-11-05 08:37:58',1),(12,2,'bartes121@interia.pl','[\"ROLE_ADMIN\", \"ROLE_MARKERING\"]','$2y$13$dK.u0UBBKgiIHY.JQvBg/uQZefxNPyi4TEq8qutBEeBSEMjqCPchO','Bartosz','Lauks','WK','99-999','W','123','123456789','2021-12-29 23:53:36',1),(14,1,'cruzon@interia.pl','[\"ROLE_ADMIN\", \"ROLE_SPECIALIST\"]','$2y$13$dK.u0UBBKgiIHY.JQvBg/uQZefxNPyi4TEq8qutBEeBSEMjqCPchO','Bartosz','Lauks','WK','99-999','W','123','123456789','2022-01-02 23:27:35',1),(16,2,'cruzonek@gmail.com','[]','$2y$13$dK.u0UBBKgiIHY.JQvBg/uQZefxNPyi4TEq8qutBEeBSEMjqCPchO','Bartosz','Lauks','WK','99-999','W','123','123456789','2022-01-08 16:25:06',1),(17,1,'bartoszlauks@gmail.com','[]','$2y$13$dK.u0UBBKgiIHY.JQvBg/uQZefxNPyi4TEq8qutBEeBSEMjqCPchO','Bartosz','Lauks','WK','99-999','W','123','123456789','2022-02-03 23:56:57',0);
/*!40000 ALTER TABLE `user` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2022-02-21 18:48:30
