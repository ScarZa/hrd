/*
Navicat MySQL Data Transfer

Source Server         : ScarZ
Source Server Version : 50626
Source Host           : localhost:3306
Source Database       : hrd

Target Server Type    : MYSQL
Target Server Version : 50626
File Encoding         : 65001

Date: 2016-04-22 16:05:18
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for `se_company`
-- ----------------------------
DROP TABLE IF EXISTS `se_company`;
CREATE TABLE `se_company` (
  `comp_id` int(7) NOT NULL AUTO_INCREMENT,
  `comp_name` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `comp_vax` varchar(13) COLLATE utf8_unicode_ci DEFAULT NULL,
  `comp_address` varchar(150) COLLATE utf8_unicode_ci NOT NULL,
  `comp_tell` int(10) DEFAULT NULL,
  `comp_mobile` int(10) DEFAULT NULL,
  `comp_fax` int(10) DEFAULT NULL,
  PRIMARY KEY (`comp_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Records of se_company
-- ----------------------------

-- ----------------------------
-- Table structure for `se_list_order`
-- ----------------------------
DROP TABLE IF EXISTS `se_list_order`;
CREATE TABLE `se_list_order` (
  `lo_id` int(7) NOT NULL AUTO_INCREMENT,
  `order_id` int(7) NOT NULL,
  `mate_id` int(7) NOT NULL,
  `price` decimal(9,2) NOT NULL,
  `amount` int(7) NOT NULL,
  `total` int(7) NOT NULL,
  PRIMARY KEY (`lo_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Records of se_list_order
-- ----------------------------

-- ----------------------------
-- Table structure for `se_material`
-- ----------------------------
DROP TABLE IF EXISTS `se_material`;
CREATE TABLE `se_material` (
  `mate_id` int(7) NOT NULL AUTO_INCREMENT,
  `mate_name` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `mate_unit` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `mate_type_id` int(7) NOT NULL,
  `receive` int(7) NOT NULL,
  `pay` int(7) NOT NULL,
  `min` int(2) NOT NULL,
  `max` int(4) NOT NULL,
  PRIMARY KEY (`mate_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Records of se_material
-- ----------------------------

-- ----------------------------
-- Table structure for `se_material_type`
-- ----------------------------
DROP TABLE IF EXISTS `se_material_type`;
CREATE TABLE `se_material_type` (
  `mate_type_id` int(2) NOT NULL AUTO_INCREMENT,
  `type_name` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`mate_type_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Records of se_material_type
-- ----------------------------

-- ----------------------------
-- Table structure for `se_money_type`
-- ----------------------------
DROP TABLE IF EXISTS `se_money_type`;
CREATE TABLE `se_money_type` (
  `mon_id` int(2) NOT NULL AUTO_INCREMENT,
  `mon_name` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`mon_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Records of se_money_type
-- ----------------------------

-- ----------------------------
-- Table structure for `se_order`
-- ----------------------------
DROP TABLE IF EXISTS `se_order`;
CREATE TABLE `se_order` (
  `order_id` int(7) NOT NULL AUTO_INCREMENT,
  `comp_id` int(7) NOT NULL,
  `order_date` date NOT NULL,
  `order_method` int(2) NOT NULL,
  `order_amount` decimal(9,2) NOT NULL,
  `empno` int(7) NOT NULL,
  `total_amount` int(3) NOT NULL COMMENT 'จำนวนรายการที่รับมา',
  PRIMARY KEY (`order_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Records of se_order
-- ----------------------------

-- ----------------------------
-- Table structure for `se_pay`
-- ----------------------------
DROP TABLE IF EXISTS `se_pay`;
CREATE TABLE `se_pay` (
  `pay_id` int(7) NOT NULL AUTO_INCREMENT,
  `pay_date` date NOT NULL,
  `po_id` int(7) NOT NULL,
  `wd_id` int(7) NOT NULL,
  `mate_id` int(7) NOT NULL,
  `amount` int(7) NOT NULL,
  `total` int(7) NOT NULL,
  `remain` int(2) DEFAULT NULL,
  `empno` int(7) NOT NULL,
  PRIMARY KEY (`pay_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Records of se_pay
-- ----------------------------

-- ----------------------------
-- Table structure for `se_pay_order`
-- ----------------------------
DROP TABLE IF EXISTS `se_pay_order`;
CREATE TABLE `se_pay_order` (
  `po_id` int(7) NOT NULL AUTO_INCREMENT,
  `or_date` date NOT NULL,
  `empno` int(7) NOT NULL,
  `dep_id` int(2) NOT NULL,
  `or_no` varchar(20) COLLATE utf8_unicode_ci DEFAULT NULL,
  `or_status` varchar(1) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`po_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Records of se_pay_order
-- ----------------------------

-- ----------------------------
-- Table structure for `se_withdrawal`
-- ----------------------------
DROP TABLE IF EXISTS `se_withdrawal`;
CREATE TABLE `se_withdrawal` (
  `wd_id` int(7) NOT NULL AUTO_INCREMENT,
  `po_id` int(7) NOT NULL,
  `mate_id` int(7) NOT NULL,
  `amount` int(7) NOT NULL,
  PRIMARY KEY (`wd_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Records of se_withdrawal
-- ----------------------------
