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

/*Data for the table `address_image` */

/*Data for the table `car` */

/*Data for the table `contact` */

/*Data for the table `event` */

/*Data for the table `event_image` */

/*Data for the table `image` */

/*Data for the table `permission` */

insert  into `permission`(`id`,`hash`,`name`,`level`,`created_at`,`created_by`,`modified_at`,`modified_by`,`archived_at`,`archived_by`) values 
(1,'098bd65a-88f9-4be3-b101-36a7233d9dab','Super Admin','64','2018-08-28 19:31:46','0',NULL,NULL,NULL,NULL);

/*Data for the table `position` */

/*Data for the table `road_group` */

/*Data for the table `team` */

/*Data for the table `team_user` */

/*Data for the table `user` */

insert  into `user`(`id`,`hash`,`permission_hash`,`username`,`password`,`language`,`first_name`,`email`,`last_name`,`is_public`,`mobile_number`,`created_at`,`created_by`,`modified_at`,`modified_by`,`archived_at`,`archived_by`) values 
(0,'00dac43a-7e35-4284-812a-8c72ca250f6f','098bd65a-88f9-4be3-b101-36a7233d9dab','admin','$2y$10$T8hPNl7bDfGVAzsRN6026.0pYRN7ino96LJN..ws0xlAmUb4MNfVe','de_CH','Björn','bjoern.pfoster@gmail.com','Pfoster',1,'+41764510128','2018-08-28 19:32:46','0',NULL,NULL,NULL,NULL);

/*Data for the table `wavetrophy` */

insert  into `wavetrophy`(`id`,`hash`,`name`,`country`,`created_at`,`created_by`,`modified_at`,`modified_by`,`archived_at`,`archived_by`) values 
(1,'bca05ad3-6ad7-43e2-8112-7064229563af','WAVETROPHY 2019 Österreich','at','2018-08-28 19:33:15','0',NULL,NULL,NULL,NULL);

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
