-- --------------------------------------------------------
-- Host:                         127.0.0.1
-- Server version:               5.7.11 - MySQL Community Server (GPL)
-- Server OS:                    Win64
-- HeidiSQL Version:             8.3.0.4694
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;

-- Dumping database structure for qas
CREATE DATABASE IF NOT EXISTS `qas` /*!40100 DEFAULT CHARACTER SET utf8 */;
USE `qas`;


-- Dumping structure for table qas.category_group
CREATE TABLE IF NOT EXISTS `category_group` (
  `category_group_id` int(10) NOT NULL AUTO_INCREMENT COMMENT '分类组别id',
  `content` varchar(50) NOT NULL COMMENT '组别内容',
  `status` enum('active','inactive','delete') NOT NULL COMMENT '状态',
  `created_by` varchar(20) NOT NULL COMMENT '提交人',
  `created_time` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '提交日期',
  `last_updated_by` varchar(20) NOT NULL DEFAULT '' COMMENT '最后处理人',
  `last_updated_time` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '最后处理时间',
  PRIMARY KEY (`category_group_id`),
  KEY `status` (`status`),
  KEY `created_by` (`created_by`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='分类组别';

-- Dumping data for table qas.category_group: ~0 rows (approximately)
/*!40000 ALTER TABLE `category_group` DISABLE KEYS */;
/*!40000 ALTER TABLE `category_group` ENABLE KEYS */;


-- Dumping structure for table qas.category_list
CREATE TABLE IF NOT EXISTS `category_list` (
  `category_list_id` int(10) NOT NULL AUTO_INCREMENT COMMENT '分类列表id',
  `parent_id` int(10) NOT NULL COMMENT '父id',
  `parent_content` varchar(50) NOT NULL COMMENT '组别内容',
  `content` varchar(50) NOT NULL COMMENT '列表内容',
  `status` enum('active','inactive','delete') NOT NULL COMMENT '状态',
  `created_by` varchar(20) NOT NULL COMMENT '提交人',
  `created_time` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '提交日期',
  `last_updated_by` varchar(20) NOT NULL COMMENT '最后处理人',
  `last_updated_time` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '最后处理时间',
  PRIMARY KEY (`category_list_id`),
  KEY `parent_id` (`parent_id`),
  KEY `status` (`status`),
  KEY `created_by` (`created_by`),
  CONSTRAINT `category_list_id` FOREIGN KEY (`parent_id`) REFERENCES `category_group` (`category_group_id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='分类列表';

-- Dumping data for table qas.category_list: ~0 rows (approximately)
/*!40000 ALTER TABLE `category_list` DISABLE KEYS */;
/*!40000 ALTER TABLE `category_list` ENABLE KEYS */;


-- Dumping structure for table qas.ci_sessions
CREATE TABLE IF NOT EXISTS `ci_sessions` (
  `id` varchar(40) NOT NULL,
  `ip_address` varchar(45) NOT NULL,
  `timestamp` int(10) unsigned NOT NULL DEFAULT '0',
  `data` blob NOT NULL,
  PRIMARY KEY (`id`),
  KEY `ci_sessions_timestamp` (`timestamp`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Dumping data for table qas.ci_sessions: ~0 rows (approximately)
/*!40000 ALTER TABLE `ci_sessions` DISABLE KEYS */;
/*!40000 ALTER TABLE `ci_sessions` ENABLE KEYS */;


-- Dumping structure for table qas.daily_qa
CREATE TABLE IF NOT EXISTS `daily_qa` (
  `daily_qa_id` int(11) NOT NULL AUTO_INCREMENT,
  `date` date NOT NULL,
  `username` varchar(20) NOT NULL,
  `yes` int(11) NOT NULL,
  `no` int(11) NOT NULL COMMENT 'fk-username,leader,import_by',
  `csi` decimal(2,0) NOT NULL,
  `art` time NOT NULL,
  `aht` time NOT NULL,
  `quantity` int(10) NOT NULL,
  `import_by` varchar(20) NOT NULL,
  `import_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `status` tinyint(4) NOT NULL DEFAULT '0' COMMENT '0=pending, 1=valid',
  PRIMARY KEY (`daily_qa_id`),
  UNIQUE KEY `_id_UNIQUE` (`daily_qa_id`),
  KEY `username_index` (`username`),
  KEY `import_by_index` (`import_by`),
  CONSTRAINT `daily_qa_username` FOREIGN KEY (`username`) REFERENCES `users` (`username`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Dumping data for table qas.daily_qa: ~0 rows (approximately)
/*!40000 ALTER TABLE `daily_qa` DISABLE KEYS */;
/*!40000 ALTER TABLE `daily_qa` ENABLE KEYS */;


-- Dumping structure for table qas.follow_up
CREATE TABLE IF NOT EXISTS `follow_up` (
  `follow_up_id` int(10) NOT NULL AUTO_INCREMENT COMMENT '跟进id',
  `shift_reports_id` int(10) NOT NULL COMMENT '班次报告id',
  `follow_up` varchar(20) NOT NULL COMMENT '跟进人',
  `status` enum('inform','informed','follow-up','done','delete') NOT NULL COMMENT '状态',
  `remarks` text NOT NULL COMMENT '备注',
  `created_by` varchar(20) NOT NULL COMMENT '提交人',
  `created_time` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '提交日期',
  `last_updated_by` varchar(20) NOT NULL COMMENT '最后处理人',
  `last_updated_time` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '最后处理时间',
  PRIMARY KEY (`follow_up_id`),
  KEY `status_UNIQUE` (`status`),
  KEY `shift_reports_id_UNIQUE` (`shift_reports_id`),
  KEY `created_by_UNIQUE` (`created_by`),
  CONSTRAINT `shift_report_id` FOREIGN KEY (`shift_reports_id`) REFERENCES `shift_reports` (`shift_reports_id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='跟进';

-- Dumping data for table qas.follow_up: ~0 rows (approximately)
/*!40000 ALTER TABLE `follow_up` DISABLE KEYS */;
/*!40000 ALTER TABLE `follow_up` ENABLE KEYS */;


-- Dumping structure for table qas.log_time
CREATE TABLE IF NOT EXISTS `log_time` (
  `log_time_id` int(11) NOT NULL AUTO_INCREMENT,
  `date` date NOT NULL DEFAULT '0000-00-00',
  `username` varchar(20) NOT NULL,
  `login_time` time NOT NULL,
  `chat_time` time NOT NULL,
  `time_online` time NOT NULL,
  `time_online_no_chat` time NOT NULL,
  `time_not_available` time NOT NULL,
  `time_not_available_chat` time NOT NULL,
  `month` varchar(10) NOT NULL,
  `leader` varchar(20) NOT NULL DEFAULT '0',
  `import_by` varchar(20) NOT NULL,
  `import_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `status` tinyint(4) NOT NULL DEFAULT '0',
  PRIMARY KEY (`log_time_id`),
  KEY `leader_index` (`leader`),
  KEY `import_by` (`import_by`),
  KEY `username` (`username`),
  CONSTRAINT `log_time_username` FOREIGN KEY (`username`) REFERENCES `users` (`username`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Dumping data for table qas.log_time: ~0 rows (approximately)
/*!40000 ALTER TABLE `log_time` DISABLE KEYS */;
/*!40000 ALTER TABLE `log_time` ENABLE KEYS */;


-- Dumping structure for table qas.monthly_qa
CREATE TABLE IF NOT EXISTS `monthly_qa` (
  `monthly_qa_id` int(11) NOT NULL AUTO_INCREMENT,
  `month` varchar(10) NOT NULL,
  `username` varchar(20) NOT NULL COMMENT 'fk-username, leader, import_by',
  `typing_test` int(11) NOT NULL,
  `monthly_assessment` decimal(2,0) NOT NULL,
  `leader` varchar(20) NOT NULL DEFAULT '0',
  `import_by` varchar(20) NOT NULL,
  `import_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `status` tinyint(4) NOT NULL,
  PRIMARY KEY (`monthly_qa_id`),
  KEY `username_index` (`username`),
  KEY `leader_index` (`leader`),
  KEY `import_index` (`import_by`),
  CONSTRAINT `username` FOREIGN KEY (`username`) REFERENCES `users` (`username`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Dumping data for table qas.monthly_qa: ~0 rows (approximately)
/*!40000 ALTER TABLE `monthly_qa` DISABLE KEYS */;
/*!40000 ALTER TABLE `monthly_qa` ENABLE KEYS */;


-- Dumping structure for table qas.oauth_providers
CREATE TABLE IF NOT EXISTS `oauth_providers` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  `client_id` text NOT NULL,
  `client_secret` text NOT NULL,
  `enabled` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Dumping data for table qas.oauth_providers: ~0 rows (approximately)
/*!40000 ALTER TABLE `oauth_providers` DISABLE KEYS */;
/*!40000 ALTER TABLE `oauth_providers` ENABLE KEYS */;


-- Dumping structure for table qas.ops_monthly
CREATE TABLE IF NOT EXISTS `ops_monthly` (
  `ops_monthly_id` int(11) NOT NULL AUTO_INCREMENT,
  `month` varchar(10) NOT NULL,
  `username` varchar(20) NOT NULL,
  `al` int(11) NOT NULL DEFAULT '0',
  `ml` int(11) NOT NULL DEFAULT '0',
  `el` int(11) NOT NULL DEFAULT '0',
  `ul` int(11) NOT NULL DEFAULT '0',
  `vw` int(11) NOT NULL DEFAULT '0',
  `fw` int(11) NOT NULL DEFAULT '0',
  `leader` varchar(20) NOT NULL DEFAULT '0',
  `import_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `import_by` varchar(20) NOT NULL,
  `status` tinyint(4) NOT NULL DEFAULT '0' COMMENT '0=pending, 1 confirm',
  PRIMARY KEY (`ops_monthly_id`),
  KEY `username_index` (`username`),
  KEY `leader_index` (`leader`),
  KEY `import_by_index` (`import_by`),
  CONSTRAINT `ops_monthly_username` FOREIGN KEY (`username`) REFERENCES `users` (`username`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Dumping data for table qas.ops_monthly: ~0 rows (approximately)
/*!40000 ALTER TABLE `ops_monthly` DISABLE KEYS */;
/*!40000 ALTER TABLE `ops_monthly` ENABLE KEYS */;


-- Dumping structure for table qas.permission
CREATE TABLE IF NOT EXISTS `permission` (
  `permission_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `permission_description` varchar(255) NOT NULL,
  `permission_system` tinyint(1) NOT NULL DEFAULT '0',
  `permission_order` int(11) NOT NULL,
  PRIMARY KEY (`permission_id`)
) ENGINE=InnoDB AUTO_INCREMENT=24 DEFAULT CHARSET=utf8;

-- Dumping data for table qas.permission: ~23 rows (approximately)
/*!40000 ALTER TABLE `permission` DISABLE KEYS */;
REPLACE INTO `permission` (`permission_id`, `permission_description`, `permission_system`, `permission_order`) VALUES
	(1, 'user_management', 0, 0),
	(2, 'user_listing', 1, 0),
	(3, 'add_user', 1, 0),
	(4, 'roles_permissions', 0, 0),
	(5, 'role', 4, 0),
	(6, 'permissions', 4, 0),
	(7, 'performance_report', 0, 0),
	(8, 'daily_qa', 7, 0),
	(9, 'monthly_qa', 7, 0),
	(10, 'ops_monthly', 7, 0),
	(11, 'log_in_out', 7, 0),
	(12, 'qa_evaluation', 7, 0),
	(13, 'operator_utilization', 7, 0),
	(14, 'operation', 0, 0),
	(15, 'shift_report', 14, 0),
	(16, 'information_update', 14, 0),
	(17, 'time_sheet', 14, 0),
	(18, 'question_type', 14, 0),
	(19, 'question_content', 14, 0),
	(20, 'roster', 0, 0),
	(21, 'roster_management', 20, 0),
	(22, 'settings', 0, 0),
	(23, 'system_settings', 22, 0);
/*!40000 ALTER TABLE `permission` ENABLE KEYS */;


-- Dumping structure for table qas.qa_evaluation
CREATE TABLE IF NOT EXISTS `qa_evaluation` (
  `qa_evaluation_id` int(11) NOT NULL AUTO_INCREMENT,
  `chat_start_date` datetime NOT NULL,
  `real_time_session_id` int(11) NOT NULL,
  `caller_identifier` varchar(25) NOT NULL,
  `operator` varchar(20) NOT NULL COMMENT 'fk-operator,evaluate_by',
  `data` mediumtext,
  `status` enum('import','evaluate','pending','close') NOT NULL DEFAULT 'import',
  `remarks` text,
  `evaluate_marks` int(11) NOT NULL DEFAULT '0',
  `evaluate_by` varchar(20) NOT NULL DEFAULT '0',
  `import_by` varchar(20) NOT NULL,
  `import_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `last_updated_by` varchar(20) NOT NULL DEFAULT '0',
  `last_updated_time` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`qa_evaluation_id`),
  KEY `operator_index` (`operator`),
  KEY `import_by` (`import_by`),
  KEY `evaluate_by` (`evaluate_by`),
  CONSTRAINT `qa_evaluation_username` FOREIGN KEY (`operator`) REFERENCES `users` (`username`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Dumping data for table qas.qa_evaluation: ~0 rows (approximately)
/*!40000 ALTER TABLE `qa_evaluation` DISABLE KEYS */;
/*!40000 ALTER TABLE `qa_evaluation` ENABLE KEYS */;


-- Dumping structure for table qas.recover_password
CREATE TABLE IF NOT EXISTS `recover_password` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(11) unsigned NOT NULL,
  `token` char(40) NOT NULL,
  `email` varchar(255) NOT NULL,
  `date_added` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Dumping data for table qas.recover_password: ~0 rows (approximately)
/*!40000 ALTER TABLE `recover_password` DISABLE KEYS */;
/*!40000 ALTER TABLE `recover_password` ENABLE KEYS */;


-- Dumping structure for table qas.remarks
CREATE TABLE IF NOT EXISTS `remarks` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(20) NOT NULL,
  `remark` text NOT NULL,
  `create_by` varchar(20) NOT NULL DEFAULT '0',
  `create_time` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `remark_username` (`username`),
  CONSTRAINT `remark_username` FOREIGN KEY (`username`) REFERENCES `users` (`username`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Dumping data for table qas.remarks: ~0 rows (approximately)
/*!40000 ALTER TABLE `remarks` DISABLE KEYS */;
/*!40000 ALTER TABLE `remarks` ENABLE KEYS */;


-- Dumping structure for table qas.role
CREATE TABLE IF NOT EXISTS `role` (
  `role_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `role_name` varchar(50) NOT NULL,
  `role_description` varchar(255) NOT NULL DEFAULT '0',
  `role_selectable` tinyint(1) NOT NULL DEFAULT '1',
  `status` enum('active','inactive') NOT NULL,
  PRIMARY KEY (`role_id`)
) ENGINE=InnoDB AUTO_INCREMENT=35 DEFAULT CHARSET=utf8;

-- Dumping data for table qas.role: ~5 rows (approximately)
/*!40000 ALTER TABLE `role` DISABLE KEYS */;
REPLACE INTO `role` (`role_id`, `role_name`, `role_description`, `role_selectable`, `status`) VALUES
	(1, 'Administrator', 'CAN NOT BE EDITED OR DELETED - All system permissions are active by default.', 1, 'active'),
	(2, 'Leader', '', 1, 'active'),
	(3, 'Senior', '', 1, 'active'),
	(4, 'CS', '', 1, 'active'),
	(5, 'QA', '', 1, 'active');
/*!40000 ALTER TABLE `role` ENABLE KEYS */;


-- Dumping structure for table qas.role_permission
CREATE TABLE IF NOT EXISTS `role_permission` (
  `role_id` int(11) unsigned NOT NULL,
  `permission_id` int(11) unsigned NOT NULL,
  `add` enum('yes','no') NOT NULL DEFAULT 'no',
  `edit` enum('yes','no') NOT NULL DEFAULT 'no',
  `delete` enum('yes','no') NOT NULL DEFAULT 'no',
  `view` enum('yes','no') NOT NULL DEFAULT 'no',
  `parentid` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`role_id`,`permission_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Dumping data for table qas.role_permission: ~138 rows (approximately)
/*!40000 ALTER TABLE `role_permission` DISABLE KEYS */;
REPLACE INTO `role_permission` (`role_id`, `permission_id`, `add`, `edit`, `delete`, `view`, `parentid`) VALUES
	(1, 1, 'yes', 'yes', 'yes', 'yes', 0),
	(1, 2, 'yes', 'yes', 'yes', 'yes', 1),
	(1, 3, 'yes', 'yes', 'yes', 'yes', 1),
	(1, 4, 'yes', 'yes', 'yes', 'yes', 0),
	(1, 5, 'yes', 'yes', 'yes', 'yes', 4),
	(1, 6, 'yes', 'yes', 'yes', 'yes', 4),
	(1, 7, 'yes', 'yes', 'yes', 'yes', 0),
	(1, 8, 'yes', 'yes', 'yes', 'yes', 7),
	(1, 9, 'yes', 'yes', 'yes', 'yes', 7),
	(1, 10, 'yes', 'yes', 'yes', 'yes', 7),
	(1, 11, 'yes', 'yes', 'yes', 'yes', 7),
	(1, 12, 'yes', 'yes', 'yes', 'yes', 7),
	(1, 13, 'yes', 'yes', 'yes', 'yes', 7),
	(1, 14, 'yes', 'yes', 'yes', 'yes', 0),
	(1, 15, 'yes', 'yes', 'yes', 'yes', 14),
	(1, 16, 'yes', 'yes', 'yes', 'yes', 14),
	(1, 17, 'yes', 'yes', 'yes', 'yes', 14),
	(1, 18, 'yes', 'yes', 'yes', 'yes', 14),
	(1, 19, 'yes', 'yes', 'yes', 'yes', 14),
	(1, 20, 'yes', 'yes', 'yes', 'yes', 0),
	(1, 21, 'yes', 'yes', 'yes', 'yes', 20),
	(1, 22, 'yes', 'yes', 'yes', 'yes', 0),
	(1, 23, 'yes', 'yes', 'yes', 'yes', 22);
/*!40000 ALTER TABLE `role_permission` ENABLE KEYS */;


-- Dumping structure for table qas.roster_management
CREATE TABLE IF NOT EXISTS `roster_management` (
  `rid` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(20) NOT NULL,
  `role` varchar(20) NOT NULL DEFAULT '0',
  `shift_date` date NOT NULL DEFAULT '0000-00-00',
  `shift_slot` varchar(20) NOT NULL DEFAULT '0',
  `time_slot` time NOT NULL DEFAULT '00:00:00',
  `created_by` varchar(20) NOT NULL DEFAULT '0',
  `created_time` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `lastupdated_by` varchar(20) NOT NULL DEFAULT '0',
  `lastupdated_time` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`rid`),
  KEY `username` (`username`),
  KEY `created_by` (`created_by`),
  CONSTRAINT `roster_management_username` FOREIGN KEY (`username`) REFERENCES `users` (`username`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Dumping data for table qas.roster_management: ~0 rows (approximately)
/*!40000 ALTER TABLE `roster_management` DISABLE KEYS */;
/*!40000 ALTER TABLE `roster_management` ENABLE KEYS */;


-- Dumping structure for table qas.settings
CREATE TABLE IF NOT EXISTS `settings` (
  `id` tinyint(4) unsigned NOT NULL AUTO_INCREMENT,
  `login_enabled` tinyint(1) NOT NULL DEFAULT '1',
  `register_enabled` tinyint(1) NOT NULL DEFAULT '1',
  `install_enabled` tinyint(1) NOT NULL DEFAULT '1',
  `members_per_page` smallint(6) NOT NULL DEFAULT '12',
  `admin_email` varchar(255) NOT NULL,
  `home_page` varchar(50) NOT NULL,
  `active_theme` varchar(40) NOT NULL DEFAULT 'bootstrap3',
  `adminpanel_theme` varchar(40) NOT NULL DEFAULT 'adminpanel',
  `login_attempts` smallint(6) NOT NULL DEFAULT '3',
  `max_login_attempts` smallint(6) NOT NULL DEFAULT '30',
  `email_protocol` tinyint(4) NOT NULL DEFAULT '1',
  `sendmail_path` varchar(100) NOT NULL DEFAULT '/usr/sbin/sendmail',
  `smtp_host` varchar(255) NOT NULL DEFAULT 'ssl://smtp.googlemail.com',
  `smtp_port` smallint(6) NOT NULL DEFAULT '465',
  `smtp_user` mediumblob NOT NULL,
  `smtp_pass` mediumblob NOT NULL,
  `site_title` varchar(60) NOT NULL DEFAULT 'CI_Membership',
  `cookie_expires` int(11) NOT NULL DEFAULT '259200',
  `password_link_expires` int(11) NOT NULL DEFAULT '1800',
  `activation_link_expires` int(11) NOT NULL DEFAULT '43200',
  `disable_all` tinyint(1) NOT NULL DEFAULT '0',
  `site_disabled_text` text NOT NULL,
  `remember_me_enabled` tinyint(1) NOT NULL DEFAULT '1',
  `recaptchav2_enabled` tinyint(1) NOT NULL DEFAULT '0',
  `recaptchav2_site_key` char(40) NOT NULL,
  `recaptchav2_secret` char(40) NOT NULL,
  `oauth2_enabled` tinyint(1) NOT NULL DEFAULT '0',
  `site_language` varchar(50) NOT NULL DEFAULT '0',
  `footer_title` varchar(100) NOT NULL DEFAULT '0',
  `system_role` varchar(50) NOT NULL DEFAULT '0',
  `logo` varchar(100) NOT NULL DEFAULT '0',
  `predefined_email` varchar(50) NOT NULL DEFAULT '0',
  `data_mask` enum('Yes','No') NOT NULL,
  `search_section` enum('in','') NOT NULL,
  `operator_leader_role` varchar(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

-- Dumping data for table qas.settings: ~0 rows (approximately)
/*!40000 ALTER TABLE `settings` DISABLE KEYS */;
REPLACE INTO `settings` (`id`, `login_enabled`, `register_enabled`, `install_enabled`, `members_per_page`, `admin_email`, `home_page`, `active_theme`, `adminpanel_theme`, `login_attempts`, `max_login_attempts`, `email_protocol`, `sendmail_path`, `smtp_host`, `smtp_port`, `smtp_user`, `smtp_pass`, `site_title`, `cookie_expires`, `password_link_expires`, `activation_link_expires`, `disable_all`, `site_disabled_text`, `remember_me_enabled`, `recaptchav2_enabled`, `recaptchav2_site_key`, `recaptchav2_secret`, `oauth2_enabled`, `site_language`, `footer_title`, `system_role`, `logo`, `predefined_email`, `data_mask`, `search_section`, `operator_leader_role`) VALUES
	(1, 1, 1, 1, 10, 'admin@example.com', 'Default_page', 'bootstrap3', 'adminpanel', 5, 30, 3, '/usr/sbin/sendmail', 'ssl://smtp.gmail.com', 465, _binary 0x62657863656C2E706F7274616C40676D61696C2E636F6D, _binary 0x313233717765214023, 'BEXCEL', 259200, 1800, 43200, 0, 'This website is momentarily offline.', 1, 0, '', '', 1, 'chinese', 'Created by Eagleeye Technologies - All rights reserved © 2016', 'CS', 'Logo.png', 'bexcel.com', 'Yes', 'in', 'Leader');
/*!40000 ALTER TABLE `settings` ENABLE KEYS */;


-- Dumping structure for table qas.shift_reports
CREATE TABLE IF NOT EXISTS `shift_reports` (
  `shift_reports_id` int(10) NOT NULL AUTO_INCREMENT COMMENT '班次报告id',
  `product` varchar(20) NOT NULL COMMENT '产品',
  `player_name` varchar(20) NOT NULL COMMENT '玩家名字',
  `shift` varchar(20) NOT NULL COMMENT '班次',
  `finish` datetime NOT NULL COMMENT '结束时间',
  `follow_up` varchar(20) NOT NULL COMMENT '跟进人',
  `status` enum('update','updated','follow-up','done','delete') NOT NULL COMMENT '状态',
  `remarks` text NOT NULL COMMENT '备注',
  `category_id` int(10) NOT NULL COMMENT '问题分类id',
  `category_content` varchar(50) NOT NULL COMMENT '问题分类内容',
  `sub_category_id` int(10) NOT NULL COMMENT '问题列表id',
  `sub_category_content` varchar(50) NOT NULL COMMENT '问题列表内容',
  `created_by` varchar(20) NOT NULL COMMENT '提交人',
  `created_time` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '提交日期',
  `last_updated_by` varchar(20) NOT NULL COMMENT '最后处理人',
  `last_updated_time` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '最后处理时间',
  PRIMARY KEY (`shift_reports_id`),
  KEY `status` (`status`),
  KEY `player_name` (`player_name`),
  KEY `follow_up` (`follow_up`),
  KEY `created_by` (`created_by`),
  KEY `product` (`product`),
  KEY `shift` (`shift`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='班次报告';

-- Dumping data for table qas.shift_reports: ~0 rows (approximately)
/*!40000 ALTER TABLE `shift_reports` DISABLE KEYS */;
/*!40000 ALTER TABLE `shift_reports` ENABLE KEYS */;


-- Dumping structure for table qas.system_setting
CREATE TABLE IF NOT EXISTS `system_setting` (
  `sid` mediumint(10) NOT NULL AUTO_INCREMENT,
  `type` varchar(20) NOT NULL,
  `group` varchar(20) NOT NULL,
  `key` varchar(20) NOT NULL,
  `value` varchar(50) NOT NULL,
  PRIMARY KEY (`sid`),
  KEY `type` (`type`),
  KEY `key` (`key`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

-- Dumping data for table qas.system_setting: ~0 rows (approximately)
/*!40000 ALTER TABLE `system_setting` DISABLE KEYS */;
REPLACE INTO `system_setting` (`sid`, `type`, `group`, `key`, `value`) VALUES
	(1, 'shift', '', 'Morning', '08:00'),
	(2, 'shift', '', 'Afternoon', '14:00'),
	(3, 'shift', '', 'Night', '22:30'),
	(4, 'shift', '', 'Normal', '11:00');
/*!40000 ALTER TABLE `system_setting` ENABLE KEYS */;


-- Dumping structure for table qas.time_sheet
CREATE TABLE IF NOT EXISTS `time_sheet` (
  `time_sheet_id` int(10) NOT NULL AUTO_INCREMENT COMMENT '时间表报告id',
  `shift` varchar(20) NOT NULL COMMENT '班次',
  `product` varchar(20) NOT NULL COMMENT '产品',
  `title` varchar(20) NOT NULL COMMENT '标题',
  `remarks` text NOT NULL COMMENT '备注',
  `time_start` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '开始时间',
  `time_end` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '结束时间',
  `status` enum('active','inactive','delete') NOT NULL COMMENT '状态',
  `created_by` varchar(20) NOT NULL COMMENT '提交人',
  `created_time` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '提交日期',
  `last_updated_by` varchar(20) NOT NULL COMMENT '最后处理人',
  `last_updated_time` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '最后处理时间',
  PRIMARY KEY (`time_sheet_id`),
  KEY `created_by` (`created_by`),
  KEY `shift` (`shift`),
  KEY `status` (`status`),
  KEY `product` (`product`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='时间表报告';

-- Dumping data for table qas.time_sheet: ~0 rows (approximately)
/*!40000 ALTER TABLE `time_sheet` DISABLE KEYS */;
/*!40000 ALTER TABLE `time_sheet` ENABLE KEYS */;


-- Dumping structure for table qas.users
CREATE TABLE IF NOT EXISTS `users` (
  `user_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `username` varchar(16) NOT NULL,
  `password` char(128) NOT NULL,
  `password_hint` varchar(30) NOT NULL,
  `email` varchar(255) NOT NULL,
  `date_registered` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `last_login` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `nonce` char(32) NOT NULL,
  `first_name` varchar(40) DEFAULT NULL,
  `last_name` varchar(60) DEFAULT NULL,
  `active` tinyint(1) NOT NULL DEFAULT '0',
  `banned` tinyint(1) NOT NULL DEFAULT '0',
  `login_attempts` tinyint(4) NOT NULL DEFAULT '0',
  `cookie_part` varchar(32) DEFAULT NULL,
  `gender` varchar(20) DEFAULT NULL,
  `profile_img` varchar(255) DEFAULT NULL,
  `real_name` varchar(50) NOT NULL DEFAULT '0',
  `nickname` varchar(20) NOT NULL DEFAULT '0',
  `dob` date NOT NULL,
  `role` varchar(15) NOT NULL DEFAULT '0',
  `windows_id` varchar(20) NOT NULL DEFAULT '0',
  `tb_lp_id` varchar(50) NOT NULL DEFAULT '0',
  `tb_lp_name` varchar(50) NOT NULL DEFAULT '0',
  `sy_lp_id` varchar(50) NOT NULL DEFAULT '0',
  `sy_lp_name` varchar(50) NOT NULL DEFAULT '0',
  `tb_bo` varchar(50) NOT NULL DEFAULT '0',
  `gd_bo` varchar(50) NOT NULL DEFAULT '0',
  `keno_bo` varchar(50) NOT NULL DEFAULT '0',
  `cyber_roam` varchar(50) NOT NULL DEFAULT '0',
  `rtx` varchar(50) NOT NULL DEFAULT '0',
  `emergency_contact` varchar(50) NOT NULL DEFAULT '0',
  `emergency_name` varchar(50) NOT NULL DEFAULT '0',
  `relationship` varchar(20) NOT NULL DEFAULT '0',
  `leader` varchar(20) NOT NULL DEFAULT '0',
  `remark` text,
  `status` enum('Active','Inactive','Pending') NOT NULL DEFAULT 'Pending',
  `phone` varchar(20) NOT NULL DEFAULT '0',
  `created_by` varchar(20) NOT NULL DEFAULT '0',
  `created_time` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `last_updated_by` varchar(20) NOT NULL DEFAULT '0',
  `last_updated_time` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`user_id`),
  UNIQUE KEY `username` (`username`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

-- Dumping data for table qas.users: ~1 rows (approximately)
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
REPLACE INTO `users` (`user_id`, `username`, `password`, `password_hint`, `email`, `date_registered`, `last_login`, `nonce`, `first_name`, `last_name`, `active`, `banned`, `login_attempts`, `cookie_part`, `gender`, `profile_img`, `real_name`, `nickname`, `dob`, `role`, `windows_id`, `tb_lp_id`, `tb_lp_name`, `sy_lp_id`, `sy_lp_name`, `tb_bo`, `gd_bo`, `keno_bo`, `cyber_roam`, `rtx`, `emergency_contact`, `emergency_name`, `relationship`, `leader`, `remark`, `status`, `phone`, `created_by`, `created_time`, `last_updated_by`, `last_updated_time`) VALUES
	(1, 'administrator', '5fac7d16d46596db220c1ad6f0ab74d2feb3db7439eef6bf05e5d70f97b0dc8b959b379fa821d19ee66e987ba651f520d0ce585242b0f25946109113b054acc2', '9797', 'bexcel.portal@gmail.com', '2016-05-13 19:10:39', '2016-05-31 14:10:03', 'e94b29ee0f94fad88b631d961f6bfeac', 'admin', 'admin', 1, 0, 0, 'c2b7742e35d1bd8016f30623178c0e78', '', '', '', '', '0000-00-00', 'Administrator', '', '', '', '', '', '', '', '', '', '', '', '', '', 'administrator', '', 'Active', '', '', '0000-00-00 00:00:00', '', '0000-00-00 00:00:00');
/*!40000 ALTER TABLE `users` ENABLE KEYS */;


-- Dumping structure for table qas.user_evaluation
CREATE TABLE IF NOT EXISTS `user_evaluation` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `username` varchar(16) NOT NULL DEFAULT '',
  `imported_time` datetime NOT NULL,
  `status` enum('pending','WIP','In-Progress','Completed') NOT NULL DEFAULT 'pending',
  `coverage` varchar(50) NOT NULL DEFAULT '',
  `evaluate_mark` decimal(4,2) unsigned NOT NULL DEFAULT '0.00',
  `evaluate_by` varchar(16) NOT NULL DEFAULT '',
  `mark_delete` enum('Y','N') NOT NULL DEFAULT 'N',
  `evaluate_time` int(10) unsigned NOT NULL DEFAULT '0',
  `chat_start_time` int(10) unsigned NOT NULL DEFAULT '0',
  `chat_end_time` int(10) unsigned NOT NULL DEFAULT '0',
  `duration` int(10) unsigned NOT NULL DEFAULT '0',
  `chat_starting_page` varchar(100) NOT NULL DEFAULT '',
  `opterator` varchar(16) NOT NULL DEFAULT '',
  `browser` varchar(30) NOT NULL DEFAULT '',
  `os` varchar(20) NOT NULL DEFAULT '',
  `host_address` varchar(100) NOT NULL DEFAULT '',
  `host_ip` varchar(20) NOT NULL DEFAULT '',
  `real_time_session_ref` varchar(100) NOT NULL DEFAULT '',
  `country` varchar(20) NOT NULL DEFAULT '',
  `city` varchar(20) NOT NULL DEFAULT '',
  `organization` varchar(100) NOT NULL DEFAULT '',
  `world_region` varchar(50) NOT NULL DEFAULT '',
  `time_zone` varchar(50) NOT NULL DEFAULT '',
  `isp` varchar(50) NOT NULL DEFAULT '',
  `player` varchar(30) NOT NULL DEFAULT '',
  `brand` varchar(20) NOT NULL DEFAULT '',
  `areas_of_strength` text NOT NULL,
  `areas_of_improvement` text NOT NULL,
  `action_plan` text NOT NULL,
  `employee_comments` text NOT NULL,
  `update_time` int(10) unsigned NOT NULL DEFAULT '0',
  `update_by` varchar(16) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`),
  KEY `FK_user_evaluation_users` (`username`),
  CONSTRAINT `FK_user_evaluation_users` FOREIGN KEY (`username`) REFERENCES `users` (`username`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Dumping data for table qas.user_evaluation: ~0 rows (approximately)
/*!40000 ALTER TABLE `user_evaluation` DISABLE KEYS */;
/*!40000 ALTER TABLE `user_evaluation` ENABLE KEYS */;


-- Dumping structure for table qas.user_evaluation_chat
CREATE TABLE IF NOT EXISTS `user_evaluation_chat` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `username` varchar(16) NOT NULL DEFAULT '',
  `user_evaluation_id` int(11) unsigned NOT NULL DEFAULT '0',
  `chat_time` int(10) unsigned NOT NULL DEFAULT '0',
  `chat_by` varchar(16) NOT NULL DEFAULT '',
  `chat_text` text NOT NULL,
  `remark` text NOT NULL,
  `update_time` int(10) unsigned NOT NULL DEFAULT '0',
  `update_by` varchar(16) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Dumping data for table qas.user_evaluation_chat: ~0 rows (approximately)
/*!40000 ALTER TABLE `user_evaluation_chat` DISABLE KEYS */;
/*!40000 ALTER TABLE `user_evaluation_chat` ENABLE KEYS */;


-- Dumping structure for table qas.user_evaluation_form
CREATE TABLE IF NOT EXISTS `user_evaluation_form` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `user_evaluation_id` int(11) unsigned NOT NULL DEFAULT '0',
  `username` varchar(16) NOT NULL DEFAULT '',
  `question_type` enum('basic','soft_skills','product_procedure') NOT NULL DEFAULT 'basic',
  `question_text` text NOT NULL,
  `weight` decimal(4,2) NOT NULL DEFAULT '0.00',
  `rating` tinyint(1) NOT NULL DEFAULT '0',
  `update_time` int(10) unsigned NOT NULL DEFAULT '0',
  `update_by` varchar(16) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Dumping data for table qas.user_evaluation_form: ~0 rows (approximately)
/*!40000 ALTER TABLE `user_evaluation_form` DISABLE KEYS */;
/*!40000 ALTER TABLE `user_evaluation_form` ENABLE KEYS */;


-- Dumping structure for table qas.user_role
CREATE TABLE IF NOT EXISTS `user_role` (
  `user_id` int(11) unsigned NOT NULL,
  `role_id` int(11) unsigned NOT NULL,
  PRIMARY KEY (`user_id`,`role_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Dumping data for table qas.user_role: ~1 rows (approximately)
/*!40000 ALTER TABLE `user_role` DISABLE KEYS */;
REPLACE INTO `user_role` (`user_id`, `role_id`) VALUES
	(1, 1);
/*!40000 ALTER TABLE `user_role` ENABLE KEYS */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
