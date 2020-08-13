<?php 

namespace Controlador;

use Ayuda\Html;
use Clase\Modelo;
use Modelo\Usuarios;
use Ayuda\Redireccion;
use Interfas\Database;
use Error\Base AS ErrorBase;

class password
{
    private Modelo $Usuarios;

    public function __construct(Database $coneccion)
    {
        $this->Usuarios = new Usuarios($coneccion);
    }

    public function cambiarPassword()
    {
        
    }
}