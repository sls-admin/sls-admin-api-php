-- MySQL dump 10.13  Distrib 5.7.17, for macos10.12 (x86_64)
--
-- Host: 127.0.0.1    Database: sls_admin
-- ------------------------------------------------------
-- Server version	5.5.42

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
-- Table structure for table `demo_article`
--

DROP TABLE IF EXISTS `demo_article`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `demo_article` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT 'id',
  `title` varchar(226) DEFAULT NULL COMMENT '文章标题',
  `content` longtext COMMENT '文章内容',
  `cate` varchar(8) DEFAULT NULL COMMENT '文章分类',
  `tabs` varchar(30) DEFAULT NULL COMMENT '文章标签，不能超过5个',
  `status` int(11) DEFAULT NULL COMMENT '状态。1：启用；2：禁用',
  `uid` int(11) DEFAULT NULL COMMENT '用户ID',
  `create_time` datetime DEFAULT NULL COMMENT '创建时间',
  `update_time` timestamp NULL DEFAULT NULL COMMENT '更新时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=71 DEFAULT CHARSET=utf8 COMMENT='文章表';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `demo_article`
--

LOCK TABLES `demo_article` WRITE;
/*!40000 ALTER TABLE `demo_article` DISABLE KEYS */;
INSERT INTO `demo_article` VALUES (60,'111','<p>11111</p>','技术','html',1,85,'2017-05-08 03:34:12','2017-05-07 19:34:12'),(69,'2','<p>2</p>','sanwen','javascript,html',1,78,'2017-06-20 10:51:19','2017-06-20 02:51:19'),(70,'3','<p>33333</p>','sanwen','javascript,html',1,78,'2017-06-20 10:51:24','2017-06-20 02:51:24');
/*!40000 ALTER TABLE `demo_article` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `demo_order`
--

DROP TABLE IF EXISTS `demo_order`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `demo_order` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT 'id',
  `name` varchar(226) DEFAULT NULL COMMENT '订单名称',
  `status` int(6) DEFAULT NULL COMMENT '订单状态。1->待支付；2->待配送；3->待收货；4->已完成；5->已取消；6->退单',
  `create_time` datetime DEFAULT NULL COMMENT '创建时间',
  `update_time` timestamp NULL DEFAULT NULL COMMENT '更新时间',
  `uid` int(11) DEFAULT NULL COMMENT '用户ID',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `demo_order`
--

LOCK TABLES `demo_order` WRITE;
/*!40000 ALTER TABLE `demo_order` DISABLE KEYS */;
INSERT INTO `demo_order` VALUES (1,'1',3,'2017-02-07 11:02:23','2017-02-07 03:02:23',78),(2,'2',3,'2017-02-07 11:02:37','2017-02-07 03:02:37',78),(3,'3',4,'2017-02-07 11:02:41','2017-02-07 03:02:41',78),(4,'4',1,'2017-02-07 11:02:45','2017-02-07 03:02:45',78),(5,'5',2,'2017-02-07 11:02:49','2017-02-07 03:02:49',78),(6,'6',5,'2017-02-07 11:02:56','2017-02-07 03:02:56',78),(7,'7',6,'2017-02-07 11:02:59','2017-02-07 03:02:59',78),(8,'a',1,'2017-02-07 11:17:52','2017-02-07 03:17:52',78),(9,'q',1,'2017-02-07 11:18:02','2017-02-07 03:18:02',78),(10,'w',1,'2017-02-07 11:18:03','2017-02-07 03:18:03',78),(11,'e',3,'2017-02-07 11:18:09','2017-02-07 03:18:09',78),(12,'rt',3,'2017-02-07 11:18:11','2017-02-07 03:18:11',78),(13,'yuyu',4,'2017-02-07 11:18:15','2017-02-07 03:18:15',78),(14,'11',1,'2017-05-08 03:34:20','2017-05-07 19:34:20',85),(15,'22',1,'2017-05-08 03:34:24','2017-05-07 19:34:24',85),(16,'111',1,'2017-06-03 21:03:12','2017-06-03 13:03:12',78);
/*!40000 ALTER TABLE `demo_order` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `demo_qiniu`
--

DROP TABLE IF EXISTS `demo_qiniu`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `demo_qiniu` (
  `id` int(111) NOT NULL AUTO_INCREMENT COMMENT 'ID',
  `path` varchar(226) DEFAULT NULL COMMENT '图片路径',
  `create_time` datetime DEFAULT NULL COMMENT '创建时间',
  `update_time` timestamp NULL DEFAULT NULL COMMENT '更新时间',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `demo_qiniu`
--

LOCK TABLES `demo_qiniu` WRITE;
/*!40000 ALTER TABLE `demo_qiniu` DISABLE KEYS */;
/*!40000 ALTER TABLE `demo_qiniu` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `demo_setting`
--

DROP TABLE IF EXISTS `demo_setting`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `demo_setting` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'ID',
  `login_style` int(11) DEFAULT '1' COMMENT '登录方式。1->单点登录；2->多点登录。',
  `disabled_update_pass` text COMMENT '禁止修改密码的用户',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `demo_setting`
--

LOCK TABLES `demo_setting` WRITE;
/*!40000 ALTER TABLE `demo_setting` DISABLE KEYS */;
INSERT INTO `demo_setting` VALUES (1,2,'79,81');
/*!40000 ALTER TABLE `demo_setting` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `demo_user`
--

DROP TABLE IF EXISTS `demo_user`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `demo_user` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '用户ID',
  `pid` int(11) DEFAULT '0' COMMENT '父级ID',
  `username` varchar(32) NOT NULL COMMENT '用户名',
  `email` varchar(32) NOT NULL COMMENT '邮箱',
  `password` varchar(32) NOT NULL COMMENT '密码',
  `token` varchar(32) NOT NULL COMMENT 'token',
  `sex` char(1) NOT NULL DEFAULT '3' COMMENT '性别。1->男；2->女；3->保密',
  `status` tinyint(1) NOT NULL DEFAULT '1' COMMENT '状态。1->启用；2->禁用。默认为1.',
  `birthday` date NOT NULL COMMENT '生日。',
  `address` text NOT NULL COMMENT '住址',
  `create_time` datetime DEFAULT NULL COMMENT '创建时间',
  `update_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '修改时间',
  `web_routers` longtext COMMENT '拥有的web端页面路由',
  `api_routers` longtext COMMENT '拥有的API接口路由',
  `default_web_routers` varchar(226) DEFAULT NULL COMMENT '当访问没有权限的页面时默认跳转的地方',
  `access_status` int(11) DEFAULT '2' COMMENT '是否开启权限。1:开启;2:关闭',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=91 DEFAULT CHARSET=utf8 COMMENT='用户表';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `demo_user`
--

LOCK TABLES `demo_user` WRITE;
/*!40000 ALTER TABLE `demo_user` DISABLE KEYS */;
INSERT INTO `demo_user` VALUES (59,0,'sailengsi','sailengsi@126.com','e10adc3949ba59abbe56e057f20f883e','90f84db602b502cd5666b89064607a78','3',1,'1992-11-05','苏州街52号院。','2017-01-27 10:27:08','2017-01-27 10:27:08',NULL,NULL,NULL,NULL);
/*!40000 ALTER TABLE `demo_user` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2017-06-20 23:09:59
