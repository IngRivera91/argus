<?php
    namespace Modelo;

    class Prueba {

        public $nombre = "maria";
    
        public function cambia_nombre($nombre):void
        {
            $this->nombre = $nombre;
        }
        
    }