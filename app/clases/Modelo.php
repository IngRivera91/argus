<?php

namespace Clase;

use Clase\Database;
use Clase\Validaciones;
use Clase\GeneraConsultas;
use Error\Base AS ErrorBase;

class Modelo 
{
    private Validaciones $valida;
    private GeneraConsultas $generaConsulta;
    private string $tabla;
    private Database $coneccion;
    private array $columnasUnicas;
    private array $columnasObligatorias;
    private array $columnasProtegidas;
    private array $relaciones;

    public function __construct( Database $coneccion ,string $tabla ,array $relaciones, array $columnas )
    {
        $this->valida  = new Validaciones();
        $this->generaConsulta = new GeneraConsultas();
        $this->coneccion = $coneccion;
        $this->tabla = $tabla;
        $this->relaciones = $relaciones;
        $this->columnasUnicas = $columnas['unicas'];
        $this->columnasObligatorias = $columnas['obligatorias'];
        $this->columnasProtegidas = $columnas['protegidas'];
    }

    public function registrarBd($datos)
    {
        $consulta = $this->generaConsulta->insert($this->tabla,$datos);
        $resultado = $this->coneccion->ejecutaConsultaInsert($consulta,$datos);
        return $resultado;
    }

    

}