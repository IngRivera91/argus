<?php 

namespace Modelo;

use Clase\Modelo;
use Interfas\Database;
use Interfas\GeneraConsultas;

class MetodosGrupos extends Modelo
{
    public function __construct(Database $coneccion, GeneraConsultas $generaConsulta)
    {
        $tabla = 'metodo_grupo';
        $relaciones = [
            'metodos' => "{$tabla}.metodo_id",
            'grupos' => "{$tabla}.grupo_id",
            'menus' => 'metodos.menu_id'
        ]; 
        $columnas = [
            'unicas' => [],
            'obligatorias' => ['grupo_id','metodo_id'],
            'protegidas' => []
        ];
        parent::__construct($coneccion, $generaConsulta, $tabla, $relaciones, $columnas );
    }
}