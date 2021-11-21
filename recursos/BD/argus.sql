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

 Date: 21/11/2021 12:04:22
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
) ENGINE = InnoDB AUTO_INCREMENT = 58 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = COMPACT;

-- ----------------------------
-- Records of group_method
-- ----------------------------
INSERT INTO `group_method` VALUES (1, 1, 1, NULL, NULL, NULL, NULL);
INSERT INTO `group_method` VALUES (2, 1, 2, NULL, NULL, NULL, NULL);
INSERT INTO `group_method` VALUES (3, 1, 3, NULL, NULL, NULL, NULL);
INSERT INTO `group_method` VALUES (4, 1, 4, NULL, NULL, NULL, NULL);
INSERT INTO `group_method` VALUES (5, 1, 5, NULL, NULL, NULL, NULL);
INSERT INTO `group_method` VALUES (6, 1, 6, NULL, NULL, NULL, NULL);
INSERT INTO `group_method` VALUES (7, 1, 7, NULL, NULL, NULL, NULL);
INSERT INTO `group_method` VALUES (8, 1, 8, NULL, NULL, NULL, NULL);
INSERT INTO `group_method` VALUES (9, 1, 9, NULL, NULL, NULL, NULL);
INSERT INTO `group_method` VALUES (10, 1, 10, NULL, NULL, NULL, NULL);
INSERT INTO `group_method` VALUES (11, 1, 11, NULL, NULL, NULL, NULL);
INSERT INTO `group_method` VALUES (12, 1, 12, NULL, NULL, NULL, NULL);
INSERT INTO `group_method` VALUES (13, 1, 13, NULL, NULL, NULL, NULL);
INSERT INTO `group_method` VALUES (14, 1, 14, NULL, NULL, NULL, NULL);
INSERT INTO `group_method` VALUES (15, 1, 15, NULL, NULL, NULL, NULL);
INSERT INTO `group_method` VALUES (16, 1, 16, NULL, NULL, NULL, NULL);
INSERT INTO `group_method` VALUES (17, 1, 17, NULL, NULL, NULL, NULL);
INSERT INTO `group_method` VALUES (18, 1, 18, NULL, NULL, NULL, NULL);
INSERT INTO `group_method` VALUES (19, 1, 19, NULL, NULL, NULL, NULL);
INSERT INTO `group_method` VALUES (20, 1, 20, NULL, NULL, NULL, NULL);
INSERT INTO `group_method` VALUES (21, 1, 21, NULL, NULL, NULL, NULL);
INSERT INTO `group_method` VALUES (22, 1, 22, NULL, NULL, NULL, NULL);
INSERT INTO `group_method` VALUES (23, 1, 23, NULL, NULL, NULL, NULL);
INSERT INTO `group_method` VALUES (24, 1, 24, NULL, NULL, NULL, NULL);
INSERT INTO `group_method` VALUES (25, 1, 25, NULL, NULL, NULL, NULL);
INSERT INTO `group_method` VALUES (26, 1, 26, NULL, NULL, NULL, NULL);
INSERT INTO `group_method` VALUES (27, 1, 27, NULL, NULL, NULL, NULL);
INSERT INTO `group_method` VALUES (28, 1, 28, NULL, NULL, NULL, NULL);
INSERT INTO `group_method` VALUES (29, 1, 29, NULL, NULL, NULL, NULL);
INSERT INTO `group_method` VALUES (30, 1, 30, NULL, NULL, NULL, NULL);
INSERT INTO `group_method` VALUES (31, 1, 31, NULL, NULL, NULL, NULL);
INSERT INTO `group_method` VALUES (32, 1, 32, NULL, NULL, NULL, NULL);
INSERT INTO `group_method` VALUES (33, 1, 33, NULL, NULL, NULL, NULL);
INSERT INTO `group_method` VALUES (34, 1, 34, NULL, NULL, NULL, NULL);
INSERT INTO `group_method` VALUES (35, 1, 35, NULL, NULL, NULL, NULL);
INSERT INTO `group_method` VALUES (36, 1, 36, NULL, NULL, NULL, NULL);
INSERT INTO `group_method` VALUES (37, 1, 37, NULL, NULL, NULL, NULL);
INSERT INTO `group_method` VALUES (38, 1, 38, NULL, NULL, NULL, NULL);
INSERT INTO `group_method` VALUES (39, 1, 39, NULL, NULL, NULL, NULL);
INSERT INTO `group_method` VALUES (40, 1, 40, NULL, NULL, NULL, NULL);
INSERT INTO `group_method` VALUES (41, 1, 41, NULL, NULL, NULL, NULL);
INSERT INTO `group_method` VALUES (42, 1, 42, NULL, NULL, NULL, NULL);
INSERT INTO `group_method` VALUES (43, 1, 43, NULL, NULL, NULL, NULL);
INSERT INTO `group_method` VALUES (44, 1, 44, NULL, NULL, NULL, NULL);
INSERT INTO `group_method` VALUES (45, 1, 45, NULL, NULL, NULL, NULL);
INSERT INTO `group_method` VALUES (46, 1, 46, NULL, NULL, NULL, NULL);
INSERT INTO `group_method` VALUES (47, 1, 47, NULL, NULL, NULL, NULL);
INSERT INTO `group_method` VALUES (48, 2, 38, NULL, NULL, NULL, NULL);
INSERT INTO `group_method` VALUES (49, 2, 39, NULL, NULL, NULL, NULL);
INSERT INTO `group_method` VALUES (50, 2, 40, NULL, NULL, NULL, NULL);
INSERT INTO `group_method` VALUES (51, 2, 41, NULL, NULL, NULL, NULL);
INSERT INTO `group_method` VALUES (52, 2, 42, NULL, NULL, NULL, NULL);
INSERT INTO `group_method` VALUES (53, 2, 43, NULL, NULL, NULL, NULL);
INSERT INTO `group_method` VALUES (54, 2, 44, NULL, NULL, NULL, NULL);
INSERT INTO `group_method` VALUES (55, 2, 45, NULL, NULL, NULL, NULL);
INSERT INTO `group_method` VALUES (56, 2, 46, NULL, NULL, NULL, NULL);
INSERT INTO `group_method` VALUES (57, 2, 47, NULL, NULL, NULL, NULL);

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
) ENGINE = InnoDB AUTO_INCREMENT = 3 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = COMPACT;

