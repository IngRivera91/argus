<?php 

namespace Clase;
use Error\Base AS ErrorBase;

class GeneraConsulta 
{
    public function insert( $tabla = '' , $datos = array() ):string
    {
        $this->validaTabla($tabla);
        $this->validaDatos($datos);
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


    private function validaDatos($datos):void
    {
        if ( !is_array($datos) )
        {
            throw new ErrorBase('Los datos deben venir en un array');
        }
        if ( count($datos) === 0)
        {
            throw new ErrorBase('El array de datos no puede estar vacio');
        }
    }

    private function validaTabla($tabla):void
    {
        if ($tabla === '')
        {
            throw new ErrorBase('El nombre de tabla no puede venir vacio');
        }
    }

}