/*
 Navicat MySQL Data Transfer

 Source Server         : Laragon
 Source Server Type    : MySQL
 Source Server Version : 50733
 Source Host           : localhost:3306
 Source Schema         : argus

 Target Server Type    : MySQL
 Target Server Version : 50733
 File Encoding         : 65001

 Date: 04/11/2021 18:38:38
*/

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
-- Table structure for group_method
-- ----------------------------
DROP TABLE IF EXISTS `group_method`;
CREATE TABLE `group_method`  (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `group_id` bigint(20) NOT NULL,
  `method_id` bigint(20) NULL DEFAULT NULL,
  `created_user_id` bigint(20) NULL DEFAULT NULL,
  `updated_user_id` bigint(20) NULL DEFAULT NULL,
  `created_at` timestamp(0) NULL DEFAULT CURRENT_TIMESTAMP(0),
  `updated_at` timestamp(0) NULL DEFAULT CURRENT_TIMESTAMP(0) ON UPDATE CURRENT_TIMESTAMP(0),
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `group_id`(`group_id`) USING BTREE,
  INDEX `method_id`(`method_id`) USING BTREE,
  CONSTRAINT `group_method_ibfk_1` FOREIGN KEY (`group_id`) REFERENCES `groups` (`id`) ON DELETE RESTRICT ON UPDATE CASCADE,
  CONSTRAINT `group_method_ibfk_2` FOREIGN KEY (`method_id`) REFERENCES `methods` (`id`) ON DELETE RESTRICT ON UPDATE CASCADE
) ENGINE = InnoDB AUTO_INCREMENT = 38 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = COMPACT;

-- ----------------------------
-- Records of group_method
-- ----------------------------
INSERT INTO `group_method` VALUES (1, 1, 1, NULL, NULL, '2021-11-04 18:38:15', '2021-11-04 18:38:15');
INSERT INTO `group_method` VALUES (2, 1, 2, NULL, NULL, '2021-11-04 18:38:15', '2021-11-04 18:38:15');
INSERT INTO `group_method` VALUES (3, 1, 3, NULL, NULL, '2021-11-04 18:38:15', '2021-11-04 18:38:15');
INSERT INTO `group_method` VALUES (4, 1, 4, NULL, NULL, '2021-11-04 18:38:15', '2021-11-04 18:38:15');
INSERT INTO `group_method` VALUES (5, 1, 5, NULL, NULL, '2021-11-04 18:38:15', '2021-11-04 18:38:15');
INSERT INTO `group_method` VALUES (6, 1, 6, NULL, NULL, '2021-11-04 18:38:15', '2021-11-04 18:38:15');
INSERT INTO `group_method` VALUES (7, 1, 7, NULL, NULL, '2021-11-04 18:38:15', '2021-11-04 18:38:15');
INSERT INTO `group_method` VALUES (8, 1, 8, NULL, NULL, '2021-11-04 18:38:15', '2021-11-04 18:38:15');
INSERT INTO `group_method` VALUES (9, 1, 9, NULL, NULL, '2021-11-04 18:38:15', '2021-11-04 18:38:15');
INSERT INTO `group_method` VALUES (10, 1, 10, NULL, NULL, '2021-11-04 18:38:15', '2021-11-04 18:38:15');
INSERT INTO `group_method` VALUES (11, 1, 11, NULL, NULL, '2021-11-04 18:38:15', '2021-11-04 18:38:15');
INSERT INTO `group_method` VALUES (12, 1, 12, NULL, NULL, '2021-11-04 18:38:15', '2021-11-04 18:38:15');
INSERT INTO `group_method` VALUES (13, 1, 13, NULL, NULL, '2021-11-04 18:38:15', '2021-11-04 18:38:15');
INSERT INTO `group_method` VALUES (14, 1, 14, NULL, NULL, '2021-11-04 18:38:15', '2021-11-04 18:38:15');
INSERT INTO `group_method` VALUES (15, 1, 15, NULL, NULL, '2021-11-04 18:38:15', '2021-11-04 18:38:15');
INSERT INTO `group_method` VALUES (16, 1, 16, NULL, NULL, '2021-11-04 18:38:15', '2021-11-04 18:38:15');
INSERT INTO `group_method` VALUES (17, 1, 17, NULL, NULL, '2021-11-04 18:38:15', '2021-11-04 18:38:15');
INSERT INTO `group_method` VALUES (18, 1, 18, NULL, NULL, '2021-11-04 18:38:15', '2021-11-04 18:38:15');
INSERT INTO `group_method` VALUES (19, 1, 19, NULL, NULL, '2021-11-04 18:38:15', '2021-11-04 18:38:15');
INSERT INTO `group_method` VALUES (20, 1, 20, NULL, NULL, '2021-11-04 18:38:15', '2021-11-04 18:38:15');
INSERT INTO `group_method` VALUES (21, 1, 21, NULL, NULL, '2021-11-04 18:38:15', '2021-11-04 18:38:15');
INSERT INTO `group_method` VALUES (22, 1, 22, NULL, NULL, '2021-11-04 18:38:15', '2021-11-04 18:38:15');
INSERT INTO `group_method` VALUES (23, 1, 23, NULL, NULL, '2021-11-04 18:38:15', '2021-11-04 18:38:15');
INSERT INTO `group_method` VALUES (24, 1, 24, NULL, NULL, '2021-11-04 18:38:15', '2021-11-04 18:38:15');
INSERT INTO `group_method` VALUES (25, 1, 25, NULL, NULL, '2021-11-04 18:38:15', '2021-11-04 18:38:15');
INSERT INTO `group_method` VALUES (26, 1, 26, NULL, NULL, '2021-11-04 18:38:15', '2021-11-04 18:38:15');
INSERT INTO `group_method` VALUES (27, 1, 27, NULL, NULL, '2021-11-04 18:38:15', '2021-11-04 18:38:15');
INSERT INTO `group_method` VALUES (28, 1, 28, NULL, NULL, '2021-11-04 18:38:15', '2021-11-04 18:38:15');
INSERT INTO `group_method` VALUES (29, 1, 29, NULL, NULL, '2021-11-04 18:38:15', '2021-11-04 18:38:15');
INSERT INTO `group_method` VALUES (30, 1, 30, NULL, NULL, '2021-11-04 18:38:15', '2021-11-04 18:38:15');
INSERT INTO `group_method` VALUES (31, 1, 31, NULL, NULL, '2021-11-04 18:38:15', '2021-11-04 18:38:15');
INSERT INTO `group_method` VALUES (32, 1, 32, NULL, NULL, '2021-11-04 18:38:15', '2021-11-04 18:38:15');
INSERT INTO `group_method` VALUES (33, 1, 33, NULL, NULL, '2021-11-04 18:38:15', '2021-11-04 18:38:15');
INSERT INTO `group_method` VALUES (34, 1, 34, NULL, NULL, '2021-11-04 18:38:15', '2021-11-04 18:38:15');
INSERT INTO `group_method` VALUES (35, 1, 35, NULL, NULL, '2021-11-04 18:38:15', '2021-11-04 18:38:15');
INSERT INTO `group_method` VALUES (36, 1, 36, NULL, NULL, '2021-11-04 18:38:15', '2021-11-04 18:38:15');
INSERT INTO `group_method` VALUES (37, 1, 37, NULL, NULL, '2021-11-04 18:38:15', '2021-11-04 18:38:15');

