/*
 Navicat Premium Data Transfer

 Source Server         : localhost
 Source Server Type    : MySQL
 Source Server Version : 50724
 Source Host           : localhost:3306
 Source Schema         : framework2

 Target Server Type    : MySQL
 Target Server Version : 50724
 File Encoding         : 65001

 Date: 26/04/2020 22:09:44
*/

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
-- Table structure for grupos
-- ----------------------------
DROP TABLE IF EXISTS `grupos`;
CREATE TABLE `grupos`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `descripcion_grupo` varchar(200) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `status` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT 'inactivo',
  `usuario_alta_id` int(11) NULL DEFAULT NULL,
  `usuario_update_id` int(11) NULL DEFAULT NULL,
  `fecha_alta` timestamp(0) NULL DEFAULT CURRENT_TIMESTAMP,
  `fecha_update` timestamp(0) NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP(0),
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `descripcion`(`descripcion_grupo`) USING BTREE,
  INDEX `id`(`id`) USING BTREE,
  INDEX `grupo_ibfk_1`(`usuario_alta_id`) USING BTREE,
  INDEX `usuario_update_id`(`usuario_update_id`) USING BTREE,
  CONSTRAINT `grupos_ibfk_1` FOREIGN KEY (`usuario_alta_id`) REFERENCES `usuarios` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  CONSTRAINT `grupos_ibfk_2` FOREIGN KEY (`usuario_update_id`) REFERENCES `usuarios` (`id`) ON DELETE SET NULL ON UPDATE CASCADE
) ENGINE = InnoDB AUTO_INCREMENT = 3 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Records of grupos
-- ----------------------------
INSERT INTO `grupos` VALUES (1, 'Programador', 'activo', 1, 1, '2019-11-16 00:20:16', '2020-04-24 20:03:33');
INSERT INTO `grupos` VALUES (2, 'Administrador', 'activo', 1, 1, '2019-12-22 19:12:04', '2020-04-24 21:26:41');

-- ----------------------------
-- Table structure for menus
-- ----------------------------
DROP TABLE IF EXISTS `menus`;
CREATE TABLE `menus`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `descripcion_menu` varchar(200) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `label_menu` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `icon_menu` varchar(200) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `status` varchar(200) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT 'inactivo',
  `usuario_alta_id` int(11) NULL DEFAULT NULL,
  `usuario_update_id` int(11) NULL DEFAULT NULL,
  `fecha_alta` timestamp(0) NULL DEFAULT CURRENT_TIMESTAMP,
  `fecha_update` timestamp(0) NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP(0),
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE INDEX `descripcion_menu`(`descripcion_menu`) USING BTREE,
  INDEX `usuario_alta_id`(`usuario_alta_id`) USING BTREE,
  INDEX `usuario_update_id`(`usuario_update_id`) USING BTREE,
  CONSTRAINT `menus_ibfk_1` FOREIGN KEY (`usuario_alta_id`) REFERENCES `usuarios` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  CONSTRAINT `menus_ibfk_2` FOREIGN KEY (`usuario_update_id`) REFERENCES `usuarios` (`id`) ON DELETE SET NULL ON UPDATE CASCADE
) ENGINE = InnoDB AUTO_INCREMENT = 8 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Records of menus
-- ----------------------------
INSERT INTO `menus` VALUES (1, 'session', ' ', ' ', 'activo', 1, 1, '2019-11-18 21:34:49', '2019-12-29 05:54:15');
INSERT INTO `menus` VALUES (2, 'usuarios', 'USUARIOS', 'fas fa-users', 'activo', 1, 1, '2019-11-18 16:05:19', '2020-04-18 22:26:41');
INSERT INTO `menus` VALUES (3, 'grupos', 'GRUPOS', 'fas fa-users-cog', 'activo', 1, 1, '2019-12-22 12:38:15', '2020-04-18 22:27:24');
INSERT INTO `menus` VALUES (6, 'menus', 'MENUS', 'fas fa-th-list', 'activo', 1, 1, '2019-12-28 22:12:18', '2020-04-18 22:29:43');
INSERT INTO `menus` VALUES (7, 'metodos', 'METODOS', 'fas fa-list-ul', 'activo', 1, 1, '2019-12-29 00:22:28', '2020-04-18 22:29:23');

