-- phpMyAdmin SQL Dump
-- version 4.4.15.6
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: 2017-08-25 17:16:05
-- 服务器版本： 5.6.29-log
-- PHP Version: 7.1.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `sls_admin`
--

-- --------------------------------------------------------

--
-- 表的结构 `demo_article`
--

CREATE TABLE IF NOT EXISTS `demo_article` (
  `id` int(11) unsigned NOT NULL COMMENT 'id',
  `title` varchar(226) DEFAULT NULL COMMENT '文章标题',
  `content` longtext COMMENT '文章内容',
  `cate` varchar(8) DEFAULT NULL COMMENT '文章分类',
  `tabs` varchar(30) DEFAULT NULL COMMENT '文章标签，不能超过5个',
  `status` int(11) DEFAULT NULL COMMENT '状态。1：启用；2：禁用',
  `uid` int(11) DEFAULT NULL COMMENT '用户ID',
  `create_time` datetime DEFAULT NULL COMMENT '创建时间',
  `update_time` timestamp NULL DEFAULT NULL COMMENT '更新时间'
) ENGINE=InnoDB AUTO_INCREMENT=95 DEFAULT CHARSET=utf8 COMMENT='文章表';

--
-- 转存表中的数据 `demo_article`
--

INSERT INTO `demo_article` (`id`, `title`, `content`, `cate`, `tabs`, `status`, `uid`, `create_time`, `update_time`) VALUES
(60, '111', '<p>11111</p>', '技术', 'html', 1, 85, '2017-05-08 03:34:12', '2017-05-07 19:34:12'),
(69, '2', '<p>2</p>', 'sanwen', 'javascript,html', 1, 78, '2017-06-20 10:51:19', '2017-06-20 02:51:19'),
(70, '3', '<p>33333</p>', 'sanwen', 'javascript,html', 1, 78, '2017-06-20 10:51:24', '2017-06-20 02:51:24'),
(73, '333333', '<p>333333</p>', 'jishu', 'css', 1, 59, '2017-06-20 23:54:09', '2017-06-20 15:54:09'),
(74, 'aaaaaaaaeeeee', 'fdfdf', 'sanwen', 'javascript,jquery', NULL, 59, '2017-07-01 02:00:27', '2017-06-30 18:00:27'),
(75, 'ssssssfdfdffdfdfdfdfdfdfdf', '<p>fdfdffdfdf<img src="//slsadmin.api.sls.com/uploads/temp/sailengsi/20170701/bd524f67661b8d1bac7ceeb1ccca6ddd.png" style="max-width: 100%;">fdfdfdfdf</p><p>fdfdffdfdfd</p>', '技术', 'html,angular', 1, 59, '2017-07-01 03:04:12', '2017-06-30 19:04:12'),
(76, 'dsfdf', '<p>fdfdfdfd</p>', '技术', 'html', 1, 59, '2017-07-06 16:40:59', '2017-07-06 08:40:59'),
(77, '1', '<p>rrrrr</p>', 'jishu', 'html', 1, 61, '2017-07-12 17:58:15', '2017-07-12 09:58:15'),
(78, 'q', '<p>q</p>', 'jishu', 'html', 1, 61, '2017-07-12 18:29:19', '2017-07-12 10:29:19'),
(79, 'qq', '<p>qq</p>', 'jishu', 'css', 1, 61, '2017-07-12 18:29:28', '2017-07-12 10:29:28'),
(80, 'w', '<p>w</p>', 'sanwen', 'css', 1, 61, '2017-07-12 18:29:40', '2017-07-12 10:29:40'),
(81, 'e', '<p>e</p>', 'qita', 'css', 1, 61, '2017-07-12 18:29:48', '2017-07-12 10:29:48'),
(82, 'r', '<p>r</p>', 'sanwen', 'javascript', 1, 61, '2017-07-12 18:29:58', '2017-07-12 10:29:58'),
(83, 'yyy', '<p>yyyy</p>', 'qita', 'javascript', 1, 61, '2017-07-12 18:30:12', '2017-07-12 10:30:12'),
(84, 'uu', '<p>uu</p>', 'sanwen', 'css', 1, 61, '2017-07-12 18:30:20', '2017-07-12 10:30:20'),
(85, 'i', '<p>i</p>', 'sanwen', 'css', 1, 61, '2017-07-12 18:30:28', '2017-07-12 10:30:28'),
(86, 'o', '<p>o</p>', 'qita', 'javascript', 1, 61, '2017-07-12 18:30:38', '2017-07-12 10:30:38'),
(87, 'p', '<p>p</p>', 'sanwen', 'css', 1, 61, '2017-07-12 18:30:47', '2017-07-12 10:30:47'),
(89, 'b', '<p>b</p>', 'sanwen', 'css', 1, 59, '2017-07-13 18:06:54', '2017-07-13 10:06:54'),
(90, 'c', '<p>c</p>', 'sanwen', 'javascript', 1, 59, '2017-07-13 18:07:03', '2017-07-13 10:07:03'),
(91, 'd', '<p>d</p>', 'qita', 'jquery', 1, 59, '2017-07-13 18:07:13', '2017-07-13 10:07:13'),
(92, 'f', '<p>e</p>', 'sanwen', 'jquery', 1, 59, '2017-07-13 21:49:34', '2017-07-13 13:49:34'),
(93, '分分分付', '<p>fdfdfdfd</p><p>fdfdfdfdfdf发扥扥发扥扥我曹。</p><p>发扥扥扥的</p><p><img src="//slsadmin.api.sls.com/uploads/temp/sailengsi/20170713/c4814f8f5002d783a55698b841aff87c.png" style="max-width:100%;"><br></p><p>发扥扥</p><p>放到d发扥</p>', '技术', 'html', 1, 59, '2017-07-13 22:53:38', '2017-07-13 14:53:38'),
(94, 'fdfd', '<p>fdfdfdf</p>', 'jishu', 'javascript', 1, 59, '2017-08-20 14:45:53', '2017-08-20 06:45:53');

