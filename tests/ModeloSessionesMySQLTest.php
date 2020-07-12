<?php

use Clase\DatabaseMySQL;
use Clase\GeneraConsultasMySQL;
use Modelo\Sessiones;
use Error\Base AS ErrorBase;
use PHPUnit\Framework\TestCase;

class ModeloSessionesMySQLTest extends TestCase
{
    /**
     * @test
     */
    public function creaModelo()
    {
        $this->assertSame(1,1);
        $coneccion = new DatabaseMySQL();
        $generaConsultas = new GeneraConsultasMySQL($coneccion);
        $coneccion->ejecutaConsultaDelete('DELETE FROM sessiones');
        return new Sessiones($coneccion,$generaConsultas);
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