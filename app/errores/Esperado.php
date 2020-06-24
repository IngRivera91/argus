<?php 

namespace Error;
use Error\Base AS ErrorBase;

class Esperado extends ErrorBase
{

    public function __construct( $mensaje = '' , ErrorBase $errorAnterior = null ) 
    {
        parent::__construct( $mensaje , $errorAnterior );
    }

}