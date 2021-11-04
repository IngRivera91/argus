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

 Date: 04/11/2021 15:53:13
*/

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
-- Table structure for groups
-- ----------------------------
DROP TABLE IF EXISTS `groups`;
CREATE TABLE `groups`  (
  `id` bigint(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `activo` tinyint(11) NULL DEFAULT 1,
  `created_user_id` bigint(11) NULL DEFAULT NULL,
  `updated_user_id` bigint(11) NULL DEFAULT NULL,
  `created_at` timestamp(0) NULL DEFAULT CURRENT_TIMESTAMP(0),
  `updated_at` timestamp(0) NULL DEFAULT CURRENT_TIMESTAMP(0) ON UPDATE CURRENT_TIMESTAMP(0),
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 2 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = COMPACT;

-- ----------------------------
-- Records of groups
-- ----------------------------
INSERT INTO `groups` VALUES (1, 'Programador', 1, NULL, NULL, '2021-11-04 15:51:29', '2021-11-04 15:51:29');

-- ----------------------------
-- Table structure for grupos
-- ----------------------------
DROP TABLE IF EXISTS `grupos`;
CREATE TABLE `grupos`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `activo` tinyint(11) NULL DEFAULT 0,
  `usuario_registro_id` int(11) NULL DEFAULT NULL,
  `usuario_actualizacion_id` int(11) NULL DEFAULT NULL,
  `fecha_registro` timestamp(0) NULL DEFAULT CURRENT_TIMESTAMP(0),
  `fecha_actualizacion` timestamp(0) NULL DEFAULT CURRENT_TIMESTAMP(0) ON UPDATE CURRENT_TIMESTAMP(0),
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 2 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = COMPACT;

-- ----------------------------
-- Records of grupos
-- ----------------------------
INSERT INTO `grupos` VALUES (1, 'programador', 1, -1, -1, '2021-10-28 22:53:57', '2021-10-28 22:53:57');

-- ----------------------------
-- Table structure for menus
-- ----------------------------
DROP TABLE IF EXISTS `menus`;
CREATE TABLE `menus`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `etiqueta` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `icono` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `activo` tinyint(11) NULL DEFAULT NULL,
  `usuario_registro_id` int(11) NULL DEFAULT NULL,
  `usuario_actualizacion_id` int(11) NULL DEFAULT NULL,
  `fecha_registro` timestamp(0) NULL DEFAULT CURRENT_TIMESTAMP(0),
  `fecha_actualizacion` timestamp(0) NULL DEFAULT CURRENT_TIMESTAMP(0) ON UPDATE CURRENT_TIMESTAMP(0),
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 5 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = COMPACT;

-- ----------------------------
-- Records of menus
-- ----------------------------
INSERT INTO `menus` VALUES (1, 'menus', 'MENUS', 'fas fa-th-list', 1, -1, -1, '2021-10-28 22:53:57', '2021-10-28 22:53:57');
INSERT INTO `menus` VALUES (2, 'metodos', 'METODOS', 'fas fa-list-ul', 1, -1, -1, '2021-10-28 22:53:57', '2021-10-28 22:53:57');
INSERT INTO `menus` VALUES (3, 'grupos', 'GRUPOS', 'fas fa-users-cog', 1, -1, -1, '2021-10-28 22:53:57', '2021-10-28 22:53:57');
INSERT INTO `menus` VALUES (4, 'usuarios', 'USUARIOS', 'fas fa-users', 1, -1, -1, '2021-10-28 22:53:57', '2021-10-28 22:53:57');

-- ----------------------------
-- Table structure for metodos
-- ----------------------------
DROP TABLE IF EXISTS `metodos`;
CREATE TABLE `metodos`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `etiqueta` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `accion` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `icono` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `menu_id` int(11) NULL DEFAULT NULL,
  `activo_menu` tinyint(11) NULL DEFAULT NULL,
  `activo_accion` tinyint(11) NULL DEFAULT NULL,
  `activo` tinyint(11) NULL DEFAULT NULL,
  `usuario_registro_id` int(11) NULL DEFAULT NULL,
  `usuario_actualizacion_id` int(11) NULL DEFAULT NULL,
  `fecha_registro` timestamp(0) NULL DEFAULT CURRENT_TIMESTAMP(0),
  `fecha_actualizacion` timestamp(0) NULL DEFAULT CURRENT_TIMESTAMP(0) ON UPDATE CURRENT_TIMESTAMP(0),
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE INDEX `nombre`(`nombre`, `menu_id`) USING BTREE,
  INDEX `menu_id`(`menu_id`) USING BTREE,
  CONSTRAINT `metodos_ibfk_1` FOREIGN KEY (`menu_id`) REFERENCES `menus` (`id`) ON DELETE RESTRICT ON UPDATE CASCADE
) ENGINE = InnoDB AUTO_INCREMENT = 39 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = COMPACT;

-- ----------------------------
-- Records of metodos
-- ----------------------------
INSERT INTO `metodos` VALUES (1, 'nuevaContra', '', 'Cambiar contraseña', 'fas fa-key', 4, 0, 1, 1, -1, -1, '2021-10-28 22:53:57', '2021-10-28 22:53:57');
INSERT INTO `metodos` VALUES (2, 'nuevaContraBd', '', '', '', 4, 0, 0, 1, -1, -1, '2021-10-28 22:53:57', '2021-10-28 22:53:57');
INSERT INTO `metodos` VALUES (3, 'permisos', '', 'Asigna Permisos', 'fas fa-plus-square', 3, 0, 1, 1, -1, -1, '2021-10-28 22:53:57', '2021-10-28 22:53:57');
INSERT INTO `metodos` VALUES (4, 'bajaPermiso', '', '', '', 3, 0, 0, 1, -1, -1, '2021-10-28 22:53:57', '2021-10-28 22:53:57');
INSERT INTO `metodos` VALUES (5, 'altaPermiso', '', '', '', 3, 0, 0, 1, -1, -1, '2021-10-28 22:53:57', '2021-10-28 22:53:57');
INSERT INTO `metodos` VALUES (6, 'registrar', 'Registrar', '', '', 1, 1, 0, 1, -1, -1, '2021-10-28 22:53:57', '2021-10-28 22:53:57');
INSERT INTO `metodos` VALUES (7, 'lista', 'Lista', '', '', 1, 1, 0, 1, -1, -1, '2021-10-28 22:53:57', '2021-10-28 22:53:57');
INSERT INTO `metodos` VALUES (8, 'registrarBd', '', '', '', 1, 0, 0, 1, -1, -1, '2021-10-28 22:53:57', '2021-10-28 22:53:57');
INSERT INTO `metodos` VALUES (9, 'activarBd', '', 'Activar', 'fas fa-play', 1, 0, 1, 1, -1, -1, '2021-10-28 22:53:57', '2021-10-28 22:53:57');
INSERT INTO `metodos` VALUES (10, 'desactivarBd', '', 'Desactivar', 'fas fa-pause', 1, 0, 1, 1, -1, -1, '2021-10-28 22:53:57', '2021-10-28 22:53:57');
INSERT INTO `metodos` VALUES (11, 'modificar', '', 'Modificar', 'fas fa-pencil-alt', 1, 0, 1, 1, -1, -1, '2021-10-28 22:53:57', '2021-10-28 22:53:57');
INSERT INTO `metodos` VALUES (12, 'eliminarBd', '', 'Eliminar', 'fas fa-trash', 1, 0, 1, 1, -1, -1, '2021-10-28 22:53:57', '2021-10-28 22:53:57');
INSERT INTO `metodos` VALUES (13, 'modificarBd', '', '', '', 1, 0, 0, 1, -1, -1, '2021-10-28 22:53:57', '2021-10-28 22:53:57');
INSERT INTO `metodos` VALUES (14, 'registrar', 'Registrar', '', '', 2, 1, 0, 1, -1, -1, '2021-10-28 22:53:57', '2021-10-28 22:53:57');
INSERT INTO `metodos` VALUES (15, 'lista', 'Lista', '', '', 2, 1, 0, 1, -1, -1, '2021-10-28 22:53:57', '2021-10-28 22:53:57');
INSERT INTO `metodos` VALUES (16, 'registrarBd', '', '', '', 2, 0, 0, 1, -1, -1, '2021-10-28 22:53:57', '2021-10-28 22:53:57');
INSERT INTO `metodos` VALUES (17, 'activarBd', '', 'Activar', 'fas fa-play', 2, 0, 1, 1, -1, -1, '2021-10-28 22:53:57', '2021-10-28 22:53:57');
INSERT INTO `metodos` VALUES (18, 'desactivarBd', '', 'Desactivar', 'fas fa-pause', 2, 0, 1, 1, -1, -1, '2021-10-28 22:53:57', '2021-10-28 22:53:57');
INSERT INTO `metodos` VALUES (19, 'modificar', '', 'Modificar', 'fas fa-pencil-alt', 2, 0, 1, 1, -1, -1, '2021-10-28 22:53:57', '2021-10-28 22:53:57');
INSERT INTO `metodos` VALUES (20, 'eliminarBd', '', 'Eliminar', 'fas fa-trash', 2, 0, 1, 1, -1, -1, '2021-10-28 22:53:57', '2021-10-28 22:53:57');
INSERT INTO `metodos` VALUES (21, 'modificarBd', '', '', '', 2, 0, 0, 1, -1, -1, '2021-10-28 22:53:57', '2021-10-28 22:53:57');
INSERT INTO `metodos` VALUES (22, 'registrar', 'Registrar', '', '', 3, 1, 0, 1, -1, -1, '2021-10-28 22:53:57', '2021-10-28 22:53:57');
INSERT INTO `metodos` VALUES (23, 'lista', 'Lista', '', '', 3, 1, 0, 1, -1, -1, '2021-10-28 22:53:57', '2021-10-28 22:53:57');
INSERT INTO `metodos` VALUES (24, 'registrarBd', '', '', '', 3, 0, 0, 1, -1, -1, '2021-10-28 22:53:57', '2021-10-28 22:53:57');
INSERT INTO `metodos` VALUES (25, 'activarBd', '', 'Activar', 'fas fa-play', 3, 0, 1, 1, -1, -1, '2021-10-28 22:53:57', '2021-10-28 22:53:57');
INSERT INTO `metodos` VALUES (26, 'desactivarBd', '', 'Desactivar', 'fas fa-pause', 3, 0, 1, 1, -1, -1, '2021-10-28 22:53:57', '2021-10-28 22:53:57');
INSERT INTO `metodos` VALUES (27, 'modificar', '', 'Modificar', 'fas fa-pencil-alt', 3, 0, 1, 1, -1, -1, '2021-10-28 22:53:57', '2021-10-28 22:53:57');
INSERT INTO `metodos` VALUES (28, 'eliminarBd', '', 'Eliminar', 'fas fa-trash', 3, 0, 1, 1, -1, -1, '2021-10-28 22:53:57', '2021-10-28 22:53:57');
INSERT INTO `metodos` VALUES (29, 'modificarBd', '', '', '', 3, 0, 0, 1, -1, -1, '2021-10-28 22:53:57', '2021-10-28 22:53:57');
INSERT INTO `metodos` VALUES (30, 'registrar', 'Registrar', '', '', 4, 1, 0, 1, -1, -1, '2021-10-28 22:53:57', '2021-10-28 22:53:57');
INSERT INTO `metodos` VALUES (31, 'lista', 'Lista', '', '', 4, 1, 0, 1, -1, -1, '2021-10-28 22:53:57', '2021-10-28 22:53:57');
INSERT INTO `metodos` VALUES (32, 'registrarBd', '', '', '', 4, 0, 0, 1, -1, -1, '2021-10-28 22:53:57', '2021-10-28 22:53:57');
INSERT INTO `metodos` VALUES (33, 'activarBd', '', 'Activar', 'fas fa-play', 4, 0, 1, 1, -1, -1, '2021-10-28 22:53:57', '2021-10-28 22:53:57');
INSERT INTO `metodos` VALUES (34, 'desactivarBd', '', 'Desactivar', 'fas fa-pause', 4, 0, 1, 1, -1, -1, '2021-10-28 22:53:57', '2021-10-28 22:53:57');
INSERT INTO `metodos` VALUES (35, 'modificar', '', 'Modificar', 'fas fa-pencil-alt', 4, 0, 1, 1, -1, -1, '2021-10-28 22:53:57', '2021-10-28 22:53:57');
INSERT INTO `metodos` VALUES (36, 'eliminarBd', '', 'Eliminar', 'fas fa-trash', 4, 0, 1, 1, -1, -1, '2021-10-28 22:53:57', '2021-10-28 22:53:57');
INSERT INTO `metodos` VALUES (37, 'modificarBd', '', '', '', 4, 0, 0, 1, -1, -1, '2021-10-28 22:53:57', '2021-10-28 22:53:57');
INSERT INTO `metodos` VALUES (38, '', '', '', '', 1, 0, 0, 1, -1, -1, '2021-10-28 22:53:57', '2021-10-28 22:53:57');

-- ----------------------------
-- Table structure for metodosgrupos
-- ----------------------------
DROP TABLE IF EXISTS `metodosgrupos`;
CREATE TABLE `metodosgrupos`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `metodo_id` int(11) NULL DEFAULT NULL,
  `grupo_id` int(11) NULL DEFAULT NULL,
  `activo` tinyint(11) NULL DEFAULT NULL,
  `usuario_registro_id` int(11) NULL DEFAULT NULL,
  `usuario_actualizacion_id` int(11) NULL DEFAULT NULL,
  `fecha_registro` timestamp(0) NULL DEFAULT CURRENT_TIMESTAMP(0),
  `fecha_actualizacion` timestamp(0) NULL DEFAULT CURRENT_TIMESTAMP(0) ON UPDATE CURRENT_TIMESTAMP(0),
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE INDEX `permiso`(`grupo_id`, `metodo_id`) USING BTREE,
  INDEX `metodo_id`(`metodo_id`) USING BTREE,
  INDEX `grupo_id`(`grupo_id`) USING BTREE,
  CONSTRAINT `metodo_grupo_ibfk_1` FOREIGN KEY (`metodo_id`) REFERENCES `metodos` (`id`) ON DELETE RESTRICT ON UPDATE CASCADE,
  CONSTRAINT `metodo_grupo_ibfk_2` FOREIGN KEY (`grupo_id`) REFERENCES `grupos` (`id`) ON DELETE RESTRICT ON UPDATE CASCADE
) ENGINE = InnoDB AUTO_INCREMENT = 38 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = COMPACT;

