<?php

namespace Modelo;
use Clase\Modelo;
use Clase\Database;

/*** modelo core ***/

class Usuarios extends Modelo{

    public function __construct(Database $link){
        $tabla = 'usuarios';
        parent::__construct($link, $tabla);
    }

}