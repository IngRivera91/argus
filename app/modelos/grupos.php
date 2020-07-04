<?php 

namespace Modelo;

use Clase\Modelo;
use Clase\Database;

class Grupos extends Modelo
{
    public function __construct(Database $coneccion)
    {
        $tabla = 'grupos';
        $relaciones = []; 
        $columnas = [
            'unicas' => ['grupo' => 'nombre'],
            'obligatorias' => ['nombre'],
            'protegidas' => []
        ];
        parent::__construct($coneccion ,$tabla ,$relaciones,$columnas );
    }
}