-- ----------------------------
-- Table structure for metodo_grupo
-- ----------------------------
DROP TABLE IF EXISTS `metodo_grupo`;
CREATE TABLE `metodo_grupo`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `metodo_id` int(11) NULL DEFAULT NULL,
  `grupo_id` int(11) NULL DEFAULT NULL,
  `status` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT 'activo',
  `usuario_alta_id` int(11) NULL DEFAULT NULL,
  `usuario_update_id` int(11) NULL DEFAULT NULL,
  `fecha_alta` timestamp(0) NULL DEFAULT CURRENT_TIMESTAMP,
  `fecha_update` timestamp(0) NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP(0),
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `metodo_grupo_ibfk_1`(`metodo_id`) USING BTREE,
  INDEX `metodo_grupo_ibfk_2`(`grupo_id`) USING BTREE,
  INDEX `metodo_grupo_ibfk_3`(`usuario_alta_id`) USING BTREE,
  INDEX `metodo_grupo_ibfk_4`(`usuario_update_id`) USING BTREE,
  CONSTRAINT `metodo_grupo_ibfk_1` FOREIGN KEY (`metodo_id`) REFERENCES `metodos` (`id`) ON DELETE RESTRICT ON UPDATE CASCADE,
  CONSTRAINT `metodo_grupo_ibfk_2` FOREIGN KEY (`grupo_id`) REFERENCES `grupos` (`id`) ON DELETE RESTRICT ON UPDATE CASCADE,
  CONSTRAINT `metodo_grupo_ibfk_3` FOREIGN KEY (`usuario_alta_id`) REFERENCES `usuarios` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  CONSTRAINT `metodo_grupo_ibfk_4` FOREIGN KEY (`usuario_update_id`) REFERENCES `usuarios` (`id`) ON DELETE SET NULL ON UPDATE CASCADE
) ENGINE = InnoDB AUTO_INCREMENT = 104 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Redundant;

