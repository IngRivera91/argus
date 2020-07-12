<?php 

namespace Modelo;

use Clase\Modelo;
use Interfas\Database;
use Interfas\GeneraConsultas;

class Menus extends Modelo
{
    public function __construct(Database $coneccion, GeneraConsultas $generaConsulta)
    {
        $tabla = 'menus';
        $relaciones = []; 
        $columnas = [
            'unicas' => ['menu' => 'nombre'],
            'obligatorias' => ['nombre'],
            'protegidas' => []
        ];
        parent::__construct($coneccion, $generaConsulta, $tabla, $relaciones, $columnas );
    }
}