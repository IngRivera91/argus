<?php 

namespace Error;
use Error\Error;

class ErrorEsperado extends Error
{

    public function __construct($mensaje = '', Exception $errorAnterior = null) 
    {
        parent::__construct($mensaje,$errorAnterior);
    }

}