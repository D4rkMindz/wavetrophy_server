/*
SQLyog Community v12.4.1 (64 bit)
MySQL - 10.1.33-MariaDB : Database - wavetrophy
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
CREATE DATABASE /*!32312 IF NOT EXISTS*/`wavetrophy` /*!40100 DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci */;

USE `wavetrophy`;

/*Data for the table `address` */

insert  into `address`(`id`,`hash`,`wavetrophy_hash`,`road_group_hash`,`name`,`city`,`street`,`zipcode`,`coordinate_lat`,`coordinate_lon`,`map_url_android`,`map_url_ios`,`description`,`created_at`,`created_by`,`modified_at`,`modified_by`,`archived_at`,`archived_by`,`comment`) values 
(1,'winti-1','wave2018','group1','Winterthur Technorama','Winterthur','Bahnhofstrasse 1','8001','47.500412','8.676881','https://maps.google.com/?daddr=47.388789,8.676881+to:47.500412,8.676881','https://maps.apple.com/?daddr=47.388789,8.676881+to:47.500412,8.676881','Ein weiterer Halt im Technorama für unsere tolle WAVETROPHY','2018-08-14 16:47:43','0',NULL,NULL,NULL,NULL,NULL);

/*Data for the table `address_image` */

insert  into `address_image`(`id`,`image_hash`,`address_hash`,`created_at`,`created_by`,`modified_at`,`modified_by`,`archived_at`,`archived_by`) values 
(1,'image1','winti-1','2018-08-14 16:49:20','0',NULL,NULL,NULL,NULL);

/*Data for the table `car` */

/*Data for the table `contact` */

insert  into `contact`(`id`,`hash`,`position`,`phonenumber`,`first_name`,`last_name`,`email`,`wavetrohpy_hash`,`created_at`,`created_by`,`modified_at`,`modified_by`,`archived_at`,`archived_by`) values 
(1,'bp','Group Leader','+41765432198','Björn','Pfoster','bjoern.pfoster@google.com','wave2018','2018-08-15 18:07:37','0',NULL,NULL,NULL,NULL),
(2,'lm','Group Video Assistant','+41791346791','Lorenz','Mustermann','','wave2018','2018-08-15 18:08:30','0',NULL,NULL,NULL,NULL),
(3,'ct','Group Assistant','+41778889911','Remo','Tester','remo@tester.com','wave2018','2018-08-15 18:09:13','0',NULL,NULL,NULL,NULL),
(4,'bp','Og','+41767678899','Bernhard','Pfister','pfister@wave.com','wave2017','2018-08-15 18:09:59','0',NULL,NULL,NULL,NULL);

/*Data for the table `event` */

insert  into `event`(`id`,`hash`,`group_hash`,`address_hash`,`title`,`description`,`start`,`end`,`day`,`created_at`,`created_by`,`modified_at`,`modified_by`,`archived_at`,`archived_by`) values 
(1,'event-winti','group1','winti-1','Ankunft','','2018-08-15 09:00:00','2018-08-15 09:45:00','1','2018-08-15 09:06:47','0',NULL,NULL,NULL,NULL),
(2,'event-wint-2','group1','winti-1','Führung','Eine Führung durch das Technorama','2018-08-15 10:00:00','2018-08-15 11:00:00','1','2018-08-15 09:08:12','0',NULL,NULL,NULL,NULL),
(3,'event-winti-3','group2','winti-1','Ankunft','','2018-08-15 10:00:00','2018-08-15 10:45:00','2','2018-08-15 09:09:13','0',NULL,NULL,NULL,NULL);

/*Data for the table `event_image` */

/*Data for the table `image` */

insert  into `image`(`id`,`hash`,`url`,`name`,`created_at`,`created_by`,`modified_at`,`modified_by`,`archived_at`,`archived_by`) values 
(1,'image1','https://www.20min.ch/diashow/195017/E36521B8D7E15A4D660954DCAC58080B.jpg','Winterthur Technorama','2018-08-14 16:50:14','0',NULL,NULL,NULL,NULL);

/*Data for the table `permission` */

insert  into `permission`(`id`,`hash`,`name`,`level`,`created_at`,`created_by`,`modified_at`,`modified_by`,`archived_at`,`archived_by`) values 
(1,'asdf','Super Admin','64','2018-08-22 12:29:39','0',NULL,NULL,NULL,NULL);

/*Data for the table `position` */

/*Data for the table `road_group` */

insert  into `road_group`(`id`,`hash`,`wavetrophy_hash`,`name`,`created_at`,`created_by`,`modified_at`,`archived_at`,`archived_by`,`modified_by`) values 
(1,'group1','wave2018','Gruppe 1 (Tesla)','2018-08-14 16:48:45','0',NULL,NULL,NULL,NULL),
(2,'group2','wave2018','Gruppe 2 (Renault)','2018-08-14 16:48:45','0',NULL,NULL,NULL,NULL),
(3,'group3','wave2019','Gruppe 3 (Test)','2018-08-14 16:48:45','0',NULL,NULL,NULL,NULL),
(4,'wt5b8469feb881c6.20151464','wave2018','asdf','2018-08-27 23:15:42','user1',NULL,NULL,NULL,NULL),
(5,'wt5b846aa2a958c1.48311911','wave2018','Gruppe 7','2018-08-27 23:18:26','user1',NULL,NULL,NULL,NULL),
(6,'wt5b846b500d51d1.91605013','wave2018','Gruppe 8 (TeSLa)','2018-08-27 23:21:20','user1',NULL,NULL,NULL,NULL);

/*Data for the table `team` */

insert  into `team`(`id`,`hash`,`group_hash`,`car_hash`,`name`,`created_at`,`created_by`,`modified_at`,`modified_by`,`archived_at`,`archived_by`) values 
(1,'team1','group1','car1','Team 1','2018-08-22 12:30:03','0',NULL,NULL,NULL,NULL);

/*Data for the table `team_user` */

/*Data for the table `user` */

insert  into `user`(`id`,`hash`,`permission_hash`,`username`,`password`,`language`,`first_name`,`email`,`last_name`,`is_public`,`mobile_number`,`created_at`,`created_by`,`modified_at`,`modified_by`,`archived_at`,`archived_by`) values 
(1,'user1','asdf','bjoern','$2y$10$3EUlesktnig.5hqCrKja6.gPmxQS60SBJPg2yth/MMv7xv6TJbLQu','de_CH','Björn','bjoern.pfoster@gmail.com','Pfoster',0,'+41764510128','2018-08-22 12:30:55','0',NULL,NULL,NULL,NULL);

/*Data for the table `wavetrophy` */

insert  into `wavetrophy`(`id`,`hash`,`name`,`country`,`created_at`,`created_by`,`modified_at`,`modified_by`,`archived_at`,`archived_by`) values 
(1,'wave2018','WAVETROPHY 2018 Switzerland','ch','2018-08-14 16:48:12','0',NULL,NULL,NULL,NULL),
(2,'wave2019','WAVETROPHY 2019 Switzerland','ch','2018-08-14 16:48:12','0',NULL,NULL,NULL,NULL);

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
