# ************************************************************
# Sequel Pro SQL dump
# Version 3408
#
# http://www.sequelpro.com/
# http://code.google.com/p/sequel-pro/
#
# Host: 127.0.0.1 (MySQL 5.5.42)
# Database: user_system
# Generation Time: 2017-04-24 23:23:30 +0000
# ************************************************************


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


# Dump of table user_info
# ------------------------------------------------------------

DROP TABLE IF EXISTS `user_info`;

CREATE TABLE `user_info` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `pid` int(11) NOT NULL,
  `username` varchar(32) NOT NULL DEFAULT '',
  `email` varchar(32) NOT NULL DEFAULT '',
  `password` varchar(32) NOT NULL DEFAULT '',
  `disabled_update_password` int(11) NOT NULL DEFAULT '1',
  `disabled_create_user` int(11) NOT NULL DEFAULT '2',
  `login_mode` int(11) NOT NULL DEFAULT '2',
  `access_status` int(11) NOT NULL DEFAULT '2',
  `login_log_status` int(11) NOT NULL DEFAULT '2',
  `action_log_status` int(11) NOT NULL DEFAULT '2',
  `role` int(11) DEFAULT NULL,
  `rotes` int(11) DEFAULT NULL,
  `token` varchar(32) NOT NULL DEFAULT '',
  `status` int(11) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Dump of table user_log_action
# ------------------------------------------------------------

DROP TABLE IF EXISTS `user_log_action`;

CREATE TABLE `user_log_action` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `request_params` longtext,
  `response_params` longtext,
  `type` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Dump of table user_log_login
# ------------------------------------------------------------

DROP TABLE IF EXISTS `user_log_login`;

CREATE TABLE `user_log_login` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `username` varchar(32) DEFAULT '',
  `email` varchar(32) DEFAULT '',
  `password` varchar(32) DEFAULT '',
  `token` varchar(32) DEFAULT '',
  `request_params` longtext,
  `response_params` longtext,
  `type` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Dump of table user_log_update_token
# ------------------------------------------------------------

DROP TABLE IF EXISTS `user_log_update_token`;

CREATE TABLE `user_log_update_token` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `u_id` int(11) NOT NULL,
  `u_login_mode` int(11) NOT NULL,
  `u_old_token` varchar(32) NOT NULL DEFAULT '',
  `u_new_token` varchar(32) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Dump of table user_role
# ------------------------------------------------------------

DROP TABLE IF EXISTS `user_role`;

CREATE TABLE `user_role` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(32) NOT NULL DEFAULT '',
  `desc` text,
  `status` int(11) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Dump of table user_router
# ------------------------------------------------------------

DROP TABLE IF EXISTS `user_router`;

CREATE TABLE `user_router` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `path` varchar(226) NOT NULL DEFAULT '',
  `name` varchar(226) NOT NULL DEFAULT '',
  `desc` text,
  `icon_class` varchar(226) DEFAULT '',
  `status` int(11) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;




/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
