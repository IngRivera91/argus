<?php 

namespace Error;
use Ayuda\Redireccion;
use Error\Base AS ErrorBase;

class Autentificacion extends ErrorBase
{

    public function __construct(string $mensaje = '') 
    {
        parent::__construct($mensaje);
    }

    public function muestraError(bool $esRecursivo = false)
    {
        Redireccion::enviar_login($this->message);
        exit;
    }

}