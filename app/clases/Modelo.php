<?php

namespace Clase;

use Clase\Database;
use Clase\Validaciones;
use Clase\GeneraConsultas;
use Error\Base AS ErrorBase;

class Modelo 
{
    public Validaciones $valida;
    private GeneraConsultas $generaConsulta;
    private string $tabla;
    private Database $coneccion;
    private array $columnasUnicas;
    private array $columnasObligatorias;
    private array $columnasProtegidas;
    private array $relaciones;

    public function __construct(Database $coneccion,string $tabla,array $columnasUnicas,array $columnasObligatorias,array $columnasProtegidas,array $relaciones)
    {
        $this->valida  = new Validaciones();
        $this->generaConsulta = new GeneraConsultas();
        $this->coneccion = $coneccion;
        $this->tabla = $tabla;
        $this->columnasUnicas = $columnasUnicas;
        $this->columnasObligatorias = $columnasObligatorias;
        $this->columnasProtegidas = $columnasProtegidas;
        $this->relaciones = $relaciones;
    }

    public function registrarBd($datos)
    {
        $this->valida->array('datos',$datos);

        try{
            $consulta = $this->generaConsulta->insert($this->tabla,$datos);
        }catch (ErrorBase $e){
            throw new ErrorBase('Error al tratar de generar la consulta');
        }
        
        $this->valida->columnasUnicas($this->columnasUnicas,$datos);

        try{
            $res = $this->coneccion->ejecutaConsultaInsert($consulta,$datos);
        }catch (ErrorBase $e){
            throw new ErrorBase('Error al ejecutar la consulta: '.$consulta);
        }
        
        return $res;
        
    }

    

}