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

 Date: 12/07/2020 15:24:49
*/

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

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
  `fecha_registro` timestamp(0) NULL DEFAULT CURRENT_TIMESTAMP,
  `fecha_actualizacion` timestamp(0) NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP(0),
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 2 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Records of grupos
-- ----------------------------
INSERT INTO `grupos` VALUES (1, 'programador', 1, 1, 1, '2020-07-10 16:38:43', '2020-07-10 16:38:43');

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
  `fecha_registro` timestamp(0) NULL DEFAULT CURRENT_TIMESTAMP,
  `fecha_actualizacion` timestamp(0) NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP(0),
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Table structure for metodo_grupo
-- ----------------------------
DROP TABLE IF EXISTS `metodo_grupo`;
CREATE TABLE `metodo_grupo`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `metodo_id` int(11) NULL DEFAULT NULL,
  `grupo_id` int(11) NULL DEFAULT NULL,
  `activo` tinyint(11) NULL DEFAULT NULL,
  `usuario_registro_id` int(11) NULL DEFAULT NULL,
  `usuario_actualizacion_id` int(11) NULL DEFAULT NULL,
  `fecha_registro` timestamp(0) NULL DEFAULT CURRENT_TIMESTAMP,
  `fecha_actualizacion` timestamp(0) NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP(0),
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `metodo_id`(`metodo_id`) USING BTREE,
  INDEX `grupo_id`(`grupo_id`) USING BTREE,
  CONSTRAINT `metodo_grupo_ibfk_1` FOREIGN KEY (`metodo_id`) REFERENCES `metodos` (`id`) ON DELETE RESTRICT ON UPDATE CASCADE,
  CONSTRAINT `metodo_grupo_ibfk_2` FOREIGN KEY (`grupo_id`) REFERENCES `grupos` (`id`) ON DELETE RESTRICT ON UPDATE CASCADE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Compact;

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
  `fecha_registro` timestamp(0) NULL DEFAULT CURRENT_TIMESTAMP,
  `fecha_actualizacion` timestamp(0) NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP(0),
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `menu_id`(`menu_id`) USING BTREE,
  CONSTRAINT `metodos_ibfk_1` FOREIGN KEY (`menu_id`) REFERENCES `menus` (`id`) ON DELETE RESTRICT ON UPDATE CASCADE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Table structure for sessiones
-- ----------------------------
DROP TABLE IF EXISTS `sessiones`;
CREATE TABLE `sessiones`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `session_id` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `usuario_id` int(11) NULL DEFAULT NULL,
  `grupo_id` int(11) NULL DEFAULT NULL,
  `fecha_registro` timestamp(0) NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `usuario_id`(`usuario_id`) USING BTREE,
  INDEX `grupo_id`(`grupo_id`) USING BTREE,
  CONSTRAINT `sessiones_ibfk_1` FOREIGN KEY (`usuario_id`) REFERENCES `usuarios` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  CONSTRAINT `sessiones_ibfk_2` FOREIGN KEY (`grupo_id`) REFERENCES `grupos` (`id`) ON DELETE SET NULL ON UPDATE CASCADE
) ENGINE = InnoDB AUTO_INCREMENT = 3 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Records of sessiones
-- ----------------------------
INSERT INTO `sessiones` VALUES (2, '3eb757a634f9da522bfee897dd8deba8', 1, 1, '2020-07-12 01:35:47');

-- ----------------------------
-- Table structure for usuarios
-- ----------------------------
DROP TABLE IF EXISTS `usuarios`;
CREATE TABLE `usuarios`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `usuario` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `password` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `nombre_completo` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `correo_electronico` varchar(200) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `sexo` varchar(200) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `grupo_id` int(11) NULL DEFAULT NULL,
  `activo` tinyint(11) NULL DEFAULT NULL,
  `usuario_registro_id` int(11) NULL DEFAULT NULL,
  `usuario_actualizacion_id` int(11) NULL DEFAULT NULL,
  `fecha_registro` timestamp(0) NULL DEFAULT CURRENT_TIMESTAMP,
  `fecha_actualizacion` timestamp(0) NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP(0),
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE INDEX `user`(`usuario`) USING BTREE,
  UNIQUE INDEX `email`(`correo_electronico`) USING BTREE,
  INDEX `grupo_id`(`grupo_id`) USING BTREE,
  INDEX `usuario_alta_id`(`usuario_registro_id`) USING BTREE,
  INDEX `usuario_update_id`(`usuario_actualizacion_id`) USING BTREE,
  CONSTRAINT `usuarios_ibfk_1` FOREIGN KEY (`grupo_id`) REFERENCES `grupos` (`id`) ON DELETE RESTRICT ON UPDATE CASCADE
) ENGINE = InnoDB AUTO_INCREMENT = 2 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Records of usuarios
-- ----------------------------
INSERT INTO `usuarios` VALUES (1, 'admin', '21232f297a57a5a743894a0e4a801fc3', 'Ricardo Rivera', 'mail@mail.com', 'm', 1, 1, 1, 1, '2020-07-10 16:38:45', '2020-07-10 16:39:25');

SET FOREIGN_KEY_CHECKS = 1;