-- --------------------------------------------------------

--
-- 表的结构 `demo_order`
--

CREATE TABLE IF NOT EXISTS `demo_order` (
  `id` int(11) unsigned NOT NULL COMMENT 'id',
  `name` varchar(226) DEFAULT NULL COMMENT '订单名称',
  `status` int(6) DEFAULT NULL COMMENT '订单状态。1->待支付；2->待配送；3->待收货；4->已完成；5->已取消；6->退单',
  `create_time` datetime DEFAULT NULL COMMENT '创建时间',
  `update_time` timestamp NULL DEFAULT NULL COMMENT '更新时间',
  `uid` int(11) DEFAULT NULL COMMENT '用户ID'
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `demo_order`
--

INSERT INTO `demo_order` (`id`, `name`, `status`, `create_time`, `update_time`, `uid`) VALUES
(1, '1', 3, '2017-02-07 11:02:23', '2017-02-07 03:02:23', 78),
(2, '2', 3, '2017-02-07 11:02:37', '2017-02-07 03:02:37', 78),
(3, '3', 4, '2017-02-07 11:02:41', '2017-02-07 03:02:41', 78),
(4, '4', 1, '2017-02-07 11:02:45', '2017-02-07 03:02:45', 78),
(5, '5', 2, '2017-02-07 11:02:49', '2017-02-07 03:02:49', 78),
(6, '6', 5, '2017-02-07 11:02:56', '2017-02-07 03:02:56', 78),
(7, '7', 6, '2017-02-07 11:02:59', '2017-02-07 03:02:59', 78),
(8, 'a', 1, '2017-02-07 11:17:52', '2017-02-07 03:17:52', 78),
(9, 'q', 1, '2017-02-07 11:18:02', '2017-02-07 03:18:02', 78),
(10, 'w', 1, '2017-02-07 11:18:03', '2017-02-07 03:18:03', 78),
(11, 'e', 3, '2017-02-07 11:18:09', '2017-02-07 03:18:09', 78),
(12, 'rt', 3, '2017-02-07 11:18:11', '2017-02-07 03:18:11', 78),
(13, 'yuyu', 4, '2017-02-07 11:18:15', '2017-02-07 03:18:15', 78),
(14, '11', 1, '2017-05-08 03:34:20', '2017-05-07 19:34:20', 85),
(15, '22', 1, '2017-05-08 03:34:24', '2017-05-07 19:34:24', 85),
(16, '111', 1, '2017-06-03 21:03:12', '2017-06-03 13:03:12', 78);

-- --------------------------------------------------------

--
-- 表的结构 `demo_qiniu`
--

CREATE TABLE IF NOT EXISTS `demo_qiniu` (
  `id` int(111) NOT NULL COMMENT 'ID',
  `path` varchar(226) DEFAULT NULL COMMENT '图片路径',
  `create_time` datetime DEFAULT NULL COMMENT '创建时间',
  `update_time` timestamp NULL DEFAULT NULL COMMENT '更新时间'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `demo_setting`
--

CREATE TABLE IF NOT EXISTS `demo_setting` (
  `id` int(11) NOT NULL COMMENT 'ID',
  `login_style` int(11) DEFAULT '1' COMMENT '登录方式。1->单点登录；2->多点登录。',
  `disabled_update_pass` text COMMENT '禁止修改密码的用户'
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `demo_setting`
--

INSERT INTO `demo_setting` (`id`, `login_style`, `disabled_update_pass`) VALUES
(1, 2, '79,81');

-- --------------------------------------------------------

--
-- 表的结构 `demo_user`
--

CREATE TABLE IF NOT EXISTS `demo_user` (
  `id` int(11) NOT NULL COMMENT '用户ID',
  `pid` int(11) DEFAULT '0' COMMENT '父级ID',
  `username` varchar(32) NOT NULL COMMENT '用户名',
  `email` varchar(32) NOT NULL COMMENT '邮箱',
  `password` varchar(32) NOT NULL COMMENT '密码',
  `token` varchar(32) NOT NULL COMMENT 'token',
  `sex` char(1) NOT NULL COMMENT '性别。1->男；2->女；3->保密',
  `status` tinyint(1) NOT NULL COMMENT '状态。1->启用；2->禁用。默认为1.',
  `birthday` date NOT NULL COMMENT '生日。',
  `address` text NOT NULL COMMENT '住址',
  `create_time` datetime DEFAULT NULL COMMENT '创建时间',
  `update_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '修改时间',
  `access_status` int(11) DEFAULT '2' COMMENT 'access status.1:open;2:close',
  `web_routers` longtext COMMENT 'web pages routers',
  `api_routers` longtext COMMENT 'api routers',
  `default_web_routers` longtext COMMENT 'web pages router not access,default pages'
) ENGINE=InnoDB AUTO_INCREMENT=2042 DEFAULT CHARSET=utf8 COMMENT='用户表';

--
-- 转存表中的数据 `demo_user`
--

INSERT INTO `demo_user` (`id`, `pid`, `username`, `email`, `password`, `token`, `sex`, `status`, `birthday`, `address`, `create_time`, `update_time`, `access_status`, `web_routers`, `api_routers`, `default_web_routers`) VALUES
(59, 0, 'sailengsi', 'mhleilei@163.com', 'e10adc3949ba59abbe56e057f20f883e', '90f84db602b502cd5666b89064607a78', '3', 1, '1992-11-05', '苏州街52号院。', '2017-01-27 10:27:08', '2017-01-27 10:27:08', 2, NULL, NULL, NULL),
(2038, 59, 'a', 'a@a.com', 'e10adc3949ba59abbe56e057f20f883e', '72766c8d1f666dd587fd67d6e6ef97bf', '3', 1, '1992-11-05', '上海市浦东新区', '2017-08-22 18:47:32', '2017-08-22 10:47:32', 2, NULL, NULL, NULL),
(2039, 2038, 'a-1', 'a-1@a-1.com', 'e10adc3949ba59abbe56e057f20f883e', 'd5b337005642c33cdb781ecbf3b0d739', '3', 1, '1992-11-05', '上海市浦东新区', '2017-08-22 18:48:17', '2017-08-22 10:48:17', 2, NULL, NULL, NULL),
(2040, 2038, 'a-2', 'a-2@a-2.com', 'e10adc3949ba59abbe56e057f20f883e', 'c5ef90b44d2cb341a826aa9d09d931eb', '3', 1, '1992-11-05', '上海市浦东新区', '2017-08-22 18:48:36', '2017-08-22 10:48:36', 2, NULL, NULL, NULL),
(2041, 2040, 'a-2-1', 'a-2-1@a-2-1.com', 'e10adc3949ba59abbe56e057f20f883e', 'fa2b5b4fce56be6e9b9ff633d80e5b45', '3', 1, '1992-11-05', '上海市浦东新区', '2017-08-22 18:49:18', '2017-08-22 10:49:18', 2, NULL, NULL, NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `demo_article`
--
ALTER TABLE `demo_article`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `demo_order`
--
ALTER TABLE `demo_order`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `demo_qiniu`
--
ALTER TABLE `demo_qiniu`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `demo_setting`
--
ALTER TABLE `demo_setting`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `demo_user`
--
ALTER TABLE `demo_user`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `demo_article`
--
ALTER TABLE `demo_article`
  MODIFY `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT 'id',AUTO_INCREMENT=95;
--
-- AUTO_INCREMENT for table `demo_order`
--
ALTER TABLE `demo_order`
  MODIFY `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT 'id',AUTO_INCREMENT=17;
--
-- AUTO_INCREMENT for table `demo_qiniu`
--
ALTER TABLE `demo_qiniu`
  MODIFY `id` int(111) NOT NULL AUTO_INCREMENT COMMENT 'ID';
--
-- AUTO_INCREMENT for table `demo_setting`
--
ALTER TABLE `demo_setting`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'ID',AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `demo_user`
--
ALTER TABLE `demo_user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '用户ID',AUTO_INCREMENT=2042;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
