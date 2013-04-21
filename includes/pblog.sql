/*
SQLyog Trial v11.01 (64 bit)
MySQL - 5.5.24-log : Database - pblog
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
CREATE DATABASE /*!32312 IF NOT EXISTS*/`pblog` /*!40100 DEFAULT CHARACTER SET utf8 */;

USE `pblog`;

/*Table structure for table `pb_comments` */

DROP TABLE IF EXISTS `pb_comments`;

CREATE TABLE `pb_comments` (
  `comment_id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `post_id` bigint(20) unsigned NOT NULL DEFAULT '0',
  `comment_author` tinytext NOT NULL,
  `comment_author_email` varchar(100) NOT NULL DEFAULT '',
  `comment_author_url` varchar(200) NOT NULL DEFAULT '',
  `comment_author_IP` varchar(100) NOT NULL DEFAULT '',
  `comment_date` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `comment_date_gmt` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `comment_content` text NOT NULL,
  `comment_approved` varchar(20) NOT NULL DEFAULT 'unapproved',
  `comment_agent` varchar(255) NOT NULL DEFAULT '',
  `comment_parent` bigint(20) unsigned NOT NULL DEFAULT '0',
  `user_id` bigint(20) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`comment_id`),
  KEY `comment_parent` (`comment_parent`),
  KEY `comment_date_gmt` (`comment_date_gmt`),
  KEY `comment_approved_date_gmt` (`comment_approved`,`comment_date_gmt`),
  KEY `comment_post_id` (`post_id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8;

/*Table structure for table `pb_meta` */

DROP TABLE IF EXISTS `pb_meta`;

CREATE TABLE `pb_meta` (
  `meta_id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `object_id` bigint(20) unsigned NOT NULL DEFAULT '0',
  `object_type` varchar(20) NOT NULL DEFAULT '',
  `meta_key` varchar(255) DEFAULT NULL,
  `meta_value` longtext,
  PRIMARY KEY (`meta_id`),
  KEY `meta_type_id_key` (`object_type`,`object_id`,`meta_key`)
) ENGINE=InnoDB AUTO_INCREMENT=19 DEFAULT CHARSET=utf8;

/*Table structure for table `pb_posts` */

DROP TABLE IF EXISTS `pb_posts`;

CREATE TABLE `pb_posts` (
  `post_id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `post_author` bigint(20) unsigned NOT NULL DEFAULT '0',
  `post_category` bigint(20) unsigned NOT NULL,
  `post_date` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `post_date_gmt` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `post_content` longtext NOT NULL,
  `post_title` text NOT NULL,
  `post_excerpt` text NOT NULL,
  `post_status` varchar(20) NOT NULL DEFAULT '',
  `comment_status` varchar(20) NOT NULL DEFAULT '',
  `post_name` text NOT NULL,
  `post_modified` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `post_modified_gmt` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `post_parent` bigint(20) unsigned NOT NULL DEFAULT '0',
  `post_url` varchar(255) NOT NULL DEFAULT '',
  `post_type` varchar(20) NOT NULL DEFAULT '',
  `post_mime_type` varchar(100) NOT NULL DEFAULT '',
  `comment_count` bigint(20) NOT NULL DEFAULT '0',
  PRIMARY KEY (`post_id`),
  KEY `post_parent` (`post_parent`),
  KEY `post_author` (`post_author`),
  KEY `type_status_date` (`post_type`,`post_status`,`post_date`,`post_id`)
) ENGINE=InnoDB AUTO_INCREMENT=20 DEFAULT CHARSET=utf8;

/*Table structure for table `pb_term_relationships` */

DROP TABLE IF EXISTS `pb_term_relationships`;

CREATE TABLE `pb_term_relationships` (
  `object_id` bigint(20) unsigned NOT NULL DEFAULT '0',
  `term_id` bigint(20) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`object_id`,`term_id`),
  KEY `term_id` (`term_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Table structure for table `pb_terms` */

DROP TABLE IF EXISTS `pb_terms`;

CREATE TABLE `pb_terms` (
  `term_id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `term_name` varchar(200) NOT NULL DEFAULT '',
  `term_slug` varchar(200) NOT NULL DEFAULT '',
  `taxonomy` varchar(32) NOT NULL DEFAULT '',
  `description` longtext NOT NULL,
  `parent` bigint(20) unsigned NOT NULL DEFAULT '0',
  `count` bigint(20) NOT NULL DEFAULT '0',
  PRIMARY KEY (`term_id`),
  KEY `taxonomy` (`taxonomy`),
  KEY `term_name_taxonomy` (`term_name`,`taxonomy`),
  KEY `term_slug` (`term_slug`)
) ENGINE=InnoDB AUTO_INCREMENT=39 DEFAULT CHARSET=utf8;

/*Table structure for table `pb_users` */

DROP TABLE IF EXISTS `pb_users`;

CREATE TABLE `pb_users` (
  `user_id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `user_login` varchar(60) NOT NULL DEFAULT '',
  `user_pass` varchar(64) NOT NULL DEFAULT '',
  `user_nicename` varchar(50) NOT NULL DEFAULT '',
  `user_displayname` varchar(250) NOT NULL DEFAULT '',
  `user_email` varchar(100) NOT NULL DEFAULT '',
  `user_registered` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `user_registered_gmt` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `user_status` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`user_id`),
  KEY `user_nicename` (`user_nicename`),
  KEY `user_login` (`user_login`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
