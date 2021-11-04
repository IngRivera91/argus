<?php 

namespace App\errors;

use App\ayudas\Redireccion;
use App\errors\Base AS ErrorBase;

class Auth extends ErrorBase
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