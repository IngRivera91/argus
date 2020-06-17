<?php

use Clase\GeneraConsultas; 
use PHPUnit\Framework\TestCase;

class ClaseGeneraConsultasTest extends TestCase
{

    /**
     * @test
     */
    public function generaConsultaDelete()
    {
        $generaConsulta = new GeneraConsultas();
        $tabla = 'usuarios';

        $consultaEsperada = 'DELETE FROM usuarios';
        $consulta = $generaConsulta->delete($tabla);
        $this->assertSame($consulta,$consultaEsperada);
        $filtros = [
            ['campo' => 'id' , 'valor' => '1' , 'signoComparacion' => '=']
        ];
        $consultaEsperada = 'DELETE FROM usuarios WHERE id = :id';
        $consulta = $generaConsulta->delete($tabla,$filtros);
        $this->assertSame($consulta,$consultaEsperada);
        
    }

    /**
     * @test
     */
    public function generaConsultaInsert()
    {
        $generaConsulta = new GeneraConsultas();

        $tabla = 'usuarios';
        $datos = ['user' => 'pedro' , 'password' => 'contra'];

        $consultaEsperada = 'INSERT INTO usuarios (user,password) VALUES (:user,:password)';
        $consulta = $generaConsulta->insert($tabla,$datos);
        
        $this->assertSame($consulta,$consultaEsperada);
        
    }
}