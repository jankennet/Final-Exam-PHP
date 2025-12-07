/*
SQLyog Community v13.3.1 (64 bit)
MySQL - 10.4.32-MariaDB : Database - belano_visitor_system
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
CREATE DATABASE /*!32312 IF NOT EXISTS*/`belano_visitor_system` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci */;

USE `belano_visitor_system`;

/*Table structure for table `users` */

DROP TABLE IF EXISTS `users`;

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `full_name` varchar(100) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`user_id`),
  UNIQUE KEY `username` (`username`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

/*Data for the table `users` */

insert  into `users`(`user_id`,`username`,`password`,`full_name`,`created_at`) values 
(1,'pogi','$2b$10$/M/UEpYxCM0iH3Ojj1WNoOX0NJ3ajrI9NIh0pIzvv093FhK5CI49C','Administrator','2025-12-07 17:13:58');

/*Table structure for table `visitors` */

DROP TABLE IF EXISTS `visitors`;

CREATE TABLE `visitors` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `visitor_name` varchar(100) NOT NULL,
  `date_of_visit` date NOT NULL,
  `time_of_visit` time NOT NULL,
  `address` text NOT NULL,
  `contact_number` varchar(20) NOT NULL,
  `school_office` varchar(100) NOT NULL,
  `purpose` enum('inquiry','exam','visit','others') NOT NULL,
  `purpose_details` text DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `created_by` (`created_by`),
  KEY `idx_date` (`date_of_visit`),
  KEY `idx_purpose` (`purpose`),
  CONSTRAINT `visitors_ibfk_1` FOREIGN KEY (`created_by`) REFERENCES `users` (`user_id`) ON DELETE SET NULL
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

/*Data for the table `visitors` */

insert  into `visitors`(`id`,`visitor_name`,`date_of_visit`,`time_of_visit`,`address`,`contact_number`,`school_office`,`purpose`,`purpose_details`,`created_by`,`created_at`) values 
(1,'Jan Kennet Belano','2025-12-07','17:13:58','Sorsogon City','09565842417','Somewhere far away','visit','Final Exam Schedule Inquiry',1,'2025-12-07 17:13:58'),
(2,'John Kenneth Belano','2025-12-07','17:13:58','Sorsogon City','09565842417','Ticol University','inquiry','Course Enrollment',1,'2025-12-07 17:13:58'),
(3,'Jn Kenet Belano','2025-12-07','17:13:58','Pogi','09565842417','Pogi Uni','visit','Campus Tour',1,'2025-12-07 17:13:58'),
(4,'Belano, John Kenneth L.','2022-02-10','10:50:00','yes','09565842417','dwad','inquiry','dwadwa',1,'2025-12-07 18:39:29');

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
