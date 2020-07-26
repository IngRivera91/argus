<?php

namespace Controlador;

use Interfas\Database;
use Interfas\GeneraConsultas;

class inicio
{
    private Database $coneccion;

    public bool $breadcrumb = false;
        
    public function __construct(Database $coneccion)
    {
        $this->coneccion = $coneccion;
    }

    public function index()
    {
        
    }
}