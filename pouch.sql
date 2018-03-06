/*
Navicat MySQL Data Transfer

Source Server         : Localhost
Source Server Version : 100119
Source Host           : localhost:3306
Source Database       : pouch

Target Server Type    : MYSQL
Target Server Version : 100119
File Encoding         : 65001

Date: 2018-01-25 13:23:17
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for accesstoken
-- ----------------------------
DROP TABLE IF EXISTS `accesstoken`;
CREATE TABLE `accesstoken` (
  `id` varchar(255) NOT NULL,
  `ttl` int(11) DEFAULT NULL,
  `scopes` text,
  `created` datetime DEFAULT NULL,
  `userId` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id` (`id`,`userId`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of accesstoken
-- ----------------------------
INSERT INTO `accesstoken` VALUES ('IGkvUFQ6lszugmJOhAt6Pb0oJoSw8SL2k9ZHTsg55VqRNoB4dpGaAodhKwQz0VMv', '1209600', null, '2017-10-30 13:49:12', '15');
INSERT INTO `accesstoken` VALUES ('OIUbPKGjrUg8vK0Nb8eyD3uOvjCJuN21PCganBJNbAFpVYwWdyyFAP2BxwSGre5G', '1209600', null, '2017-10-30 11:09:29', '16');
INSERT INTO `accesstoken` VALUES ('U0Q8iUxs4EhaZBtbZ3BAriPbWf1snx6MiQyQR4CYL1WBoc0xX34zHUDXn6G2Z9pd', '1209600', null, '2017-10-30 14:00:07', '16');
INSERT INTO `accesstoken` VALUES ('U3B8f2Ow2DtspNSrxQySDocmsi6h9e3M5WbLyt4TixHUtz4Lu71EV8zCgwYneeqR', '1209600', null, '2017-10-30 14:02:35', '16');
INSERT INTO `accesstoken` VALUES ('N9Ch9R6MCSdkvGrLArGsq3Vsrp4nuG1Nx3tKIeu2w8TrpTLt9tjkcBSZx9av8P0O', '1209600', null, '2017-10-30 17:15:36', '15');
INSERT INTO `accesstoken` VALUES ('PbojUCGd75n2ON5RDxc01lAZm3QzbrjSJe3tt94CcbU9dMz61AOlZy21AV5xPGBG', '1209600', null, '2017-11-02 07:49:52', '1');
INSERT INTO `accesstoken` VALUES ('af5UkKDd3XbEEF0mWp7wCdwBLFY35RpZSQeug6OFDUIIQOy4zdmpD6T3dClq65up', '1209600', null, '2017-11-02 09:10:23', '1');
INSERT INTO `accesstoken` VALUES ('Fk3zVMZIY11YxWhfVoD2OtPUiQMdXlb47fqQwG4kXZA2t69ZrzUf1lSxTYKQJIMo', '1209600', null, '2017-11-02 09:15:07', '1');
INSERT INTO `accesstoken` VALUES ('29jDTrvKc4JxMgiKGCkXqVmGrFDgU6pLEqtXXCOQba6biyqhnDW7OBp2MtZK5pDN', '1209600', null, '2017-11-02 09:16:32', '1');
INSERT INTO `accesstoken` VALUES ('glvS2vWZqPxQvwaGHRLiWq1YigjbmUXoVTskcmU5DSDYwARYDA9J0GF8LCIAnnPE', '1209600', null, '2017-11-02 09:43:23', '1');
INSERT INTO `accesstoken` VALUES ('6XG8SF6yjqgcnB6Pk1iWR48qJa6qlTSAsvgOxPmpHPlNWGpwvxJvpDGmDWFgAun6', '1209600', null, '2017-11-02 10:23:18', '1');
INSERT INTO `accesstoken` VALUES ('6JQr0jk6iVc2G5xmlbaIfNQa70cgKT5ioD5IYs3llayODuPDYkvx6XTfJ6rXqL7m', '1209600', null, '2017-11-02 10:29:16', '1');
INSERT INTO `accesstoken` VALUES ('Qsz8zYSX9WUIyl0LIQmUJCKMUTkK9HTCLKBvmYtMDfzCCfOkN8urw4gDfHbo66Hi', '1209600', null, '2017-11-02 10:30:56', '1');
INSERT INTO `accesstoken` VALUES ('2Rp7gRVHWZ6EhYLwJ0WkB2FHUfPyvvigmRzPYMczFEQpeei1z2NJ70EwDVyWrgpU', '1209600', null, '2017-11-02 14:00:10', '1');
INSERT INTO `accesstoken` VALUES ('aZ1WQTVXyOQ5HTINvPiqEYgTWTOoEpjuhsP1xHuMFJ5fL5RxrQRiXflSFfxzuUFc', '1209600', null, '2017-11-02 14:03:11', '1');
INSERT INTO `accesstoken` VALUES ('lBf5N0nlS7cDRVyYfQuK1rhuI3iuhV0CWzdguQAUwc8BOlJD9ZnsaEoIZJSGdnrx', '1209600', null, '2017-11-02 14:24:56', '15');

-- ----------------------------
-- Table structure for acl
-- ----------------------------
DROP TABLE IF EXISTS `acl`;
CREATE TABLE `acl` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `model` varchar(512) DEFAULT NULL,
  `property` varchar(512) DEFAULT NULL,
  `accessType` varchar(512) DEFAULT NULL,
  `permission` varchar(512) DEFAULT NULL,
  `principalType` varchar(512) DEFAULT NULL,
  `principalId` varchar(512) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of acl
-- ----------------------------

-- ----------------------------
-- Table structure for permission_map
-- ----------------------------
DROP TABLE IF EXISTS `permission_map`;
CREATE TABLE `permission_map` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `permission_id` varchar(11) DEFAULT NULL,
  `permission_name` varchar(50) DEFAULT NULL,
  `permission_icon` varchar(100) DEFAULT NULL,
  `permission_ket` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of permission_map
-- ----------------------------
INSERT INTO `permission_map` VALUES ('1', 'viewer001', 'View', 'remove_red_eye', 'View transaction details, download report, check billing details and status');
INSERT INTO `permission_map` VALUES ('2', 'editor001', 'Edit', 'mode_edit', 'Upload and delete batch disbursement, validate name mismatch on batch disbursement, generate invoice');
INSERT INTO `permission_map` VALUES ('3', 'approver001', 'Approve', 'beenhere', 'Approve batch disbursements');
INSERT INTO `permission_map` VALUES ('4', 'admin001', 'Admin', 'perm_identity', 'Add and delete user, edit user access, add,edit, and delete withdrawal bank account, change business settings');

-- ----------------------------
-- Table structure for pouch_bankcode
-- ----------------------------
DROP TABLE IF EXISTS `pouch_bankcode`;
CREATE TABLE `pouch_bankcode` (
  `bank_code` varchar(10) NOT NULL,
  `bank_name` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`bank_code`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of pouch_bankcode
-- ----------------------------
INSERT INTO `pouch_bankcode` VALUES ('BCA', 'BCA');
INSERT INTO `pouch_bankcode` VALUES ('BJB', 'BJB');
INSERT INTO `pouch_bankcode` VALUES ('BNI', 'BNI');
INSERT INTO `pouch_bankcode` VALUES ('BRI', 'BRI');
INSERT INTO `pouch_bankcode` VALUES ('CIMB', 'CIMB NIAGA');
INSERT INTO `pouch_bankcode` VALUES ('mandi', 'Mandiri');

-- ----------------------------
-- Table structure for pouch_mastercompanyaccount
-- ----------------------------
DROP TABLE IF EXISTS `pouch_mastercompanyaccount`;
CREATE TABLE `pouch_mastercompanyaccount` (
  `company_id` varchar(100) NOT NULL,
  `company_account_number` int(20) NOT NULL,
  `company_account_name` varchar(100) DEFAULT NULL,
  `company_balance` float NOT NULL,
  `company_pin` varchar(225) NOT NULL,
  UNIQUE KEY `get_data_account` (`company_id`,`company_account_number`,`company_pin`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of pouch_mastercompanyaccount
-- ----------------------------
INSERT INTO `pouch_mastercompanyaccount` VALUES ('010318CMP010001', '0', 'VMD Indonesia', '0', '4pzSzTkrzXT5wTcExj2WYw==');

-- ----------------------------
-- Table structure for pouch_mastercompanybalancetransaction
-- ----------------------------
DROP TABLE IF EXISTS `pouch_mastercompanybalancetransaction`;
CREATE TABLE `pouch_mastercompanybalancetransaction` (
  `balance_id` varchar(100) NOT NULL,
  `company_id` varchar(100) NOT NULL,
  `company_account_number` int(20) DEFAULT NULL,
  `company_balance` float NOT NULL,
  `balance_date` datetime NOT NULL,
  `balance_type` enum('income','outcome') DEFAULT NULL,
  `note` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`balance_id`),
  UNIQUE KEY `balance_id` (`balance_id`,`company_id`,`balance_date`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of pouch_mastercompanybalancetransaction
-- ----------------------------

-- ----------------------------
-- Table structure for pouch_mastercompanydata
-- ----------------------------
DROP TABLE IF EXISTS `pouch_mastercompanydata`;
CREATE TABLE `pouch_mastercompanydata` (
  `company_id` varchar(50) NOT NULL,
  `company_name` varchar(225) NOT NULL,
  `company_address` varchar(225) NOT NULL,
  `company_logo` varchar(225) NOT NULL,
  `company_email` varchar(50) NOT NULL,
  `userID` varchar(100) NOT NULL,
  UNIQUE KEY `id` (`company_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of pouch_mastercompanydata
-- ----------------------------
INSERT INTO `pouch_mastercompanydata` VALUES ('010318CMP010001', 'VMD Indonesia', '', 'http://localhost/pouch/appsources/logo/company/8661515373000.jpg', 'vmdindonesia@gmail.com', '010318MPC0001');

-- ----------------------------
-- Table structure for pouch_masteremployeecredential
-- ----------------------------
DROP TABLE IF EXISTS `pouch_masteremployeecredential`;
CREATE TABLE `pouch_masteremployeecredential` (
  `userID` varchar(120) NOT NULL,
  `fullName` varchar(225) NOT NULL,
  `password` varchar(255) NOT NULL,
  `email` varchar(150) NOT NULL,
  `emailVerified` tinyint(1) NOT NULL,
  `phoneNumber` varchar(14) NOT NULL,
  `company_id` varchar(50) DEFAULT NULL,
  `status` enum('active','deactive') DEFAULT NULL,
  PRIMARY KEY (`userID`,`email`)
) ENGINE=MyISAM AUTO_INCREMENT=18 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of pouch_masteremployeecredential
-- ----------------------------
INSERT INTO `pouch_masteremployeecredential` VALUES ('010318MPC0001', 'Fashah Darullah', 'cOQs6P7SvR2cz2pD/J/FYA==', 'fashahd@gmail.com', '0', '081212847577', '010318CMP010001', 'active');
INSERT INTO `pouch_masteremployeecredential` VALUES ('010818MPC0001', 'Rendy Sutandy', 'SCxe0uvq5HxSiJ3XzMnd0g==', 'rendy@gmail.com', '0', '', '010318CMP010001', 'deactive');
INSERT INTO `pouch_masteremployeecredential` VALUES ('010918MPC0001', 'Dhimas Priaji', 'cOQs6P7SvR2cz2pD/J/FYA==', 'dhimas@gmail.com', '0', '', '010318CMP010001', 'active');

-- ----------------------------
-- Table structure for pouch_mastertransaction
-- ----------------------------
DROP TABLE IF EXISTS `pouch_mastertransaction`;
CREATE TABLE `pouch_mastertransaction` (
  `transaction_id` varchar(100) NOT NULL,
  `reference` varchar(100) DEFAULT NULL,
  `company_id` varchar(100) DEFAULT NULL,
  `status` enum('pending','success','failed','approved','active') DEFAULT NULL,
  `created_dttm` datetime DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  `created_user_id` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`transaction_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of pouch_mastertransaction
-- ----------------------------
INSERT INTO `pouch_mastertransaction` VALUES ('011718TRDSB010318CMP0100010001', '2123123123', '010318CMP010001', 'active', '2018-01-17 13:07:58', '010318MPC0001');

-- ----------------------------
-- Table structure for pouch_mastertransactiondetail
-- ----------------------------
DROP TABLE IF EXISTS `pouch_mastertransactiondetail`;
CREATE TABLE `pouch_mastertransactiondetail` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `transaction_id` varchar(100) DEFAULT NULL,
  `company_id` varchar(100) DEFAULT NULL,
  `company_account` varchar(100) DEFAULT NULL,
  `amount` float DEFAULT NULL,
  `bank_code` varchar(100) DEFAULT NULL,
  `account_number` varchar(100) DEFAULT NULL,
  `account_holder_name` varchar(100) DEFAULT NULL,
  `transaction_date` datetime DEFAULT NULL,
  `payment_type` enum('TOPUP','KREDIT','DISBURSE') DEFAULT NULL,
  `status` enum('pending','success','failed','approved','active') DEFAULT NULL,
  `note` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=120634 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of pouch_mastertransactiondetail
-- ----------------------------
INSERT INTO `pouch_mastertransactiondetail` VALUES ('120628', '011718TRDSB010318CMP0100010001', '010318CMP010001', '', '200000', 'BCA', 'HuvR1Mk0t0ZpNTss8E/hfw==', 'Test', '2018-01-17 13:07:59', 'DISBURSE', 'active', null);
INSERT INTO `pouch_mastertransactiondetail` VALUES ('120629', '011718TRDSB010318CMP0100010001', '010318CMP010001', '', '200000', 'BCA', 'EwdzvZvJK8GKJX3Q84zSzw==', 'Test', '2018-01-17 13:07:59', 'DISBURSE', 'active', null);
INSERT INTO `pouch_mastertransactiondetail` VALUES ('120630', '011718TRDSB010318CMP0100010001', '010318CMP010001', '', '200000', 'MANDIRI', 'WFclbQBnTKyAfLM6ScWrwg==', 'Test', '2018-01-17 13:07:59', 'DISBURSE', 'active', null);
INSERT INTO `pouch_mastertransactiondetail` VALUES ('120631', '011718TRDSB010318CMP0100010001', '010318CMP010001', '', '200000', 'MANDIRI', '42RPGXI8DEvcz7bZsnlc9w==', 'Test', '2018-01-17 13:07:59', 'DISBURSE', 'active', null);
INSERT INTO `pouch_mastertransactiondetail` VALUES ('120632', '011718TRDSB010318CMP0100010001', '010318CMP010001', '', '200000', 'BCA', '5srR+2flMOH1RQSzV2h3yA==', 'Test', '2018-01-17 13:07:59', 'DISBURSE', 'active', null);
INSERT INTO `pouch_mastertransactiondetail` VALUES ('120633', '011718TRDSB010318CMP0100010001', '010318CMP010001', '', '200000', 'MANDIRI', 'o4daQzBby3lG19aEq3kfGw==', 'Test', '2018-01-17 13:07:59', 'DISBURSE', 'active', null);

-- ----------------------------
-- Table structure for pouch_roleuser
-- ----------------------------
DROP TABLE IF EXISTS `pouch_roleuser`;
CREATE TABLE `pouch_roleuser` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `userID` varchar(120) DEFAULT NULL,
  `permission_id` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=48 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of pouch_roleuser
-- ----------------------------
INSERT INTO `pouch_roleuser` VALUES ('29', '010318MPC0001', 'viewer001');
INSERT INTO `pouch_roleuser` VALUES ('30', '010318MPC0001', 'editor001');
INSERT INTO `pouch_roleuser` VALUES ('31', '010318MPC0001', 'approver001');
INSERT INTO `pouch_roleuser` VALUES ('32', '010318MPC0001', 'admin001');
INSERT INTO `pouch_roleuser` VALUES ('33', '010818MPC0001', 'approver001');
INSERT INTO `pouch_roleuser` VALUES ('46', '010918MPC0001', 'editor001');
INSERT INTO `pouch_roleuser` VALUES ('47', '010918MPC0001', 'admin001');

-- ----------------------------
-- Table structure for pouch_useradmincredential
-- ----------------------------
DROP TABLE IF EXISTS `pouch_useradmincredential`;
CREATE TABLE `pouch_useradmincredential` (
  `username` varchar(255) NOT NULL,
  `full_name` varchar(255) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `role` varchar(255) DEFAULT NULL,
  `status` enum('active','disabled') DEFAULT NULL,
  PRIMARY KEY (`username`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of pouch_useradmincredential
-- ----------------------------
INSERT INTO `pouch_useradmincredential` VALUES ('superadmin', 'Admin Pouch', 'bcbKEltc0OGtmGqjcS0bag==', null, 'active');

-- ----------------------------
-- Table structure for role
-- ----------------------------
DROP TABLE IF EXISTS `role`;
CREATE TABLE `role` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(512) NOT NULL,
  `description` varchar(512) DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of role
-- ----------------------------

-- ----------------------------
-- Table structure for rolemapping
-- ----------------------------
DROP TABLE IF EXISTS `rolemapping`;
CREATE TABLE `rolemapping` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `principalType` varchar(512) DEFAULT NULL,
  `principalId` varchar(255) DEFAULT NULL,
  `roleId` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `principalId` (`principalId`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of rolemapping
-- ----------------------------

-- ----------------------------
-- Table structure for user
-- ----------------------------
DROP TABLE IF EXISTS `user`;
CREATE TABLE `user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `realm` varchar(512) DEFAULT NULL,
  `username` varchar(512) DEFAULT NULL,
  `password` varchar(512) NOT NULL,
  `email` varchar(512) NOT NULL,
  `emailVerified` tinyint(1) DEFAULT NULL,
  `verificationToken` varchar(512) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of user
-- ----------------------------
