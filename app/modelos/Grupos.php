<?php 

namespace Modelo;

use Clase\Modelo;
use Modelo\Metodos;
use Interfas\Database;
use Modelo\MetodosGrupos;
use Error\Base AS ErrorBase;

class Grupos extends Modelo
{
    public Modelo $MetodosGrupos;
    public Modelo $Metodos;

    public function __construct(Database $coneccion)
    {
        $this->MetodosGrupos = new MetodosGrupos($coneccion);
        $this->Metodos = new Metodos($coneccion);
        $tabla = 'grupos';
        $relaciones = []; 
        $columnas = [
            'unicas' => ['grupo' => 'nombre'],
            'obligatorias' => ['nombre'],
            'protegidas' => []
        ];
        parent::__construct($coneccion, $tabla, $relaciones, $columnas);
    }

    public function obtenerMetodosAgrupadosPorMenu(int $grupoId):array
    {
        $columnas = ['id','nombre','menus_nombre'];
        $orderBy = ['menus.nombre' => 'ASC'];

        try {
            $resultado = $this->Metodos->buscarTodo($columnas, $orderBy);
        } catch (ErrorBase $e) {
            throw new ErrorBase('Error al tratar de obtener los Metodos',$e);
        }

        try {
            $ids = $this->obtenerIdsMetodosGrupos($grupoId);
        } catch (ErrorBase $e) {
            throw new ErrorBase('Error al tratar de obtener los ids',$e);
        }

        $metodos = [];

        foreach ($resultado['registros'] as $registro) {

            $nombreMenu = $registro['menus_nombre'];
            if (!isset($metodos[$nombreMenu])){
                $metodos[$nombreMenu] = [];
            }
            $activo = 0;
            if (in_array($registro['metodos_id'],$ids)){
                $activo = 1;
            }

            $metodos[$nombreMenu ][] = [
                'id' => $registro['metodos_id'],
                'metodo' => $registro['metodos_nombre'],
                'activo' => $activo 
            ];
        }

        return $metodos;
    }

    public function obtenerIdsMetodosGrupos(int $grupoId):array
    {
        $filtros = [
            ['campo' => "{$this->MetodosGrupos->obtenerTabla()}.grupo_id", 'valor'=>$grupoId, 'signoComparacion'=>'=', 'conectivaLogica'=>'']
        ];
    
        $columnas = ['id'];
        $orderBy = [];
        $limit = '';
        $noUsarRelaciones = true;
        try {
            $resultado = $this->MetodosGrupos->buscarConFiltros($filtros, $columnas, $orderBy, $limit, $noUsarRelaciones);
        } catch (ErrorBase $e) {
            throw new ErrorBase('Error al tratar de obtener los MetodosGrupos',$e);
        }

        $ids = [];

        foreach ($resultado['registros'] as $registro) {
            $ids[] = $registro["{$this->MetodosGrupos->obtenerTabla()}_id"];
        }

        return $ids;
    }
}