-- ----------------------------
-- Records of metodosgrupos
-- ----------------------------
INSERT INTO `metodosgrupos` VALUES (1, 1, 1, 1, NULL, NULL, '2021-10-28 22:53:57', '2021-10-28 22:53:57');
INSERT INTO `metodosgrupos` VALUES (2, 2, 1, 1, NULL, NULL, '2021-10-28 22:53:57', '2021-10-28 22:53:57');
INSERT INTO `metodosgrupos` VALUES (3, 3, 1, 1, NULL, NULL, '2021-10-28 22:53:57', '2021-10-28 22:53:57');
INSERT INTO `metodosgrupos` VALUES (4, 4, 1, 1, NULL, NULL, '2021-10-28 22:53:57', '2021-10-28 22:53:57');
INSERT INTO `metodosgrupos` VALUES (5, 5, 1, 1, NULL, NULL, '2021-10-28 22:53:57', '2021-10-28 22:53:57');
INSERT INTO `metodosgrupos` VALUES (6, 6, 1, 1, NULL, NULL, '2021-10-28 22:53:57', '2021-10-28 22:53:57');
INSERT INTO `metodosgrupos` VALUES (7, 7, 1, 1, NULL, NULL, '2021-10-28 22:53:57', '2021-10-28 22:53:57');
INSERT INTO `metodosgrupos` VALUES (8, 8, 1, 1, NULL, NULL, '2021-10-28 22:53:57', '2021-10-28 22:53:57');
INSERT INTO `metodosgrupos` VALUES (9, 9, 1, 1, NULL, NULL, '2021-10-28 22:53:57', '2021-10-28 22:53:57');
INSERT INTO `metodosgrupos` VALUES (10, 10, 1, 1, NULL, NULL, '2021-10-28 22:53:57', '2021-10-28 22:53:57');
INSERT INTO `metodosgrupos` VALUES (11, 11, 1, 1, NULL, NULL, '2021-10-28 22:53:57', '2021-10-28 22:53:57');
INSERT INTO `metodosgrupos` VALUES (12, 12, 1, 1, NULL, NULL, '2021-10-28 22:53:57', '2021-10-28 22:53:57');
INSERT INTO `metodosgrupos` VALUES (13, 13, 1, 1, NULL, NULL, '2021-10-28 22:53:57', '2021-10-28 22:53:57');
INSERT INTO `metodosgrupos` VALUES (14, 14, 1, 1, NULL, NULL, '2021-10-28 22:53:57', '2021-10-28 22:53:57');
INSERT INTO `metodosgrupos` VALUES (15, 15, 1, 1, NULL, NULL, '2021-10-28 22:53:57', '2021-10-28 22:53:57');
INSERT INTO `metodosgrupos` VALUES (16, 16, 1, 1, NULL, NULL, '2021-10-28 22:53:57', '2021-10-28 22:53:57');
INSERT INTO `metodosgrupos` VALUES (17, 17, 1, 1, NULL, NULL, '2021-10-28 22:53:57', '2021-10-28 22:53:57');
INSERT INTO `metodosgrupos` VALUES (18, 18, 1, 1, NULL, NULL, '2021-10-28 22:53:57', '2021-10-28 22:53:57');
INSERT INTO `metodosgrupos` VALUES (19, 19, 1, 1, NULL, NULL, '2021-10-28 22:53:57', '2021-10-28 22:53:57');
INSERT INTO `metodosgrupos` VALUES (20, 20, 1, 1, NULL, NULL, '2021-10-28 22:53:57', '2021-10-28 22:53:57');
INSERT INTO `metodosgrupos` VALUES (21, 21, 1, 1, NULL, NULL, '2021-10-28 22:53:57', '2021-10-28 22:53:57');
INSERT INTO `metodosgrupos` VALUES (22, 22, 1, 1, NULL, NULL, '2021-10-28 22:53:57', '2021-10-28 22:53:57');
INSERT INTO `metodosgrupos` VALUES (23, 23, 1, 1, NULL, NULL, '2021-10-28 22:53:57', '2021-10-28 22:53:57');
INSERT INTO `metodosgrupos` VALUES (24, 24, 1, 1, NULL, NULL, '2021-10-28 22:53:57', '2021-10-28 22:53:57');
INSERT INTO `metodosgrupos` VALUES (25, 25, 1, 1, NULL, NULL, '2021-10-28 22:53:57', '2021-10-28 22:53:57');
INSERT INTO `metodosgrupos` VALUES (26, 26, 1, 1, NULL, NULL, '2021-10-28 22:53:57', '2021-10-28 22:53:57');
INSERT INTO `metodosgrupos` VALUES (27, 27, 1, 1, NULL, NULL, '2021-10-28 22:53:57', '2021-10-28 22:53:57');
INSERT INTO `metodosgrupos` VALUES (28, 28, 1, 1, NULL, NULL, '2021-10-28 22:53:57', '2021-10-28 22:53:57');
INSERT INTO `metodosgrupos` VALUES (29, 29, 1, 1, NULL, NULL, '2021-10-28 22:53:57', '2021-10-28 22:53:57');
INSERT INTO `metodosgrupos` VALUES (30, 30, 1, 1, NULL, NULL, '2021-10-28 22:53:57', '2021-10-28 22:53:57');
INSERT INTO `metodosgrupos` VALUES (31, 31, 1, 1, NULL, NULL, '2021-10-28 22:53:57', '2021-10-28 22:53:57');
INSERT INTO `metodosgrupos` VALUES (32, 32, 1, 1, NULL, NULL, '2021-10-28 22:53:57', '2021-10-28 22:53:57');
INSERT INTO `metodosgrupos` VALUES (33, 33, 1, 1, NULL, NULL, '2021-10-28 22:53:57', '2021-10-28 22:53:57');
INSERT INTO `metodosgrupos` VALUES (34, 34, 1, 1, NULL, NULL, '2021-10-28 22:53:57', '2021-10-28 22:53:57');
INSERT INTO `metodosgrupos` VALUES (35, 35, 1, 1, NULL, NULL, '2021-10-28 22:53:57', '2021-10-28 22:53:57');
INSERT INTO `metodosgrupos` VALUES (36, 36, 1, 1, NULL, NULL, '2021-10-28 22:53:57', '2021-10-28 22:53:57');
INSERT INTO `metodosgrupos` VALUES (37, 37, 1, 1, NULL, NULL, '2021-10-28 22:53:57', '2021-10-28 22:53:57');

