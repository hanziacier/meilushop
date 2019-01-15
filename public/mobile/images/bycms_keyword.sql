-- phpMyAdmin SQL Dump
-- version phpStudy 2014
-- http://www.phpmyadmin.net
--
-- 主机: localhost
-- 生成日期: 2018 年 03 月 27 日 14:57
-- 服务器版本: 5.5.53
-- PHP 版本: 5.4.45

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- 数据库: `sc`
--

-- --------------------------------------------------------

--
-- 表的结构 `bycms_keyword`
--

CREATE TABLE IF NOT EXISTS `bycms_keyword` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '分类ID',
  `title` varchar(225) NOT NULL DEFAULT '' COMMENT '标题',
  `uid` varchar(225) NOT NULL DEFAULT '' COMMENT '链接',
  `remark` varchar(225) NOT NULL DEFAULT '',
  `create_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '创建时间',
  `update_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '更新时间',
  `key` varchar(225) DEFAULT NULL,
  `status` int(2) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='搜索表' AUTO_INCREMENT=19 ;

--
-- 转存表中的数据 `bycms_keyword`
--

INSERT INTO `bycms_keyword` (`id`, `title`, `uid`, `remark`, `create_time`, `update_time`, `key`, `status`) VALUES
(17, 'tyt', '0', '', 1521303751, 0, '711521301044', 1),
(10, 'ert', '0', '', 1521297753, 0, NULL, 1),
(11, 'jkljl', '0', '', 1521298157, 0, NULL, 1),
(15, 'jkljl', '0', '', 1521303139, 0, '711521301044', 0),
(13, '4656', '0', '', 1521301050, 0, '711521301044', 0),
(14, '7899', '0', '', 1521301092, 0, '711521301044', 0),
(16, 'yu', '0', '', 1521303147, 0, '711521301044', 0),
(18, 'ert', '0', '', 1521607179, 0, '421521434637', 1);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
