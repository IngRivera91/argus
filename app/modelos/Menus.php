<?php 

namespace Modelo;

use Clase\Modelo;
use Interfas\Database;
use Interfas\GeneraConsultas;

class Menus extends Modelo
{
    public function __construct(Database $coneccion)
    {
        $tabla = 'menus';
        $relaciones = []; 
        $columnas = [
            'unicas' => ['menu' => 'nombre'],
            'obligatorias' => ['nombre'],
            'protegidas' => []
        ];
        parent::__construct($coneccion, $tabla, $relaciones, $columnas);
    }
}