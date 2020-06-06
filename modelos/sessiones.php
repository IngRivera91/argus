<?php
/*** modelo core ***/

class sessiones extends modelo {
    public function __construct(database $link){
        $tabla = __CLASS__;
        parent::__construct($link, $tabla);
    }
}