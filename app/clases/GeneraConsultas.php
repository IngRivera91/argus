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

        $filtrosGenerado = '';
        if ( count($filtros) !== 0 )
        {
            $this->valida->filtros($filtros);
            $filtrosGenerado = $this->generaFiltros($filtros);
        }

        $consulta = "DELETE FROM $tabla $filtrosGenerado";
        $consulta = trim($consulta,' ');

        return $consulta;
    }

    public function insert( $tabla = '' , $datos = array() ):string
    {
        $this->valida->tabla($tabla);
        $this->valida->arrayAsociativo('datos',$datos);
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

    private function generaFiltros( $filtros ):string
    {
        $filtrosGenerado = '';
        foreach ($filtros as $filtro )
        {
            $filtrosGenerado .= "{$filtro['campo']} {$filtro['signoComparacion']} :{$filtro['campo']} AND";
        }

        $filtrosGenerado = trim($filtrosGenerado,'AND');
        $filtrosGenerado = trim($filtrosGenerado,' ');

        return "WHERE $filtrosGenerado";
    }

    private function generaRelaciones( $tabla , $relaciones):string
    {
        $relacionesGeneradas = '';

        foreach ( $relaciones as $tablaRelacionada => $llaveForania)
        {
            $relacionesGeneradas .= " LEFT JOIN $tabla ON $tablaRelacionada.id = $llaveForania ";
        }
        $relacionesGeneradas = trim($relacionesGeneradas,' ');

        return $relacionesGeneradas;

    }

    public function update($tabla = '' , $datos = array() , $filtros = array() ):string
    {
        $this->valida->tabla($tabla);
        $this->valida->arrayAsociativo('datos',$datos);

        $filtrosGenerado = '';
        if ( count($filtros) !== 0 )
        {
            $this->valida->filtros($filtros);
            $filtrosGenerado = $this->generaFiltros($filtros);
        }

        $campoValor = '';
        foreach ($datos as $campo => $valor)
        {
            $campoValor .= " $campo = :$campo ,";
        }
        $campoValor = trim($campoValor,',');
        $campoValor = trim($campoValor,' ');

        $consulta = "UPDATE $tabla SET $campoValor $filtrosGenerado";
        $consulta = trim($consulta,' ');
        return $consulta;
    }

}