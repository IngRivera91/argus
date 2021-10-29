<?php

namespace Test;

use App\models\Menus;
use App\models\Grupos;
use App\models\Metodos;
use App\models\Usuarios;
use App\models\Sessiones;
use App\interfaces\Database;
use App\models\MetodosGrupos;

class LimpiarDatabase
{
    public static function start(Database $coneccion): void
    {
        $MetodosGrupos = new MetodosGrupos($coneccion);
        $Metodos = new Metodos($coneccion);
        $Menus = new Menus($coneccion);
        $Usuarios = new Usuarios($coneccion);
        $Grupos = new Grupos($coneccion);
        $Sessiones = new Sessiones($coneccion);

        $Sessiones->eliminarTodo();
        $MetodosGrupos->eliminarTodo();
        $Metodos->eliminarTodo();
        $Menus->eliminarTodo();
        $Usuarios->eliminarTodo();
        $Grupos->eliminarTodo();
    }
}