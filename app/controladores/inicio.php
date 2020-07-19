<?php

namespace Controlador;

use Interfas\Database;
use Interfas\GeneraConsultas;

class inicio
{
    private Database $coneccion;
    private GeneraConsultas $generaConsulta;

    public function __construct(Database $coneccion, GeneraConsultas $generaConsulta)
    {
        $this->coneccion = $coneccion;
        $this->generaConsulta = $generaConsulta;
    }

    public function index()
    {
        
    }
}