<?php

namespace Modelo;
use Clase\Modelo;
use Clase\Database;

/*** modelo core ***/

class Metodos extends Modelo {

    public function __construct(Database $link){
        $tabla = 'metodos';
        parent::__construct($link, $tabla);
    }

}