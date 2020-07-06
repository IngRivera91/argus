<?php

namespace Clase;

use Clase\Database;
use Modelo\Usuarios;
use Modelo\Sessiones;

class Autentificacion 
{
    private $modeloUsuarios;
    private $modeloSessiones;
    public function __construct(Database $coneccion)
    {
        $this->modeloSessiones = new Sessiones($coneccion);
        $this->modeloUsuarios = new Usuarios($coneccion);
    }

    public function login()
    {
        
    }
}