-- ----------------------------
-- Records of groups
-- ----------------------------
INSERT INTO `groups` VALUES (1, 'Programador', 1, -1, -1, NULL, NULL);
INSERT INTO `groups` VALUES (2, 'Administrador', 1, -1, -1, NULL, NULL);

-- ----------------------------
-- Table structure for menus
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
) ENGINE = InnoDB AUTO_INCREMENT = 6 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = COMPACT;

-- ----------------------------
-- Records of menus
-- ----------------------------
INSERT INTO `menus` VALUES (1, 'Menu', 'MENUS', 'fas fa-th-list', 1, -1, -1, NULL, NULL);
INSERT INTO `menus` VALUES (2, 'Method', 'METODOS', 'fas fa-list-ul', 1, -1, -1, NULL, NULL);
INSERT INTO `menus` VALUES (3, 'Group', 'GRUPOS', 'fas fa-users-cog', 1, -1, -1, NULL, NULL);
INSERT INTO `menus` VALUES (4, 'User', 'USUARIOS', 'fas fa-users', 1, -1, -1, NULL, NULL);
INSERT INTO `menus` VALUES (5, 'Admin', 'ADMINS', 'fas fa-users', 1, -1, -1, NULL, NULL);

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
) ENGINE = InnoDB AUTO_INCREMENT = 48 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = COMPACT;

