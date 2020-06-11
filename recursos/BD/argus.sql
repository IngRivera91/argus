/*
 Navicat Premium Data Transfer

 Source Server         : Local
 Source Server Type    : MySQL
 Source Server Version : 50724
 Source Host           : localhost:3306
 Source Schema         : argus

 Target Server Type    : MySQL
 Target Server Version : 50724
 File Encoding         : 65001

 Date: 11/06/2020 17:57:17
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
  INDEX `usuario_update_id`(`usuario_update_id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Compact;

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
  INDEX `usuario_update_id`(`usuario_update_id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Compact;

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
  INDEX `metodo_grupo_ibfk_4`(`usuario_update_id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Redundant;

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
  INDEX `metodos_ibfk_3`(`usuario_alta_id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Redundant;

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
  INDEX `grupo_id`(`grupo_id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = Dynamic;

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
  INDEX `usuario_update_id`(`usuario_update_id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 5 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Records of usuarios
-- ----------------------------
INSERT INTO `usuarios` VALUES (4, 'juan', 'juan', 'Juan', 'correo@mail.com', 'masculino', 1, 'activo', 1, 1, '2020-06-11 14:48:05', '2020-06-11 14:48:05');

SET FOREIGN_KEY_CHECKS = 1;
