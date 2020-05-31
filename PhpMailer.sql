/*
 Navicat Premium Data Transfer

 Source Server         : local
 Source Server Type    : MySQL
 Source Server Version : 80020
 Source Host           : localhost:3306
 Source Schema         : PhpMailer

 Target Server Type    : MySQL
 Target Server Version : 80020
 File Encoding         : 65001

 Date: 31/05/2020 21:26:35
*/

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
-- Table structure for ac_filter
-- ----------------------------
DROP TABLE IF EXISTS `ac_filter`;
CREATE TABLE `ac_filter` (
  `mail_name` varchar(32) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `cont` varchar(32) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  PRIMARY KEY (`mail_name`,`cont`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of ac_filter
-- ----------------------------
BEGIN;
INSERT INTO `ac_filter` VALUES ('cindy', 'wjy@123.com');
INSERT INTO `ac_filter` VALUES ('kaia', 'wjy@123.com');
INSERT INTO `ac_filter` VALUES ('wjy', '123@123.com');
INSERT INTO `ac_filter` VALUES ('wjy', '126@123.com');
COMMIT;

-- ----------------------------
-- Table structure for email
-- ----------------------------
DROP TABLE IF EXISTS `email`;
CREATE TABLE `email` (
  `email_id` int(32) unsigned zerofill NOT NULL AUTO_INCREMENT,
  `mail_from` varchar(32) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL,
  `mail_to` varchar(32) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL,
  `subject` varchar(64) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL,
  `body` varchar(1024) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL,
  `time` varchar(63) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL,
  `size` int DEFAULT NULL,
  `is_read` char(1) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT '0',
  PRIMARY KEY (`email_id`)
) ENGINE=InnoDB AUTO_INCREMENT=25 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of email
-- ----------------------------
BEGIN;
INSERT INTO `email` VALUES (00000000000000000000000000000001, 'wjy@123.com', 'kaia@123.com', '第一次发', '测试数据库\n', '2020-05-29 23:16:48', 15, '1');
INSERT INTO `email` VALUES (00000000000000000000000000000002, 'wjy@123.com', 'wjy@123.com', '第一次发', '测试数据库\n', '2020-05-29 23:16:48', 15, '1');
INSERT INTO `email` VALUES (00000000000000000000000000000003, 'cindy@123.com', 'wjy@123.com', '群发', '测试数据库\n', '2020-05-29 23:21:45', 15, '1');
INSERT INTO `email` VALUES (00000000000000000000000000000004, 'cindy@123.com', 'kaia@123.com', '群发', '测试数据库\n', '2020-05-29 23:21:45', 15, '0');
INSERT INTO `email` VALUES (00000000000000000000000000000005, 'cindy@123.com', 'cindy@123.com', '群发', '测试数据库\n', '2020-05-29 23:21:45', 15, '0');
INSERT INTO `email` VALUES (00000000000000000000000000000007, 'wjy@123.com', 'cindy@123.com', '123', '132\n', '2020-05-29 23:28:21', 3, '0');
INSERT INTO `email` VALUES (00000000000000000000000000000009, 'wjy@123.com', 'kaia@123.com', '123', '123\n', '2020-05-30 01:38:36', 3, '0');
INSERT INTO `email` VALUES (00000000000000000000000000000013, 'wjy@123.com', 'cindy@123.com', '过滤', '12312312\n', '2020-05-31 17:47:08', 8, '1');
INSERT INTO `email` VALUES (00000000000000000000000000000014, 'wjy@123.com', 'kaia@123.com', '过滤', '12312312\n', '2020-05-31 17:47:08', 8, '1');
INSERT INTO `email` VALUES (00000000000000000000000000000015, 'wjy@123.com', 'kaia@123.com', '过滤try', '1233\n', '2020-05-31 18:03:17', 4, '0');
INSERT INTO `email` VALUES (00000000000000000000000000000016, 'wjy@123.com', 'kaia@123.com', '过滤尝试', '1234\n', '2020-05-31 18:21:35', 4, '0');
INSERT INTO `email` VALUES (00000000000000000000000000000017, 'wjy@123.com', 'cindy@123.com', '过滤尝试', '1234\n', '2020-05-31 18:21:35', 4, '0');
INSERT INTO `email` VALUES (00000000000000000000000000000018, 'wjy@123.com', 'wjy@123.com', '过滤尝试', '1234\n', '2020-05-31 18:21:35', 4, '1');
INSERT INTO `email` VALUES (00000000000000000000000000000019, 'wjy@123.com', 'cindy@123.com', '过滤', '日志情况测试\n', '2020-05-31 18:39:14', 18, '0');
INSERT INTO `email` VALUES (00000000000000000000000000000020, 'wjy@123.com', 'wjy@123.com', '过滤', '日志情况测试\n', '2020-05-31 18:39:14', 18, '1');
INSERT INTO `email` VALUES (00000000000000000000000000000021, 'wjy@123.com', 'cindy@123.com', '锅炉', 'ssss\n', '2020-05-31 18:41:19', 4, '1');
INSERT INTO `email` VALUES (00000000000000000000000000000023, '', '', '', '\n', '2020-05-31 20:44:56', 0, '0');
INSERT INTO `email` VALUES (00000000000000000000000000000024, 'wjy@123.com', 'wjy@123.com', 'filter for copy', '啦啦啦\n', '2020-05-31 21:17:47', 9, '0');
COMMIT;

-- ----------------------------
-- Table structure for ip_filter
-- ----------------------------
DROP TABLE IF EXISTS `ip_filter`;
CREATE TABLE `ip_filter` (
  `mail_name` varchar(32) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `cont` varchar(32) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  PRIMARY KEY (`mail_name`,`cont`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of ip_filter
-- ----------------------------
BEGIN;
INSERT INTO `ip_filter` VALUES ('wjy', '123.1.1.1');
COMMIT;

-- ----------------------------
-- Table structure for log
-- ----------------------------
DROP TABLE IF EXISTS `log`;
CREATE TABLE `log` (
  `log_id` int(32) unsigned zerofill NOT NULL AUTO_INCREMENT,
  `time` varchar(32) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL,
  `ip` varchar(32) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL,
  `op` varchar(32) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL,
  `data` varchar(1024) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL,
  `state` varchar(32) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL,
  `op_user` varchar(32) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL,
  `type` enum('ALL','SMTP','POP3','SERVER') CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL,
  PRIMARY KEY (`log_id`)
) ENGINE=InnoDB AUTO_INCREMENT=219 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of log
-- ----------------------------
BEGIN;
INSERT INTO `log` VALUES (00000000000000000000000000000003, '2020-05-29 23:16:05', '(\'192.168.1.4\', 57761)', 'register', '{\'User\':\'kaia\',\'Password\':\'123\'}', 'Successful', 'kaia', 'SERVER');
INSERT INTO `log` VALUES (00000000000000000000000000000005, '2020-05-29 23:16:25', '(\'192.168.1.4\', 57943)', 'login', '{\'User\':\'wjy\',\'Password\':\'123\'}', 'Successful', 'wjy', 'SERVER');
INSERT INTO `log` VALUES (00000000000000000000000000000006, '2020-05-29 23:16:48', '(\'192.168.1.4\', 48054)', 'SMTP auth', '{\'User\':\'wjy\',\'Password\':\'123\'}', 'Successful', 'wjy', 'SMTP');
INSERT INTO `log` VALUES (00000000000000000000000000000007, '2020-05-29 23:16:51', '(\'192.168.1.4\', 30636)', 'POP3 auth', '{\'User\':\'wjy\',\'Password\':\'123\'}', 'Successful', 'wjy', 'POP3');
INSERT INTO `log` VALUES (00000000000000000000000000000008, '2020-05-29 23:16:55', '(\'192.168.1.4\', 36639)', 'POP3 auth', '{\'User\':\'wjy\',\'Password\':\'123\'}', 'Successful', 'wjy', 'POP3');
INSERT INTO `log` VALUES (00000000000000000000000000000009, '2020-05-29 23:16:57', '(\'192.168.1.4\', 34769)', 'POP3 auth', '{\'User\':\'wjy\',\'Password\':\'123\'}', 'Successful', 'wjy', 'POP3');
INSERT INTO `log` VALUES (00000000000000000000000000000010, '2020-05-29 23:21:21', '(\'192.168.1.4\', 53730)', 'register', '{\'User\':\'cindy\',\'Password\':\'123\'}', 'Successful', 'cindy', 'SERVER');
INSERT INTO `log` VALUES (00000000000000000000000000000011, '2020-05-29 23:21:21', '(\'192.168.1.4\', 52451)', 'login', '{\'User\':\'cindy\',\'Password\':\'123\'}', 'Successful', 'cindy', 'SERVER');
INSERT INTO `log` VALUES (00000000000000000000000000000012, '2020-05-29 23:21:45', '(\'192.168.1.4\', 48543)', 'SMTP auth', '{\'User\':\'cindy\',\'Password\':\'123\'}', 'Successful', 'cindy', 'SMTP');
INSERT INTO `log` VALUES (00000000000000000000000000000013, '2020-05-29 23:21:45', '(\'192.168.1.4\', 48543)', 'start deliver', '{\'from\':\'cindy@123.com\',\'to\':\'wjy@123.com kaia@123.com cindy@123.com\',\'subject\':\'群发\'}', 'Mail Delivering...', 'cindy', 'SMTP');
INSERT INTO `log` VALUES (00000000000000000000000000000014, '2020-05-29 23:21:45', '(\'192.168.1.4\', 48543)', 'deliver mail', '{\'from\':\'cindy@123.com\',\'to\':\'wjy@123.com kaia@123.com cindy@123.com\',\'subject\':\'群发\'}', 'Successful', 'cindy', 'SMTP');
INSERT INTO `log` VALUES (00000000000000000000000000000015, '2020-05-29 23:21:45', '(\'192.168.1.4\', 48543)', 'deliver mail', '{\'from\':\'cindy@123.com\',\'to\':\'wjy@123.com kaia@123.com cindy@123.com\',\'subject\':\'群发\'}', 'Successful', 'cindy', 'SMTP');
INSERT INTO `log` VALUES (00000000000000000000000000000016, '2020-05-29 23:21:45', '(\'192.168.1.4\', 48543)', 'deliver mail', '{\'from\':\'cindy@123.com\',\'to\':\'wjy@123.com kaia@123.com cindy@123.com\',\'subject\':\'群发\'}', 'Successful', 'cindy', 'SMTP');
INSERT INTO `log` VALUES (00000000000000000000000000000017, '2020-05-29 23:21:51', '(\'192.168.1.4\', 34606)', 'POP3 auth', '{\'User\':\'cindy\',\'Password\':\'123\'}', 'Successful', 'cindy', 'POP3');
INSERT INTO `log` VALUES (00000000000000000000000000000018, '2020-05-29 23:22:19', '(\'192.168.1.4\', 50133)', 'login', '{\'User\':\'wjy\',\'Password\':\'132\'}', 'Failed : password error', 'wjy', 'SERVER');
INSERT INTO `log` VALUES (00000000000000000000000000000019, '2020-05-29 23:22:23', '(\'192.168.1.4\', 55691)', 'login', '{\'User\':\'wjy\',\'Password\':\'123\'}', 'Successful', 'wjy', 'SERVER');
INSERT INTO `log` VALUES (00000000000000000000000000000020, '2020-05-29 23:22:25', '(\'192.168.1.4\', 36236)', 'POP3 auth', '{\'User\':\'wjy\',\'Password\':\'123\'}', 'Successful', 'wjy', 'POP3');
INSERT INTO `log` VALUES (00000000000000000000000000000021, '2020-05-29 23:22:28', '(\'192.168.1.4\', 31696)', 'POP3 auth', '{\'User\':\'wjy\',\'Password\':\'123\'}', 'Successful', 'wjy', 'POP3');
INSERT INTO `log` VALUES (00000000000000000000000000000022, '2020-05-29 23:22:28', '(\'192.168.1.4\', 31696)', 'check mail', '{\'from\':\'wjy@123.com\',\'to\':\'wjy@123.com\',\'subject\':\'第一次发\',\'body\':\'测试数据库\n\'}', 'Successful', 'wjy', 'POP3');
INSERT INTO `log` VALUES (00000000000000000000000000000023, '2020-05-29 23:22:30', '(\'192.168.1.4\', 33837)', 'POP3 auth', '{\'User\':\'wjy\',\'Password\':\'123\'}', 'Successful', 'wjy', 'POP3');
INSERT INTO `log` VALUES (00000000000000000000000000000024, '2020-05-29 23:22:31', '(\'192.168.1.4\', 31299)', 'POP3 auth', '{\'User\':\'wjy\',\'Password\':\'123\'}', 'Successful', 'wjy', 'POP3');
INSERT INTO `log` VALUES (00000000000000000000000000000025, '2020-05-29 23:22:31', '(\'192.168.1.4\', 31299)', 'check mail', '{\'from\':\'cindy@123.com\',\'to\':\'wjy@123.com\',\'subject\':\'群发\',\'body\':\'测试数据库\n\'}', 'Successful', 'wjy', 'POP3');
INSERT INTO `log` VALUES (00000000000000000000000000000026, '2020-05-29 23:22:32', '(\'192.168.1.4\', 31514)', 'POP3 auth', '{\'User\':\'wjy\',\'Password\':\'123\'}', 'Successful', 'wjy', 'POP3');
INSERT INTO `log` VALUES (00000000000000000000000000000027, '2020-05-29 23:23:06', '(\'192.168.1.4\', 54469)', 'login', '{\'User\':\'wjy\',\'Password\':\'1234\'}', 'Successful', 'wjy', 'SERVER');
INSERT INTO `log` VALUES (00000000000000000000000000000028, '2020-05-29 23:23:32', '(\'192.168.1.4\', 53795)', 'manage user', '{\'Administrator\':\'wjy\',\'SrcIp\':\'(\'192.168.1.4\' 53795)\',\'Modified User\':\'kaia\'}', 'Successful', 'wjy', 'SERVER');
INSERT INTO `log` VALUES (00000000000000000000000000000029, '2020-05-29 23:24:04', '(\'192.168.1.4\', 57364)', 'manage user', '{\'Administrator\':\'wjy\',\'SrcIp\':\'(\'192.168.1.4\' 57364)\',\'Modified User\':\'kaia\'}', 'Successful', 'wjy', 'SERVER');
INSERT INTO `log` VALUES (00000000000000000000000000000084, '2020-05-31 13:15:03', '(\'192.168.1.4\', 52210)', 'login', '{\'User\':\'wjy\',\'Password\':\'123\'}', 'Successful', 'wjy', 'SERVER');
INSERT INTO `log` VALUES (00000000000000000000000000000085, '2020-05-31 15:57:10', '(\'192.168.1.4\', 54773)', 'login', '{\'User\':\'wjy\',\'Password\':\'123\'}', 'Successful', 'wjy', 'SERVER');
INSERT INTO `log` VALUES (00000000000000000000000000000086, '2020-05-31 16:07:13', '(\'192.168.1.4\', 57085)', 'login', '{\'User\':\'kaia\',\'Password\':\'123\'}', 'Successful', 'kaia', 'SERVER');
INSERT INTO `log` VALUES (00000000000000000000000000000087, '2020-05-31 16:07:18', '(\'192.168.1.4\', 55713)', 'login', '{\'User\':\'wjy\',\'Password\':\'123\'}', 'Successful', 'wjy', 'SERVER');
INSERT INTO `log` VALUES (00000000000000000000000000000088, '2020-05-31 16:12:45', '(\'192.168.1.4\', 59063)', 'login', '{\'User\':\'wjy\',\'Password\':\'123\'}', 'Successful', 'wjy', 'SERVER');
INSERT INTO `log` VALUES (00000000000000000000000000000089, '2020-05-31 16:48:41', '(\'192.168.1.4\', 57648)', 'login', '{\'User\':\'kaia\',\'Password\':\'123\'}', 'Successful', 'kaia', 'SERVER');
INSERT INTO `log` VALUES (00000000000000000000000000000090, '2020-05-31 16:57:42', '(\'192.168.1.4\', 51417)', 'login', '{\'User\':\'kaia\',\'Password\':\'123\'}', 'Successful', 'kaia', 'SERVER');
INSERT INTO `log` VALUES (00000000000000000000000000000091, '2020-05-31 17:42:36', '(\'192.168.1.4\', 50618)', 'login', '{\'User\':\'wjy\',\'Password\':\'123\'}', 'Successful', 'wjy', 'SERVER');
INSERT INTO `log` VALUES (00000000000000000000000000000092, '2020-05-31 17:42:41', '(\'192.168.1.4\', 51463)', 'login', '{\'User\':\'kaia\',\'Password\':\'123\'}', 'Successful', 'kaia', 'SERVER');
INSERT INTO `log` VALUES (00000000000000000000000000000093, '2020-05-31 17:42:46', '(\'192.168.1.4\', 55329)', 'login', '{\'User\':\'cindy\',\'Password\':\'123\'}', 'Successful', 'cindy', 'SERVER');
INSERT INTO `log` VALUES (00000000000000000000000000000094, '2020-05-31 17:42:50', '(\'192.168.1.4\', 57299)', 'login', '{\'User\':\'wjy\',\'Password\':\'123\'}', 'Successful', 'wjy', 'SERVER');
INSERT INTO `log` VALUES (00000000000000000000000000000095, '2020-05-31 17:42:59', '(\'192.168.1.4\', 53492)', 'login', '{\'User\':\'kaia\',\'Password\':\'123\'}', 'Successful', 'kaia', 'SERVER');
INSERT INTO `log` VALUES (00000000000000000000000000000096, '2020-05-31 17:43:09', '(\'192.168.1.4\', 51389)', 'login', '{\'User\':\'cindy\',\'Password\':\'123\'}', 'Successful', 'cindy', 'SERVER');
INSERT INTO `log` VALUES (00000000000000000000000000000097, '2020-05-31 17:44:06', '(\'192.168.1.4\', 51936)', 'login', '{\'User\':\'wjy\',\'Password\':\'123\'}', 'Successful', 'wjy', 'SERVER');
INSERT INTO `log` VALUES (00000000000000000000000000000098, '2020-05-31 17:47:08', '(\'192.168.1.4\', 44513)', 'SMTP auth', '{\'User\':\'wjy\',\'Password\':\'123\'}', 'Successful', 'wjy', 'SMTP');
INSERT INTO `log` VALUES (00000000000000000000000000000099, '2020-05-31 17:47:08', '(\'192.168.1.4\', 44513)', 'start deliver', '{\'from\':\'wjy@123.com\',\'to\':\'cindy@123.com kaia@123.com\',\'subject\':\'过滤\'}', 'Mail Delivering...', 'wjy', 'SMTP');
INSERT INTO `log` VALUES (00000000000000000000000000000100, '2020-05-31 17:47:08', '(\'192.168.1.4\', 44513)', 'deliver mail', '{\'from\':\'wjy@123.com\',\'to\':\'cindy@123.com kaia@123.com\',\'subject\':\'过滤\'}', 'Successful', 'wjy', 'SMTP');
INSERT INTO `log` VALUES (00000000000000000000000000000101, '2020-05-31 17:47:08', '(\'192.168.1.4\', 44513)', 'deliver mail', '{\'from\':\'wjy@123.com\',\'to\':\'cindy@123.com kaia@123.com\',\'subject\':\'过滤\'}', 'Successful', 'wjy', 'SMTP');
INSERT INTO `log` VALUES (00000000000000000000000000000102, '2020-05-31 17:47:41', '(\'192.168.1.4\', 50121)', 'login', '{\'User\':\'cindy\',\'Password\':\'123\'}', 'Successful', 'cindy', 'SERVER');
INSERT INTO `log` VALUES (00000000000000000000000000000103, '2020-05-31 17:47:49', '(\'192.168.1.4\', 38147)', 'POP3 auth', '{\'User\':\'cindy\',\'Password\':\'123\'}', 'Successful', 'cindy', 'POP3');
INSERT INTO `log` VALUES (00000000000000000000000000000104, '2020-05-31 17:48:14', '(\'192.168.1.4\', 32879)', 'POP3 auth', '{\'User\':\'cindy\',\'Password\':\'123\'}', 'Successful', 'cindy', 'POP3');
INSERT INTO `log` VALUES (00000000000000000000000000000105, '2020-05-31 17:48:14', '(\'192.168.1.4\', 32879)', 'check mail', '{\'from\':\'wjy@123.com\',\'to\':\'cindy@123.com\',\'subject\':\'过滤\',\'body\':\'12312312\n\'}', 'Successful', 'cindy', 'POP3');
INSERT INTO `log` VALUES (00000000000000000000000000000106, '2020-05-31 17:48:16', '(\'192.168.1.4\', 30460)', 'POP3 auth', '{\'User\':\'cindy\',\'Password\':\'123\'}', 'Successful', 'cindy', 'POP3');
INSERT INTO `log` VALUES (00000000000000000000000000000107, '2020-05-31 18:01:05', '(\'192.168.1.4\', 58383)', 'login', '{\'User\':\'kaia\',\'Password\':\'123\'}', 'Successful', 'kaia', 'SERVER');
INSERT INTO `log` VALUES (00000000000000000000000000000108, '2020-05-31 18:01:58', '(\'192.168.1.4\', 55097)', 'login', '{\'User\':\'kaia\',\'Password\':\'123\'}', 'Successful', 'kaia', 'SERVER');
INSERT INTO `log` VALUES (00000000000000000000000000000109, '2020-05-31 18:02:09', '(\'192.168.1.4\', 50407)', 'login', '{\'User\':\'wjy\',\'Password\':\'123\'}', 'Successful', 'wjy', 'SERVER');
INSERT INTO `log` VALUES (00000000000000000000000000000110, '2020-05-31 18:03:17', '(\'192.168.1.4\', 45494)', 'SMTP auth', '{\'User\':\'wjy\',\'Password\':\'123\'}', 'Successful', 'wjy', 'SMTP');
INSERT INTO `log` VALUES (00000000000000000000000000000111, '2020-05-31 18:03:17', '(\'192.168.1.4\', 45494)', 'start deliver', '{\'from\':\'wjy@123.com\',\'to\':\'kaia@123.com\',\'subject\':\'过滤try\'}', 'Mail Delivering...', 'wjy', 'SMTP');
INSERT INTO `log` VALUES (00000000000000000000000000000112, '2020-05-31 18:03:17', '(\'192.168.1.4\', 45494)', 'deliver mail', '{\'from\':\'wjy@123.com\',\'to\':\'kaia@123.com\',\'subject\':\'过滤try\'}', 'Successful', 'wjy', 'SMTP');
INSERT INTO `log` VALUES (00000000000000000000000000000113, '2020-05-31 18:18:59', '(\'192.168.1.4\', 56862)', 'login', '{\'User\':\'cindy\',\'Password\':\'123\'}', 'Successful', 'cindy', 'SERVER');
INSERT INTO `log` VALUES (00000000000000000000000000000114, '2020-05-31 18:19:06', '(\'192.168.1.4\', 58931)', 'login', '{\'User\':\'wjy\',\'Password\':\'123\'}', 'Successful', 'wjy', 'SERVER');
INSERT INTO `log` VALUES (00000000000000000000000000000115, '2020-05-31 18:19:35', '(\'192.168.1.4\', 43555)', 'SMTP auth', '{\'User\':\'wjy\',\'Password\':\'123\'}', 'Successful', 'wjy', 'SMTP');
INSERT INTO `log` VALUES (00000000000000000000000000000116, '2020-05-31 18:19:35', '(\'192.168.1.4\', 43555)', 'start deliver', '{\'from\':\'wjy@123.com\',\'to\':\'kaia@123.com cindy@123.com wjy@123.com\',\'subject\':\'过滤尝试\'}', 'Mail Delivering...', 'wjy', 'SMTP');
INSERT INTO `log` VALUES (00000000000000000000000000000117, '2020-05-31 18:19:38', '(\'192.168.1.4\', 39113)', 'POP3 auth', '{\'User\':\'wjy\',\'Password\':\'123\'}', 'Successful', 'wjy', 'POP3');
INSERT INTO `log` VALUES (00000000000000000000000000000118, '2020-05-31 18:19:45', '(\'192.168.1.4\', 32394)', 'POP3 auth', '{\'User\':\'wjy\',\'Password\':\'123\'}', 'Successful', 'wjy', 'POP3');
INSERT INTO `log` VALUES (00000000000000000000000000000119, '2020-05-31 18:19:52', '(\'192.168.1.4\', 51663)', 'login', '{\'User\':\'wjy\',\'Password\':\'123\'}', 'Successful', 'wjy', 'SERVER');
INSERT INTO `log` VALUES (00000000000000000000000000000120, '2020-05-31 18:20:05', '(\'192.168.1.4\', 58779)', 'login', '{\'User\':\'kaia\',\'Password\':\'123\'}', 'Successful', 'kaia', 'SERVER');
INSERT INTO `log` VALUES (00000000000000000000000000000121, '2020-05-31 18:20:05', '(\'192.168.1.4\', 39320)', 'POP3 auth', '{\'User\':\'kaia\',\'Password\':\'123\'}', 'Successful', 'kaia', 'POP3');
INSERT INTO `log` VALUES (00000000000000000000000000000122, '2020-05-31 18:21:35', '(\'192.168.1.4\', 43555)', 'deliver mail', '{\'from\':\'wjy@123.com\',\'to\':\'kaia@123.com cindy@123.com wjy@123.com\',\'subject\':\'过滤尝试\'}', 'Successful', 'wjy', 'SMTP');
INSERT INTO `log` VALUES (00000000000000000000000000000123, '2020-05-31 18:21:35', '(\'192.168.1.4\', 43555)', 'deliver mail', '{\'from\':\'wjy@123.com\',\'to\':\'kaia@123.com cindy@123.com wjy@123.com\',\'subject\':\'过滤尝试\'}', 'Successful', 'wjy', 'SMTP');
INSERT INTO `log` VALUES (00000000000000000000000000000124, '2020-05-31 18:21:35', '(\'192.168.1.4\', 43555)', 'deliver mail', '{\'from\':\'wjy@123.com\',\'to\':\'kaia@123.com cindy@123.com wjy@123.com\',\'subject\':\'过滤尝试\'}', 'Successful', 'wjy', 'SMTP');
INSERT INTO `log` VALUES (00000000000000000000000000000125, '2020-05-31 18:38:37', '(\'192.168.1.4\', 54461)', 'login', '{\'User\':\'cindy\',\'Password\':\'123\'}', 'Successful', 'cindy', 'SERVER');
INSERT INTO `log` VALUES (00000000000000000000000000000126, '2020-05-31 18:38:44', '(\'192.168.1.4\', 58215)', 'login', '{\'User\':\'wjy\',\'Password\':\'123\'}', 'Successful', 'wjy', 'SERVER');
INSERT INTO `log` VALUES (00000000000000000000000000000127, '2020-05-31 18:39:14', '(\'192.168.1.4\', 41422)', 'SMTP auth', '{\'User\':\'wjy\',\'Password\':\'123\'}', 'Successful', 'wjy', 'SMTP');
INSERT INTO `log` VALUES (00000000000000000000000000000128, '2020-05-31 18:39:14', '(\'192.168.1.4\', 41422)', 'start deliver', '{\'from\':\'wjy@123.com\',\'to\':\'cindy@123.com wjy@123.com\',\'subject\':\'过滤\'}', 'Mail Delivering...', 'wjy', 'SMTP');
INSERT INTO `log` VALUES (00000000000000000000000000000129, '2020-05-31 18:39:14', '(\'192.168.1.4\', 41422)', 'deliver mail', '{\'from\':\'wjy@123.com\',\'to\':\'cindy@123.com wjy@123.com\',\'subject\':\'过滤\'}', 'Successful', 'wjy', 'SMTP');
INSERT INTO `log` VALUES (00000000000000000000000000000130, '2020-05-31 18:39:14', '(\'192.168.1.4\', 41422)', 'deliver mail', '{\'from\':\'wjy@123.com\',\'to\':\'cindy@123.com wjy@123.com\',\'subject\':\'过滤\'}', 'Successful', 'wjy', 'SMTP');
INSERT INTO `log` VALUES (00000000000000000000000000000131, '2020-05-31 18:39:17', '(\'192.168.1.4\', 31506)', 'POP3 auth', '{\'User\':\'wjy\',\'Password\':\'123\'}', 'Successful', 'wjy', 'POP3');
INSERT INTO `log` VALUES (00000000000000000000000000000132, '2020-05-31 18:39:24', '(\'192.168.1.4\', 38931)', 'POP3 auth', '{\'User\':\'wjy\',\'Password\':\'123\'}', 'Successful', 'wjy', 'POP3');
INSERT INTO `log` VALUES (00000000000000000000000000000133, '2020-05-31 18:39:24', '(\'192.168.1.4\', 38931)', 'check mail', '{\'from\':\'wjy@123.com\',\'to\':\'wjy@123.com\',\'subject\':\'过滤尝试\',\'body\':\'1234\n\'}', 'Successful', 'wjy', 'POP3');
INSERT INTO `log` VALUES (00000000000000000000000000000134, '2020-05-31 18:39:25', '(\'192.168.1.4\', 37508)', 'POP3 auth', '{\'User\':\'wjy\',\'Password\':\'123\'}', 'Successful', 'wjy', 'POP3');
INSERT INTO `log` VALUES (00000000000000000000000000000135, '2020-05-31 18:39:35', '(\'192.168.1.4\', 57804)', 'login', '{\'User\':\'cindy\',\'Password\':\'123\'}', 'Successful', 'cindy', 'SERVER');
INSERT INTO `log` VALUES (00000000000000000000000000000136, '2020-05-31 18:39:36', '(\'192.168.1.4\', 32902)', 'POP3 auth', '{\'User\':\'cindy\',\'Password\':\'123\'}', 'Successful', 'cindy', 'POP3');
INSERT INTO `log` VALUES (00000000000000000000000000000137, '2020-05-31 18:40:41', '(\'192.168.1.4\', 52415)', 'login', '{\'User\':\'cindy\',\'Password\':\'123\'}', 'Successful', 'cindy', 'SERVER');
INSERT INTO `log` VALUES (00000000000000000000000000000138, '2020-05-31 18:41:08', '(\'192.168.1.4\', 58875)', 'login', '{\'User\':\'wjy\',\'Password\':\'123\'}', 'Successful', 'wjy', 'SERVER');
INSERT INTO `log` VALUES (00000000000000000000000000000139, '2020-05-31 18:41:19', '(\'192.168.1.4\', 41133)', 'SMTP auth', '{\'User\':\'wjy\',\'Password\':\'123\'}', 'Successful', 'wjy', 'SMTP');
INSERT INTO `log` VALUES (00000000000000000000000000000140, '2020-05-31 18:41:19', '(\'192.168.1.4\', 41133)', 'start deliver', '{\'from\':\'wjy@123.com\',\'to\':\'cindy@123.com\',\'subject\':\'锅炉\'}', 'Mail Delivering...', 'wjy', 'SMTP');
INSERT INTO `log` VALUES (00000000000000000000000000000141, '2020-05-31 18:41:19', '(\'192.168.1.4\', 41133)', 'deliver mail', '{\'from\':\'wjy@123.com\',\'to\':\'cindy@123.com\',\'subject\':\'锅炉\'}', 'Successful', 'wjy', 'SMTP');
INSERT INTO `log` VALUES (00000000000000000000000000000142, '2020-05-31 18:42:08', '(\'192.168.1.4\', 56886)', 'login', '{\'User\':\'cindy\',\'Password\':\'123\'}', 'Successful', 'cindy', 'SERVER');
INSERT INTO `log` VALUES (00000000000000000000000000000143, '2020-05-31 18:42:11', '(\'192.168.1.4\', 35049)', 'POP3 auth', '{\'User\':\'cindy\',\'Password\':\'123\'}', 'Successful', 'cindy', 'POP3');
INSERT INTO `log` VALUES (00000000000000000000000000000144, '2020-05-31 18:42:13', '(\'192.168.1.4\', 36837)', 'POP3 auth', '{\'User\':\'cindy\',\'Password\':\'123\'}', 'Successful', 'cindy', 'POP3');
INSERT INTO `log` VALUES (00000000000000000000000000000145, '2020-05-31 18:42:13', '(\'192.168.1.4\', 36837)', 'check mail', '{\'from\':\'wjy@123.com\',\'to\':\'cindy@123.com\',\'subject\':\'锅炉\',\'body\':\'ssss\n\'}', 'Successful', 'cindy', 'POP3');
INSERT INTO `log` VALUES (00000000000000000000000000000146, '2020-05-31 18:42:15', '(\'192.168.1.4\', 39049)', 'POP3 auth', '{\'User\':\'cindy\',\'Password\':\'123\'}', 'Successful', 'cindy', 'POP3');
INSERT INTO `log` VALUES (00000000000000000000000000000147, '2020-05-31 18:48:11', '(\'192.168.1.4\', 53967)', 'login', '{\'User\':\'wjy\',\'Password\':\'123\'}', 'Successful', 'wjy', 'SERVER');
INSERT INTO `log` VALUES (00000000000000000000000000000148, '2020-05-31 18:48:22', '(\'192.168.1.4\', 50819)', 'login', '{\'User\':\'cindy\',\'Password\':\'123\'}', 'Successful', 'cindy', 'SERVER');
INSERT INTO `log` VALUES (00000000000000000000000000000149, '2020-05-31 18:49:24', '(\'192.168.1.4\', 45956)', 'SMTP auth', '{\'User\':\'wjy\',\'Password\':\'123\'}', 'Successful', 'wjy', 'SMTP');
INSERT INTO `log` VALUES (00000000000000000000000000000150, '2020-05-31 18:50:19', '(\'192.168.1.4\', 56169)', 'login', '{\'User\':\'kaia\',\'Password\':\'123\'}', 'Successful', 'kaia', 'SERVER');
INSERT INTO `log` VALUES (00000000000000000000000000000151, '2020-05-31 18:50:50', '(\'192.168.1.4\', 45956)', 'start deliver', '{\'from\':\'wjy@123.com\',\'to\':\'kaia@123.com\',\'subject\':\'hava a try!\'}', 'Mail Delivering...', 'wjy', 'SMTP');
INSERT INTO `log` VALUES (00000000000000000000000000000152, '2020-05-31 18:50:50', '(\'192.168.1.4\', 45956)', 'deliver mail', '{\'from\':\'wjy@123.com\',\'to\':\'kaia@123.com\',\'subject\':\'hava a try!\'}', 'Successful', 'wjy', 'SMTP');
INSERT INTO `log` VALUES (00000000000000000000000000000153, '2020-05-31 18:52:54', '(\'192.168.1.4\', 52996)', 'login', '{\'User\':\'kaia\',\'Password\':\'123\'}', 'Successful', 'kaia', 'SERVER');
INSERT INTO `log` VALUES (00000000000000000000000000000154, '2020-05-31 18:54:01', '(\'192.168.1.4\', 56563)', 'login', '{\'User\':\'wjy\',\'Password\':\'123\'}', 'Successful', 'wjy', 'SERVER');
INSERT INTO `log` VALUES (00000000000000000000000000000155, '2020-05-31 18:54:53', '(\'192.168.1.4\', 49375)', 'SMTP auth', '{\'User\':\'wjy\',\'Password\':\'123\'}', 'Successful', 'wjy', 'SMTP');
INSERT INTO `log` VALUES (00000000000000000000000000000156, '2020-05-31 18:55:21', '(\'192.168.1.4\', 49375)', 'start deliver', '{\'from\':\'wjy@123.com\',\'to\':\'kaia@123.com\',\'subject\':\'hava a try!\'}', 'Mail Delivering...', 'wjy', 'SMTP');
INSERT INTO `log` VALUES (00000000000000000000000000000157, '2020-05-31 19:00:43', '(\'192.168.1.4\', 54513)', 'login', '{\'User\':\'kaia\',\'Password\':\'123\'}', 'Successful', 'kaia', 'SERVER');
INSERT INTO `log` VALUES (00000000000000000000000000000158, '2020-05-31 19:00:53', '(\'192.168.1.4\', 57067)', 'login', '{\'User\':\'wjy\',\'Password\':\'123\'}', 'Successful', 'wjy', 'SERVER');
INSERT INTO `log` VALUES (00000000000000000000000000000159, '2020-05-31 19:01:17', '(\'192.168.1.4\', 47018)', 'SMTP auth', '{\'User\':\'wjy\',\'Password\':\'123\'}', 'Successful', 'wjy', 'SMTP');
INSERT INTO `log` VALUES (00000000000000000000000000000160, '2020-05-31 19:01:46', '(\'192.168.1.4\', 47018)', 'start deliver', '{\'from\':\'wjy@123.com\',\'to\':\'kaia@123.com\',\'subject\':\'hava a try!\'}', 'Mail Delivering...', 'wjy', 'SMTP');
INSERT INTO `log` VALUES (00000000000000000000000000000161, '2020-05-31 19:08:59', '(\'192.168.1.4\', 56402)', 'login', '{\'User\':\'kaia\',\'Password\':\'123\'}', 'Successful', 'kaia', 'SERVER');
INSERT INTO `log` VALUES (00000000000000000000000000000162, '2020-05-31 19:09:06', '(\'192.168.1.4\', 59776)', 'login', '{\'User\':\'wjy\',\'Password\':\'123\'}', 'Successful', 'wjy', 'SERVER');
INSERT INTO `log` VALUES (00000000000000000000000000000163, '2020-05-31 19:09:32', '(\'192.168.1.4\', 40704)', 'SMTP auth', '{\'User\':\'wjy\',\'Password\':\'123\'}', 'Successful', 'wjy', 'SMTP');
INSERT INTO `log` VALUES (00000000000000000000000000000164, '2020-05-31 19:09:48', '(\'192.168.1.4\', 40704)', 'start deliver', '{\'from\':\'wjy@123.com\',\'to\':\'kaia@123.com\',\'subject\':\'hava a try!\'}', 'Mail Delivering...', 'wjy', 'SMTP');
INSERT INTO `log` VALUES (00000000000000000000000000000166, '2020-05-31 19:13:18', '(\'192.168.1.4\', 59999)', 'login', '{\'User\':\'wjy\',\'Password\':\'123\'}', 'Successful', 'wjy', 'SERVER');
INSERT INTO `log` VALUES (00000000000000000000000000000167, '2020-05-31 19:13:46', '(\'192.168.1.4\', 45384)', 'SMTP auth', '{\'User\':\'wjy\',\'Password\':\'123\'}', 'Successful', 'wjy', 'SMTP');
INSERT INTO `log` VALUES (00000000000000000000000000000168, '2020-05-31 19:13:46', '(\'192.168.1.4\', 45384)', 'start deliver', '{\'from\':\'wjy@123.com\',\'to\':\'kaia@123.com wjy@123.com\',\'subject\':\'filter log try\'}', 'Mail Delivering...', 'wjy', 'SMTP');
INSERT INTO `log` VALUES (00000000000000000000000000000169, '2020-05-31 19:13:48', '(\'192.168.1.4\', 32357)', 'POP3 auth', '{\'User\':\'wjy\',\'Password\':\'123\'}', 'Successful', 'wjy', 'POP3');
INSERT INTO `log` VALUES (00000000000000000000000000000170, '2020-05-31 19:13:55', '(\'192.168.1.4\', 34041)', 'POP3 auth', '{\'User\':\'wjy\',\'Password\':\'123\'}', 'Successful', 'wjy', 'POP3');
INSERT INTO `log` VALUES (00000000000000000000000000000171, '2020-05-31 19:14:00', '(\'192.168.1.4\', 35814)', 'POP3 auth', '{\'User\':\'wjy\',\'Password\':\'123\'}', 'Successful', 'wjy', 'POP3');
INSERT INTO `log` VALUES (00000000000000000000000000000172, '2020-05-31 19:14:00', '(\'192.168.1.4\', 35814)', 'check mail', '{\'from\':\'wjy@123.com\',\'to\':\'wjy@123.com\',\'subject\':\'过滤\',\'body\':\'日志情况测试\n\'}', 'Successful', 'wjy', 'POP3');
INSERT INTO `log` VALUES (00000000000000000000000000000173, '2020-05-31 19:14:01', '(\'192.168.1.4\', 32724)', 'POP3 auth', '{\'User\':\'wjy\',\'Password\':\'123\'}', 'Successful', 'wjy', 'POP3');
INSERT INTO `log` VALUES (00000000000000000000000000000174, '2020-05-31 19:14:14', '(\'192.168.1.4\', 57352)', 'login', '{\'User\':\'kaia\',\'Password\':\'123\'}', 'Successful', 'kaia', 'SERVER');
INSERT INTO `log` VALUES (00000000000000000000000000000175, '2020-05-31 19:14:15', '(\'192.168.1.4\', 33469)', 'POP3 auth', '{\'User\':\'kaia\',\'Password\':\'123\'}', 'Successful', 'kaia', 'POP3');
INSERT INTO `log` VALUES (00000000000000000000000000000176, '2020-05-31 19:15:59', '(\'192.168.1.4\', 50208)', 'login', '{\'User\':\'kaia\',\'Password\':\'123\'}', 'Successful', 'kaia', 'SERVER');
INSERT INTO `log` VALUES (00000000000000000000000000000177, '2020-05-31 19:16:06', '(\'192.168.1.4\', 54499)', 'login', '{\'User\':\'wjy\',\'Password\':\'123\'}', 'Successful', 'wjy', 'SERVER');
INSERT INTO `log` VALUES (00000000000000000000000000000178, '2020-05-31 19:16:29', '(\'192.168.1.4\', 42741)', 'SMTP auth', '{\'User\':\'wjy\',\'Password\':\'123\'}', 'Successful', 'wjy', 'SMTP');
INSERT INTO `log` VALUES (00000000000000000000000000000179, '2020-05-31 19:16:47', '(\'192.168.1.4\', 42741)', 'start deliver', '{\'from\':\'wjy@123.com\',\'to\':\'kaia@123.com\',\'subject\':\'hava a try!\'}', 'Mail Delivering...', 'wjy', 'SMTP');
INSERT INTO `log` VALUES (00000000000000000000000000000180, '2020-05-31 19:16:47', '(\'192.168.1.4\', 58410)', 'intercept mail', '{\'from\':\'wjy@123.com\',\'to\':\'kaia@123.com\',\'subject\':\'hava a try!\'}', 'Successful', 'kaia', 'SMTP');
INSERT INTO `log` VALUES (00000000000000000000000000000181, '2020-05-31 19:17:32', '(\'192.168.1.4\', 56818)', 'login', '{\'User\':\'kaia\',\'Password\':\'123\'}', 'Successful', 'kaia', 'SERVER');
INSERT INTO `log` VALUES (00000000000000000000000000000182, '2020-05-31 19:17:36', '(\'192.168.1.4\', 50779)', 'login', '{\'User\':\'cindy\',\'Password\':\'123\'}', 'Successful', 'cindy', 'SERVER');
INSERT INTO `log` VALUES (00000000000000000000000000000183, '2020-05-31 19:17:39', '(\'192.168.1.4\', 51837)', 'login', '{\'User\':\'wjy\',\'Password\':\'123\'}', 'Successful', 'wjy', 'SERVER');
INSERT INTO `log` VALUES (00000000000000000000000000000184, '2020-05-31 19:18:06', '(\'192.168.1.4\', 46972)', 'SMTP auth', '{\'User\':\'wjy\',\'Password\':\'123\'}', 'Successful', 'wjy', 'SMTP');
INSERT INTO `log` VALUES (00000000000000000000000000000185, '2020-05-31 19:18:06', '(\'192.168.1.4\', 46972)', 'start deliver', '{\'from\':\'wjy@123.com\',\'to\':\'kaia@123.com\',\'subject\':\'filter kaia try\'}', 'Mail Delivering...', 'wjy', 'SMTP');
INSERT INTO `log` VALUES (00000000000000000000000000000186, '2020-05-31 19:18:06', '(\'192.168.1.4\', 54951)', 'intercept mail', '{\'from\':\'wjy@123.com\',\'to\':\'kaia@123.com\',\'subject\':\'filter kaia try\'}', 'Successful', 'kaia', 'SMTP');
INSERT INTO `log` VALUES (00000000000000000000000000000187, '2020-05-31 19:18:15', '(\'192.168.1.4\', 57878)', 'login', '{\'User\':\'kaia\',\'Password\':\'123\'}', 'Successful', 'kaia', 'SERVER');
INSERT INTO `log` VALUES (00000000000000000000000000000188, '2020-05-31 19:18:17', '(\'192.168.1.4\', 35459)', 'POP3 auth', '{\'User\':\'kaia\',\'Password\':\'123\'}', 'Successful', 'kaia', 'POP3');
INSERT INTO `log` VALUES (00000000000000000000000000000189, '2020-05-31 19:27:56', '(\'192.168.1.4\', 53397)', 'login', '{\'User\':\'wjy\',\'Password\':\'123\'}', 'Successful', 'wjy', 'SERVER');
INSERT INTO `log` VALUES (00000000000000000000000000000190, '2020-05-31 19:29:50', '(\'192.168.1.4\', 58292)', 'login', '{\'User\':\'kaia\',\'Password\':\'123\'}', 'Successful', 'kaia', 'SERVER');
INSERT INTO `log` VALUES (00000000000000000000000000000191, '2020-05-31 19:29:55', '(\'192.168.1.4\', 50664)', 'login', '{\'User\':\'wjy\',\'Password\':\'123\'}', 'Successful', 'wjy', 'SERVER');
INSERT INTO `log` VALUES (00000000000000000000000000000192, '2020-05-31 19:30:19', '(\'192.168.1.4\', 43919)', 'SMTP auth', '{\'User\':\'wjy\',\'Password\':\'123\'}', 'Successful', 'wjy', 'SMTP');
INSERT INTO `log` VALUES (00000000000000000000000000000193, '2020-05-31 19:30:19', '(\'192.168.1.4\', 43919)', 'start deliver', '{\'from\':\'wjy@123.com\',\'to\':\'kaia@123.com\',\'subject\':\'过滤返回\'}', 'Mail Delivering...', 'wjy', 'SMTP');
INSERT INTO `log` VALUES (00000000000000000000000000000194, '2020-05-31 19:30:19', '(\'192.168.1.4\', 59495)', 'intercept mail', '{\'from\':\'wjy@123.com\',\'to\':\'kaia@123.com\',\'subject\':\'过滤返回\'}', 'Successful', 'kaia', 'SMTP');
INSERT INTO `log` VALUES (00000000000000000000000000000195, '2020-05-31 20:42:32', '(\'192.168.1.4\', 57075)', 'login', '{\'User\':\'kaia\',\'Password\':\'123\'}', 'Successful', 'kaia', 'SERVER');
INSERT INTO `log` VALUES (00000000000000000000000000000196, '2020-05-31 20:42:39', '(\'192.168.1.4\', 57620)', 'login', '{\'User\':\'wjy\',\'Password\':\'123\'}', 'Successful', 'wjy', 'SERVER');
INSERT INTO `log` VALUES (00000000000000000000000000000197, '2020-05-31 20:44:56', '(\'192.168.1.4\', 47408)', 'SMTP auth', '{\'User\':\'wjy\',\'Password\':\'123\'}', 'Successful', 'wjy', 'SMTP');
INSERT INTO `log` VALUES (00000000000000000000000000000198, '2020-05-31 20:44:56', '(\'192.168.1.4\', 47408)', 'start deliver', '{\'from\':\'wjy@123.com\',\'to\':\'kaia@123.com wjy@123.com\',\'subject\':\'guolv\'}', 'Mail Delivering...', 'wjy', 'SMTP');
INSERT INTO `log` VALUES (00000000000000000000000000000199, '2020-05-31 20:44:56', '(\'192.168.1.4\', 50830)', 'intercept mail', '{\'from\':\'wjy@123.com\',\'to\':\'kaia@123.com\',\'subject\':\'guolv\'}', 'Successful', 'kaia', 'SMTP');
INSERT INTO `log` VALUES (00000000000000000000000000000200, '2020-05-31 20:44:56', '(\'192.168.1.4\', 47408)', 'deliver mail', '{\'from\':\'wjy@123.com\',\'to\':\'kaia@123.com wjy@123.com\',\'subject\':\'guolv\'}', 'Successful', 'wjy', 'SMTP');
INSERT INTO `log` VALUES (00000000000000000000000000000201, '2020-05-31 20:48:51', '(\'192.168.1.4\', 33652)', 'POP3 auth', '{\'User\':\'wjy\',\'Password\':\'123\'}', 'Successful', 'wjy', 'POP3');
INSERT INTO `log` VALUES (00000000000000000000000000000202, '2020-05-31 21:17:26', '(\'192.168.1.4\', 51995)', 'login', '{\'User\':\'kaia\',\'Password\':\'123\'}', 'Successful', 'kaia', 'SERVER');
INSERT INTO `log` VALUES (00000000000000000000000000000203, '2020-05-31 21:17:30', '(\'192.168.1.4\', 57441)', 'login', '{\'User\':\'wjy\',\'Password\':\'123\'}', 'Successful', 'wjy', 'SERVER');
INSERT INTO `log` VALUES (00000000000000000000000000000204, '2020-05-31 21:17:47', '(\'192.168.1.4\', 43548)', 'SMTP auth', '{\'User\':\'wjy\',\'Password\':\'123\'}', 'Successful', 'wjy', 'SMTP');
INSERT INTO `log` VALUES (00000000000000000000000000000205, '2020-05-31 21:17:47', '(\'192.168.1.4\', 43548)', 'start deliver', '{\'from\':\'wjy@123.com\',\'to\':\'kaia@123.com wjy@123.com\',\'subject\':\'filter for copy\'}', 'Mail Delivering...', 'wjy', 'SMTP');
INSERT INTO `log` VALUES (00000000000000000000000000000206, '2020-05-31 21:17:47', '(\'192.168.1.4\', 54339)', 'intercept mail', '{\'from\':\'wjy@123.com\',\'to\':\'kaia@123.com\',\'subject\':\'filter for copy\'}', 'Successful', 'kaia', 'SMTP');
INSERT INTO `log` VALUES (00000000000000000000000000000207, '2020-05-31 21:17:47', '(\'192.168.1.4\', 43548)', 'deliver mail', '{\'from\':\'wjy@123.com\',\'to\':\'kaia@123.com wjy@123.com\',\'subject\':\'filter for copy\'}', 'Successful', 'wjy', 'SMTP');
INSERT INTO `log` VALUES (00000000000000000000000000000208, '2020-05-31 21:18:08', '(\'192.168.1.4\', 30187)', 'POP3 auth', '{\'User\':\'wjy\',\'Password\':\'123\'}', 'Successful', 'wjy', 'POP3');
INSERT INTO `log` VALUES (00000000000000000000000000000209, '2020-05-31 21:20:31', '(\'192.168.1.4\', 53629)', 'login', '{\'User\':\'kaia\',\'Password\':\'123\'}', 'Successful', 'kaia', 'SERVER');
INSERT INTO `log` VALUES (00000000000000000000000000000210, '2020-05-31 21:20:32', '(\'192.168.1.4\', 38331)', 'POP3 auth', '{\'User\':\'kaia\',\'Password\':\'123\'}', 'Successful', 'kaia', 'POP3');
INSERT INTO `log` VALUES (00000000000000000000000000000211, '2020-05-31 21:20:35', '(\'192.168.1.4\', 31128)', 'POP3 auth', '{\'User\':\'kaia\',\'Password\':\'123\'}', 'Successful', 'kaia', 'POP3');
INSERT INTO `log` VALUES (00000000000000000000000000000212, '2020-05-31 21:20:35', '(\'192.168.1.4\', 31128)', 'check mail', '{\'from\':\'wjy@123.com\',\'to\':\'kaia@123.com\',\'subject\':\'过滤\',\'body\':\'12312312\n\'}', 'Successful', 'kaia', 'POP3');
INSERT INTO `log` VALUES (00000000000000000000000000000213, '2020-05-31 21:20:36', '(\'192.168.1.4\', 33127)', 'POP3 auth', '{\'User\':\'kaia\',\'Password\':\'123\'}', 'Successful', 'kaia', 'POP3');
INSERT INTO `log` VALUES (00000000000000000000000000000214, '2020-05-31 21:20:38', '(\'192.168.1.4\', 31890)', 'POP3 auth', '{\'User\':\'kaia\',\'Password\':\'123\'}', 'Successful', 'kaia', 'POP3');
INSERT INTO `log` VALUES (00000000000000000000000000000215, '2020-05-31 21:20:38', '(\'192.168.1.4\', 31890)', 'check mail', '{\'from\':\'wjy@123.com\',\'to\':\'kaia@123.com\',\'subject\':\'第一次发\',\'body\':\'测试数据库\n\'}', 'Successful', 'kaia', 'POP3');
INSERT INTO `log` VALUES (00000000000000000000000000000216, '2020-05-31 21:20:39', '(\'192.168.1.4\', 35713)', 'POP3 auth', '{\'User\':\'kaia\',\'Password\':\'123\'}', 'Successful', 'kaia', 'POP3');
INSERT INTO `log` VALUES (00000000000000000000000000000217, '2020-05-31 21:21:16', '(\'192.168.1.4\', 50535)', 'register', '{\'User\':\'hhh\',\'Password\':\'123\'}', 'Successful', 'hhh', 'SERVER');
INSERT INTO `log` VALUES (00000000000000000000000000000218, '2020-05-31 21:21:16', '(\'192.168.1.4\', 55862)', 'login', '{\'User\':\'hhh\',\'Password\':\'123\'}', 'Successful', 'hhh', 'SERVER');
COMMIT;

-- ----------------------------
-- Table structure for mail_user
-- ----------------------------
DROP TABLE IF EXISTS `mail_user`;
CREATE TABLE `mail_user` (
  `mail_name` varchar(32) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `mail_addr` varchar(32) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL,
  `mail_pwd` varchar(32) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL,
  `port` int DEFAULT NULL,
  `is_admin` char(1) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL,
  `smtp_state` char(1) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT '1',
  `pop_state` char(1) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT '1',
  `mod_power` char(1) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT '1',
  PRIMARY KEY (`mail_name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of mail_user
-- ----------------------------
BEGIN;
INSERT INTO `mail_user` VALUES ('cindy', 'cindy@123.com', '123', 53730, '0', '1', '1', '1');
INSERT INTO `mail_user` VALUES ('hhh', 'hhh@123.com', '123', 50535, '0', '1', '1', '1');
INSERT INTO `mail_user` VALUES ('kaia', 'kaia@123.com', '123', 57761, '0', '1', '1', '0');
INSERT INTO `mail_user` VALUES ('register', 'register@123.com', '123', 56264, '1', '1', '1', '1');
INSERT INTO `mail_user` VALUES ('wjy', 'wjy@123.com', '123', 54232, '1', '1', '1', '1');
COMMIT;

SET FOREIGN_KEY_CHECKS = 1;
