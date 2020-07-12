<?php 

namespace Modelo;

use Clase\Modelo;
use Interfas\Database;
use Interfas\GeneraConsultas;

class Metodos extends Modelo
{
    public function __construct(Database $coneccion, GeneraConsultas $generaConsulta)
    {
        $tabla = 'metodos';
        $relaciones = [
            'menus' => "{$tabla}.menu_id"

        ]; 
        $columnas = [
            'unicas' => ['metodo' => 'nombre'],
            'obligatorias' => ['nombre','menu_id'],
            'protegidas' => []
        ];
        parent::__construct($coneccion, $generaConsulta, $tabla, $relaciones, $columnas );
    }
}