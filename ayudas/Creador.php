<?php 

namespace Ayuda;
use Clase\Controlador;
use Clase\Database;
use Clase\Modelo;

use Controlador\Controlador_Grupos;
use Controlador\Controlador_Inicio;
use Controlador\Controlador_Menus;
use Controlador\Controlador_Metodos;
use Controlador\Controlador_Usuarios;

use Modelo\Grupos;
use Modelo\Menus;
use Modelo\Metodo_Grupo;
use Modelo\Metodos;
use Modelo\Sessiones;
use Modelo\Usuarios;

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

    public static function modelo(string $nombre_tabla,Database $link ):Modelo{
        
        if ($nombre_tabla == 'grupos'){
            return new Grupos($link);
        }

        if ($nombre_tabla == 'menus'){
            return new Menus($link);
        }

        if ($nombre_tabla == 'metodo_grupo'){
            return new Metodo_Grupo($link);
        }

        if ($nombre_tabla == 'metodos'){
            return new Metodos($link);
        }

        if ($nombre_tabla == 'sessiones'){
            return new Sessiones($link);
        }

        if ($nombre_tabla == 'usuarios'){
            return new Usuarios($link);
        }

    
    }

}