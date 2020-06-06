<?php

    //clases
    require_once('clases/controlador.php');
    require_once('clases/database.php');
    require_once('clases/errores.php');
    require_once('clases/html.php');
    require_once('clases/modelo.php');
    require_once('clases/seguridad.php');

    // modelos
    require_once('modelos/grupos.php');
    require_once('modelos/menus.php');
    require_once('modelos/metodo_grupo.php');
    require_once('modelos/metodos.php');
    require_once('modelos/sessiones.php');
    require_once('modelos/usuarios.php');

    // controladores
    require_once('controladores/controlador_grupos.php');
    require_once('controladores/controlador_inicio.php');
    require_once('controladores/controlador_menus.php');
    require_once('controladores/controlador_metodos.php');
    require_once('controladores/controlador_usuarios.php');
    
    // ayudas
    require_once('ayudas/Redirect.php');
    
