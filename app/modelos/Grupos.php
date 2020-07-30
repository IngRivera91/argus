<?php 

namespace Modelo;

use Clase\Modelo;
use Interfas\Database;
use Modelo\MetodosGrupos;
use Error\Base AS ErrorBase;

class Grupos extends Modelo
{
    public Modelo $MetodosGrupos;

    public function __construct(Database $coneccion)
    {
        $this->MetodosGrupos = new MetodosGrupos($coneccion);
        $tabla = 'grupos';
        $relaciones = []; 
        $columnas = [
            'unicas' => ['grupo' => 'nombre'],
            'obligatorias' => ['nombre'],
            'protegidas' => []
        ];
        parent::__construct($coneccion, $tabla, $relaciones, $columnas);
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