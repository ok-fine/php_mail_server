/*
 Navicat Premium Data Transfer

 Source Server         : local
 Source Server Type    : MySQL
 Source Server Version : 80017
 Source Host           : localhost:3306
 Source Schema         : PhpMailer

 Target Server Type    : MySQL
 Target Server Version : 80017
 File Encoding         : 65001

 Date: 26/04/2020 14:11:49
*/

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
-- Table structure for admin_info
-- ----------------------------
DROP TABLE IF EXISTS `admin_info`;
CREATE TABLE `admin_info` (
  `admin_id` int(32) unsigned zerofill NOT NULL AUTO_INCREMENT,
  `admin_name` varchar(32) NOT NULL,
  `password` varchar(32) NOT NULL,
  `mail_address` varchar(32) NOT NULL,
  `mail_pwd` varchar(32) NOT NULL,
  `mail_type` enum('qq.com','126.com') CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  PRIMARY KEY (`admin_id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of admin_info
-- ----------------------------
BEGIN;
INSERT INTO `admin_info` VALUES (00000000000000000000000000000006, 'wjy', '123', '1109953925@qq.com', 'olzfxmyendvighhc', 'qq.com');
INSERT INTO `admin_info` VALUES (00000000000000000000000000000007, 'kaia', '123', 'kaiawei@126.com', 'LNOUSIDCTNTPEZUK', '126.com');
COMMIT;

-- ----------------------------
-- Table structure for email
-- ----------------------------
DROP TABLE IF EXISTS `email`;
CREATE TABLE `email` (
  `email_id` int(32) unsigned zerofill NOT NULL AUTO_INCREMENT,
  `mail_from` varchar(32) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `mail_to` varchar(32) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `subject` varchar(64) NOT NULL,
  `body` varchar(256) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `time` datetime NOT NULL,
  `size` int(16) NOT NULL,
  `is_read` char(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`email_id`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- ----------------------------
-- Records of email
-- ----------------------------
BEGIN;
INSERT INTO `email` VALUES (00000000000000000000000000000005, 'wjy@123.com', 'kaia@123.com', 'hava a try!', '\n', '2020-04-26 01:11:23', 32, '0');
INSERT INTO `email` VALUES (00000000000000000000000000000007, 'wjy@123.com', 'kaia@123.com', 'hava a try!', 'hahaha lalala  aaa!\n', '2020-04-26 01:21:04', 19, '0');
INSERT INTO `email` VALUES (00000000000000000000000000000008, 'wjy@123.com', 'kaia@123.com', 'hava a try!', '试一下time wait!\n', '2020-04-26 09:12:38', 19, '0');
INSERT INTO `email` VALUES (00000000000000000000000000000009, 'wjy@123.com', 'kaia@123.com', '123', '123\n', '2020-04-26 13:59:11', 3, '0');
INSERT INTO `email` VALUES (00000000000000000000000000000011, 'kaia@123.com', 'wjy@123.com', 'try my send page!', 'hahaha lalala aaa!!!!\n', '2020-04-26 14:01:32', 21, '0');
INSERT INTO `email` VALUES (00000000000000000000000000000012, 'wjy@123.com', 'kaia@123.com', 'try my  群发', 'lalala so excited!\n', '2020-04-26 14:08:46', 18, '0');
INSERT INTO `email` VALUES (00000000000000000000000000000013, 'wjy@123.com', 'wjy@123.com', 'try my  群发', 'lalala so excited!\n', '2020-04-26 14:08:46', 18, '0');
COMMIT;

-- ----------------------------
-- Table structure for log
-- ----------------------------
DROP TABLE IF EXISTS `log`;
CREATE TABLE `log` (
  `log_id` int(32) unsigned zerofill NOT NULL AUTO_INCREMENT,
  `time` varchar(32) DEFAULT NULL,
  `ip` varchar(32) DEFAULT NULL,
  `op` varchar(32) DEFAULT NULL,
  `data` varchar(512) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `state` varchar(32) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  PRIMARY KEY (`log_id`)
) ENGINE=InnoDB AUTO_INCREMENT=152 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- ----------------------------
-- Records of log
-- ----------------------------
BEGIN;
INSERT INTO `log` VALUES (00000000000000000000000000000120, '2020-04-26 11:35:43', '(\'192.168.1.9\', 53945)', 'login', '{\'User\':\'wjy\',\'Password\':\'123\'}', 'Successful');
INSERT INTO `log` VALUES (00000000000000000000000000000121, '2020-04-26 11:43:44', '(\'192.168.1.9\', 50320)', 'register', '{\'User\':\'kaia\',\'Password\':\'23\'}', 'Failed : user already exist');
INSERT INTO `log` VALUES (00000000000000000000000000000122, '2020-04-26 11:44:36', '(\'192.168.1.9\', 51560)', 'register', '{\'User\':\'kaia\',\'Password\':\'asd\'}', 'Failed : user already exist');
INSERT INTO `log` VALUES (00000000000000000000000000000123, '2020-04-26 11:44:46', '(\'192.168.1.9\', 54469)', 'register', '{\'User\':\'wjy\',\'Password\':\'asd\'}', 'Failed : user already exist');
INSERT INTO `log` VALUES (00000000000000000000000000000124, '2020-04-26 12:26:54', '(\'192.168.1.9\', 51880)', 'login', '{\'User\':\'kaia\',\'Password\':\'123\'}', 'Successful');
INSERT INTO `log` VALUES (00000000000000000000000000000125, '2020-04-26 12:27:12', '(\'192.168.1.9\', 53025)', 'login', '{\'User\':\'wjy\',\'Password\':\'123\'}', 'Successful');
INSERT INTO `log` VALUES (00000000000000000000000000000126, '2020-04-26 12:27:54', '(\'192.168.1.9\', 59335)', 'login', '{\'User\':\'wjy\',\'Password\':\'123\'}', 'Successful');
INSERT INTO `log` VALUES (00000000000000000000000000000127, '2020-04-26 12:30:44', '(\'192.168.1.9\', 54610)', 'login', '{\'User\':\'wjy\',\'Password\':\'123\'}', 'Successful');
INSERT INTO `log` VALUES (00000000000000000000000000000128, '2020-04-26 12:30:58', '(\'192.168.1.9\', 51473)', 'detele user', '{\'Admin:\':\'kaia2\',\'Deleted User\':\'wjy\'}', 'Successful');
INSERT INTO `log` VALUES (00000000000000000000000000000129, '2020-04-26 12:31:31', '(\'192.168.1.9\', 50224)', 'register', '{\'User\':\'kaia2\',\'Password\':\'123\'}', 'Failed : user already exist');
INSERT INTO `log` VALUES (00000000000000000000000000000130, '2020-04-26 12:31:54', '(\'192.168.1.9\', 58880)', 'register', '{\'User\':\'wjy\',\'Password\':\'qwe\'}', 'Successful');
INSERT INTO `log` VALUES (00000000000000000000000000000131, '2020-04-26 12:40:10', '(\'192.168.1.9\', 54429)', 'detele user', '{\'Admin:\':\'wjy\',\'Deleted User\':\'kaia2\'}', 'Successful');
INSERT INTO `log` VALUES (00000000000000000000000000000132, '2020-04-26 12:40:19', '(\'192.168.1.9\', 51466)', 'register', '{\'User\':\'kaia2\',\'Password\':\'123\'}', 'Successful');
INSERT INTO `log` VALUES (00000000000000000000000000000133, '2020-04-26 12:59:14', '(\'192.168.1.9\', 57251)', 'login', '{\'User\':\'wjy\',\'Password\':\'12222\'}', 'Failed : password error');
INSERT INTO `log` VALUES (00000000000000000000000000000134, '2020-04-26 12:59:18', '(\'192.168.1.9\', 59860)', 'login', '{\'User\':\'wjy\',\'Password\':\'123\'}', 'Failed : password error');
INSERT INTO `log` VALUES (00000000000000000000000000000135, '2020-04-26 12:59:42', '(\'192.168.1.9\', 50131)', 'login', '{\'User\':\'wjy\',\'Password\':\'123\'}', 'Successful');
INSERT INTO `log` VALUES (00000000000000000000000000000136, '2020-04-26 12:59:56', '(\'192.168.1.9\', 53517)', 'login', '{\'User\':\'wjy\',\'Password\':\'123\'}', 'Successful');
INSERT INTO `log` VALUES (00000000000000000000000000000137, '2020-04-26 13:08:38', '(\'192.168.1.9\', 55264)', 'login', '{\'User\':\'wjy\',\'Password\':\'123\'}', 'Successful');
INSERT INTO `log` VALUES (00000000000000000000000000000138, '2020-04-26 13:08:55', '(\'192.168.1.9\', 57979)', 'register', '{\'User\':\'kaia2\',\'Password\':\'123\'}', 'Failed : user already exist');
INSERT INTO `log` VALUES (00000000000000000000000000000139, '2020-04-26 13:09:02', '(\'192.168.1.9\', 53185)', 'register', '{\'User\':\'wjy2\',\'Password\':\'123\'}', 'Successful');
INSERT INTO `log` VALUES (00000000000000000000000000000140, '2020-04-26 13:40:35', '(\'192.168.1.9\', 57575)', 'login', '{\'User\':\'kaia\',\'Password\':\'123\'}', 'Successful');
INSERT INTO `log` VALUES (00000000000000000000000000000141, '2020-04-26 13:59:05', '(\'192.168.1.9\', 59689)', 'login', '{\'User\':\'wjy\',\'Password\':\'123\'}', 'Successful');
INSERT INTO `log` VALUES (00000000000000000000000000000142, '2020-04-26 13:59:11', '(\'192.168.1.9\', 43017)', 'deliver mail', '{\'from\':\'wjy@123.com\',\'to\':\'kaia@123.com\',\'subject\':\'123\'}', 'Mail delivering');
INSERT INTO `log` VALUES (00000000000000000000000000000143, '2020-04-26 13:59:11', '(\'192.168.1.9\', 43017)', 'deliver letter', '{\'from\':\'wjy@123.com\',\'to\':\'kaia@123.com\',\'subject\':\'123\'}', 'Deliver success');
INSERT INTO `log` VALUES (00000000000000000000000000000144, '2020-04-26 14:00:37', '(\'192.168.1.9\', 59649)', 'login', '{\'User\':\'wjy\',\'Password\':\'123\'}', 'Successful');
INSERT INTO `log` VALUES (00000000000000000000000000000145, '2020-04-26 14:00:53', '(\'192.168.1.9\', 56494)', 'login', '{\'User\':\'kaia\',\'Password\':\'123\'}', 'Successful');
INSERT INTO `log` VALUES (00000000000000000000000000000146, '2020-04-26 14:01:32', '(\'192.168.1.9\', 43311)', 'deliver mail', '{\'from\':\'kaia@123.com\',\'to\':\'wjy@123.com\',\'subject\':\'try my send page!\'}', 'Mail delivering');
INSERT INTO `log` VALUES (00000000000000000000000000000147, '2020-04-26 14:01:32', '(\'192.168.1.9\', 43311)', 'deliver letter', '{\'from\':\'kaia@123.com\',\'to\':\'wjy@123.com\',\'subject\':\'try my send page!\'}', 'Deliver success');
INSERT INTO `log` VALUES (00000000000000000000000000000148, '2020-04-26 14:04:34', '(\'192.168.1.9\', 52096)', 'login', '{\'User\':\'kaia\',\'Password\':\'123\'}', 'Successful');
INSERT INTO `log` VALUES (00000000000000000000000000000149, '2020-04-26 14:08:46', '(\'192.168.1.9\', 40711)', 'deliver mail', '{\'from\':\'wjy@123.com\',\'to\':\'kaia@123.com wjy@123.com  \',\'subject\':\'try my  u7fa4u53d1\'}', 'Mail delivering');
INSERT INTO `log` VALUES (00000000000000000000000000000150, '2020-04-26 14:08:46', '(\'192.168.1.9\', 40711)', 'deliver letter', '{\'from\':\'wjy@123.com\',\'to\':\'kaia@123.com wjy@123.com  \',\'subject\':\'try my  u7fa4u53d1\'}', 'Deliver success');
INSERT INTO `log` VALUES (00000000000000000000000000000151, '2020-04-26 14:08:46', '(\'192.168.1.9\', 40711)', 'deliver letter', '{\'from\':\'wjy@123.com\',\'to\':\'kaia@123.com wjy@123.com  \',\'subject\':\'try my  u7fa4u53d1\'}', 'Deliver success');
COMMIT;

-- ----------------------------
-- Table structure for mail_user
-- ----------------------------
DROP TABLE IF EXISTS `mail_user`;
CREATE TABLE `mail_user` (
  `mail_name` varchar(32) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `mail_addr` varchar(32) NOT NULL,
  `mail_pwd` varchar(32) NOT NULL,
  `port` varchar(8) NOT NULL,
  `smtp_state` char(1) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL DEFAULT '1',
  `pop_state` char(1) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL DEFAULT '1',
  `is_admin` char(1) NOT NULL DEFAULT '0',
  `mod_power` char(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`mail_addr`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- ----------------------------
-- Records of mail_user
-- ----------------------------
BEGIN;
INSERT INTO `mail_user` VALUES ('kaia', 'kaia@123.com', '123', '59716', '1', '1', '0', '1');
INSERT INTO `mail_user` VALUES ('kaia2', 'kaia2@123.com', '123', '51466', '1', '1', '0', '1');
INSERT INTO `mail_user` VALUES ('register', 'register@123.com', '123', '56263', '1', '1', '1', '1');
INSERT INTO `mail_user` VALUES ('wjy', 'wjy@123.com', '123', '58880', '1', '1', '1', '1');
INSERT INTO `mail_user` VALUES ('wjy2', 'wjy2@123.com', '123', '53185', '1', '1', '0', '1');
COMMIT;

-- ----------------------------
-- Table structure for user_info
-- ----------------------------
DROP TABLE IF EXISTS `user_info`;
CREATE TABLE `user_info` (
  `user_id` int(32) unsigned zerofill NOT NULL AUTO_INCREMENT,
  `user_name` varchar(32) NOT NULL,
  `password` varchar(32) NOT NULL,
  `mail_address` varchar(32) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `mail_pwd` varchar(32) NOT NULL,
  `mail_type` enum('qq.com','126.com') CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `send_power` char(1) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT '1',
  `get_power` char(1) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT '1',
  `mod_power` char(1) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT '1',
  PRIMARY KEY (`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of user_info
-- ----------------------------
BEGIN;
INSERT INTO `user_info` VALUES (00000000000000000000000000000004, 'wjy', '456', '1109953925@qq.com', 'olzfxmyendvighhc', 'qq.com', '1', '1', '0');
INSERT INTO `user_info` VALUES (00000000000000000000000000000005, 'kaia', '456', 'kaiawei@126.com', 'LNOUSIDCTNTPEZUK', '126.com', '0', '1', '1');
INSERT INTO `user_info` VALUES (00000000000000000000000000000006, 'kaia1', '456', 'kaiawei@126.com', 'LNOUSIDCTNTPEZUK', '126.com', '1', '1', '1');
COMMIT;

SET FOREIGN_KEY_CHECKS = 1;
