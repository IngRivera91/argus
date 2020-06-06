<?php

    //clases
    require_once('clases/Controlador.php');
    require_once('clases/Database.php');
    require_once('clases/Errores.php');
    require_once('clases/Html.php');
    require_once('clases/Modelo.php');
    require_once('clases/Seguridad.php');

    // modelos
    require_once('modelos/Grupos.php');
    require_once('modelos/Menus.php');
    require_once('modelos/Metodo_Grupo.php');
    require_once('modelos/Metodos.php');
    require_once('modelos/Sessiones.php');
    require_once('modelos/Usuarios.php');

    // controladores
    require_once('controladores/controlador_grupos.php');
    require_once('controladores/controlador_inicio.php');
    require_once('controladores/controlador_menus.php');
    require_once('controladores/controlador_metodos.php');
    require_once('controladores/controlador_usuarios.php');
    
    // ayudas
    require_once('ayudas/Redirect.php');
    
