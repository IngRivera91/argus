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

}