CREATE TABLE `tiles` (
  `tile_id` int(20) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `tile_uri` text NOT NULL,
  `new_window` tinyint(4) NOT NULL DEFAULT '0' COMMENT '1: open in new window',
  `status` tinyint(4) NOT NULL DEFAULT '1',
  `image_name` varchar(255) NOT NULL,
  `created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `modified` datetime NOT NULL,
  PRIMARY KEY (`tile_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;
ALTER TABLE `tiles` CHANGE `status` `status` TINYINT(4) NOT NULL DEFAULT '0';
ALTER TABLE `homepage` ADD `tiles` INT NOT NULL AFTER `stories`;


ALTER TABLE `tiles` ADD `sort_order` INT NOT NULL AFTER `image_name`;