-- ----------------------------
-- Table structure for sessiones
-- ----------------------------
DROP TABLE IF EXISTS `sessiones`;
CREATE TABLE `sessiones`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `session_id` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `usuario_id` int(11) NULL DEFAULT NULL,
  `activo` tinyint(11) NULL DEFAULT NULL,
  `usuario_registro_id` int(11) NULL DEFAULT NULL,
  `usuario_actualizacion_id` int(11) NULL DEFAULT NULL,
  `fecha_registro` timestamp(0) NULL DEFAULT CURRENT_TIMESTAMP(0),
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `usuario_id`(`usuario_id`) USING BTREE,
  CONSTRAINT `sessiones_ibfk_1` FOREIGN KEY (`usuario_id`) REFERENCES `usuarios` (`id`) ON DELETE SET NULL ON UPDATE CASCADE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = COMPACT;

-- ----------------------------
-- Records of sessiones
-- ----------------------------

-- ----------------------------
-- Table structure for sessions
-- ----------------------------
DROP TABLE IF EXISTS `sessions`;
CREATE TABLE `sessions`  (
  `session_id` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `user_id` bigint(20) NOT NULL,
  `created_at` timestamp(0) NULL DEFAULT CURRENT_TIMESTAMP(0),
  `updated_at` timestamp(0) NULL DEFAULT NULL,
  INDEX `user_id`(`user_id`) USING BTREE,
  CONSTRAINT `sessions_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE RESTRICT ON UPDATE CASCADE
) ENGINE = InnoDB CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = COMPACT;

-- ----------------------------
-- Records of sessions
-- ----------------------------
INSERT INTO `sessions` VALUES ('6b42b74e76d4a14a0929a04bbd8d7e95', 1, '2021-11-04 15:29:57', '2021-11-04 15:29:57');
INSERT INTO `sessions` VALUES ('6f05bf719b517dda70cfc92f3452f098', 1, '2021-11-04 15:30:14', '2021-11-04 15:30:14');
INSERT INTO `sessions` VALUES ('a5c76c8b96f9c66ab038f115f00a39b2', 1, '2021-11-04 15:30:16', '2021-11-04 15:30:16');
INSERT INTO `sessions` VALUES ('07082fe204b984e6fb5c7d42cbdcc074', 1, '2021-11-04 15:31:40', '2021-11-04 15:31:40');
INSERT INTO `sessions` VALUES ('4ec8d067636636205ee2949ba4b4b5c6', 1, '2021-11-04 15:35:06', '2021-11-04 15:35:06');

-- ----------------------------
-- Table structure for users
-- ----------------------------
DROP TABLE IF EXISTS `users`;
CREATE TABLE `users`  (
  `id` bigint(11) NOT NULL AUTO_INCREMENT,
  `user` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `password` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `name` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `last_name` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `email` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `group_id` bigint(11) NULL DEFAULT NULL,
  `activo` tinyint(11) NULL DEFAULT 0,
  `created_user_id` bigint(11) NULL DEFAULT NULL,
  `updated_user_id` bigint(11) NULL DEFAULT NULL,
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

-- ----------------------------
-- Table structure for usuarios
-- ----------------------------
DROP TABLE IF EXISTS `usuarios`;
CREATE TABLE `usuarios`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `usuario` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `password` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `nombre_completo` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `correo_electronico` varchar(200) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `grupo_id` int(11) NOT NULL,
  `activo` tinyint(11) NULL DEFAULT NULL,
  `usuario_registro_id` int(11) NULL DEFAULT NULL,
  `usuario_actualizacion_id` int(11) NULL DEFAULT NULL,
  `created_at` timestamp(0) NULL DEFAULT CURRENT_TIMESTAMP(0),
  `updated_at` timestamp(0) NULL DEFAULT CURRENT_TIMESTAMP(0) ON UPDATE CURRENT_TIMESTAMP(0),
  `group_id` int(11) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE INDEX `user`(`usuario`) USING BTREE,
  UNIQUE INDEX `email`(`correo_electronico`) USING BTREE,
  INDEX `grupo_id`(`grupo_id`) USING BTREE,
  INDEX `usuario_alta_id`(`usuario_registro_id`) USING BTREE,
  INDEX `usuario_update_id`(`usuario_actualizacion_id`) USING BTREE,
  CONSTRAINT `usuarios_ibfk_1` FOREIGN KEY (`grupo_id`) REFERENCES `grupos` (`id`) ON DELETE RESTRICT ON UPDATE CASCADE
) ENGINE = InnoDB AUTO_INCREMENT = 2 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = COMPACT;

-- ----------------------------
-- Records of usuarios
-- ----------------------------
INSERT INTO `usuarios` VALUES (1, 'admin', '4b3626865dc6d5cfe1c60b855e68634a', 'programador', 'master@argus.com', 1, 1, -1, -1, '2021-10-28 22:53:57', '2021-10-28 22:53:57', NULL);

SET FOREIGN_KEY_CHECKS = 1;
