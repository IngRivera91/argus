<?php 

namespace Clase;
use Clase\Validaciones;

class GeneraConsultas 
{
    private $valida;
    public function __construct()
    {
        $this->valida = new Validaciones();
    }

    public function delete( $tabla , $filtros = array() ):string
    {
        $this->valida->tabla($tabla);

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

    public function update($tabla = '' , $datos = array() , $filtros = array() ):string
    {
        $this->valida->tabla($tabla);
        $this->valida->datos($datos);

        $filtroGenerado = '';
        if ( count($filtros) !== 0 )
        {
            $this->valida->filtros($filtros);
            $filtroGenerado = $this->generaFiltro($filtros);
        }

        $campoValor = '';
        foreach ($datos as $campo => $valor)
        {
            $campoValor .= " $campo = :$campo ,";
        }
        $campoValor = trim($campoValor,',');
        $campoValor = trim($campoValor,' ');

        $consulta = "UPDATE $tabla SET $campoValor $filtroGenerado";
        $consulta = trim($consulta,' ');
        return $consulta;
    }

}