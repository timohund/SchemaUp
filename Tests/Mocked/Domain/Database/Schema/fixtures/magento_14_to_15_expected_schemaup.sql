CREATE TABLE `importexport_importdata` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `entity` varchar(50) NOT NULL,
  `behavior` set('append','replace','delete') NOT NULL DEFAULT 'append',
  `data` mediumtext NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
CREATE TABLE `paypal_cert` (
  `cert_id` smallint(5) unsigned NOT NULL AUTO_INCREMENT,
  `website_id` smallint(5) unsigned NOT NULL DEFAULT '0',
  `content` mediumblob NOT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`cert_id`),
  KEY `IDX_PAYPAL_CERT_WEBSITE` (`website_id`),
  CONSTRAINT `FK_PAYPAL_CERT_WEBSITE` FOREIGN KEY (`website_id`) REFERENCES `core_website` (`website_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
ALTER TABLE `sales_flat_invoice` ADD `base_total_refunded` decimal(12,4) DEFAULT NULL;
CREATE TABLE `sales_order_status` (
  `status` varchar(32) NOT NULL,
  `label` varchar(128) NOT NULL,
  PRIMARY KEY (`status`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
CREATE TABLE `sales_order_status_label` (
  `status` varchar(32) NOT NULL,
  `store_id` smallint(5) unsigned NOT NULL,
  `label` varchar(128) NOT NULL,
  PRIMARY KEY (`status`,`store_id`),
  KEY `FK_SALES_ORDER_STATUS_LABEL_STORE` (`store_id`),
  CONSTRAINT `FK_SALES_ORDER_STATUS_LABEL_STATUS` FOREIGN KEY (`status`) REFERENCES `sales_order_status` (`status`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `FK_SALES_ORDER_STATUS_LABEL_STORE` FOREIGN KEY (`store_id`) REFERENCES `core_store` (`store_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
CREATE TABLE `sales_order_status_state` (
  `status` varchar(32) NOT NULL,
  `state` varchar(32) NOT NULL,
  `is_default` tinyint(1) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`status`,`state`),
  CONSTRAINT `FK_SALES_ORDER_STATUS_STATE_STATUS` FOREIGN KEY (`status`) REFERENCES `sales_order_status` (`status`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
ALTER TABLE `wishlist_item` ADD `qty` decimal(12,4) NOT NULL;
CREATE TABLE `wishlist_item_option` (
  `option_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `wishlist_item_id` int(10) unsigned NOT NULL,
  `product_id` int(10) unsigned NOT NULL,
  `code` varchar(255) NOT NULL,
  `value` text NOT NULL,
  PRIMARY KEY (`option_id`),
  KEY `FK_WISHLIST_ITEM_OPTION_ITEM_ID` (`wishlist_item_id`),
  CONSTRAINT `FK_WISHLIST_ITEM_OPTION_ITEM_ID` FOREIGN KEY (`wishlist_item_id`) REFERENCES `wishlist_item` (`wishlist_item_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Additional options for wishlist item';
CREATE TABLE `xmlconnect_application` (
  `application_id` smallint(5) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `code` varchar(32) NOT NULL,
  `type` varchar(32) NOT NULL,
  `store_id` smallint(5) unsigned DEFAULT NULL,
  `active_from` date DEFAULT NULL,
  `active_to` date DEFAULT NULL,
  `updated_at` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `configuration` blob,
  `status` tinyint(1) NOT NULL DEFAULT '0',
  `browsing_mode` tinyint(1) DEFAULT '0',
  PRIMARY KEY (`application_id`),
  UNIQUE KEY `UNQ_XMLCONNECT_APPLICATION_CODE` (`code`),
  KEY `FK_XMLCONNECT_APPLICAION_STORE` (`store_id`),
  CONSTRAINT `FK_XMLCONNECT_APPLICAION_STORE` FOREIGN KEY (`store_id`) REFERENCES `core_store` (`store_id`) ON DELETE SET NULL ON UPDATE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
CREATE TABLE `xmlconnect_history` (
  `history_id` int(11) NOT NULL AUTO_INCREMENT,
  `application_id` smallint(5) unsigned NOT NULL,
  `created_at` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `store_id` smallint(5) unsigned DEFAULT NULL,
  `params` blob,
  `title` varchar(200) NOT NULL,
  `activation_key` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `code` varchar(255) NOT NULL,
  PRIMARY KEY (`history_id`),
  KEY `FK_XMLCONNECT_HISTORY_APPLICATION` (`application_id`),
  CONSTRAINT `FK_XMLCONNECT_HISTORY_APPLICATION` FOREIGN KEY (`application_id`) REFERENCES `xmlconnect_application` (`application_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
CREATE TABLE `xmlconnect_notification_template` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `app_code` varchar(32) NOT NULL,
  `name` varchar(255) NOT NULL,
  `push_title` varchar(141) NOT NULL,
  `message_title` varchar(255) NOT NULL,
  `content` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `modified_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`),
  KEY `FK_APP_CODE` (`app_code`),
  CONSTRAINT `FK_APP_CODE` FOREIGN KEY (`app_code`) REFERENCES `xmlconnect_application` (`code`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
CREATE TABLE `xmlconnect_queue` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `create_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `exec_time` timestamp NULL DEFAULT NULL,
  `template_id` int(11) NOT NULL,
  `push_title` varchar(140) NOT NULL,
  `message_title` varchar(255) NOT NULL,
  `content` text NOT NULL,
  `status` tinyint(4) NOT NULL DEFAULT '0',
  `type` varchar(12) NOT NULL,
  `app_code` varchar(32) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_TEMPLATE_ID` (`template_id`),
  CONSTRAINT `FK_TEMPLATE_ID` FOREIGN KEY (`template_id`) REFERENCES `xmlconnect_notification_template` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;