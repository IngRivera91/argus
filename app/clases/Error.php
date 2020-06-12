<?php

namespace Clase;

use Exception;

class Error extends Exception
{
    private $consulta;
    public function __construct($mensaje = '', Exception $errorAnterior = null, $codigo = 0,string $consulta = '') 
    {
        $this->consulta = $consulta;
        parent::__construct($mensaje, $codigo ,$errorAnterior);
    }

    public function muestraError()
    {
        
    }
}