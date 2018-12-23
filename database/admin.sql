/*
 Navicat Premium Data Transfer

 Source Server         : 本地
 Source Server Type    : MySQL
 Source Server Version : 50719
 Source Host           : localhost:3306
 Source Schema         : admin

 Target Server Type    : MySQL
 Target Server Version : 50719
 File Encoding         : 65001

 Date: 23/12/2018 11:33:33
*/

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
-- Table structure for permissions
-- ----------------------------
DROP TABLE IF EXISTS `permissions`;
CREATE TABLE `permissions`  (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `p_id` int(10) NOT NULL DEFAULT 0 COMMENT '0一级菜单 >0子菜单',
  `controller` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '控制器',
  `action` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '方法',
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '方法别名',
  `access` tinyint(1) NOT NULL DEFAULT 0 COMMENT '0公有 1保护 2私有',
  `view` tinyint(1) NOT NULL DEFAULT 0 COMMENT '0不可见 1可见',
  `sort` int(10) NOT NULL DEFAULT 0 COMMENT '排序',
  `description` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 10 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of permissions
-- ----------------------------
INSERT INTO `permissions` VALUES (1, 0, 'Home', '', '首页', 0, 1, 0, '');
INSERT INTO `permissions` VALUES (2, 1, 'Home', 'index', '首页', 0, 1, 0, '');
INSERT INTO `permissions` VALUES (3, 0, 'Auth', '', '授权管理', 0, 1, 0, '');
INSERT INTO `permissions` VALUES (4, 3, 'Auth', 'menu', '导航菜单', 0, 1, 0, '');
INSERT INTO `permissions` VALUES (5, 3, 'Auth', 'upMenu', '', 1, 1, 0, '');
INSERT INTO `permissions` VALUES (6, 3, 'Auth', 'role', '管理角色', 0, 1, 0, '');
INSERT INTO `permissions` VALUES (7, 3, 'Auth', 'login', '', 0, 0, 0, '');
INSERT INTO `permissions` VALUES (8, 3, 'Auth', 'roleBindUser', '角色绑定', 0, 0, 0, '');
INSERT INTO `permissions` VALUES (9, 3, 'Auth', 'permission', '权限设置', 0, 0, 0, '');

-- ----------------------------
-- Table structure for role_permission
-- ----------------------------
DROP TABLE IF EXISTS `role_permission`;
CREATE TABLE `role_permission`  (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `role_id` int(10) UNSIGNED NOT NULL,
  `permission_id` int(10) UNSIGNED NOT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 10 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of role_permission
-- ----------------------------
INSERT INTO `role_permission` VALUES (1, 1, 1);
INSERT INTO `role_permission` VALUES (2, 1, 2);
INSERT INTO `role_permission` VALUES (3, 1, 3);
INSERT INTO `role_permission` VALUES (4, 1, 4);
INSERT INTO `role_permission` VALUES (5, 1, 5);
INSERT INTO `role_permission` VALUES (6, 1, 6);
INSERT INTO `role_permission` VALUES (7, 1, 7);
INSERT INTO `role_permission` VALUES (8, 1, 8);
INSERT INTO `role_permission` VALUES (9, 1, 9);

-- ----------------------------
-- Table structure for roles
-- ----------------------------
DROP TABLE IF EXISTS `roles`;
CREATE TABLE `roles`  (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 2 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of roles
-- ----------------------------
INSERT INTO `roles` VALUES (1, '超级管理员', 'admin');

-- ----------------------------
-- Table structure for user_role
-- ----------------------------
DROP TABLE IF EXISTS `user_role`;
CREATE TABLE `user_role`  (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `user_id` int(10) UNSIGNED NOT NULL,
  `role_id` int(10) UNSIGNED NOT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 2 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of user_role
-- ----------------------------
INSERT INTO `user_role` VALUES (1, 10000, 1);

-- ----------------------------
-- Table structure for users
-- ----------------------------
DROP TABLE IF EXISTS `users`;
CREATE TABLE `users`  (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '',
  `account` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '',
  `password` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '',
  `account_type` tinyint(1) NOT NULL DEFAULT 0 COMMENT '0.默认 1.手机 2.github 3.coding 4.qq',
  `gender` tinyint(1) NOT NULL DEFAULT 0,
  `level` tinyint(1) NOT NULL DEFAULT 0,
  `avatar` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '',
  `status` tinyint(1) NOT NULL DEFAULT 0,
  `star` int(11) NOT NULL DEFAULT 0,
  `resource_count` int(11) NOT NULL DEFAULT 0,
  `note_count` int(11) NOT NULL DEFAULT 0,
  `token` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '',
  `last_login_time` timestamp(0) NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `update_at` timestamp(0) NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `create_at` timestamp(0) NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `from` tinyint(5) NOT NULL DEFAULT 0 COMMENT '渠道商',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 10001 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of users
-- ----------------------------
INSERT INTO `users` VALUES (10000, 'hikki', 'hikki', 'b2f9e74b64c1ecc46044d71f643a7b7c', 0, 1, 5, '', 0, 0, 0, 0, 'd566d09f30d217a2d344e0578f62e098', '2018-11-02 10:12:31', '2018-10-30 14:27:03', '2018-10-18 14:45:23', 0);

SET FOREIGN_KEY_CHECKS = 1;
