/*
 Navicat Premium Data Transfer

 Source Server         : Localhost_PHP_7_3
 Source Server Type    : MySQL
 Source Server Version : 100137
 Source Host           : localhost:3306
 Source Schema         : aqua

 Target Server Type    : MySQL
 Target Server Version : 100137
 File Encoding         : 65001

 Date: 01/09/2019 09:10:58
*/

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
-- Table structure for alamatdetails
-- ----------------------------
DROP TABLE IF EXISTS `alamatdetails`;
CREATE TABLE `alamatdetails`  (
  `idalamat` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `name` varchar(50) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `adress` varchar(100) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `phone` varchar(15) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  PRIMARY KEY (`idalamat`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 3 CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Records of alamatdetails
-- ----------------------------
INSERT INTO `alamatdetails` VALUES (1, 4, 'gilang', 'adisetyo', '081226558445');
INSERT INTO `alamatdetails` VALUES (2, 4, 'ananda maya', 'palur', '085647247592');

-- ----------------------------
-- Table structure for bank_transfer
-- ----------------------------
DROP TABLE IF EXISTS `bank_transfer`;
CREATE TABLE `bank_transfer`  (
  `id_bank` int(11) NOT NULL AUTO_INCREMENT,
  `alamat_id` int(11) NULL DEFAULT NULL,
  `user_id` int(11) NULL DEFAULT NULL,
  `bank_name` varchar(50) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `ats_nama` varchar(50) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `norek` varchar(50) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `jumlah` int(11) NULL DEFAULT NULL,
  PRIMARY KEY (`id_bank`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 3 CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Records of bank_transfer
-- ----------------------------
INSERT INTO `bank_transfer` VALUES (1, 1, 4, 'bni', 'gilang', '009', 750000);
INSERT INTO `bank_transfer` VALUES (2, 2, 4, 'mandiri', 'Yudistira Gilang Adisetyo', '13423', 600000);

-- ----------------------------
-- Table structure for items
-- ----------------------------
DROP TABLE IF EXISTS `items`;
CREATE TABLE `items`  (
  `item_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `item_name` varchar(5000) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL DEFAULT '',
  `item_price` double NULL DEFAULT NULL,
  `item_image` varchar(5000) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL DEFAULT '',
  `item_date` date NOT NULL,
  PRIMARY KEY (`item_id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 7 CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Records of items
-- ----------------------------
INSERT INTO `items` VALUES (1, 'aquascape fullset', 1000000, '855156.jpg', '2019-08-19');
INSERT INTO `items` VALUES (2, 'aquascape iwagumi', 500000, '432880.jpg', '2019-08-19');
INSERT INTO `items` VALUES (3, 'aquascape jungle', 750000, '184166.jpg', '2019-08-19');
INSERT INTO `items` VALUES (4, 'aquascape natural', 300000, '487360.jpg', '2019-08-19');
INSERT INTO `items` VALUES (5, 'aquascape iwagumi 1', 750000, '237122.jpg', '2019-08-19');
INSERT INTO `items` VALUES (6, 'aquascape iwagumi 2', 800000, '749458.jpg', '2019-08-19');

-- ----------------------------
-- Table structure for orderdetails
-- ----------------------------
DROP TABLE IF EXISTS `orderdetails`;
CREATE TABLE `orderdetails`  (
  `order_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NULL DEFAULT NULL,
  `item_id` int(11) NOT NULL DEFAULT 0,
  `order_name` varchar(1000) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL DEFAULT '',
  `order_price` double NOT NULL DEFAULT 0,
  `order_quantity` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `order_total` double NOT NULL DEFAULT 0,
  `order_status` varchar(45) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL DEFAULT '',
  `order_date` date NOT NULL,
  PRIMARY KEY (`order_id`) USING BTREE,
  INDEX `FK_orderdetails_1`(`user_id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 3 CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Records of orderdetails
-- ----------------------------
INSERT INTO `orderdetails` VALUES (2, 4, 4, 'aquascape natural', 300000, 2, 600000, 'ordered', '2019-08-23');

-- ----------------------------
-- Table structure for saran
-- ----------------------------
DROP TABLE IF EXISTS `saran`;
CREATE TABLE `saran`  (
  `idsaran` int(11) NOT NULL AUTO_INCREMENT,
  `namasaran` varchar(100) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `saran` text CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL,
  PRIMARY KEY (`idsaran`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Table structure for users
-- ----------------------------
DROP TABLE IF EXISTS `users`;
CREATE TABLE `users`  (
  `user_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_email` varchar(1000) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `user_password` varchar(1000) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `user_firstname` varchar(1000) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `user_lastname` varchar(1000) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `user_address` varchar(1000) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `user_level` int(1) NULL DEFAULT NULL,
  PRIMARY KEY (`user_id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 5 CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Records of users
-- ----------------------------
INSERT INTO `users` VALUES (1, 'admin@admin.com', 'admin', 'Sapi', 'Cungkring', 'Solo', 1);
INSERT INTO `users` VALUES (4, 'sapi@cungkring.com', 'sapi', 'Yudhistira', 'Gilang', 'Karangasem Rt.04 Rw.03 Sroyo Jaten Karanganyar', 0);

SET FOREIGN_KEY_CHECKS = 1;
