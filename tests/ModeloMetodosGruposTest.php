<?php

use Modelo\MetodosGrupos;
use Error\Base AS ErrorBase;
use PHPUnit\Framework\TestCase;

class ModeloMetodosGruposTest extends TestCase
{
    /**
     * @test
     */
    public function creaModelo()
    {
        $this->assertSame(1,1);
        $claseDatabase = 'Clase\\'.DB_TIPO.'\\Database';
        $coneccion = new $claseDatabase();

        $claseGeneraConsultas = 'Clase\\'.DB_TIPO.'\\GeneraConsultas';
        $generaConsultas = new $claseGeneraConsultas($coneccion);
        
        return new MetodosGrupos($coneccion,$generaConsultas);
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