-- MySQL dump 10.13  Distrib 8.0.43, for Linux (x86_64)
--
-- Host: 127.0.0.1    Database: app
-- ------------------------------------------------------
-- Server version	5.5.5-10.6.22-MariaDB-ubu2004

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `courses`
--

DROP TABLE IF EXISTS `courses`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `courses` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `code` varchar(50) NOT NULL,
  `active` tinyint(1) DEFAULT NULL,
  `persmax` int(11) DEFAULT NULL,
  `persmin` int(11) DEFAULT NULL,
  `isconfirmed` tinyint(1) DEFAULT NULL,
  `cancelled` datetime DEFAULT NULL,
  `start` datetime DEFAULT NULL,
  `end` datetime DEFAULT NULL,
  `created_at` datetime NOT NULL COMMENT '(DC2Type:datetime_immutable)',
  `updated_at` datetime NOT NULL COMMENT '(DC2Type:datetime_immutable)',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `courses`
--

LOCK TABLES `courses` WRITE;
/*!40000 ALTER TABLE `courses` DISABLE KEYS */;
INSERT INTO `courses` VALUES (1,'COURSE-001',1,341,5,1,NULL,'2025-09-03 15:10:54','2025-09-10 15:10:54','2025-08-27 15:10:54','2025-09-08 17:04:44'),(2,'COURSE-002',0,25,10,0,'2025-08-24 15:10:54','2025-08-13 15:10:54','2025-08-20 15:10:54','2025-08-27 15:10:54','2025-08-27 15:10:54'),(3,'COURSE-003',1,100,50,1,NULL,'2025-09-01 00:00:00','2025-09-30 00:00:00','2025-08-27 15:10:54','2025-08-27 15:10:54'),(4,'COURSE-004',1,40,15,0,NULL,'2025-08-30 15:10:54','2025-09-16 15:10:54','2025-08-27 15:10:54','2025-08-27 15:10:54'),(5,'COURSE-005',0,60,20,0,'2025-08-17 15:10:54','2025-07-28 15:10:54','2025-08-12 15:10:54','2025-08-27 15:10:54','2025-08-27 15:10:54'),(6,'COURSE-006',1,15,5,1,NULL,'2025-09-01 15:10:54','2025-09-08 15:10:54','2025-08-27 15:10:54','2025-08-27 15:10:54'),(7,'COURSE-007',1,200,100,1,NULL,'2025-10-01 00:00:00','2025-10-31 00:00:00','2025-08-27 15:10:54','2025-08-27 15:10:54'),(8,'COURSE-008',0,10,2,0,'2025-07-27 15:10:54','2025-06-27 15:10:54','2025-07-27 15:10:54','2025-08-27 15:10:54','2025-08-27 15:10:54'),(9,'COURSE-009',1,80,20,1,NULL,'2025-10-27 15:10:54','2025-11-27 15:10:54','2025-08-27 15:10:54','2025-08-27 15:10:54'),(12,'COURSE-012',1,90,30,1,NULL,'2025-12-01 00:00:00','2025-12-31 00:00:00','2025-08-27 15:10:54','2025-08-27 15:10:54'),(15,'asasasass',0,NULL,NULL,0,NULL,NULL,NULL,'2025-09-10 17:26:54','2025-09-10 17:26:54'),(16,'sdsdsds',0,555,55,0,NULL,NULL,NULL,'2025-09-12 17:52:29','2025-09-12 17:56:22');
/*!40000 ALTER TABLE `courses` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `doctrine_migration_versions`
--

DROP TABLE IF EXISTS `doctrine_migration_versions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `doctrine_migration_versions` (
  `version` varchar(191) NOT NULL,
  `executed_at` datetime DEFAULT NULL,
  `execution_time` int(11) DEFAULT NULL,
  PRIMARY KEY (`version`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `doctrine_migration_versions`
--

LOCK TABLES `doctrine_migration_versions` WRITE;
/*!40000 ALTER TABLE `doctrine_migration_versions` DISABLE KEYS */;
INSERT INTO `doctrine_migration_versions` VALUES ('DoctrineMigrations\\Version20250827150855','2025-08-27 15:10:16',22);
/*!40000 ALTER TABLE `doctrine_migration_versions` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2025-10-02 17:09:10
