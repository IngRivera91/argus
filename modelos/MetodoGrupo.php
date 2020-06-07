<?php

namespace Modelo;
use Clase\Modelo;
use Clase\Database;

/*** modelo core ***/

class MetodoGrupo extends Modelo {

    public function __construct(Database $link){
        $tabla = 'metodo_grupo';
        parent::__construct($link, $tabla);
    }

}