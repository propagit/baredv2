ALTER TABLE `tiles` ADD `category` TINYINT NOT NULL DEFAULT '1' COMMENT '1: male section, 2: female section' AFTER `sort_order`;
ALTER TABLE `tiles` ADD `btn_name` VARCHAR(255) NOT NULL AFTER `name`, ADD `caption` TEXT NOT NULL AFTER `btn_name`;
ALTER TABLE `tiles` ADD `btn_visibility` TINYINT NOT NULL DEFAULT '0' COMMENT '1: visible, 0: not visible. Default 0' AFTER `category`;