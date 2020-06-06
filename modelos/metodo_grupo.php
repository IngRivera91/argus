<?php
/*** modelo core ***/

class Metodo_Grupo extends Modelo {

    public function __construct(database $link){
        $tabla = 'metodo_grupo';
        parent::__construct($link, $tabla);
    }

}