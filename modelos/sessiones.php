<?php
/*** modelo core ***/

class Sessiones extends Modelo {
    public function __construct(database $link){
        $tabla = 'sessiones';
        parent::__construct($link, $tabla);
    }
}