-- ----------------------------
-- Records of metodo_grupo
-- ----------------------------
INSERT INTO `metodo_grupo` VALUES (1, 1, 1, 'activo', 1, 1, '2019-11-18 21:39:12', '2019-12-20 22:43:41');
INSERT INTO `metodo_grupo` VALUES (4, 2, 1, 'activo', 1, 1, '2019-11-18 21:38:25', '2019-12-20 22:43:42');
INSERT INTO `metodo_grupo` VALUES (7, 3, 1, 'activo', 1, 1, '2019-11-18 16:50:34', '2019-12-20 22:43:42');
INSERT INTO `metodo_grupo` VALUES (9, 5, 1, 'activo', 1, 1, '2019-11-18 21:19:54', '2019-12-20 22:43:44');
INSERT INTO `metodo_grupo` VALUES (10, 6, 1, 'activo', 1, 1, '2019-11-21 00:23:12', '2019-12-20 22:43:45');
INSERT INTO `metodo_grupo` VALUES (12, 8, 1, 'activo', 1, 1, '2019-11-21 00:23:49', '2019-12-20 22:43:48');
INSERT INTO `metodo_grupo` VALUES (14, 10, 1, 'activo', 1, 1, '2019-12-22 12:46:15', '2019-12-22 12:46:15');
INSERT INTO `metodo_grupo` VALUES (15, 11, 1, 'activo', 1, 1, '2019-12-22 12:46:25', '2019-12-22 12:46:25');
INSERT INTO `metodo_grupo` VALUES (16, 12, 1, 'activo', 1, 1, '2019-12-22 12:46:34', '2019-12-22 12:46:34');
INSERT INTO `metodo_grupo` VALUES (18, 14, 1, 'activo', 1, 1, '2019-12-22 12:46:44', '2019-12-22 12:46:44');
INSERT INTO `metodo_grupo` VALUES (20, 16, 1, 'activo', 1, 1, '2019-12-22 13:58:48', '2019-12-22 13:58:48');
INSERT INTO `metodo_grupo` VALUES (21, 17, 1, 'activo', 1, 1, '2019-12-22 13:58:59', '2019-12-22 13:58:59');
INSERT INTO `metodo_grupo` VALUES (57, 1, 2, 'activo', 1, 1, '2019-12-23 04:03:03', '2019-12-23 04:03:03');
INSERT INTO `metodo_grupo` VALUES (58, 2, 2, 'activo', 1, 1, '2019-12-23 04:03:20', '2019-12-23 04:03:20');
INSERT INTO `metodo_grupo` VALUES (60, 37, 1, 'activo', 1, 1, '2019-12-28 22:19:28', '2019-12-28 22:19:28');
INSERT INTO `metodo_grupo` VALUES (62, 39, 1, 'activo', 1, 1, '2019-12-28 22:19:28', '2019-12-28 22:19:28');
INSERT INTO `metodo_grupo` VALUES (67, 45, 1, 'activo', 1, 1, '2019-12-29 00:25:08', '2019-12-29 00:25:08');
INSERT INTO `metodo_grupo` VALUES (68, 46, 1, 'activo', 1, 1, '2019-12-29 00:25:08', '2019-12-29 00:25:08');
INSERT INTO `metodo_grupo` VALUES (69, 47, 1, 'activo', 1, 1, '2019-12-29 00:25:08', '2019-12-29 00:25:08');
INSERT INTO `metodo_grupo` VALUES (70, 48, 1, 'activo', 1, 1, '2019-12-29 00:25:09', '2019-12-29 00:25:09');
INSERT INTO `metodo_grupo` VALUES (71, 49, 1, 'activo', 1, 1, '2019-12-29 00:25:09', '2019-12-29 00:25:09');
INSERT INTO `metodo_grupo` VALUES (72, 50, 1, 'activo', 1, 1, '2019-12-29 00:25:09', '2019-12-29 00:25:09');
INSERT INTO `metodo_grupo` VALUES (73, 51, 1, 'activo', 1, 1, '2019-12-29 00:25:09', '2019-12-29 00:25:09');
INSERT INTO `metodo_grupo` VALUES (74, 52, 1, 'activo', 1, 1, '2019-12-29 00:25:09', '2019-12-29 00:25:09');
INSERT INTO `metodo_grupo` VALUES (75, 53, 1, 'activo', 1, 1, '2020-01-03 02:10:46', '2020-01-03 02:10:46');
INSERT INTO `metodo_grupo` VALUES (77, 55, 1, 'activo', 1, 1, '2020-01-03 02:11:01', '2020-01-03 02:11:01');
INSERT INTO `metodo_grupo` VALUES (78, 18, 1, 'activo', 1, 1, '2020-04-24 20:56:58', '2020-04-24 20:56:58');
INSERT INTO `metodo_grupo` VALUES (79, 9, 1, 'activo', 1, 1, '2020-04-24 20:57:00', '2020-04-24 20:57:00');
INSERT INTO `metodo_grupo` VALUES (80, 19, 1, 'activo', 1, 1, '2020-04-24 20:57:03', '2020-04-24 20:57:03');
INSERT INTO `metodo_grupo` VALUES (81, 4, 1, 'activo', 1, 1, '2020-04-24 20:57:12', '2020-04-24 20:57:12');
INSERT INTO `metodo_grupo` VALUES (82, 7, 1, 'activo', 1, 1, '2020-04-24 20:57:44', '2020-04-24 20:57:44');
INSERT INTO `metodo_grupo` VALUES (83, 54, 1, 'activo', 1, 1, '2020-04-24 21:12:53', '2020-04-24 21:12:53');
INSERT INTO `metodo_grupo` VALUES (84, 13, 1, 'activo', 1, 1, '2020-04-24 21:13:10', '2020-04-24 21:13:10');
INSERT INTO `metodo_grupo` VALUES (95, 42, 1, 'activo', 1, 1, '2020-04-24 22:26:58', '2020-04-24 22:26:58');
INSERT INTO `metodo_grupo` VALUES (96, 40, 1, 'activo', 1, 1, '2020-04-24 22:26:59', '2020-04-24 22:26:59');
INSERT INTO `metodo_grupo` VALUES (97, 38, 1, 'activo', 1, 1, '2020-04-24 22:27:07', '2020-04-24 22:27:07');
INSERT INTO `metodo_grupo` VALUES (99, 41, 1, 'activo', 1, 1, '2020-04-24 22:27:10', '2020-04-24 22:27:10');
INSERT INTO `metodo_grupo` VALUES (100, 43, 1, 'activo', 1, 1, '2020-04-24 22:27:12', '2020-04-24 22:27:12');
INSERT INTO `metodo_grupo` VALUES (103, 36, 1, 'activo', 1, 1, '2020-04-24 22:55:17', '2020-04-24 22:55:17');

