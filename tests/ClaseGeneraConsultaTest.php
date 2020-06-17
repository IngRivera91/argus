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

        $error = null;
        try{
            $consulta = $generaConsulta->insert();
        }catch(ErrorBase $e){
            $error = $e;
        }
        $mensajeEsperado = 'El nombre de tabla no puede venir vacio';
        $this->assertSame($error->getMessage(),$mensajeEsperado);

        $error = null;
        try{
            $consulta = $generaConsulta->insert('usuarios');
        }catch(ErrorBase $e){
            $error = $e;
        }
        $mensajeEsperado = 'El array de datos no puede estar vacio';
        $this->assertSame($error->getMessage(),$mensajeEsperado);

        $error = null;
        try{
            $consulta = $generaConsulta->insert('usuarios','datos');
        }catch(ErrorBase $e){
            $error = $e;
        }
        $mensajeEsperado = 'Los datos deben venir en un array';
        $this->assertSame($error->getMessage(),$mensajeEsperado);

        $error = null;
        try{
            $consulta = $generaConsulta->insert('usuarios',['juan','password']);
        }catch(ErrorBase $e){
            $error = $e;
        }
        $mensajeEsperado = 'Los datos deben venir en un array asociativo';
        $this->assertSame($error->getMessage(),$mensajeEsperado);

        $tabla = 'usuarios';
        $datos = ['user' => 'pedro' , 'password' => 'contra'];
        $consultaEsperada = 'INSERT INTO usuarios (user,password) VALUES (:user,:password)';
        $consulta = $generaConsulta->insert($tabla,$datos);
        $this->assertSame($consulta,$consultaEsperada);
        
    }
}