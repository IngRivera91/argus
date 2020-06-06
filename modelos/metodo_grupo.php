<?php

namespace Modelo;
use Clase\Modelo;
use Clase\Database;

/*** modelo core ***/

class Metodo_Grupo extends Modelo {

    public function __construct(Database $link){
        $tabla = 'metodo_grupo';
        parent::__construct($link, $tabla);
    }

}