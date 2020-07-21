<?php 

namespace Error;
use Ayuda\Redireccion;
use Error\Base AS ErrorBase;

class Esperado extends ErrorBase
{
    private string $controlador;
    private string $metodo;

    public function __construct(string $mensaje = '', string $controlador = '', string $metodo = '') 
    {
        $this->controlador = $controlador;
        $this->metodo = $metodo;
        parent::__construct($mensaje, null);
    }

    public function muestraError(bool $esRecursivo = false)
    {
        Redireccion::enviar($this->controlador, $this->metodo, SESSION_ID, $this->message);
        exit;
    }

}