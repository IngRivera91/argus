<?php 

namespace Clase;
use Clase\Validaciones;
use Interfas\GeneraConsultas;
use Interfas\Database;

class GeneraConsultasMySQL implements GeneraConsultas
{
    private Validaciones $valida;
    private Database $coneccion;
    public function __construct(Database $coneccion)
    {
        $this->coneccion = $coneccion;
        $this->valida = new Validaciones();
    }

    public function delete(string $tabla, array $filtros = []):string
    {
        $this->valida->nombreTabla($tabla);
        $filtrosGenerados = $this->generaFiltros($filtros);
        $consulta = "DELETE FROM {$tabla}{$filtrosGenerados}";
        return $consulta;
    }

    public function insert(string $tabla = '', array $datos = []):string
    {
        $this->valida->nombreTabla($tabla);
        $this->valida->arrayAsociativo('datos',$datos);
        $campos = '';
        $valores = '';

        foreach ($datos as $campo => $valor)
        {
            $campos .=  "{$this->valida->analizaCampo($campo)},";
            $valores .=  ":{$this->valida->analizaCampo($campo)},";
        }

        $campos = trim($campos,',');
        $valores = trim($valores,',');
    
        return "INSERT INTO $tabla ($campos) VALUES ($valores)";
    }

    private function generaColumnas(string $tabla, array $columnas):string
    {
        $colunmasGeneradas = '';
        foreach ($columnas as $columna)
        {
            $explodeColumna = explode('_',$columna);
            if ( count($explodeColumna) > 1 ){
                $explodeColumnasFinal = '';
                for($i = 1 ; $i < count($explodeColumna) ; $i ++)
                {
                    $explodeColumnasFinal .= "{$explodeColumna[$i]}_";
                    
                }
                $explodeColumnasFinal = trim($explodeColumnasFinal,'_');
                $colunmasGeneradas .= "{$explodeColumna[0]}.$explodeColumnasFinal ";
                $colunmasGeneradas .= "AS {$explodeColumna[0]}_$explodeColumnasFinal,";
            }
            if ( count($explodeColumna) == 1 ){
                $colunmasGeneradas .= "{$tabla}.{$columna} AS {$tabla}_{$columna},";
            }
        }
        $colunmasGeneradas = trim($colunmasGeneradas,',');
        $colunmasGeneradas = trim($colunmasGeneradas,' ');
        return $colunmasGeneradas; 
    }

    private function generaFiltros(array $filtros):string
    {
        $filtrosGenerados = '';
        if ( count($filtros) === 0 )
        {
             return $filtrosGenerados;
        }
        $this->valida->filtros($filtros);
        foreach ($filtros as $filtro )
        {
            $conectivaLogica = '';
            if (isset($filtro['conectivaLogica'])){
                $conectivaLogica = $filtro['conectivaLogica'];
            }
            $filtrosGenerados .= "$conectivaLogica {$filtro['campo']} {$filtro['signoComparacion']} ";
            $filtrosGenerados .= ":{$this->valida->analizaCampo($filtro['campo'])} ";
        }
        $filtrosGenerados = trim($filtrosGenerados,' ');
        return " WHERE $filtrosGenerados";
    }

    private function generaLimit(string $limit):string
    {
        if ($limit != ''){
            return " LIMIT $limit";
        }
        return '';
    }

    private function generaOrderBy(array $orderBy):string
    {
        $orderByGenerado = '';
        if ( count($orderBy) === 0 )
        {
             return $orderByGenerado;
        }
        $this->valida->arrayAsociativo('orderBy',$orderBy);
        $orderByGenerado = 'ORDER BY ';
        foreach ( $orderBy as $campo => $DescAsc)
        {
            $orderByGenerado .= "$campo $DescAsc, ";
        }
        $orderByGenerado = trim($orderByGenerado,' ');
        $orderByGenerado = trim($orderByGenerado,',');

        return " $orderByGenerado";
    }

    private function generaRelaciones(array $relaciones):string
    {
        $relacionesGeneradas = '';
        if ( count($relaciones) === 0 )
        {
             return $relacionesGeneradas;
        }
        $this->valida->arrayAsociativo('relaciones',$relaciones);
        foreach ( $relaciones as $tablaRelacionada => $llaveForania)
        {
            $relacionesGeneradas .= " LEFT JOIN $tablaRelacionada ON $tablaRelacionada.id = $llaveForania";
        }
        $relacionesGeneradas = trim($relacionesGeneradas,' ');

        return " $relacionesGeneradas";
    }

    private function generaTodasLasColumnas(string $tabla, array $relaciones):string
    {
        $colunmasGeneradas = '';

        $arrayColumnas = $this->coneccion->obtenColumnasTabla($tabla);
        foreach ($arrayColumnas as $columna)
        {
            $colunmasGeneradas .= "{$tabla}.{$columna} AS {$tabla}_{$columna},";
        }

        foreach ($relaciones as $tablaRelacion => $relacion)
        {
            $arrayColumnas = $this->coneccion->obtenColumnasTabla($tablaRelacion);
            foreach ($arrayColumnas as $columna)
            {
                $colunmasGeneradas .= "{$tablaRelacion}.{$columna} AS {$tablaRelacion}_{$columna},";
            }
        }

        $colunmasGeneradas = trim($colunmasGeneradas,',');
        return $colunmasGeneradas; 
    }

    private function obtenColumnas(string $tabla, array $columnas, array $relaciones):string
    {
        $columnasGeneradas = '';
        if ( count($columnas) === 0 ){
            $columnasGeneradas = $this->generaTodasLasColumnas($tabla,$relaciones);
        }
        if ( count($columnas) !== 0 ){
            $this->valida->array('columnas',$columnas);
            $columnasGeneradas = $this->generaColumnas($tabla,$columnas);
        }
        return $columnasGeneradas;
    }
    
    public function select(
        string $tabla = '',
        array $columnas = [],
        array $filtros = [], 
        string $limit = '',
        array $orderBy = [],
        array $relaciones = []
    ) {   
        $this->valida->nombreTabla($tabla);
        $columnasGeneradas = $this->obtenColumnas($tabla,$columnas,$relaciones);
        $filtrosGenerados = $this->generaFiltros($filtros);
        $relacionesGeneradas = $this->generaRelaciones($relaciones);
        $orderByGenerado = $this->generaOrderBy($orderBy);
        $limitGenerado = $this->generaLimit($limit);
        $consultaSelect = "SELECT {$columnasGeneradas} FROM {$tabla}";
        $consultaSelect .= "{$relacionesGeneradas}{$filtrosGenerados}{$orderByGenerado}{$limitGenerado}";
        return $consultaSelect;
    }

    public function update(
        string $tabla = '', 
        array $datos = [], 
        array $filtros = [] 
    ): string {
        $this->valida->nombreTabla($tabla);
        $this->valida->arrayAsociativo('datos',$datos);

        $filtrosGenerados = $this->generaFiltros($filtros);

        $campoValor = '';
        foreach ($datos as $campo => $valor)
        {
            $campoValor .= " {$this->valida->analizaCampo($campo)} = :{$this->valida->analizaCampo($campo)} ,";
        }
        $campoValor = trim($campoValor,',');
        $campoValor = trim($campoValor,' ');

        $consulta = "UPDATE $tabla SET {$campoValor}{$filtrosGenerados}";
        return $consulta;
    }

}