CREATE DATABASE  IF NOT EXISTS `sensorbase` /*!40100 DEFAULT CHARACTER SET utf8 */;
USE `sensorbase`;
-- MySQL dump 10.13  Distrib 5.5.44, for debian-linux-gnu (armv7l)
--
-- Host: 178.62.121.17    Database: sensorbase
-- ------------------------------------------------------
-- Server version	5.5.47-0ubuntu0.14.04.1

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
-- Table structure for table `locations`
--

DROP TABLE IF EXISTS `locations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `locations` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `zone_id` int(11) NOT NULL,
  `lattitude` decimal(11,8) NOT NULL,
  `longitude` decimal(11,8) NOT NULL,
  `name` varchar(255) NOT NULL,
  `date_added` datetime NOT NULL,
  `date_modified` datetime DEFAULT NULL,
  `zones_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_locations_zones_idx` (`zones_id`),
  CONSTRAINT `fk_locations_zones` FOREIGN KEY (`zones_id`) REFERENCES `zones` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `sensor_data`
--

DROP TABLE IF EXISTS `sensor_data`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `sensor_data` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `sensor_id` int(11) NOT NULL,
  `value` varchar(255) NOT NULL,
  `sequence` int(11) NOT NULL,
  `date_added` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_sensor_data_sensors1_idx` (`sensor_id`),
  CONSTRAINT `fk_sensor_data_sensor1` FOREIGN KEY (`sensor_id`) REFERENCES `sensors` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `sensor_types`
--

DROP TABLE IF EXISTS `sensor_types`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `sensor_types` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `type` varchar(255) NOT NULL,
  `date_added` datetime NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `type_UNIQUE` (`type`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `sensors`
--

DROP TABLE IF EXISTS `sensors`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `sensors` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `location_id` int(11) NOT NULL,
  `unit` varchar(45) NOT NULL,
  `last` datetime NOT NULL,
  `date_added` datetime NOT NULL,
  `date_modified` datetime DEFAULT NULL,
  `sensor_type_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_sensors_locations1_idx` (`location_id`),
  KEY `fk_sensors_sensor_types1_idx` (`sensor_type_id`),
  CONSTRAINT `fk_sensors_locations1` FOREIGN KEY (`location_id`) REFERENCES `locations` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_sensors_sensor_types1` FOREIGN KEY (`sensor_type_id`) REFERENCES `sensor_types` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `stations`
--

DROP TABLE IF EXISTS `stations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `stations` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `date_added` datetime NOT NULL,
  `zone_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_stations_zones1_idx` (`zone_id`),
  CONSTRAINT `fk_stations_zones1` FOREIGN KEY (`zone_id`) REFERENCES `zones` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `zones`
--

DROP TABLE IF EXISTS `zones`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `zones` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `date_added` datetime NOT NULL,
  `date_modified` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id_UNIQUE` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2016-02-19 10:19:38
