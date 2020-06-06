<?php 

namespace Ayuda;
use Clase\Controlador;
use Clase\Database;

use Controlador\Controlador_Grupos;
use Controlador\Controlador_Inicio;
use Controlador\Controlador_Menus;
use Controlador\Controlador_Metodos;
use Controlador\Controlador_Usuarios;

class Creador {

    public static function controlador(string $nombre_controlador,Database $link ):Controlador{
        
        if ($nombre_controlador == 'Controlador_Grupos'){
            return new Controlador_Grupos($link);
        }

        if ($nombre_controlador == 'Controlador_Inicio'){
            return new Controlador_Inicio($link);
        }

        if ($nombre_controlador == 'Controlador_Menus'){
            return new Controlador_Menus($link);
        }

        if ($nombre_controlador == 'Controlador_Metodos'){
            return new Controlador_Metodos($link);
        }

        if ($nombre_controlador == 'Controlador_Usuarios'){
            return new Controlador_Usuarios($link);
        }
    }

}