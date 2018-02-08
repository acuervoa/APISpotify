-- MySQL dump 10.13  Distrib 5.7.20, for Linux (x86_64)
--
-- Host: localhost    Database: homestead
-- ------------------------------------------------------
-- Server version	5.7.20-0ubuntu0.16.04.1

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
-- Table structure for table `migrations`
--

DROP TABLE IF EXISTS `migrations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `migrations` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `migrations`
--

LOCK TABLES `migrations` WRITE;
/*!40000 ALTER TABLE `migrations` DISABLE KEYS */;
INSERT INTO `migrations` VALUES (7,'2014_10_12_000000_create_users_table',1),(8,'2014_10_12_100000_create_password_resets_table',1),(9,'2018_02_07_154708_create_spotify_profiles_table',1),(10,'2018_02_08_110207_create_tracks_table',1);
/*!40000 ALTER TABLE `migrations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `password_resets`
--

DROP TABLE IF EXISTS `password_resets`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `password_resets` (
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  KEY `password_resets_email_index` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `password_resets`
--

LOCK TABLES `password_resets` WRITE;
/*!40000 ALTER TABLE `password_resets` DISABLE KEYS */;
/*!40000 ALTER TABLE `password_resets` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `spotify_profiles`
--

DROP TABLE IF EXISTS `spotify_profiles`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `spotify_profiles` (
  `id` char(36) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nick` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `display_name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `country` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `href` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `image_url` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `accessToken` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `refreshToken` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `expirationToken` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `spotify_profiles`
--

LOCK TABLES `spotify_profiles` WRITE;
/*!40000 ALTER TABLE `spotify_profiles` DISABLE KEYS */;
INSERT INTO `spotify_profiles` VALUES ('165f4b64-0cee-11e8-8ec3-0800273b4cc5','kuerbo','kuerbo@gmail.com','Andres Cuervo Adame','ES','https://api.spotify.com/v1/users/kuerbo','https://scontent.xx.fbcdn.net/v/t1.0-1/p200x200/1185562_10152183848826832_142916018_n.jpg?oh=c3b1fd6c253120f2ac58e53ab678c7d1&oe=5AD8A311','BQCneIC1pc_my3T8xEns8TD8d159shiZhples_RiciRYwmbpk1y2oq5ftj8r63k8bNch8CAONF3s8oXNVctAanxQDmc1V60IEKzBj2iwUP7TdyRtBmZkrTeMK_j06SO1ul1OCIMss4pCPSke2Qf39UE-gMxtcPfPLsQZd3Y','AQDPjLsFV37xYAJP6oHZLwJ4lDgHlW6b2BtePjV4AA1eyL-yFPKOBbKvEjArEEiRr7ExYzlBPGb1e0V4teoGHGPl_DlBc_ZLHigVVIt7v3PRS9y0U5wkP76x-hplodHSggg','1518111334','2018-02-08 12:57:06','2018-02-08 16:35:35',NULL);
/*!40000 ALTER TABLE `spotify_profiles` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tracks`
--

DROP TABLE IF EXISTS `tracks`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tracks` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `track_id` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `popularity` int(11) NOT NULL,
  `played_at` datetime NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=61 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tracks`
--

LOCK TABLES `tracks` WRITE;
/*!40000 ALTER TABLE `tracks` DISABLE KEYS */;
INSERT INTO `tracks` VALUES (1,'1cjhpCOdgqRLKHi0jnPOPs','Arrival',19,'2018-02-08 13:07:48','2018-02-08 13:13:26','2018-02-08 13:13:26'),(2,'118DoPuWRCEs6oIyd76ZSi','Who Will Find Me - Radio Edit',29,'2018-02-08 13:03:22','2018-02-08 13:13:26','2018-02-08 13:13:26'),(3,'57D6eFA249A7y9SntwQP3a','Booya',32,'2018-02-08 13:00:38','2018-02-08 13:13:26','2018-02-08 13:13:26'),(4,'2V0F4062FJ4cQLY7ADuj2Z','Cosmos - Alexander Volosnikov Remix',35,'2018-02-08 12:56:43','2018-02-08 13:13:26','2018-02-08 13:13:26'),(5,'34icTRsJ1clSjcRFG65IvW','Fly Away (Mix Cut) - Cosmic Gate Remix',45,'2018-02-08 12:55:14','2018-02-08 13:13:26','2018-02-08 13:13:26'),(6,'4NHvGNhnxBPZqQGEIwk5JB','The Theme (Mix Cut)',43,'2018-02-08 12:53:53','2018-02-08 13:13:26','2018-02-08 13:13:26'),(7,'65DzBVmzCk00ytU2GGfilN','Burned With Desire (Classic Bonus Track) - Rising Star Remix',48,'2018-02-08 12:50:51','2018-02-08 13:13:26','2018-02-08 13:13:26'),(8,'6CYTLvT7Gth8lv1mVK6TjO','This Love Kills Me - Gabriel & Dresden Club Mix - Above & Beyond Respray',42,'2018-02-08 12:46:54','2018-02-08 13:13:26','2018-02-08 13:13:26'),(9,'3faEHHzS7ApaU7wPY3HPOt','Pulsar - UK Radio Edit',31,'2018-02-08 12:43:50','2018-02-08 13:13:26','2018-02-08 13:13:26'),(10,'5cXRWnFBedZKbm1Ju7fATC','Atom',37,'2018-02-08 12:40:26','2018-02-08 13:13:26','2018-02-08 13:13:26'),(11,'3ODnmdFn6EqkP8MP4A3eJL','Kill The Fear - Farius Remix',31,'2018-02-08 12:36:46','2018-02-08 13:13:26','2018-02-08 13:13:26'),(12,'4b3NodWtuaG8bs4Vj9ywv0','Memory',34,'2018-02-08 12:34:03','2018-02-08 13:13:26','2018-02-08 13:13:26'),(13,'5XPXNwnUuNnueFlXdZ2Fsa','This Time',27,'2018-02-08 12:30:10','2018-02-08 13:13:26','2018-02-08 13:13:26'),(14,'5XPXNwnUuNnueFlXdZ2Fsa','This Time',27,'2018-02-08 12:25:22','2018-02-08 13:13:26','2018-02-08 13:13:26'),(15,'5XPXNwnUuNnueFlXdZ2Fsa','This Time',27,'2018-02-08 12:22:33','2018-02-08 13:13:26','2018-02-08 13:13:26'),(16,'25tXTgmNN0fjit447b7NJJ','Anthem - Original Radio Version',31,'2018-02-08 12:19:10','2018-02-08 13:13:26','2018-02-08 13:13:26'),(17,'3K8mUh976eVuw0i6WCufxs','Chakra',56,'2018-02-08 12:15:47','2018-02-08 13:13:26','2018-02-08 13:13:26'),(18,'3qbOQxMBxBb0igrNgGVapI','Evil Intent',31,'2018-02-08 12:11:54','2018-02-08 13:13:26','2018-02-08 13:13:26'),(19,'0nGYLsyhvT1k8R0YCWE91O','Rattle - Audien Remix',28,'2018-02-08 12:08:03','2018-02-08 13:13:26','2018-02-08 13:13:26'),(20,'2QoZDDUGDsSxZCixtZYN17','Kalopsia',23,'2018-02-08 12:03:58','2018-02-08 13:13:26','2018-02-08 13:13:26'),(21,'7KCPXknzQNAfWYcgIvWaOw','Until We Meet Again',29,'2018-02-08 13:11:32','2018-02-08 13:14:38','2018-02-08 13:14:38'),(22,'7n15DDJ5ZRekzvaaeO7dyP','Xplode (Mix Cut) - Grahham Bell & Yoel Lewis Remix',38,'2018-02-08 14:26:02','2018-02-08 14:27:56','2018-02-08 14:27:56'),(23,'1CxmVyo4eIEAgoML8o90b3','Blossom',19,'2018-02-08 14:23:07','2018-02-08 14:27:56','2018-02-08 14:27:56'),(24,'1Dv0sZdsUvWQ7Ff46Dnfsv','Home - Dash Berlin Club Mix',43,'2018-02-08 13:14:29','2018-02-08 14:27:56','2018-02-08 14:27:56'),(25,'5NIODn9ze0xHaBj9yWVjTl','Brutal',28,'2018-02-08 14:27:01','2018-02-08 14:33:14','2018-02-08 14:33:14'),(26,'0EpjbFlDqYtYblJv8ElJwF','Trust In The Wind - Driftmoon Rework',31,'2018-02-08 14:38:21','2018-02-08 14:44:47','2018-02-08 14:44:47'),(27,'7ej6hXuIvbHAz5tKRikMi1','U',55,'2018-02-08 14:34:00','2018-02-08 14:44:47','2018-02-08 14:44:47'),(28,'3hqMCtoirW66g2E8ty7aRw','EOS',29,'2018-02-08 14:30:23','2018-02-08 14:44:47','2018-02-08 14:44:47'),(29,'2t0otAL0p0IiqHDMFrcZN9','Game Of Love',27,'2018-02-08 14:42:13','2018-02-08 14:46:59','2018-02-08 14:46:59'),(30,'4VeGyQQqZc7toj6lOFcG85','Love Theme Dusk - Mike\'s Broken Record Mix Edit',34,'2018-02-08 14:48:35','2018-02-08 14:54:09','2018-02-08 14:54:09'),(31,'48bKLvvmJrE9RZ3bl2tOff','Stained Glass',32,'2018-02-08 14:45:26','2018-02-08 14:54:09','2018-02-08 14:54:09'),(32,'7eoD3ZZXyyBGndJkcaU8fV','Together (In A State Of Trance) - Radio Edit',35,'2018-02-08 14:59:54','2018-02-08 15:03:27','2018-02-08 15:03:27'),(33,'2LL7L539LJpP9atyy7GYWq','Kuala Lights',30,'2018-02-08 14:56:43','2018-02-08 15:03:27','2018-02-08 15:03:27'),(34,'3tHBtxQ1B4llfxsHD0vmK5','Calatheas',30,'2018-02-08 14:52:53','2018-02-08 15:03:27','2018-02-08 15:03:27'),(35,'1sTirjlbSyCuAck3ZKAxqh','Lift - Sunny Terrace Remix',36,'2018-02-08 15:15:57','2018-02-08 15:20:20','2018-02-08 15:20:20'),(36,'5h19Jl5o8vrtcq32OvV5FD','Just Believe Me Yesterday',29,'2018-02-08 15:12:31','2018-02-08 15:20:20','2018-02-08 15:20:20'),(37,'5Ly7Q5s9U7tZpj8bCrELm2','Suburban Train - Radio Edit',30,'2018-02-08 15:09:06','2018-02-08 15:20:21','2018-02-08 15:20:21'),(38,'77sH8nRkZPQSE77VkfcS8Q','Don’t Talk Away The Magic - Heatbeat Remix',30,'2018-02-08 15:05:14','2018-02-08 15:20:21','2018-02-08 15:20:21'),(39,'5Qi7e4lMXbRuhA8wBCHlI8','Yámana',30,'2018-02-08 15:02:34','2018-02-08 15:20:21','2018-02-08 15:20:21'),(40,'1dcdbDPOorQ2dJw4CXPvsA','Neba',44,'2018-02-08 16:31:14','2018-02-08 16:35:36','2018-02-08 16:35:36'),(41,'0NfpxJ1Wpmfe9BrfsxppVS','RAMexico',32,'2018-02-08 16:27:40','2018-02-08 16:35:36','2018-02-08 16:35:36'),(42,'2Of2boNN8WnfXSvQ9U7hS2','24 Hours',39,'2018-02-08 16:24:01','2018-02-08 16:35:36','2018-02-08 16:35:36'),(43,'72duqMVH5yBPN0RhfGGpZ9','Airwave - Radio Edit',41,'2018-02-08 16:21:00','2018-02-08 16:35:36','2018-02-08 16:35:36'),(44,'5j5xz0zpIfNcS1FZwOZo2i','Brace Yourself - Radio Edit',30,'2018-02-08 16:18:21','2018-02-08 16:35:36','2018-02-08 16:35:36'),(45,'1xlsHr2eYMGgIQIGPYyZZT','Why Do You Run',44,'2018-02-08 16:14:28','2018-02-08 16:35:36','2018-02-08 16:35:36'),(46,'5WGOhaEiVJzjeUbjgPK2ww','When You Smile',38,'2018-02-08 16:10:49','2018-02-08 16:35:36','2018-02-08 16:35:36'),(47,'6RiCCUEwE2jlWqxcD0szBU','Last Minute - Radio Edit',26,'2018-02-08 16:07:15','2018-02-08 16:35:36','2018-02-08 16:35:36'),(48,'7p93udj0pIzdIxVSiUSK4X','Lullaby',28,'2018-02-08 16:03:18','2018-02-08 16:35:36','2018-02-08 16:35:36'),(49,'5JqZRtdTqdIrtDDZj5X9mp','Closer - Radio Mix',32,'2018-02-08 15:59:12','2018-02-08 16:35:36','2018-02-08 16:35:36'),(50,'5IBEH118k466deGeyH9PWc','Where We Began - Steve Allen Remix',26,'2018-02-08 15:55:38','2018-02-08 16:35:36','2018-02-08 16:35:36'),(51,'2IIlQLexKCuAePULrQTrRl','Alone Tonight - Radio Edit',27,'2018-02-08 15:52:13','2018-02-08 16:35:36','2018-02-08 16:35:36'),(52,'5bdWnpMYf1ZY83rlDI7Fg4','Who\'s Afraid Of 138?!',32,'2018-02-08 15:48:20','2018-02-08 16:35:36','2018-02-08 16:35:36'),(53,'4bnJgsyigmwkkgtE5gGVtl','Surreal',32,'2018-02-08 15:44:45','2018-02-08 16:35:36','2018-02-08 16:35:36'),(54,'4AYJbDvTSshPS4B795HvP1','Sailing Airwaves (In Memory of Matt Trigle)',31,'2018-02-08 15:41:04','2018-02-08 16:35:36','2018-02-08 16:35:36'),(55,'2MvXrN8hxHnT90ekb6FSST','Cobra',27,'2018-02-08 15:38:13','2018-02-08 16:35:36','2018-02-08 16:35:36'),(56,'21GZaJfJaXokJzGpsNrBEg','The Odd Number',27,'2018-02-08 15:34:32','2018-02-08 16:35:36','2018-02-08 16:35:36'),(57,'70vUDalMqqOxrCp1dY3Exj','Frozen - LTN Sunrise Remix',27,'2018-02-08 15:30:35','2018-02-08 16:35:36','2018-02-08 16:35:36'),(58,'2AJ6sqDx8UNpS5JtFYSaJe','Kyokushin',36,'2018-02-08 15:26:50','2018-02-08 16:35:36','2018-02-08 16:35:36'),(59,'2DhVlBGUzsrWXB8QxiKR2d','On Fire',28,'2018-02-08 15:22:27','2018-02-08 16:35:36','2018-02-08 16:35:36'),(60,'5JNTZfFoVb6a2xJJXU1YmR','Mechanizer',31,'2018-02-08 16:35:23','2018-02-08 16:41:07','2018-02-08 16:41:07');
/*!40000 ALTER TABLE `tracks` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `users` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2018-02-08 17:25:02
