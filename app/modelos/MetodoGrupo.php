<?php 

namespace Modelo;

use Clase\Modelo;
use Clase\Database;

class MetodoGrupo extends Modelo
{
    public function __construct(Database $coneccion)
    {
        $tabla = 'metodo_grupo';
        $relaciones = [
            'metodos' => "{$tabla}.metodo_id",
            'grupos' => "{$tabla}.grupo_id"
        ]; 
        $columnas = [
            'unicas' => [],
            'obligatorias' => ['grupo_id','metodo_id'],
            'protegidas' => []
        ];
        parent::__construct($coneccion ,$tabla ,$relaciones,$columnas );
    }
}