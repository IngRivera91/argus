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

    public function delete( $tabla , $filtros = [] ):string
    {
        $this->valida->nombreTabla($tabla);

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

    public function insert( $tabla = '' , $datos = [] ):string
    {
        $this->valida->nombreTabla($tabla);
        $this->valida->arrayAsociativo('datos',$datos);
        $campos = '';
        $valores = '';

        foreach ($datos as $campo => $valor)
        {
            $campo_explode = explode('.',$campo);
            $numero = count($campo_explode);
            if ($numero == 2){
                $campos .=  "{$campo[0]}_{$campo[1]} ,";
                $valores .=  ":{$campo[0]}_{$campo[1]} ,";
            }
            if ($numero == 1){
                $campos .=  "$campo,";
                $valores .=  ":$campo,";
            }  
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
            if ( count($explodeColumna) == 2 ){
                $colunmasGeneradas .= "{$explodeColumna[0]}.{$explodeColumna[1]} AS {$explodeColumna[0]}_{$explodeColumna[1]},";
            }
            if ( count($explodeColumna) == 1 ){

                $explodeColumna = explode('_',$columna);
                if ( count($explodeColumna) == 2 ){
                    $colunmasGeneradas .= "{$explodeColumna[0]}.{$explodeColumna[1]} AS {$explodeColumna[0]}_{$explodeColumna[1]},";
                }
                
                if ( count($explodeColumna) == 1 ){
                    $colunmasGeneradas .= "{$tabla}.{$columna} AS {$tabla}_{$columna},";
                }
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
            $conectivaLogica = '';
            if (isset($filtro['conectivaLogica'])){
                $conectivaLogica = $filtro['conectivaLogica'];
            }

            $campo_explode = explode('.',$filtro['campo']);
            $numero = count($campo_explode);
            if ($numero == 2){
                $filtrosGenerados .= "$conectivaLogica {$filtro['campo']} {$filtro['signoComparacion']} :{$campo_explode[0]}_{$campo_explode[1]} ";
            }
            if ($numero == 1){
                $filtrosGenerados .= "$conectivaLogica {$filtro['campo']} {$filtro['signoComparacion']} :{$filtro['campo']} ";
            }

        }
        
        $filtrosGenerados = trim($filtrosGenerados,' ');
        
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
        $this->valida->nombreTabla($tabla);
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

    public function update($tabla = '' , $datos = [] , $filtros = [] ):string
    {
        $this->valida->nombreTabla($tabla);
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
            $campo_explode = explode('.',$campo);
            $numero = count($campo_explode);
            if ($numero == 2){
                $campoValor .= " {$campo[0]}_{$campo[1]} = :{$campo[0]}_{$campo[1]} ,";
            }
            if ($numero == 1){
                $campoValor .= " $campo = :$campo ,";
            }

        }
        $campoValor = trim($campoValor,',');
        $campoValor = trim($campoValor,' ');

        $consulta = "UPDATE $tabla SET $campoValor $filtrosGenerados";
        $consulta = trim($consulta,' ');
        return $consulta;
    }

}