-- ----------------------------
-- Table structure for metodos
-- ----------------------------
DROP TABLE IF EXISTS `metodos`;
CREATE TABLE `metodos`  (
  `id` int(100) NOT NULL AUTO_INCREMENT,
  `descripcion_metodo` varchar(200) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `label_metodo` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `label_accion` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `icon_accion` varchar(200) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `status` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT 'activo',
  `status_menu` varchar(200) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT 'inactivo',
  `status_accion` varchar(200) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT 'inactivo',
  `menu_id` int(100) NULL DEFAULT NULL,
  `usuario_update_id` int(100) NULL DEFAULT NULL,
  `usuario_alta_id` int(100) NULL DEFAULT NULL,
  `fecha_alta` timestamp(0) NULL DEFAULT CURRENT_TIMESTAMP,
  `fecha_update` timestamp(0) NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP(0),
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE INDEX `id`(`id`) USING BTREE,
  UNIQUE INDEX `descripcion`(`descripcion_metodo`, `menu_id`) USING BTREE,
  INDEX `metodos_ibfk_1`(`menu_id`) USING BTREE,
  INDEX `metodos_ibfk_2`(`usuario_update_id`) USING BTREE,
  INDEX `metodos_ibfk_3`(`usuario_alta_id`) USING BTREE,
  CONSTRAINT `metodos_ibfk_1` FOREIGN KEY (`menu_id`) REFERENCES `menus` (`id`) ON DELETE RESTRICT ON UPDATE CASCADE,
  CONSTRAINT `metodos_ibfk_2` FOREIGN KEY (`usuario_update_id`) REFERENCES `usuarios` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  CONSTRAINT `metodos_ibfk_3` FOREIGN KEY (`usuario_alta_id`) REFERENCES `usuarios` (`id`) ON DELETE SET NULL ON UPDATE CASCADE
) ENGINE = InnoDB AUTO_INCREMENT = 56 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Redundant;

