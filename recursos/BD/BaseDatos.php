<?php

class BaseDatos 
{
    public static function crear($coneccion)
    {
        $query = "
    
            SET NAMES utf8mb4;
            SET FOREIGN_KEY_CHECKS = 0;
    
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
            ) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Compact;
    
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
    
            DROP TABLE IF EXISTS `sessiones`;
            CREATE TABLE `sessiones`  (
            `id` int(11) NOT NULL AUTO_INCREMENT,
            `session_id` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
            `usuario_id` int(11) NULL DEFAULT NULL,
            `grupo_id` int(11) NULL DEFAULT NULL,
            `activo` tinyint(11) NULL DEFAULT NULL,
            `usuario_registro_id` int(11) NULL DEFAULT NULL,
            `usuario_actualizacion_id` int(11) NULL DEFAULT NULL,
            `fecha_registro` timestamp(0) NULL DEFAULT CURRENT_TIMESTAMP,
            PRIMARY KEY (`id`) USING BTREE,
            INDEX `usuario_id`(`usuario_id`) USING BTREE,
            INDEX `grupo_id`(`grupo_id`) USING BTREE,
            CONSTRAINT `sessiones_ibfk_1` FOREIGN KEY (`usuario_id`) REFERENCES `usuarios` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
            CONSTRAINT `sessiones_ibfk_2` FOREIGN KEY (`grupo_id`) REFERENCES `grupos` (`id`) ON DELETE SET NULL ON UPDATE CASCADE
            ) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Compact;
    
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
            ) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Compact;
    
            SET FOREIGN_KEY_CHECKS = 1;
    
        ";
    
        $resultado = $coneccion->ejecutaQuery($query);
        print_r('crear:');
        print_r($resultado);
    }

    public static function insertarRegistrosBase($coneccion,$user,$password,$nombre,$email,$sexo = 'm')
    {
        $password = md5($password);
        $query = "
            INSERT INTO grupos (grupos.nombre , grupos.activo , grupos.usuario_registro_id ,grupos.usuario_actualizacion_id)
            VALUES
            ('programador',TRUE,-1,-1);

            INSERT INTO usuarios 
            (usuario, password, nombre_completo, correo_electronico, sexo, grupo_id, activo, usuario_registro_id, usuario_actualizacion_id) 
            VALUES 
            ('$user', '$password', '$nombre', '$email', '$sexo', '1', '1', '-1', '-1');

            INSERT INTO `menus` 
            (id, nombre, etiqueta, icono, activo, usuario_registro_id, usuario_actualizacion_id) 
            VALUES 
            (1, 'menus', 'MENUS', 'fas fa-th-list', '1', '-1', '-1'),
            (2, 'metodos', 'METODOS', 'fas fa-list-ul', '1', '-1', '-1'),
            (3, 'grupos', 'GRUPOS', 'fas fa-users-cog', '1', '-1', '-1'),
            (4, 'usuarios', 'USUARIOS', 'fas fa-users', '1', '-1', '-1');

            INSERT INTO `metodos` 
            (metodos.id,metodos.nombre, metodos.etiqueta,metodos.accion,metodos.icono,metodos.menu_id,metodos.activo_menu,metodos.activo_accion,metodos.activo, usuario_registro_id, usuario_actualizacion_id)
            VALUES
            (1,'registrar','Registrar','','',1,TRUE,FALSE,TRUE,-1,-1),
            (2,'lista','Lista','','',1,TRUE,FALSE,TRUE,-1,-1),
            (3,'registrar_bd','','','',1,FALSE,FALSE,TRUE,-1,-1),
            (4,'activar_bd','','Activar','fas fa-play',1,FALSE,TRUE,TRUE,-1,-1),
            (5,'desactivar_bd','','Desactivar','fas fa-pause',1,FALSE,TRUE,TRUE,-1,-1),
            (6,'modificar','','Modificar','fas fa-pencil-alt',1,FALSE,TRUE,TRUE,-1,-1),
            (7,'eliminar_bd','','Eliminar','fas fa-trash',1,FALSE,TRUE,TRUE,-1,-1),
            (8,'modificar_bd','','','',1,FALSE,FALSE,TRUE,-1,-1),

            (9,'registrar','Registrar','','',2,TRUE,FALSE,TRUE,-1,-1),
            (10,'lista','Lista','','',2,TRUE,FALSE,TRUE,-1,-1),
            (11,'registrar_bd','','','',2,FALSE,FALSE,TRUE,-1,-1),
            (12,'activar_bd','','Activar','fas fa-play',2,FALSE,TRUE,TRUE,-1,-1),
            (13,'desactivar_bd','','Desactivar','fas fa-pause',2,FALSE,TRUE,TRUE,-1,-1),
            (14,'modificar','','Modificar','fas fa-pencil-alt',2,FALSE,TRUE,TRUE,-1,-1),
            (15,'eliminar_bd','','Eliminar','fas fa-trash',2,FALSE,TRUE,TRUE,-1,-1),
            (16,'modificar_bd','','','',2,FALSE,FALSE,TRUE,-1,-1),

            (17,'registrar','Registrar','','',3,TRUE,FALSE,TRUE,-1,-1),
            (18,'lista','Lista','','',3,TRUE,FALSE,TRUE,-1,-1),
            (19,'registrar_bd','','','',3,FALSE,FALSE,TRUE,-1,-1),
            (20,'activar_bd','','Activar','fas fa-play',3,FALSE,TRUE,TRUE,-1,-1),
            (21,'desactivar_bd','','Desactivar','fas fa-pause',3,FALSE,TRUE,TRUE,-1,-1),
            (22,'modificar','','Modificar','fas fa-pencil-alt',3,FALSE,TRUE,TRUE,-1,-1),
            (23,'eliminar_bd','','Eliminar','fas fa-trash',3,FALSE,TRUE,TRUE,-1,-1),
            (24,'modificar_bd','','','',3,FALSE,FALSE,TRUE,-1,-1),

            (25,'registrar','Registrar','','',4,TRUE,FALSE,TRUE,-1,-1),
            (26,'lista','Lista','','',4,TRUE,FALSE,TRUE,-1,-1),
            (27,'registrar_bd','','','',4,FALSE,FALSE,TRUE,-1,-1),
            (28,'activar_bd','','Activar','fas fa-play',4,FALSE,TRUE,TRUE,-1,-1),
            (29,'desactivar_bd','','Desactivar','fas fa-pause',4,FALSE,TRUE,TRUE,-1,-1),
            (30,'modificar','','Modificar','fas fa-pencil-alt',4,FALSE,TRUE,TRUE,-1,-1),
            (31,'eliminar_bd','','Eliminar','fas fa-trash',4,FALSE,TRUE,TRUE,-1,-1),
            (32,'modificar_bd','','','',4,FALSE,FALSE,TRUE,-1,-1);

            DELETE FROM metodo_grupo;
            SET @grupo_id = 1;
            INSERT INTO metodo_grupo (metodo_grupo.id,metodo_grupo.metodo_id,metodo_grupo.grupo_id,metodo_grupo.activo)
            VALUES 
            (1,1,@grupo_id,TRUE),
            (2,2,@grupo_id,TRUE),
            (3,3,@grupo_id,TRUE),
            (4,4,@grupo_id,TRUE),
            (5,5,@grupo_id,TRUE),
            (6,6,@grupo_id,TRUE),
            (7,7,@grupo_id,TRUE),
            (8,8,@grupo_id,TRUE),
            (9,9,@grupo_id,TRUE),
            (10,10,@grupo_id,TRUE),
            (11,11,@grupo_id,TRUE),
            (12,12,@grupo_id,TRUE),
            (13,13,@grupo_id,TRUE),
            (14,14,@grupo_id,TRUE),
            (15,15,@grupo_id,TRUE),
            (16,16,@grupo_id,TRUE),
            (17,17,@grupo_id,TRUE),
            (18,18,@grupo_id,TRUE),
            (19,19,@grupo_id,TRUE),
            (20,20,@grupo_id,TRUE),
            (21,21,@grupo_id,TRUE),
            (22,22,@grupo_id,TRUE),
            (23,23,@grupo_id,TRUE),
            (24,24,@grupo_id,TRUE),
            (25,25,@grupo_id,TRUE),
            (26,26,@grupo_id,TRUE),
            (27,27,@grupo_id,TRUE),
            (28,28,@grupo_id,TRUE),
            (29,29,@grupo_id,TRUE),
            (30,30,@grupo_id,TRUE),
            (31,31,@grupo_id,TRUE),
            (32,32,@grupo_id,TRUE);
        ";

        $resultado = $coneccion->ejecutaQuery($query);
        print_r('insertar:');
        print_r($resultado);
    }
}

