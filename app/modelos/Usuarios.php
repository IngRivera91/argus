<?php 

namespace Modelo;

use Clase\Modelo;
use Clase\Database;

class Usuarios extends Modelo
{
    public function __construct(Database $coneccion)
    {
        $tabla = 'usuarios';
        $relaciones = [
            'grupos' => "{$tabla}.grupo_id"
        ]; 
        $columnas = [
            'unicas' => ['usuario' => 'usuario','correo' => 'correo_electronico'],
            'obligatorias' => ['usuario','password','correo_electronico','grupo_id'],
            'protegidas' => ['password']
        ];
        parent::__construct($coneccion ,$tabla ,$relaciones,$columnas );
    }

    public function registrar($datos):array
    {
        $datos['password'] = md5($datos['password']);
        $resultado = parent::registrar($datos);
        return $resultado;
    }
}