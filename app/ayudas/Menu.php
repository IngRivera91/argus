<?php 

namespace Ayuda;

use Interfas\Database;
use Interfas\GeneraConsultas;
use Modelo\MetodosGrupos;

class Menu
{
    public static function crear(
        Database $coneccion, 
        GeneraConsultas $generaConsultas, 
        int $grupoId
    ): array {
        
        if (isset($_SESSION[SESSION_ID]['menuDefinido'])) {
            return $_SESSION[SESSION_ID]['menuDefinido'];
        }

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

        $menuDefinido = array();

        foreach ( $resultado['registros'] as $menu){
            if (!isset($menuDefinido[ $menu['menus_etiqueta'] ])){
                $menuDefinido[ $menu['menus_etiqueta'] ] = array($menu['menus_nombre'],
                    $menu['menus_icono'],$menu['menus_etiqueta']);
            }
            array_push($menuDefinido[ $menu['menus_etiqueta'] ] ,array(
                'label' =>  $menu['metodos_etiqueta'],
                'metodo' => $menu['metodos_nombre']
            ));

        }
        $_SESSION[SESSION_ID]['menuDefinido'] = $menuDefinido; 
        return $menuDefinido;
    }
}