<?php 

namespace Modelo;

use Clase\Modelo;
use Clase\Database;

class Metodos extends Modelo
{
    public function __construct(Database $coneccion)
    {
        $tabla = 'metodos';
        $relaciones = [
            'menus' => 'metodos.menu_id'

        ]; 
        $columnas = [
            'unicas' => ['metodo' => 'nombre'],
            'obligatorias' => ['nombre','menu_id'],
            'protegidas' => []
        ];
        parent::__construct($coneccion ,$tabla ,$relaciones,$columnas );
    }
}