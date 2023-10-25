/*
 Navicat Premium Data Transfer

 Source Server         : cnn
 Source Server Type    : MySQL
 Source Server Version : 100421
 Source Host           : localhost:3306
 Source Schema         : paypal

 Target Server Type    : MySQL
 Target Server Version : 100421
 File Encoding         : 65001

 Date: 17/10/2023 07:46:14
*/

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
-- Table structure for payments
-- ----------------------------
DROP TABLE IF EXISTS `payments`;
CREATE TABLE `payments`  (
  `payment_id` int NOT NULL AUTO_INCREMENT,
  `username` char(200) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `product_id` int NOT NULL,
  `txn_id` varchar(100) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `amount` float(10, 2) NOT NULL,
  `currency_code` varchar(5) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(100) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `payment_status` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `location` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  PRIMARY KEY (`payment_id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 17 CHARACTER SET = utf8 COLLATE = utf8_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of payments
-- ----------------------------
INSERT INTO `payments` VALUES (3, 'dd', 0, '3U845265FH373061K', 32.00, 'USD', 'sb-2owaw27760977@personal.example.com', 'Completed', 'sdf');
INSERT INTO `payments` VALUES (4, 'dd', 0, '8F003267N74160820', 22.00, 'USD', 'sb-ns4i927761360@personal.example.com', 'Completed', 'fdfdf');
INSERT INTO `payments` VALUES (5, 'dd111', 0, '91N82779UB2633806', 22.00, 'USD', 'sb-ns4i927761360@personal.example.com', 'Completed', 'fdfdf');
INSERT INTO `payments` VALUES (6, 'ddd', 0, '2VU9049219696882R', 3.00, 'USD', 'sb-ns4i927761360@personal.example.com', 'Completed', 'sd');
INSERT INTO `payments` VALUES (7, 'ddd', 0, '2VU9049219696882R', 3.00, 'USD', 'sb-ns4i927761360@personal.example.com', 'Completed', 'sd');
INSERT INTO `payments` VALUES (8, 'ddd', 0, '5L650699YK079041F', 23.00, 'USD', 'sb-ns4i927761360@personal.example.com', 'Completed', 'sd');
INSERT INTO `payments` VALUES (9, 'ddd', 0, '1L812639R53232119', 32.00, 'USD', 'sb-ns4i927761360@personal.example.com', 'Completed', '32');
INSERT INTO `payments` VALUES (10, 'ddd', 0, '1L812639R53232119', 32.00, 'USD', 'sb-ns4i927761360@personal.example.com', 'Completed', '32');
INSERT INTO `payments` VALUES (11, 'dd', 0, '56L50539UT750954X', 333333.00, 'USD', 'sb-ns4i927761360@personal.example.com', 'Completed', 'sd');
INSERT INTO `payments` VALUES (12, 'dd', 0, '56L50539UT750954X', 333333.00, 'USD', 'sb-ns4i927761360@personal.example.com', 'Completed', 'sd');
INSERT INTO `payments` VALUES (13, 'dd', 0, '56L50539UT750954X', 333333.00, 'USD', 'sb-ns4i927761360@personal.example.com', 'Completed', 'sd');
INSERT INTO `payments` VALUES (14, 'sd', 0, '2NV16060BD7203433', 455.00, 'USD', 'sb-r473h727760565@personal.example.com', 'Completed', 'sd');
INSERT INTO `payments` VALUES (15, 'sd', 0, '2NV16060BD7203433', 455.00, 'USD', 'sb-r473h727760565@personal.example.com', 'Completed', 'sd');
INSERT INTO `payments` VALUES (16, 'sd', 0, '2NV16060BD7203433', 455.00, 'USD', 'sb-r473h727760565@personal.example.com', 'Completed', 'sd');

-- ----------------------------
-- Table structure for products
-- ----------------------------
DROP TABLE IF EXISTS `products`;
CREATE TABLE `products`  (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `image` varchar(200) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `price` float(10, 2) NOT NULL,
  `status` enum('1','0') CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 3 CHARACTER SET = utf8 COLLATE = utf8_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of products
-- ----------------------------
INSERT INTO `products` VALUES (1, 'Product 1', 'product_image.jpg', 15.00, '1');
INSERT INTO `products` VALUES (2, 'Product 2', 'product_image.jpg', 25.00, '1');

SET FOREIGN_KEY_CHECKS = 1;
