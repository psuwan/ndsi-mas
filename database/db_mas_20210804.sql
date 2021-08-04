-- --------------------------------------------------------
-- Host:                         127.0.0.1
-- Server version:               8.0.18 - MySQL Community Server - GPL
-- Server OS:                    Win64
-- HeidiSQL Version:             11.3.0.6295
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

-- Dumping structure for table db_mas.mas_as
CREATE TABLE IF NOT EXISTS `mas_as` (
  `as_code` char(4) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL COMMENT 'AS01',
  `as_name` char(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `as_number` tinyint(1) DEFAULT NULL,
  UNIQUE KEY `as_code` (`as_code`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Dumping data for table db_mas.mas_as: ~4 rows (approximately)
DELETE FROM `mas_as`;
/*!40000 ALTER TABLE `mas_as` DISABLE KEYS */;
INSERT INTO `mas_as` (`as_code`, `as_name`, `as_number`) VALUES
	(NULL, 'ครูชำนาญการต้น', 1),
	(NULL, 'ครูชำนาญการ (ครูทหาร)', 2),
	(NULL, 'ครูชำนาญการ (ครูวิชาการ)', 3),
	(NULL, 'ครูชำนาญการพิเศษ', 4),
	(NULL, 'ไม่มีวิทยฐานะ', 0);
/*!40000 ALTER TABLE `mas_as` ENABLE KEYS */;

-- Dumping structure for table db_mas.mas_committee
CREATE TABLE IF NOT EXISTS `mas_committee` (
  `cmt_code` char(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `cmt_namef` varchar(250) COLLATE utf8_unicode_ci DEFAULT NULL,
  `cmt_namel` varchar(250) COLLATE utf8_unicode_ci DEFAULT NULL,
  `cmt_createdat` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Dumping data for table db_mas.mas_committee: ~0 rows (approximately)
DELETE FROM `mas_committee`;
/*!40000 ALTER TABLE `mas_committee` DISABLE KEYS */;
/*!40000 ALTER TABLE `mas_committee` ENABLE KEYS */;

-- Dumping structure for table db_mas.mas_evdchk
CREATE TABLE IF NOT EXISTS `mas_evdchk` (
  `evd_refnumber` char(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `evd_newup` char(1) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT '0',
  `evd_chked` char(1) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT '0',
  `evd_comment` text CHARACTER SET utf8 COLLATE utf8_unicode_ci
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Dumping data for table db_mas.mas_evdchk: ~0 rows (approximately)
DELETE FROM `mas_evdchk`;
/*!40000 ALTER TABLE `mas_evdchk` DISABLE KEYS */;
INSERT INTO `mas_evdchk` (`evd_refnumber`, `evd_newup`, `evd_chked`, `evd_comment`) VALUES
	('1234567890123mAS1evd01', '1', '0', NULL),
	('FileSec1', '1', '0', NULL);
/*!40000 ALTER TABLE `mas_evdchk` ENABLE KEYS */;

-- Dumping structure for table db_mas.mas_evidence
CREATE TABLE IF NOT EXISTS `mas_evidence` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `evd_code` char(3) COLLATE utf8_unicode_ci NOT NULL DEFAULT '0',
  `evd_name` varchar(250) COLLATE utf8_unicode_ci NOT NULL DEFAULT '0',
  `evd_usefor` char(4) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL DEFAULT '0',
  `evd_order` int(2) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Dumping data for table db_mas.mas_evidence: ~11 rows (approximately)
DELETE FROM `mas_evidence`;
/*!40000 ALTER TABLE `mas_evidence` DISABLE KEYS */;
INSERT INTO `mas_evidence` (`id`, `evd_code`, `evd_name`, `evd_usefor`, `evd_order`) VALUES
	(1, '0', 'สำเนาหนังสือรับรองมาตรฐานการเป็นผู้สอน/ใบอนุญาติประกอบวิชาชีพครู', '1111', 1),
	(2, '0', 'สำเนาเอกสารแสดงวุฒิการศึกษาสูงสุด', '111', 2),
	(3, '0', 'สำเนาคำสั่งบรรจุเข้ารับราชการ', '111', NULL),
	(4, '0', 'สำเนาคำสั่งให้รับราชการในตำแหน่งปัจจุบัน', '1111', NULL),
	(5, '0', 'สำเนาเอกสารแสดงระยะเวลาปฏิบัติหน่าที่สอน', '111', NULL),
	(6, '0', 'คำสั่งแต่งตั้งให้มีวิทยฐานะชำนาญการ', '0001', NULL),
	(7, '0', 'สำเนาเอกสารแสดงชั่วโมงการสอน ฝึก ศึกษา และการอบรม', '1111', NULL),
	(8, '0', 'สำเนาการเปลี่ยนชื่อสกุล (ถ้ามี)', '1111', NULL),
	(9, '0', 'แบบเสนอขอรับการประเมิน', '1111', NULL),
	(10, '0', 'วฐ.ร. 1', '1111', NULL),
	(11, '0', 'วฐ.ร. 3.1', '1111', NULL),
	(12, '0', 'เอกสารหลักฐานด้านที่ 3', '1111', NULL);
/*!40000 ALTER TABLE `mas_evidence` ENABLE KEYS */;

-- Dumping structure for table db_mas.mas_milcourse
CREATE TABLE IF NOT EXISTS `mas_milcourse` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `mil_number` char(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `course_name` varchar(250) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `course_opener` varchar(250) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `course_year` varchar(250) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Dumping data for table db_mas.mas_milcourse: ~0 rows (approximately)
DELETE FROM `mas_milcourse`;
/*!40000 ALTER TABLE `mas_milcourse` DISABLE KEYS */;
INSERT INTO `mas_milcourse` (`id`, `mil_number`, `course_name`, `course_opener`, `course_year`) VALUES
	(2, '1234567890123', 'การโจมตีทางอินเทอร์เน็ต', 'ศูนย์ไซเบอร์ บก.ทท.', 'พ.ศ.2562');
/*!40000 ALTER TABLE `mas_milcourse` ENABLE KEYS */;

-- Dumping structure for table db_mas.mas_milwork
CREATE TABLE IF NOT EXISTS `mas_milwork` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `mil_number` char(20) COLLATE utf8_unicode_ci DEFAULT NULL,
  `mil_position` varchar(250) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `mil_command` char(50) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `mil_numext` char(20) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT 'extend for upload',
  `mil_workisnow` char(1) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT '0',
  `mil_workstart` datetime DEFAULT NULL,
  `mil_workstop` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Dumping data for table db_mas.mas_milwork: ~0 rows (approximately)
DELETE FROM `mas_milwork`;
/*!40000 ALTER TABLE `mas_milwork` DISABLE KEYS */;
INSERT INTO `mas_milwork` (`id`, `mil_number`, `mil_position`, `mil_command`, `mil_numext`, `mil_workisnow`, `mil_workstart`, `mil_workstop`) VALUES
	(2, '1234567890123', 'ครูปฏิบัติการ', 'มรส.123', '', '0', '1999-05-17 08:00:00', '1999-12-31 08:00:00');
/*!40000 ALTER TABLE `mas_milwork` ENABLE KEYS */;

-- Dumping structure for table db_mas.mas_users
CREATE TABLE IF NOT EXISTS `mas_users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `mil_number` char(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `user_pass` varchar(200) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `user_level` char(1) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL DEFAULT '1',
  `user_status` char(1) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT '0',
  `user_createdat` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `mil_number` (`mil_number`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Dumping data for table db_mas.mas_users: ~4 rows (approximately)
DELETE FROM `mas_users`;
/*!40000 ALTER TABLE `mas_users` DISABLE KEYS */;
INSERT INTO `mas_users` (`id`, `mil_number`, `user_pass`, `user_level`, `user_status`, `user_createdat`) VALUES
	(1, '9999999999999', '$2y$10$vAx6EPnc.m9DV0uG7mpB2OlcM7x5tHJ1Sx.AIZoqThnDr4Xec.nR.', '9', '1', '2021-07-31 18:19:50'),
	(2, '1234567890123', '$2y$10$hnVU8qPikI.MHbOp/1hFreuFjYK/qcSXax4rAG4w8xYhcuTBqGhLu', '1', '1', '2021-07-31 18:23:58'),
	(3, '9876543210987', '$2y$10$ts2Fupj1Ba1MhREEsBZW8O7V.7ZQwURZr8ZS9AaRTdltpFawTWbIa', '1', '1', '2021-08-01 15:53:22'),
	(4, '7412589630147', '$2y$10$wGZIsXqKvGrVVIomEZXuVuck8262jS11ZZYGyKmBpR495HxvyoRGa', '1', '1', '2021-08-01 15:53:41'),
	(5, '9876543210', '$2y$10$M4y8UZenJ.WwP44xe.pOOOTZHCSluKn06h4ZRw.DpxVKPRDZjeZ2m', '1', '0', '2021-08-02 05:43:33'),
	(6, '8521479630', '$2y$10$YHLP2VYiUgtzEs.ApnvrGu6QOBSAzxW3HJclYqo9M1bFg2xayYe/2', '1', '1', '2021-08-03 09:59:22');
/*!40000 ALTER TABLE `mas_users` ENABLE KEYS */;

-- Dumping structure for table db_mas.mas_userschool
CREATE TABLE IF NOT EXISTS `mas_userschool` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `mil_number` char(20) COLLATE utf8_unicode_ci DEFAULT NULL,
  `school_level` int(2) DEFAULT '1',
  `school_name` varchar(250) COLLATE utf8_unicode_ci DEFAULT NULL,
  `school_branch` varchar(250) COLLATE utf8_unicode_ci DEFAULT NULL,
  `school_major` varchar(250) COLLATE utf8_unicode_ci DEFAULT NULL,
  `school_year` varchar(250) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Dumping data for table db_mas.mas_userschool: ~0 rows (approximately)
DELETE FROM `mas_userschool`;
/*!40000 ALTER TABLE `mas_userschool` DISABLE KEYS */;
INSERT INTO `mas_userschool` (`id`, `mil_number`, `school_level`, `school_name`, `school_branch`, `school_major`, `school_year`) VALUES
	(1, '1234567890123', 1, 'โรงเรียนเบ็ญจะมะมหาราช อุบลราชธานี', 'วิทย์-คณิต', 'วิทย์-คณิต', '2536'),
	(2, '1234567890123', 2, 'สถาบันเทคโนโลยีพระจอมเกล้าเจ้าคุณทหารลาดกระบัง', 'ฟิสิกส์ประยุกต์', 'โซลิดสเตทอิเล็กทรอนิกส์', '2540');
/*!40000 ALTER TABLE `mas_userschool` ENABLE KEYS */;

-- Dumping structure for table db_mas.mas_wrkreport
CREATE TABLE IF NOT EXISTS `mas_wrkreport` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `mil_number` char(20) COLLATE utf8_unicode_ci DEFAULT NULL,
  `mil_wrktopic` varchar(150) COLLATE utf8_unicode_ci DEFAULT NULL,
  `mil_wrkdetails` text COLLATE utf8_unicode_ci,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Dumping data for table db_mas.mas_wrkreport: ~0 rows (approximately)
DELETE FROM `mas_wrkreport`;
/*!40000 ALTER TABLE `mas_wrkreport` DISABLE KEYS */;
/*!40000 ALTER TABLE `mas_wrkreport` ENABLE KEYS */;

-- Dumping structure for table db_mas.rtarf_ranks
CREATE TABLE IF NOT EXISTS `rtarf_ranks` (
  `rank_code` char(5) COLLATE utf8_unicode_ci DEFAULT NULL,
  `rank_group` char(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `rank_order` char(4) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL COMMENT 'RK01',
  `rank_name` char(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `rank_abbrv` char(20) COLLATE utf8_unicode_ci DEFAULT NULL,
  `rank_masuse` char(1) COLLATE utf8_unicode_ci DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Dumping data for table db_mas.rtarf_ranks: ~45 rows (approximately)
DELETE FROM `rtarf_ranks`;
/*!40000 ALTER TABLE `rtarf_ranks` DISABLE KEYS */;
INSERT INTO `rtarf_ranks` (`rank_code`, `rank_group`, `rank_order`, `rank_name`, `rank_abbrv`, `rank_masuse`) VALUES
	('rk101', '1', '01', 'พลเอก', 'พล.อ.', '0'),
	('rk102', '1', '02', 'พลโท', 'พล.ท.', '0'),
	('rk103', '1', '03', 'พลตรี', 'พล.ต.', '0'),
	('rk104', '1', '04', 'พันเอก', 'พ.อ.', '1'),
	('rk105', '1', '05', 'พันโท', 'พ.ท.', '1'),
	('rk106', '1', '06', 'พันตรี', 'พ.ต.', '1'),
	('rk107', '1', '07', 'ร้อยเอก', 'ร.อ.', '1'),
	('rk108', '1', '08', 'ร้อยโท', 'ร.ท.', '1'),
	('rk109', '1', '09', 'ร้อยตรี', 'ร.ต.', '1'),
	('rk110', '1', '10', 'จ่าสิบเอก', 'จ.ส.อ.', '1'),
	('rk111', '1', '11', 'จ่าสิบโท', 'จ.ส.ท.', '1'),
	('rk112', '1', '12', 'จ่าสิบตรี', 'จ.ส.ต.', '1'),
	('rk113', '1', '13', 'สิบเอก', 'ส.อ.', '1'),
	('rk114', '1', '14', 'สิบโท', 'ส.ท.', '1'),
	('rk115', '1', '15', 'สิบตรี', 'ส.ต.', '1'),
	('rk201', '2', '01', 'พลเรือเอก', 'พล.ร.อ.', '0'),
	('rk202', '2', '02', 'พลเรือโท', 'พล.ร.ท.', '0'),
	('rk203', '2', '03', 'พลเรือตรี', 'พล.ร.ต.', '0'),
	('rk204', '2', '04', 'นาวาเอก', 'น.อ.', '1'),
	('rk205', '2', '05', 'นาวาโท', 'น.ท.', '1'),
	('rk206', '2', '06', 'นาวาตรี', 'น.ต.', '1'),
	('rk207', '2', '07', 'เรือเอก', 'ร.อ.', '1'),
	('rk208', '2', '08', 'เรือโท', 'ร.ท.', '1'),
	('rk209', '2', '09', 'เรือตรี', 'ร.ต.', '1'),
	('rk210', '2', '10', 'พันจ่าเอก', 'พ.จ.อ.', '1'),
	('rk211', '2', '11', 'พันจ่าโท', 'พ.จ.ท.', '1'),
	('rk212', '2', '12', 'พันจ่าตรี', 'พ.จ.ต.', '1'),
	('rk213', '2', '13', 'จ่าเอก', 'จ.อ.', '1'),
	('rk214', '2', '14', 'จ่าโท', 'จ.ท.', '1'),
	('rk215', '2', '15', 'จ่าตรี', 'จ.ต.', '1'),
	('rk301', '3', '01', 'พลอากาศเอก', 'พล.อ.อ.', '0'),
	('rk302', '3', '02', 'พลอากาศโท', 'พล.อ.ท.', '0'),
	('rk303', '3', '03', 'พลอากาศตรี', 'พล.อ.ต.', '0'),
	('rk304', '3', '04', 'นาวาอากาศเอก', 'น.อ.', '1'),
	('rk305', '3', '05', 'นาวาอากาศโท', 'น.ท.', '1'),
	('rk306', '3', '06', 'นาวาอากาศตรี', 'น.ต.', '1'),
	('rk307', '3', '07', 'เรืออากาศเอก', 'ร.อ.', '1'),
	('rk308', '3', '08', 'เรืออากาศโท', 'ร.ท.', '1'),
	('rk309', '3', '09', 'เรืออากาศตรี', 'ร.ต.', '1'),
	('rk310', '3', '10', 'พันจ่าอากาศเอก', 'พ.อ.อ.', '1'),
	('rk311', '3', '11', 'พันจ่าอากาศโท', 'พ.อ.ท.', '1'),
	('rk312', '3', '12', 'พันจ่าอากาศตรี', 'พ.อ.ต.', '1'),
	('rk313', '3', '13', 'จ่าอากาศเอก', 'จ.อ.', '1'),
	('rk314', '3', '14', 'จ่าอากาศโท', 'จ.ท.', '1'),
	('rk315', '3', '15', 'จ่าอากาศตรี', 'จ.ต.', '1');
/*!40000 ALTER TABLE `rtarf_ranks` ENABLE KEYS */;

-- Dumping structure for table db_mas.tbl_profiles
CREATE TABLE IF NOT EXISTS `tbl_profiles` (
  `mil_number` char(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `pf_namefirst` varchar(250) COLLATE utf8_unicode_ci DEFAULT NULL,
  `pf_namelast` varchar(250) COLLATE utf8_unicode_ci DEFAULT NULL,
  `pf_rank` char(5) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `pf_sex` char(1) COLLATE utf8_unicode_ci DEFAULT NULL,
  `pf_datebirth` datetime DEFAULT NULL,
  `pf_dateingov` datetime DEFAULT NULL,
  `pf_position` varchar(150) COLLATE utf8_unicode_ci DEFAULT NULL,
  `pf_office` varchar(150) COLLATE utf8_unicode_ci DEFAULT NULL,
  `pf_asnow` char(1) COLLATE utf8_unicode_ci DEFAULT '0',
  `pf_dateasnow` datetime DEFAULT NULL,
  `pf_asnext` char(1) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `pf_dateasnext` datetime DEFAULT NULL,
  `pf_salarylevel` char(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `pf_salaryfloor` char(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `pf_salary` double DEFAULT NULL,
  `pf_updatedat` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  UNIQUE KEY `pf_milnumber` (`mil_number`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Dumping data for table db_mas.tbl_profiles: ~1 rows (approximately)
DELETE FROM `tbl_profiles`;
/*!40000 ALTER TABLE `tbl_profiles` DISABLE KEYS */;
INSERT INTO `tbl_profiles` (`mil_number`, `pf_namefirst`, `pf_namelast`, `pf_rank`, `pf_sex`, `pf_datebirth`, `pf_dateingov`, `pf_position`, `pf_office`, `pf_asnow`, `pf_dateasnow`, `pf_asnext`, `pf_dateasnext`, `pf_salarylevel`, `pf_salaryfloor`, `pf_salary`, `pf_updatedat`) VALUES
	('1234567890123', 'ทดสอน', 'ทดสอบกัน', 'rk204', '2', '1976-07-14 08:00:00', '2007-01-01 08:00:00', 'รรก.อจช.', 'วปอ.บก.สปท.', '1', '1900-01-01 08:00:00', NULL, NULL, 'น.1', '34', 25000.51, '2021-08-04 06:09:27');
/*!40000 ALTER TABLE `tbl_profiles` ENABLE KEYS */;

/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
