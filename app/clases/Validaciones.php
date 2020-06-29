<?php

namespace Clase;

use Error\Base AS ErrorBase;

class Validaciones 
{

    public function analizaCampo($campo)
    {
        $campo_explode = explode('.',$campo);
        $numero = count($campo_explode);
        if ($numero == 2){
            return "{$campo_explode[0]}_{$campo_explode[1]}";
        }
        if ($numero == 1){
            return $campo;
        }  
    }
    
    public function consulta(string $consulta = ''):void
    {
        if( $consulta === '')
        {
            throw new ErrorBase('La consulta no puede estar vacia');
        }

    }

    public function arrayAsociativo(string $nombreArray = '' ,$array):void
    {
        $this->array($nombreArray,$array);

        if ( !$this->esAsociativo($array) )
        {
            throw new ErrorBase("Array:$nombreArray debe ser un array asociativo");
        }
    }

    public function array(string $nombreArray = '' ,$array):void
    {
        if ( !is_array($array) )
        {
            throw new ErrorBase("Array:$nombreArray debe ser un array");
        }
        
        if ( count($array) === 0)
        {
            throw new ErrorBase("Array:$nombreArray no puede ser un array vacio");
        }
    }

    public function filtros($filtros)
    {
        if ( !is_array($filtros) )
        {
            throw new ErrorBase('Los filtros deben venir en un array');
        }

        if ( count($filtros) === 0)
        {
            throw new ErrorBase('El array de filtros no puede estar vacio');
        }

        foreach ($filtros as $filtro)
        {
            if ( !is_array($filtro) )
            {
                throw new ErrorBase('Los filtros deben ser un array de arrays');
            }
            if (!array_key_exists('campo', $filtro)) {
                throw new ErrorBase('Cada filtro debe tener el key [\'campo\']');
            }
            if (!array_key_exists('valor', $filtro)) {
                throw new ErrorBase('Cada filtro debe tener el key [\'valor\']');
            }
            if (!array_key_exists('signoComparacion', $filtro)) {
                throw new ErrorBase('Cada filtro debe tener el key [\'signoComparacion\']');
            }
        }
    }

    public function nombreTabla($tabla):void
    {
        $tabla = trim($tabla,' ');

        if ($tabla === '')
        {
            throw new ErrorBase('El nombre de tabla no puede venir vacio');
        }

        $explodeTabla = explode(' ',$tabla);
        
        if ( count($explodeTabla) != 1 )
        {
            throw new ErrorBase('El nombre de la tabla no es valido');
        }
    }

    private function esAsociativo( $array ) 
    {
        // https://cybmeta.com/comprobar-si-un-array-es-asociativo-o-secuencial-en-php
        return array_keys( $array ) !== range( 0, count($array) - 1 );
    }

}