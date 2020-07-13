<?php 

namespace Ayuda;

use Interfas\Database;
use Interfas\GeneraConsultas;
use Modelo\MetodosGrupos;

class Genera
{
    public function menu(
        Database $coneccion, 
        GeneraConsultas $generaConsultas, 
        int $grupoId
    ): array {
        
        $modeloMetodosGrupos = new MetodosGrupos($coneccion,$generaConsultas);
        
        $filtros = [
            ['campo' => "metodo_grupo.grupo_id", 'valor'=>$grupoId, 'signoComparacion'=>'=', 'conectivaLogica'=>''],
            ['campo' => "metodos.activo", 'valor'=>true, 'signoComparacion'=>'=', 'conectivaLogica'=>'AND'],
            ['campo' => "metodos.activo_menu", 'valor'=>true, 'signoComparacion'=>'=', 'conectivaLogica'=>'AND'],
            ['campo' => "menus.activo", 'valor'=>true, 'signoComparacion'=>'=', 'conectivaLogica'=>'AND']
        ];
        
        $columnas = [
            'metodos_nombre',
            'metodos_etiqueta',
            'menus_nombre',
            'menus_etiqueta',
            'menus_icono'
        ];

        $orderBy = [
            'menus.nombre' => 'ASC',
            'metodos.nombre' => 'ASC'
        ];

        $resultado = $modeloMetodosGrupos->buscarConFiltros($filtros, $columnas, $orderBy);
        print_r($resultado);exit;
        return $resultado;
    }
}