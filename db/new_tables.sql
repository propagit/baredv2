
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



--
-- Table structure for table `instagram_gallery`
--

CREATE TABLE `instagram_gallery` (
`instagram_gallery_id` int(11) unsigned NOT NULL,
  `name` varchar(255) NOT NULL,
  `image` varchar(255) NOT NULL,
  `product_id` int(11) NOT NULL COMMENT 'Product id',
  `home_category` tinyint(11) NOT NULL COMMENT '1: Men, 2: Women',
  `sort_order` int(11) NOT NULL DEFAULT '0',
  `status` tinyint(4) NOT NULL DEFAULT '0' COMMENT '0:Inactive, 1:Active',
  `created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `instagram_gallery`
--
ALTER TABLE `instagram_gallery`
 ADD PRIMARY KEY (`instagram_gallery_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `instagram_gallery`
--
ALTER TABLE `instagram_gallery`
MODIFY `instagram_gallery_id` int(11) unsigned NOT NULL AUTO_INCREMENT;


ALTER TABLE `products_features` ADD `home_category` TINYINT NOT NULL DEFAULT '1' COMMENT 'Flags which home page ''men'' or ''women'' does this belong to. 1 Mens: 2 Female' AFTER `order`;

ALTER TABLE `tiles` ADD `category` TINYINT NOT NULL DEFAULT '0' COMMENT '1: male section, 2: female section' AFTER `sort_order`;
ALTER TABLE `tiles` ADD `btn_name` VARCHAR(255) NOT NULL AFTER `name`, ADD `caption` TEXT NOT NULL AFTER `btn_name`;
ALTER TABLE `tiles` ADD `btn_visibility` TINYINT NOT NULL DEFAULT '0' COMMENT '1: visible, 0: not visible. Default 0' AFTER `category`;

ALTER TABLE banners
ADD category tinyint NOT NULL;

ALTER TABLE banners
ADD caption text NOT NULL;
