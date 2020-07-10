<?php 

namespace Error;
use Ayuda\Redireccion;
use Error\Base AS ErrorBase;

class Autentificacion extends ErrorBase
{

    public function __construct( $mensaje = '' , ErrorBase $errorAnterior = null ) 
    {
        parent::__construct( $mensaje , $errorAnterior );
    }

    public function muestraError($esRecursivo = false)
    {
        Redireccion::enviar_login($this->message);
        exit;
    }

}