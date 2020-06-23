<?php 

namespace Error;
use Error\Base AS ErrorBase;

class Esperado extends ErrorBase
{

    public function __construct( $mensaje = '' , Exception $errorAnterior = null ) 
    {
        parent::__construct( $mensaje , $errorAnterior );
    }

}