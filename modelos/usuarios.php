<?php
/*** modelo core ***/

class Usuarios extends Modelo{

    public function __construct(database $link){
        $tabla = 'usuarios';
        parent::__construct($link, $tabla);
    }

}