<?php

use Error\Base AS ErrorBase;
use Clase\GeneraConsulta; 
use PHPUnit\Framework\TestCase;

class ClaseGeneraConsultaTest extends TestCase
{
    /**
     * @test
     */
    public function generaConsultaInsert()
    {
        $generaConsulta = new GeneraConsulta();

        $tabla = 'usuarios';
        $datos = ['user' => 'pedro' , 'password' => 'contra'];

        $consultaEsperada = 'INSERT INTO usuarios (user,password) VALUES (:user,:password)';
        
        $consulta = $generaConsulta->insert($tabla,$datos);
        $this->assertSame($consulta,$consultaEsperada);
        
    }
}