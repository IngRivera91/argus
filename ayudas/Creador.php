<?php 

namespace Ayuda;
use Clase\Controlador;
use Clase\Database;

use Controlador\ControladorGrupos;
use Controlador\ControladorInicio;
use Controlador\ControladorMenus;
use Controlador\ControladorMetodos;
use Controlador\ControladorUsuarios;

class Creador {

    public static function controlador(string $nombre_controlador,Database $link ):Controlador{
        
        if ($nombre_controlador == 'ControladorGrupos'){
            return new ControladorGrupos($link);
        }

        if ($nombre_controlador == 'ControladorInicio'){
            return new ControladorInicio($link);
        }

        if ($nombre_controlador == 'ControladorMenus'){
            return new ControladorMenus($link);
        }

        if ($nombre_controlador == 'ControladorMetodos'){
            return new ControladorMetodos($link);
        }

        if ($nombre_controlador == 'ControladorUsuarios'){
            return new ControladorUsuarios($link);
        }
    }

}