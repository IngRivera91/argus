<?php 

namespace Clase;
use Clase\Validaciones;

class GeneraConsulta 
{
    private $valida;
    public function __construct()
    {
        $this->valida = new Validaciones();
    }

    public function delete( $tabla , $filtros = array() ):string
    {
        $filtroGenerado = '';
        if ( count($filtros) !== 0 )
        {
            $this->valida->filtros($filtros);
            $filtroGenerado = $this->generaFiltro($filtros);
        }

        $consulta = "DELETE FROM $tabla $filtroGenerado";
        $consulta = trim($consulta,' ');

        return $consulta;
    }

    public function insert( $tabla = '' , $datos = array() ):string
    {
        $this->valida->tabla($tabla);
        $this->valida->datos($datos);
        $campos = '';
        $valores = '';

        foreach ($datos as $campo => $valor)
        {
            $campos .=  $campo.',';
            $valores .=  ':'.$campo.',';
        }

        $campos = trim($campos,',');
        $valores = trim($valores,',');
    
        return "INSERT INTO $tabla ($campos) VALUES ($valores)";
    }

    private function generaFiltro( $filtros ):string
    {
        $filtroGenerado = '';
        foreach ($filtros as $filtro )
        {
            $filtroGenerado .= "{$filtro['campo']} {$filtro['signoComparacion']} :{$filtro['campo']} AND";
        }

        $filtroGenerado = trim($filtroGenerado,'AND');
        $filtroGenerado = trim($filtroGenerado,'');

        return "WHERE $filtroGenerado";
    }

}