<?php 

namespace Modelo;

use Clase\Modelo;
use Clase\Database;
use Error\Base AS ErrorBase;
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

    public function buscarPorSessionId(string $sessionId):array
    {
        $filtros = [
            ['campo' => "sessiones.session_id" , 'valor' =>  $sessionId , 'signoComparacion' => '=' , 'conectivaLogica' => '' ]
        ];

        $resultado = parent::buscarConFiltros($filtros);

        if ( $resultado['n_registros'] !== 1){
            throw new ErrorBase('sessionId no valido');
        }
        unset($resultado['registros'][0]['usuarios_password']);
        return $resultado['registros'][0];
    }
}