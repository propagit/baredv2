
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