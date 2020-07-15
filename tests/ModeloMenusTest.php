<?php

use Modelo\Menus;
use Error\Base AS ErrorBase;
use PHPUnit\Framework\TestCase;

class ModeloMenusTest extends TestCase
{
    /**
     * @test
     */
    public function creaModelo()
    {
        $this->assertSame(1,1);
        $claseDatabase = 'Clase\\Database'.DB_TIPO;
        $coneccion = new $claseDatabase();

        $claseGeneraConsultas = 'Clase\\GeneraConsultas'.DB_TIPO;
        $generaConsultas = new $claseGeneraConsultas($coneccion);
        
        return new Menus($coneccion,$generaConsultas);
    }

    /**
     * @test
     * @depends creaModelo
     */
    public function buscarTodo($modelo)
    {
        $resultado = $modelo->buscarTodo();
        $this->assertIsArray($resultado);
        $this->assertSame(0,$resultado['n_registros']);
        $this->assertCount(0,$resultado['registros']);
    }
}