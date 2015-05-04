/*
Navicat MySQL Data Transfer

Source Server         : homeMySQL
Source Server Version : 50534
Source Host           : localhost:3306
Source Database       : baredv2

Target Server Type    : MYSQL
Target Server Version : 50534
File Encoding         : 65001

Date: 2015-05-01 17:28:02
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for `landing_page`
-- ----------------------------
DROP TABLE IF EXISTS `landing_page`;
CREATE TABLE `landing_page` (
  `landing_page_id` int(20) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `image_name` varchar(255) NOT NULL,
  `url` text NOT NULL,
  `sort_order` int(11) NOT NULL,
  `created` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `modified` datetime DEFAULT NULL,
  PRIMARY KEY (`landing_page_id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of landing_page
-- ----------------------------
INSERT INTO `landing_page` VALUES ('1', 'Shop Men\'s', 'Mens.jpg', 'test', '2', '2015-05-01 11:52:08', '2015-05-01 05:33:35');
INSERT INTO `landing_page` VALUES ('2', 'Shop Women\'s', 'Womens.jpg', '', '1', '2015-05-01 11:52:14', '2015-05-01 05:34:02');
