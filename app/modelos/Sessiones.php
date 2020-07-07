<?php 

namespace Modelo;

use Clase\Modelo;
use Clase\Database;

class Sessiones extends Modelo
{
    public function __construct(Database $coneccion)
    {
        $tabla = 'sessiones';
        $relaciones = [
            'usuarios' => "{$tabla}.usuario_id",
            'grupos' => "{$tabla}.grupo_id"
        ]; 
        $columnas = [
            'unicas' => [],
            'obligatorias' => ['session_id','usuario_id','grupo_id'],
            'protegidas' => ['session_id']
        ];
        parent::__construct($coneccion ,$tabla ,$relaciones,$columnas );
    }
}