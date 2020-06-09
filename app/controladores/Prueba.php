<?php
    namespace Controlador;

    class Prueba {

        public $nombre = "juan";
    
        public function cambia_nombre($nombre):void
        {
            $this->nombre = $nombre;
        }
        
    }
