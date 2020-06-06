<?php

namespace Modelo;
use Clase\Modelo;
use Clase\Database;

/*** modelo core ***/

class Sessiones extends Modelo {
    public function __construct(Database $link){
        $tabla = 'sessiones';
        parent::__construct($link, $tabla);
    }
}