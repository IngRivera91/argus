<?php

namespace Clase;

use Error\Base AS ErrorBase;

class Validaciones 
{
    public function consulta(string $consulta = ''):void
    {
        if( $consulta === '')
        {
            throw new ErrorBase('La consulta no puede estar vacia');
        }

    }

    public function datos($datos):void
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

    public function tabla($tabla):void
    {
        if ($tabla === '')
        {
            throw new ErrorBase('El nombre de tabla no puede venir vacio');
        }
    }

    private function esAsociativo( $array ) 
    {
        return array_keys( $array ) !== range( 0, count($array) - 1 );
    }
    
}