-- ----------------------------
-- Records of metodos
-- ----------------------------
INSERT INTO `metodos` VALUES (1, 'inicio', ' ', ' ', ' ', 'activo', 'inactivo', 'inactivo', 1, 1, 1, '2019-11-18 21:36:47', '2019-12-29 05:45:24');
INSERT INTO `metodos` VALUES (2, 'login_off', ' ', ' ', ' ', 'activo', 'inactivo', 'inactivo', 1, 1, 1, '2019-11-18 21:36:07', '2019-12-29 05:45:25');
INSERT INTO `metodos` VALUES (3, 'alta', 'Alta', ' ', ' ', 'activo', 'activo', 'inactivo', 2, 1, 1, '2019-11-18 16:48:00', '2019-12-29 05:45:26');
INSERT INTO `metodos` VALUES (4, 'lista', 'Lista', ' ', ' ', 'activo', 'activo', 'inactivo', 2, 1, 1, '2019-11-18 16:49:08', '2019-12-29 05:45:27');
INSERT INTO `metodos` VALUES (5, 'alta_bd', ' ', ' ', ' ', 'activo', 'inactivo', 'inactivo', 2, 1, 1, '2019-11-18 21:18:00', '2019-12-29 05:45:28');
INSERT INTO `metodos` VALUES (6, 'modifica', ' ', 'Editar', 'fas fa-pencil-alt', 'activo', 'inactivo', 'activo', 2, 1, 1, '2019-11-21 00:19:26', '2020-04-18 12:05:00');
INSERT INTO `metodos` VALUES (7, 'modifica_bd', ' ', ' ', ' ', 'activo', 'inactivo', 'inactivo', 2, 1, 1, '2019-11-21 00:19:39', '2019-12-29 05:45:29');
INSERT INTO `metodos` VALUES (8, 'elimina_bd', ' ', 'Eliminar', 'fas fa-trash', 'activo', 'inactivo', 'activo', 2, 1, 1, '2019-11-21 00:19:58', '2020-04-18 12:07:58');
INSERT INTO `metodos` VALUES (9, 'alta', 'Alta', ' ', ' ', 'activo', 'activo', 'inactivo', 3, 1, 1, '2019-12-22 12:42:18', '2019-12-29 05:45:31');
INSERT INTO `metodos` VALUES (10, 'lista', 'Lista', ' ', ' ', 'activo', 'activo', 'inactivo', 3, 1, 1, '2019-12-22 12:42:40', '2019-12-29 05:45:32');
INSERT INTO `metodos` VALUES (11, 'alta_bd', ' ', ' ', ' ', 'activo', 'inactivo', 'inactivo', 3, 1, 1, '2019-12-22 12:43:37', '2019-12-29 05:45:33');
INSERT INTO `metodos` VALUES (12, 'modifica', ' ', 'Editar', 'fas fa-pencil-alt', 'activo', 'inactivo', 'activo', 3, 1, 1, '2019-12-22 12:43:55', '2020-04-18 12:05:00');
INSERT INTO `metodos` VALUES (13, 'modifica_bd', ' ', ' ', ' ', 'activo', 'inactivo', 'inactivo', 3, 1, 1, '2019-12-22 12:44:08', '2019-12-29 05:45:35');
INSERT INTO `metodos` VALUES (14, 'elimina_bd', ' ', 'Eliminar', 'fas fa-trash', 'activo', 'inactivo', 'activo', 3, 1, 1, '2019-12-22 12:44:43', '2020-04-18 12:07:58');
INSERT INTO `metodos` VALUES (16, 'activa_bd', ' ', 'Activar', 'fas fa-play', 'activo', 'inactivo', 'activo', 2, 1, 1, '2019-12-22 13:56:47', '2020-04-18 12:06:57');
INSERT INTO `metodos` VALUES (17, 'desactiva_bd', ' ', 'Desactivar', 'fas fa-pause', 'activo', 'inactivo', 'activo', 2, 1, 1, '2019-12-22 13:57:38', '2020-04-18 12:07:39');
INSERT INTO `metodos` VALUES (18, 'activa_bd', ' ', 'Activar', 'fas fa-play', 'activo', 'inactivo', 'activo', 3, 1, 1, '2019-12-22 13:59:56', '2020-04-18 12:06:57');
INSERT INTO `metodos` VALUES (19, 'desactiva_bd', ' ', 'Desactivar', 'fas fa-pause', 'activo', 'inactivo', 'activo', 3, 1, 1, '2019-12-22 14:00:16', '2020-04-18 12:07:39');
INSERT INTO `metodos` VALUES (36, 'alta', 'Alta', ' ', ' ', 'activo', 'activo', 'inactivo', 6, 1, 1, '2019-12-28 22:16:27', '2019-12-29 05:45:50');
INSERT INTO `metodos` VALUES (37, 'lista', 'Lista', ' ', ' ', 'activo', 'activo', 'inactivo', 6, 1, 1, '2019-12-28 22:16:27', '2019-12-29 05:45:52');
INSERT INTO `metodos` VALUES (38, 'alta_bd', ' ', ' ', ' ', 'activo', 'inactivo', 'inactivo', 6, 1, 1, '2019-12-28 22:16:27', '2019-12-29 05:45:53');
INSERT INTO `metodos` VALUES (39, 'modifica', ' ', 'Editar', 'fas fa-pencil-alt', 'activo', 'inactivo', 'activo', 6, 1, 1, '2019-12-28 22:16:28', '2020-04-18 12:05:00');
INSERT INTO `metodos` VALUES (40, 'modifica_bd', ' ', ' ', ' ', 'activo', 'inactivo', 'inactivo', 6, 1, 1, '2019-12-28 22:16:28', '2019-12-29 05:45:54');
INSERT INTO `metodos` VALUES (41, 'elimina_bd', ' ', 'Eliminar', 'fas fa-trash', 'activo', 'inactivo', 'activo', 6, 1, 1, '2019-12-28 22:16:29', '2020-04-18 12:07:58');
INSERT INTO `metodos` VALUES (42, 'activa_bd', ' ', 'Activar', 'fas fa-play', 'activo', 'inactivo', 'activo', 6, 1, 1, '2019-12-28 22:16:29', '2020-04-18 12:06:57');
INSERT INTO `metodos` VALUES (43, 'desactiva_bd', ' ', 'Desactivar', 'fas fa-pause', 'activo', 'inactivo', 'activo', 6, 1, 1, '2019-12-28 22:16:29', '2020-04-18 12:07:39');
INSERT INTO `metodos` VALUES (45, 'alta', 'Alta', '', '', 'activo', 'activo', 'inactivo', 7, 1, 1, '2019-12-29 00:23:38', '2019-12-29 00:23:38');
INSERT INTO `metodos` VALUES (46, 'lista', 'Lista', '', '', 'activo', 'activo', 'inactivo', 7, 1, 1, '2019-12-29 00:23:38', '2019-12-29 00:23:38');
INSERT INTO `metodos` VALUES (47, 'alta_bd', '', '', '', 'activo', 'inactivo', 'inactivo', 7, 1, 1, '2019-12-29 00:23:38', '2019-12-29 00:23:38');
INSERT INTO `metodos` VALUES (48, 'modifica', ' ', 'Editar', 'fas fa-pencil-alt', 'activo', 'inactivo', 'activo', 7, 1, 1, '2019-12-29 00:23:38', '2020-04-18 14:57:34');
INSERT INTO `metodos` VALUES (49, 'modifica_bd', '', '', '', 'activo', 'inactivo', 'inactivo', 7, 1, 1, '2019-12-29 00:23:39', '2019-12-29 00:23:39');
INSERT INTO `metodos` VALUES (50, 'elimina_bd', '', 'Eliminar', 'fas fa-trash', 'activo', 'inactivo', 'activo', 7, 1, 1, '2019-12-29 00:23:39', '2020-04-18 12:07:58');
INSERT INTO `metodos` VALUES (51, 'activa_bd', '', 'Activar', 'fas fa-play', 'activo', 'inactivo', 'activo', 7, 1, 1, '2019-12-29 00:23:39', '2020-04-18 12:06:57');
INSERT INTO `metodos` VALUES (52, 'desactiva_bd', '', 'Desactivar', 'fas fa-pause', 'activo', 'inactivo', 'activo', 7, 1, 1, '2019-12-29 00:23:39', '2020-04-18 12:07:39');
INSERT INTO `metodos` VALUES (53, 'asigna_permisos', ' ', 'Asigna Permisos', 'fas fa-plus-square', 'activo', 'inactivo', 'activo', 3, 1, 1, '2020-01-02 18:38:06', '2020-04-18 12:06:51');
INSERT INTO `metodos` VALUES (54, 'baja_permiso', ' ', ' ', ' ', 'activo', 'inactivo', 'inactivo', 3, 1, 1, '2020-01-03 02:10:11', '2020-01-03 02:10:11');
INSERT INTO `metodos` VALUES (55, 'alta_permiso', ' ', ' ', ' ', 'activo', 'inactivo', 'inactivo', 3, 1, 1, '2020-01-03 02:10:24', '2020-01-03 02:10:24');