-- ----------------------------
-- Records of methods
-- ----------------------------
INSERT INTO `methods` VALUES (1, 'registrar', 'Registrar', NULL, NULL, 1, 1, 0, 1, -1, -1, NULL, NULL);
INSERT INTO `methods` VALUES (2, 'lista', 'Lista', NULL, NULL, 1, 1, 0, 1, -1, -1, NULL, NULL);
INSERT INTO `methods` VALUES (3, 'registrarBd', NULL, NULL, NULL, 1, 0, 0, 1, -1, -1, NULL, NULL);
INSERT INTO `methods` VALUES (4, 'activarBd', NULL, 'Activar', 'fas fa-play', 1, 0, 1, 1, -1, -1, NULL, NULL);
INSERT INTO `methods` VALUES (5, 'desactivarBd', NULL, 'Desactivar', 'fas fa-pause', 1, 0, 1, 1, -1, -1, NULL, NULL);
INSERT INTO `methods` VALUES (6, 'modificar', NULL, 'Modificar', 'fas fa-pencil-alt', 1, 0, 1, 1, -1, -1, NULL, NULL);
INSERT INTO `methods` VALUES (7, 'eliminarBd', NULL, 'Eliminar', 'fas fa-trash', 1, 0, 1, 1, -1, -1, NULL, NULL);
INSERT INTO `methods` VALUES (8, 'modificarBd', NULL, NULL, NULL, 1, 0, 0, 1, -1, -1, NULL, NULL);
INSERT INTO `methods` VALUES (9, 'registrar', 'Registrar', NULL, NULL, 2, 1, 0, 1, -1, -1, NULL, NULL);
INSERT INTO `methods` VALUES (10, 'lista', 'Lista', NULL, NULL, 2, 1, 0, 1, -1, -1, NULL, NULL);
INSERT INTO `methods` VALUES (11, 'registrarBd', NULL, NULL, NULL, 2, 0, 0, 1, -1, -1, NULL, NULL);
INSERT INTO `methods` VALUES (12, 'activarBd', NULL, 'Activar', 'fas fa-play', 2, 0, 1, 1, -1, -1, NULL, NULL);
INSERT INTO `methods` VALUES (13, 'desactivarBd', NULL, 'Desactivar', 'fas fa-pause', 2, 0, 1, 1, -1, -1, NULL, NULL);
INSERT INTO `methods` VALUES (14, 'modificar', NULL, 'Modificar', 'fas fa-pencil-alt', 2, 0, 1, 1, -1, -1, NULL, NULL);
INSERT INTO `methods` VALUES (15, 'eliminarBd', NULL, 'Eliminar', 'fas fa-trash', 2, 0, 1, 1, -1, -1, NULL, NULL);
INSERT INTO `methods` VALUES (16, 'modificarBd', NULL, NULL, NULL, 2, 0, 0, 1, -1, -1, NULL, NULL);
INSERT INTO `methods` VALUES (17, 'permisos', NULL, 'Asigna Permisos', 'fas fa-plus-square', 3, 0, 1, 1, -1, -1, NULL, NULL);
INSERT INTO `methods` VALUES (18, 'bajaPermiso', NULL, NULL, NULL, 3, 0, 0, 1, -1, -1, NULL, NULL);
INSERT INTO `methods` VALUES (19, 'altaPermiso', NULL, NULL, NULL, 3, 0, 0, 1, -1, -1, NULL, NULL);
INSERT INTO `methods` VALUES (20, 'registrar', 'Registrar', NULL, NULL, 3, 1, 0, 1, -1, -1, NULL, NULL);
INSERT INTO `methods` VALUES (21, 'lista', 'Lista', NULL, NULL, 3, 1, 0, 1, -1, -1, NULL, NULL);
INSERT INTO `methods` VALUES (22, 'registrarBd', NULL, NULL, NULL, 3, 0, 0, 1, -1, -1, NULL, NULL);
INSERT INTO `methods` VALUES (23, 'activarBd', NULL, 'Activar', 'fas fa-play', 3, 0, 1, 1, -1, -1, NULL, NULL);
INSERT INTO `methods` VALUES (24, 'desactivarBd', NULL, 'Desactivar', 'fas fa-pause', 3, 0, 1, 1, -1, -1, NULL, NULL);
INSERT INTO `methods` VALUES (25, 'modificar', NULL, 'Modificar', 'fas fa-pencil-alt', 3, 0, 1, 1, -1, -1, NULL, NULL);
INSERT INTO `methods` VALUES (26, 'eliminarBd', NULL, 'Eliminar', 'fas fa-trash', 3, 0, 1, 1, -1, -1, NULL, NULL);
INSERT INTO `methods` VALUES (27, 'modificarBd', NULL, NULL, NULL, 3, 0, 0, 1, -1, -1, NULL, NULL);
INSERT INTO `methods` VALUES (28, 'nuevaContra', NULL, 'Cambiar contraseña', 'fas fa-key', 4, 0, 1, 1, -1, -1, NULL, NULL);
INSERT INTO `methods` VALUES (29, 'nuevaContraBd', NULL, NULL, NULL, 4, 0, 0, 1, -1, -1, NULL, NULL);
INSERT INTO `methods` VALUES (30, 'registrar', 'Registrar', NULL, NULL, 4, 1, 0, 1, -1, -1, NULL, NULL);
INSERT INTO `methods` VALUES (31, 'lista', 'Lista', NULL, NULL, 4, 1, 0, 1, -1, -1, NULL, NULL);
INSERT INTO `methods` VALUES (32, 'registrarBd', NULL, NULL, NULL, 4, 0, 0, 1, -1, -1, NULL, NULL);
INSERT INTO `methods` VALUES (33, 'activarBd', NULL, 'Activar', 'fas fa-play', 4, 0, 1, 1, -1, -1, NULL, NULL);
INSERT INTO `methods` VALUES (34, 'desactivarBd', NULL, 'Desactivar', 'fas fa-pause', 4, 0, 1, 1, -1, -1, NULL, NULL);
INSERT INTO `methods` VALUES (35, 'modificar', NULL, 'Modificar', 'fas fa-pencil-alt', 4, 0, 1, 1, -1, -1, NULL, NULL);
INSERT INTO `methods` VALUES (36, 'eliminarBd', NULL, 'Eliminar', 'fas fa-trash', 4, 0, 1, 1, -1, -1, NULL, NULL);
INSERT INTO `methods` VALUES (37, 'modificarBd', NULL, NULL, NULL, 4, 0, 0, 1, -1, -1, NULL, NULL);
INSERT INTO `methods` VALUES (38, 'nuevaContra', '', 'Cambiar contraseña', 'fas fa-key', 5, 0, 1, 1, -1, -1, NULL, NULL);
INSERT INTO `methods` VALUES (39, 'nuevaContraBd', '', '', '', 5, 0, 0, 1, -1, -1, NULL, NULL);
INSERT INTO `methods` VALUES (40, 'registrar', 'Registrar', '', '', 5, 1, 0, 1, -1, -1, NULL, NULL);
INSERT INTO `methods` VALUES (41, 'lista', 'Lista', '', '', 5, 1, 0, 1, -1, -1, NULL, NULL);
INSERT INTO `methods` VALUES (42, 'registrarBd', '', '', '', 5, 0, 0, 1, -1, -1, NULL, NULL);
INSERT INTO `methods` VALUES (43, 'activarBd', '', 'Activar', 'fas fa-play', 5, 0, 1, 1, -1, -1, NULL, NULL);
INSERT INTO `methods` VALUES (44, 'desactivarBd', '', 'Desactivar', 'fas fa-pause', 5, 0, 1, 1, -1, -1, NULL, NULL);
INSERT INTO `methods` VALUES (45, 'modificar', '', 'Modificar', 'fas fa-pencil-alt', 5, 0, 1, 1, -1, -1, NULL, NULL);
INSERT INTO `methods` VALUES (46, 'eliminarBd', '', 'Eliminar', 'fas fa-trash', 5, 0, 1, 1, -1, -1, NULL, NULL);
INSERT INTO `methods` VALUES (47, 'modificarBd', '', '', '', 5, 0, 0, 1, -1, -1, NULL, NULL);

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
  CONSTRAINT `sessions_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = COMPACT;

-- ----------------------------
-- Records of sessions
-- ----------------------------

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
) ENGINE = InnoDB AUTO_INCREMENT = 3 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = COMPACT;

-- ----------------------------
-- Records of users
-- ----------------------------
INSERT INTO `users` VALUES (1, 'admin', 'ed76e9ebfe90e6affbd3cbcb6a9a5f60', 'Ricardo', 'Rivera Sanchez', 'desarrollo@ingrivera.com', 1, 1, -1, -1, NULL, NULL);
INSERT INTO `users` VALUES (2, 'adminn', 'ed76e9ebfe90e6affbd3cbcb6a9a5f60', 'Ricardo', 'Rivera Sanchez', 'ricardo@ingrivera.com', 2, 1, -1, -1, NULL, NULL);

SET FOREIGN_KEY_CHECKS = 1;
