<?php

use Modelo\Grupos;
use Modelo\MetodosGrupos;
use Error\Base AS ErrorBase;
use PHPUnit\Framework\TestCase;

class ModeloGruposTest extends TestCase
{
    /**
     * @test
     */
    public function crearConeccion()
    {
        $this->assertSame(1,1);
        $claseDatabase = 'Clase\\'.DB_TIPO.'\\Database';
        $coneccion = new $claseDatabase();
        return $coneccion;
    }

    /**
     * @test
     * @depends crearConeccion
     */
    public function crearModelo($coneccion)
    {
        $this->assertSame(1,1);
        $MetodosGrupos = new MetodosGrupos($coneccion);
        $Grupos = new Grupos($coneccion);

        $MetodosGrupos->eliminarTodo();
        $Grupos->eliminarTodo();

        return $Grupos;
    }

    /**
     * @test
     * @depends crearModelo
     */
    public function registrar($modelo)
    {
        $registros = [
            ['id' => 1,'nombre' => 'nombre1' , 'activo' => 1],
            ['id' => 2,'nombre' => 'nombre2' , 'activo' => 1],
            ['id' => 3,'nombre' => 'nombre3' , 'activo' => 1],
            ['id' => 4,'nombre' => 'nombre4' , 'activo' => 1],
        ];

        foreach ($registros as $key => $registro) {

            $resultado = $modelo->registrar($registro);
            $this->assertIsArray($resultado);
            $this->assertCount(2,$resultado);
            $mensajeEsperado = 'datos registrados';
            $this->assertSame($mensajeEsperado,$resultado['mensaje']);
            $this->assertSame($registro['id'],$resultado['registroId']);

            $error = null;
            try {
                $resultado = $modelo->registrar($registro);
            } catch (ErrorBase $e) {
                $error = $e;
            }
            $mensajeEsperado = "grupo:{$registro['nombre']} ya registrad@";
            $this->assertSame($mensajeEsperado,$error->getMessage());

        }

    }
}