-- ----------------------------
-- Table structure for groups
-- ----------------------------
DROP TABLE IF EXISTS `groups`;
CREATE TABLE `groups`  (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `activo` tinyint(11) NULL DEFAULT 1,
  `created_user_id` bigint(20) NULL DEFAULT NULL,
  `updated_user_id` bigint(20) NULL DEFAULT NULL,
  `created_at` timestamp(0) NULL DEFAULT CURRENT_TIMESTAMP(0),
  `updated_at` timestamp(0) NULL DEFAULT CURRENT_TIMESTAMP(0) ON UPDATE CURRENT_TIMESTAMP(0),
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 2 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = COMPACT;

-- ----------------------------
-- Records of groups
-- ----------------------------
INSERT INTO `groups` VALUES (1, 'Programador', 1, NULL, NULL, '2021-11-04 15:51:29', '2021-11-04 15:51:29');

-- ----------------------------
-- Table structure for menusController
-- ----------------------------
DROP TABLE IF EXISTS `menus`;
CREATE TABLE `menus`  (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `label` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `icon` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `activo` tinyint(11) NULL DEFAULT 1,
  `created_user_id` bigint(20) NULL DEFAULT NULL,
  `updated_user_id` bigint(20) NULL DEFAULT NULL,
  `created_at` timestamp(0) NULL DEFAULT CURRENT_TIMESTAMP(0),
  `updated_at` timestamp(0) NULL DEFAULT CURRENT_TIMESTAMP(0) ON UPDATE CURRENT_TIMESTAMP(0),
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 5 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = COMPACT;

-- ----------------------------
-- Records of menusController
-- ----------------------------
INSERT INTO `menus` VALUES (1, 'menusController', 'MENUS', 'fas fa-th-list', 1, -1, -1, '2021-10-25 13:09:24', '2021-10-25 13:09:24');
INSERT INTO `menus` VALUES (2, 'metodos', 'METODOS', 'fas fa-list-ul', 1, -1, -1, '2021-10-25 13:09:24', '2021-10-25 13:09:24');
INSERT INTO `menus` VALUES (3, 'grupos', 'GRUPOS', 'fas fa-users-cog', 1, -1, -1, '2021-10-25 13:09:24', '2021-10-25 13:09:24');
INSERT INTO `menus` VALUES (4, 'usuarios', 'USUARIOS', 'fas fa-users', 1, -1, -1, '2021-10-25 13:09:24', '2021-10-25 13:09:24');

-- ----------------------------
-- Table structure for methods
-- ----------------------------
DROP TABLE IF EXISTS `methods`;
CREATE TABLE `methods`  (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `label` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `action` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `icon` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `menu_id` bigint(20) NULL DEFAULT NULL,
  `is_menu` tinyint(11) NULL DEFAULT NULL,
  `is_action` tinyint(11) NULL DEFAULT NULL,
  `activo` tinyint(11) NULL DEFAULT 1,
  `created_user_id` bigint(20) NULL DEFAULT NULL,
  `updated_user_id` bigint(20) NULL DEFAULT NULL,
  `created_at` timestamp(0) NULL DEFAULT CURRENT_TIMESTAMP(0),
  `updated_at` timestamp(0) NULL DEFAULT CURRENT_TIMESTAMP(0) ON UPDATE CURRENT_TIMESTAMP(0),
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `menu_id`(`menu_id`) USING BTREE,
  CONSTRAINT `methods_ibfk_1` FOREIGN KEY (`menu_id`) REFERENCES `menus` (`id`) ON DELETE RESTRICT ON UPDATE CASCADE
) ENGINE = InnoDB AUTO_INCREMENT = 39 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = COMPACT;

-- ----------------------------
-- Records of methods
-- ----------------------------
INSERT INTO `methods` VALUES (1, 'nuevaContra', NULL, 'Cambiar contraseña', 'fas fa-key', 4, 0, 1, 1, -1, -1, '2021-10-25 13:09:24', '2021-10-25 13:09:24');
INSERT INTO `methods` VALUES (2, 'nuevaContraBd', NULL, NULL, NULL, 4, 0, 0, 1, -1, -1, '2021-10-25 13:09:24', '2021-10-25 13:09:24');
INSERT INTO `methods` VALUES (3, 'permisos', NULL, 'Asigna Permisos', 'fas fa-plus-square', 3, 0, 1, 1, -1, -1, '2021-10-25 13:09:24', '2021-10-25 13:09:24');
INSERT INTO `methods` VALUES (4, 'bajaPermiso', NULL, NULL, NULL, 3, 0, 0, 1, -1, -1, '2021-10-25 13:09:24', '2021-10-25 13:09:24');
INSERT INTO `methods` VALUES (5, 'altaPermiso', NULL, NULL, NULL, 3, 0, 0, 1, -1, -1, '2021-10-25 13:09:24', '2021-10-25 13:09:24');
INSERT INTO `methods` VALUES (6, 'registrar', 'Registrar', NULL, NULL, 1, 1, 0, 1, -1, -1, '2021-10-25 13:09:24', '2021-10-25 13:09:24');
INSERT INTO `methods` VALUES (7, 'lista', 'Lista', NULL, NULL, 1, 1, 0, 1, -1, -1, '2021-10-25 13:09:24', '2021-10-25 13:09:24');
INSERT INTO `methods` VALUES (8, 'registrarBd', NULL, NULL, NULL, 1, 0, 0, 1, -1, -1, '2021-10-25 13:09:24', '2021-10-25 13:09:24');
INSERT INTO `methods` VALUES (9, 'activarBd', NULL, 'Activar', 'fas fa-play', 1, 0, 1, 1, -1, -1, '2021-10-25 13:09:24', '2021-10-25 13:09:24');
INSERT INTO `methods` VALUES (10, 'desactivarBd', NULL, 'Desactivar', 'fas fa-pause', 1, 0, 1, 1, -1, -1, '2021-10-25 13:09:24', '2021-10-25 13:09:24');
INSERT INTO `methods` VALUES (11, 'modificar', NULL, 'Modificar', 'fas fa-pencil-alt', 1, 0, 1, 1, -1, -1, '2021-10-25 13:09:24', '2021-10-25 13:09:24');
INSERT INTO `methods` VALUES (12, 'eliminarBd', NULL, 'Eliminar', 'fas fa-trash', 1, 0, 1, 1, -1, -1, '2021-10-25 13:09:24', '2021-10-25 13:09:24');
INSERT INTO `methods` VALUES (13, 'modificarBd', NULL, NULL, NULL, 1, 0, 0, 1, -1, -1, '2021-10-25 13:09:24', '2021-10-25 13:09:24');
INSERT INTO `methods` VALUES (14, 'registrar', 'Registrar', NULL, NULL, 2, 1, 0, 1, -1, -1, '2021-10-25 13:09:24', '2021-10-25 13:09:24');
INSERT INTO `methods` VALUES (15, 'lista', 'Lista', NULL, NULL, 2, 1, 0, 1, -1, -1, '2021-10-25 13:09:24', '2021-10-25 13:09:24');
INSERT INTO `methods` VALUES (16, 'registrarBd', NULL, NULL, NULL, 2, 0, 0, 1, -1, -1, '2021-10-25 13:09:24', '2021-10-25 13:09:24');
INSERT INTO `methods` VALUES (17, 'activarBd', NULL, 'Activar', 'fas fa-play', 2, 0, 1, 1, -1, -1, '2021-10-25 13:09:24', '2021-10-25 13:09:24');
INSERT INTO `methods` VALUES (18, 'desactivarBd', NULL, 'Desactivar', 'fas fa-pause', 2, 0, 1, 1, -1, -1, '2021-10-25 13:09:24', '2021-10-25 13:09:24');
INSERT INTO `methods` VALUES (19, 'modificar', NULL, 'Modificar', 'fas fa-pencil-alt', 2, 0, 1, 1, -1, -1, '2021-10-25 13:09:24', '2021-10-25 13:09:24');
INSERT INTO `methods` VALUES (20, 'eliminarBd', NULL, 'Eliminar', 'fas fa-trash', 2, 0, 1, 1, -1, -1, '2021-10-25 13:09:24', '2021-10-25 13:09:24');
INSERT INTO `methods` VALUES (21, 'modificarBd', NULL, NULL, NULL, 2, 0, 0, 1, -1, -1, '2021-10-25 13:09:24', '2021-10-25 13:09:24');
INSERT INTO `methods` VALUES (22, 'registrar', 'Registrar', NULL, NULL, 3, 1, 0, 1, -1, -1, '2021-10-25 13:09:24', '2021-10-25 13:09:24');
INSERT INTO `methods` VALUES (23, 'lista', 'Lista', NULL, NULL, 3, 1, 0, 1, -1, -1, '2021-10-25 13:09:24', '2021-10-25 13:09:24');
INSERT INTO `methods` VALUES (24, 'registrarBd', NULL, NULL, NULL, 3, 0, 0, 1, -1, -1, '2021-10-25 13:09:24', '2021-10-25 13:09:24');
INSERT INTO `methods` VALUES (25, 'activarBd', NULL, 'Activar', 'fas fa-play', 3, 0, 1, 1, -1, -1, '2021-10-25 13:09:24', '2021-10-25 13:09:24');
INSERT INTO `methods` VALUES (26, 'desactivarBd', NULL, 'Desactivar', 'fas fa-pause', 3, 0, 1, 1, -1, -1, '2021-10-25 13:09:24', '2021-10-25 13:09:24');
INSERT INTO `methods` VALUES (27, 'modificar', NULL, 'Modificar', 'fas fa-pencil-alt', 3, 0, 1, 1, -1, -1, '2021-10-25 13:09:24', '2021-10-25 13:09:24');
INSERT INTO `methods` VALUES (28, 'eliminarBd', NULL, 'Eliminar', 'fas fa-trash', 3, 0, 1, 1, -1, -1, '2021-10-25 13:09:24', '2021-10-25 13:09:24');
INSERT INTO `methods` VALUES (29, 'modificarBd', NULL, NULL, NULL, 3, 0, 0, 1, -1, -1, '2021-10-25 13:09:24', '2021-10-25 13:09:24');
INSERT INTO `methods` VALUES (30, 'registrar', 'Registrar', NULL, NULL, 4, 1, 0, 1, -1, -1, '2021-10-25 13:09:24', '2021-10-25 13:09:24');
INSERT INTO `methods` VALUES (31, 'lista', 'Lista', NULL, NULL, 4, 1, 0, 1, -1, -1, '2021-10-25 13:09:24', '2021-10-25 13:09:24');
INSERT INTO `methods` VALUES (32, 'registrarBd', NULL, NULL, NULL, 4, 0, 0, 1, -1, -1, '2021-10-25 13:09:24', '2021-10-25 13:09:24');
INSERT INTO `methods` VALUES (33, 'activarBd', NULL, 'Activar', 'fas fa-play', 4, 0, 1, 1, -1, -1, '2021-10-25 13:09:24', '2021-10-25 13:09:24');
INSERT INTO `methods` VALUES (34, 'desactivarBd', NULL, 'Desactivar', 'fas fa-pause', 4, 0, 1, 1, -1, -1, '2021-10-25 13:09:24', '2021-10-25 13:09:24');
INSERT INTO `methods` VALUES (35, 'modificar', NULL, 'Modificar', 'fas fa-pencil-alt', 4, 0, 1, 1, -1, -1, '2021-10-25 13:09:24', '2021-10-25 13:09:24');
INSERT INTO `methods` VALUES (36, 'eliminarBd', NULL, 'Eliminar', 'fas fa-trash', 4, 0, 1, 1, -1, -1, '2021-10-25 13:09:24', '2021-10-25 13:09:24');
INSERT INTO `methods` VALUES (37, 'modificarBd', NULL, NULL, NULL, 4, 0, 0, 1, -1, -1, '2021-10-25 13:09:24', '2021-10-25 13:09:24');

-- ----------------------------
-- Table structure for sessions
-- ----------------------------
DROP TABLE IF EXISTS `sessions`;
CREATE TABLE `sessions`  (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `session_id` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `user_id` bigint(20) NOT NULL,
  `created_at` timestamp(0) NULL DEFAULT CURRENT_TIMESTAMP(0),
  `updated_at` timestamp(0) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `user_id`(`user_id`) USING BTREE,
  CONSTRAINT `sessions_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE RESTRICT ON UPDATE CASCADE
) ENGINE = InnoDB AUTO_INCREMENT = 9 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = COMPACT;

-- ----------------------------
-- Records of sessions
-- ----------------------------
INSERT INTO `sessions` VALUES (1, '6b42b74e76d4a14a0929a04bbd8d7e95', 1, '2021-11-04 15:29:57', '2021-11-04 15:29:57');
INSERT INTO `sessions` VALUES (2, '6f05bf719b517dda70cfc92f3452f098', 1, '2021-11-04 15:30:14', '2021-11-04 15:30:14');
INSERT INTO `sessions` VALUES (3, 'a5c76c8b96f9c66ab038f115f00a39b2', 1, '2021-11-04 15:30:16', '2021-11-04 15:30:16');
INSERT INTO `sessions` VALUES (4, '07082fe204b984e6fb5c7d42cbdcc074', 1, '2021-11-04 15:31:40', '2021-11-04 15:31:40');
INSERT INTO `sessions` VALUES (5, '4ec8d067636636205ee2949ba4b4b5c6', 1, '2021-11-04 15:35:06', '2021-11-04 15:35:06');
INSERT INTO `sessions` VALUES (7, '32a998e6ec37fe9878b771c69444a699', 1, '2021-11-04 16:09:36', '2021-11-04 16:09:36');
INSERT INTO `sessions` VALUES (8, '0fb123ec67e33a3a3a61fdfd7f37e058', 1, '2021-11-04 16:10:17', '2021-11-04 16:10:17');

-- ----------------------------
-- Table structure for users
-- ----------------------------
DROP TABLE IF EXISTS `users`;
CREATE TABLE `users`  (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `user` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `password` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `name` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `last_name` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `email` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `group_id` bigint(20) NULL DEFAULT NULL,
  `activo` tinyint(11) NULL DEFAULT 0,
  `created_user_id` bigint(20) NULL DEFAULT NULL,
  `updated_user_id` bigint(20) NULL DEFAULT NULL,
  `created_at` timestamp(0) NULL DEFAULT CURRENT_TIMESTAMP(0),
  `updated_at` timestamp(0) NULL DEFAULT CURRENT_TIMESTAMP(0) ON UPDATE CURRENT_TIMESTAMP(0),
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `group_id`(`group_id`) USING BTREE,
  CONSTRAINT `users_ibfk_1` FOREIGN KEY (`group_id`) REFERENCES `groups` (`id`) ON DELETE RESTRICT ON UPDATE CASCADE
) ENGINE = InnoDB AUTO_INCREMENT = 2 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = COMPACT;

-- ----------------------------
-- Records of users
-- ----------------------------
INSERT INTO `users` VALUES (1, 'admin', '22a05a99fd4e0f03d7b0d22e3b6393d1', 'asd', NULL, NULL, 1, 0, NULL, NULL, '2021-11-04 13:59:27', '2021-11-04 15:51:34');

SET FOREIGN_KEY_CHECKS = 1;