-- ----------------------------
-- Table structure for sessiones
-- ----------------------------
DROP TABLE IF EXISTS `sessiones`;
CREATE TABLE `sessiones`  (
  `id` int(100) NOT NULL AUTO_INCREMENT,
  `session_id` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `usuario_id` int(11) NULL DEFAULT NULL,
  `fecha` date NULL DEFAULT NULL,
  `grupo_id` int(100) NULL DEFAULT NULL,
  `fecha_alta` timestamp(0) NULL DEFAULT CURRENT_TIMESTAMP,
  `fecha_update` timestamp(0) NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP(0),
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `grupo_id`(`grupo_id`) USING BTREE,
  CONSTRAINT `sessiones_ibfk_1` FOREIGN KEY (`grupo_id`) REFERENCES `grupos` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE = InnoDB AUTO_INCREMENT = 42 CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of sessiones
-- ----------------------------
INSERT INTO `sessiones` VALUES (21, '9750428dde1f4cba0d9f9324b8d78439', 1, '2020-04-16', 1, '2020-04-16 12:42:42', '2020-04-16 12:42:42');
INSERT INTO `sessiones` VALUES (22, 'afce587d829a7eec7da501d96b097b28', 1, '2020-04-16', 1, '2020-04-16 16:48:41', '2020-04-16 16:48:41');
INSERT INTO `sessiones` VALUES (23, '926500a4958e439aef45258177433aa0', 1, '2020-04-18', 1, '2020-04-18 11:13:04', '2020-04-18 11:13:04');
INSERT INTO `sessiones` VALUES (24, '3c84014bd32aad662f9c365fc78103ee', 1, '2020-04-18', 1, '2020-04-18 12:25:29', '2020-04-18 12:25:29');
INSERT INTO `sessiones` VALUES (25, '3ff321391b89266c40d023a2e56b3381', 1, '2020-04-18', 1, '2020-04-18 12:40:01', '2020-04-18 12:40:01');
INSERT INTO `sessiones` VALUES (26, '250070af135883e6896f7780459c67a4', 1, '2020-04-18', 1, '2020-04-18 14:29:36', '2020-04-18 14:29:36');
INSERT INTO `sessiones` VALUES (27, '2e31c34d0cbc7ef0eafd91452b43cc00', 1, '2020-04-18', 1, '2020-04-18 21:59:55', '2020-04-18 21:59:55');
INSERT INTO `sessiones` VALUES (29, '8cf324dc48e21dd7efe906e728b7fefa', 1, '2020-04-20', 1, '2020-04-20 11:16:35', '2020-04-20 11:16:35');
INSERT INTO `sessiones` VALUES (31, '7704aa88a70044baca26255ff5f12bd7', 1, '2020-04-21', 1, '2020-04-21 23:37:20', '2020-04-21 23:37:20');
INSERT INTO `sessiones` VALUES (32, '4d3e15f81b9cb595b6872058138ad6f3', 1, '2020-04-24', 1, '2020-04-24 19:54:41', '2020-04-24 19:54:41');
INSERT INTO `sessiones` VALUES (35, '457328447fd30fac2d7543344649c7ee', 1, '2020-04-24', 1, '2020-04-24 22:23:43', '2020-04-24 22:23:43');
INSERT INTO `sessiones` VALUES (36, '94ad594bc3cd35b344ac5a3c6b02c151', 1, '2020-04-25', 1, '2020-04-25 09:55:47', '2020-04-25 09:55:47');
INSERT INTO `sessiones` VALUES (37, '7c8784506de35f81af8c41f93c8a1bc8', 1, '2020-04-25', 1, '2020-04-25 10:22:40', '2020-04-25 10:22:40');
INSERT INTO `sessiones` VALUES (38, 'b0dab502582fb6706026f1c21a76c93b', 1, '2020-04-26', 1, '2020-04-26 20:01:15', '2020-04-26 20:01:15');
INSERT INTO `sessiones` VALUES (39, '6365a62a1db0f9cae45fdab6fd99ad4f', 1, '2020-04-26', 1, '2020-04-26 21:47:56', '2020-04-26 21:47:56');
INSERT INTO `sessiones` VALUES (41, '7c7cf2402da3ca8242a12c3f48f73cbb', 2, '2020-04-26', 1, '2020-04-26 22:09:17', '2020-04-26 22:09:17');

-- ----------------------------
-- Table structure for usuarios
-- ----------------------------
DROP TABLE IF EXISTS `usuarios`;
CREATE TABLE `usuarios`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user` varchar(200) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `password` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `nombre_completo` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `email` varchar(200) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `sexo` varchar(200) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `grupo_id` int(11) NULL DEFAULT NULL,
  `status` varchar(11) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT 'inactivo',
  `usuario_alta_id` int(11) NULL DEFAULT NULL,
  `usuario_update_id` int(11) NULL DEFAULT NULL,
  `fecha_alta` timestamp(0) NULL DEFAULT CURRENT_TIMESTAMP,
  `fecha_update` timestamp(0) NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP(0),
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE INDEX `user`(`user`) USING BTREE,
  UNIQUE INDEX `email`(`email`) USING BTREE,
  INDEX `grupo_id`(`grupo_id`) USING BTREE,
  INDEX `usuario_alta_id`(`usuario_alta_id`) USING BTREE,
  INDEX `usuario_update_id`(`usuario_update_id`) USING BTREE,
  CONSTRAINT `usuarios_ibfk_1` FOREIGN KEY (`grupo_id`) REFERENCES `grupos` (`id`) ON DELETE RESTRICT ON UPDATE CASCADE,
  CONSTRAINT `usuarios_ibfk_2` FOREIGN KEY (`usuario_alta_id`) REFERENCES `usuarios` (`id`) ON DELETE RESTRICT ON UPDATE CASCADE,
  CONSTRAINT `usuarios_ibfk_3` FOREIGN KEY (`usuario_update_id`) REFERENCES `usuarios` (`id`) ON DELETE RESTRICT ON UPDATE CASCADE
) ENGINE = InnoDB AUTO_INCREMENT = 3 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Records of usuarios
-- ----------------------------
INSERT INTO `usuarios` VALUES (1, 'admin', 'admin', 'Programador', 'programador@admin.com', 'masculino', 1, 'activo', 1, 1, '2019-11-11 23:13:57', '2020-04-26 22:08:41');
INSERT INTO `usuarios` VALUES (2, 'maria', 'maria', 'maria', 'maria@mail.com', 'femenino', 1, 'activo', 1, 1, '2020-04-26 22:09:10', '2020-04-26 22:09:10');

SET FOREIGN_KEY_CHECKS = 1;
