<?php
/*** modelo core ***/

class Menus extends Modelo {

    public function __construct(database $link){
        $tabla = 'menus';
        parent::__construct($link, $tabla);
    }

}