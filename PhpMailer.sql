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

 Date: 30/05/2020 01:46:01
*/

SET NAMES utf8;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
-- Table structure for ac_filter
-- ----------------------------
DROP TABLE IF EXISTS `ac_filter`;
CREATE TABLE `ac_filter` (
  `mail_name` varchar(32) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `cont` varchar(32) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  PRIMARY KEY (`mail_name`,`cont`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

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
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- ----------------------------
-- Records of email
-- ----------------------------
BEGIN;
INSERT INTO `email` VALUES (00000000000000000000000000000001, 'wjy@123.com', 'kaia@123.com', '第一次发', '测试数据库\n', '2020-05-29 23:16:48', 15, '0');
INSERT INTO `email` VALUES (00000000000000000000000000000002, 'wjy@123.com', 'wjy@123.com', '第一次发', '测试数据库\n', '2020-05-29 23:16:48', 15, '1');
INSERT INTO `email` VALUES (00000000000000000000000000000003, 'cindy@123.com', 'wjy@123.com', '群发', '测试数据库\n', '2020-05-29 23:21:45', 15, '1');
INSERT INTO `email` VALUES (00000000000000000000000000000004, 'cindy@123.com', 'kaia@123.com', '群发', '测试数据库\n', '2020-05-29 23:21:45', 15, '0');
INSERT INTO `email` VALUES (00000000000000000000000000000005, 'cindy@123.com', 'cindy@123.com', '群发', '测试数据库\n', '2020-05-29 23:21:45', 15, '0');
INSERT INTO `email` VALUES (00000000000000000000000000000007, 'wjy@123.com', 'cindy@123.com', '123', '132\n', '2020-05-29 23:28:21', 3, '0');
INSERT INTO `email` VALUES (00000000000000000000000000000009, 'wjy@123.com', 'kaia@123.com', '123', '123\n', '2020-05-30 01:38:36', 3, '0');
COMMIT;

-- ----------------------------
-- Table structure for ip_filter
-- ----------------------------
DROP TABLE IF EXISTS `ip_filter`;
CREATE TABLE `ip_filter` (
  `mail_name` varchar(32) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `cont` varchar(32) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  PRIMARY KEY (`mail_name`,`cont`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

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
) ENGINE=InnoDB AUTO_INCREMENT=84 DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- ----------------------------
-- Records of log
-- ----------------------------
BEGIN;
INSERT INTO `log` VALUES (00000000000000000000000000000001, '2020-05-29 23:15:52', '(\'192.168.1.4\', 58471)', 'login', '{\'User\':\'wjy\',\'Password\':\'123\'}', 'Successful', 'wjy', 'SERVER');
INSERT INTO `log` VALUES (00000000000000000000000000000002, '2020-05-29 23:15:57', '(\'192.168.1.4\', 56640)', 'login', '{\'User\':\'kaia\',\'Password\':\'123\'}', 'Failed : password error', 'kaia', 'SERVER');
INSERT INTO `log` VALUES (00000000000000000000000000000003, '2020-05-29 23:16:05', '(\'192.168.1.4\', 57761)', 'register', '{\'User\':\'kaia\',\'Password\':\'123\'}', 'Successful', 'kaia', 'SERVER');
INSERT INTO `log` VALUES (00000000000000000000000000000004, '2020-05-29 23:16:05', '(\'192.168.1.4\', 50532)', 'login', '{\'User\':\'kaia\',\'Password\':\'123\'}', 'Successful', 'kaia', 'SERVER');
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- ----------------------------
-- Records of mail_user
-- ----------------------------
BEGIN;
INSERT INTO `mail_user` VALUES ('cindy', 'cindy@123.com', '123', 53730, '0', '1', '1', '1');
INSERT INTO `mail_user` VALUES ('kaia', 'kaia@123.com', '123', 57761, '0', '1', '1', '0');
INSERT INTO `mail_user` VALUES ('register', 'register@123.com', '123', 56263, '1', '1', '1', '1');
INSERT INTO `mail_user` VALUES ('wjy', 'wjy@123.com', '123', 5432, '1', '1', '1', '1');
COMMIT;

SET FOREIGN_KEY_CHECKS = 1;
