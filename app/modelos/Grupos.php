<?php 

namespace Modelo;

use Clase\Modelo;
use Interfas\Database;
use Interfas\GeneraConsultas;

class Grupos extends Modelo
{
    public function __construct(Database $coneccion, GeneraConsultas $generaConsulta)
    {
        $tabla = 'grupos';
        $relaciones = []; 
        $columnas = [
            'unicas' => ['grupo' => 'nombre'],
            'obligatorias' => ['nombre'],
            'protegidas' => []
        ];
        parent::__construct($coneccion, $generaConsulta, $tabla, $relaciones, $columnas );
    }
}