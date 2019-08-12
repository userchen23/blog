/*
MySQL Data Transfer
Source Host: localhost
Source Database: thinkphp5
Target Host: localhost
Target Database: thinkphp5
Date: 2019/8/12 12:29:24
*/

SET FOREIGN_KEY_CHECKS=0;
-- ----------------------------
-- Table structure for classify
-- ----------------------------
DROP TABLE IF EXISTS `classify`;
CREATE TABLE `classify` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `cname` varchar(20) NOT NULL DEFAULT '',
  `pid` varchar(20) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=8 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for jurisdiction
-- ----------------------------
DROP TABLE IF EXISTS `jurisdiction`;
CREATE TABLE `jurisdiction` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `status` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for message
-- ----------------------------
DROP TABLE IF EXISTS `message`;
CREATE TABLE `message` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `cid` varchar(10) NOT NULL DEFAULT '' COMMENT '类别',
  `userid` int(11) NOT NULL,
  `content` varchar(100) NOT NULL DEFAULT '',
  `img` varchar(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=14 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for user
-- ----------------------------
DROP TABLE IF EXISTS `user`;
CREATE TABLE `user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(20) NOT NULL DEFAULT '',
  `password` varchar(40) NOT NULL DEFAULT '',
  `phone` varchar(11) NOT NULL DEFAULT '',
  `status` int(10) NOT NULL COMMENT '1 for menber,2 for manager',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=12 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records 
-- ----------------------------
INSERT INTO `classify` VALUES ('1', '电子产品', '0');
INSERT INTO `classify` VALUES ('2', '手机', '1');
INSERT INTO `classify` VALUES ('3', '电脑', '1');
INSERT INTO `classify` VALUES ('4', '智能手机', '2');
INSERT INTO `classify` VALUES ('5', '笔记本电脑', '3');
INSERT INTO `classify` VALUES ('6', '台式电脑', '3');
INSERT INTO `classify` VALUES ('7', '老人机', '2');
INSERT INTO `jurisdiction` VALUES ('1', '1', '普通成员');
INSERT INTO `jurisdiction` VALUES ('2', '2', '管理员');
INSERT INTO `jurisdiction` VALUES ('3', '3', 'BOSS');
INSERT INTO `message` VALUES ('1', '5', '1', '12323123123', '');
INSERT INTO `message` VALUES ('5', '7', '10', '1235人', '');
INSERT INTO `message` VALUES ('4', '4', '10', '啊啊啊啊1', '');
INSERT INTO `message` VALUES ('9', '4', '1', 'qqqq', 'uploads/20190413\\747c95e4c80170769ba1e6790a3d8881.jpg');
INSERT INTO `message` VALUES ('12', '7', '1', '7777', 'uploads/20190413\\26b6607f8d8bca99e9dc7600c3033abd.jpg');
INSERT INTO `message` VALUES ('10', '4', '1', '1111', 'uploads/20190413\\dfc5ce81a3c5134fbcc7bc1a94d59e72.jpg');
INSERT INTO `user` VALUES ('1', '01', '123', '123', '2');
INSERT INTO `user` VALUES ('10', '嗷嗷', '321', '321', '1');
INSERT INTO `user` VALUES ('11', '管理员1', '12345', '12345', '2');
INSERT INTO `user` VALUES ('2', 'root', 'asd123', '13166991570', '3');
