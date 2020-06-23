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

    private function generaColumnas( $tabla , $columnas ):string
    {
        $colunmasGeneradas = '';
        foreach ($columnas as $columna)
        {
            $explodeColumna = explode('.',$columna);
            if ( count($explodeColumna) == 1 ){
                $colunmasGeneradas .= "{$tabla}.{$columna},";
            }
            if ( count($explodeColumna) == 2 ){
                $colunmasGeneradas .= "{$explodeColumna[0]}.{$explodeColumna[1]},";
            }
        }
        $colunmasGeneradas = trim($colunmasGeneradas,',');
        $colunmasGeneradas = trim($colunmasGeneradas,' ');

        return $colunmasGeneradas;
        
    }

    private function generaFiltros( $filtros ):string
    {
        $filtrosGenerados = '';
        foreach ($filtros as $filtro )
        {
            $filtrosGenerados .= "{$filtro['campo']} {$filtro['signoComparacion']} :{$filtro['campo']} AND ";
        }
        
        $filtrosGenerados = trim($filtrosGenerados,' ');
        $filtrosGenerados = trim($filtrosGenerados,'AND');
        

        return "WHERE $filtrosGenerados";
    }

    private function generaRelaciones( $relaciones ):string
    {
        $relacionesGeneradas = '';

        foreach ( $relaciones as $tablaRelacionada => $llaveForania)
        {
            $relacionesGeneradas .= "LEFT JOIN $tablaRelacionada ON $tablaRelacionada.id = $llaveForania";
        }
        $relacionesGeneradas = trim($relacionesGeneradas,' ');

        return $relacionesGeneradas;

    }

    private function generaOrderBy( $orderBy ):string
    {
        $orderByGenerado = '';

        foreach ( $orderBy as $campo => $DescAsc)
        {
            $orderByGenerado .= "ORDER BY $campo $DescAsc";
        }
        $orderByGenerado = trim($orderByGenerado,' ');

        return $orderByGenerado;

    }

    public function select($tabla = '', $columnas = [] ,$filtros = [] , $limit = '' , $orderBy = [] , $relaciones = [] )
    {   
        $this->valida->tabla($tabla);
        $columnasGeneradas = '*';
        if ( count($columnas) !== 0 ){
            $this->valida->array('columnas',$columnas);
            $columnasGeneradas = $this->generaColumnas($tabla,$columnas);
        }
        $filtrosGenerados = '';
        if ( count($filtros) !== 0 ){
            $this->valida->filtros($filtros);
            $filtrosGenerados = $this->generaFiltros($filtros);
        }
        $relacionesGeneradas = '';
        if ( count($relaciones) !== 0 ){
            $this->valida->arrayAsociativo('relaciones',$relaciones);
            $relacionesGeneradas = $this->generaRelaciones($relaciones);
        }
        $orderByGenerado = '';
        if ( count($orderBy) !== 0 ){
            $this->valida->arrayAsociativo('orderBy',$orderBy);
            $orderByGenerado = $this->generaOrderBy($orderBy);
        }
        $limitGenerado = '';
        if ($limit != ''){
            $limitGenerado = "LIMIT $limit";
        }
        $consulta = "SELECT $columnasGeneradas FROM {$tabla}";
        $consulta = trim($consulta,' ');
        $consulta .= " {$relacionesGeneradas}";
        $consulta = trim($consulta,' ');
        $consulta .= " {$filtrosGenerados}";
        $consulta = trim($consulta,' ');
        $consulta .= " {$orderByGenerado}";
        $consulta = trim($consulta,' ');
        $consulta .= " {$limitGenerado}";
        $consulta = trim($consulta,' ');
        return $consulta;
    }

    public function update($tabla = '' , $datos = array() , $filtros = array() ):string
    {
        $this->valida->tabla($tabla);
        $this->valida->arrayAsociativo('datos',$datos);

        $filtrosGenerados = '';
        if ( count($filtros) !== 0 )
        {
            $this->valida->filtros($filtros);
            $filtrosGenerados = $this->generaFiltros($filtros);
        }

        $campoValor = '';
        foreach ($datos as $campo => $valor)
        {
            $campoValor .= " $campo = :$campo ,";
        }
        $campoValor = trim($campoValor,',');
        $campoValor = trim($campoValor,' ');

        $consulta = "UPDATE $tabla SET $campoValor $filtrosGenerados";
        $consulta = trim($consulta,' ');
        return $consulta;
    }

}