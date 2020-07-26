<?php 

namespace Modelo;

use Clase\Modelo;
use Interfas\Database;
use Interfas\GeneraConsultas;

class Metodos extends Modelo
{
    public function __construct(Database $coneccion)
    {
        $tabla = 'metodos';
        $relaciones = [
            'menus' => "{$tabla}.menu_id"

        ]; 
        $columnas = [
            'unicas' => [],
            'obligatorias' => ['nombre','menu_id'],
            'protegidas' => []
        ];
        parent::__construct($coneccion, $tabla, $relaciones, $columnas);
    }
}