<?php

namespace Modelo;
use Clase\Modelo;
use Clase\Database;

/*** modelo core ***/

class Menus extends Modelo {

    public function __construct(Database $link){
        $tabla = 'menus';
        parent::__construct($link, $tabla);
    }

}