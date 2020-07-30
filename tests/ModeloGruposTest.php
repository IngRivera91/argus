<?php

use Modelo\Menus;
use Modelo\Grupos;
use Modelo\Metodos;
use Modelo\MetodosGrupos;
use Error\Base AS ErrorBase;
use PHPUnit\Framework\TestCase;

class ModeloGruposTest extends TestCase
{
    public int $registrosExtras = 2;
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
        $Metodos = new Metodos($coneccion);
        $Menus = new Menus($coneccion);

        $MetodosGrupos->eliminarTodo();
        $Grupos->eliminarTodo();
        $Metodos->eliminarTodo();
        $Menus->eliminarTodo();
        
        $grupos = [
            ['id' => 5,'nombre' => 'nombre5' , 'activo' => 1],
            ['id' => 6,'nombre' => 'nombre6' , 'activo' => 1]
        ];
        foreach ($grupos as $grupo) {
            $Grupos->registrar($grupo);
        }

        $menus = [
            ['id' => 1,'nombre' => 'nombre1' , 'activo' => 1],
            ['id' => 2,'nombre' => 'nombre2' , 'activo' => 1]
        ];
        foreach ($menus as $menu) {
            $Menus->registrar($menu);
        }

        $metodos = [
            ['id'=>1, 'nombre'=>'accion1', 'accion'=> 'accion1', 'icono' => 'icono-accion1', 'menu_id'=>1, 'activo_menu'=>0, 'activo_accion'=>1],
            ['id'=>2, 'nombre'=>'accion2', 'accion'=> 'accion2', 'icono' => 'icono-accion2', 'menu_id'=>1, 'activo_menu'=>0, 'activo_accion'=>1],
            ['id'=>3, 'nombre'=>'accion3', 'accion'=> 'accion3', 'icono' => 'icono-accion3', 'menu_id'=>1, 'activo_menu'=>0, 'activo_accion'=>1],
            ['id'=>4, 'nombre'=>'accion4', 'accion'=> 'accion4', 'icono' => 'icono-accion4', 'menu_id'=>1, 'activo_menu'=>0, 'activo_accion'=>1],

            ['id'=>5, 'nombre'=>'accion1', 'accion'=> 'accion1', 'icono' => 'icono-accion1', 'menu_id'=>2, 'activo_menu'=>0, 'activo_accion'=>1],
            ['id'=>6, 'nombre'=>'accion2', 'accion'=> 'accion2', 'icono' => 'icono-accion2', 'menu_id'=>2, 'activo_menu'=>0, 'activo_accion'=>1],
            ['id'=>7, 'nombre'=>'accion3', 'accion'=> 'accion3', 'icono' => 'icono-accion3', 'menu_id'=>2, 'activo_menu'=>0, 'activo_accion'=>1],
            ['id'=>8, 'nombre'=>'accion4', 'accion'=> 'accion4', 'icono' => 'icono-accion4', 'menu_id'=>2, 'activo_menu'=>0, 'activo_accion'=>1]
        ];
        foreach ($metodos as $metodo) {
            $Metodos->registrar($metodo);
        }

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

        return $registros;

    }

    /**
     * @test
     * @depends crearModelo
     * @depends registrar
     */
    public function obtenerDatosConRegistroId($modelo,$registros)
    {
        foreach ($registros as $key => $registro) {

            $resultado = $modelo->obtenerDatosConRegistroId($registro['id']);
            $this->assertIsArray($resultado);
            $this->assertCount(7,$resultado);

            $columnas = [];
            $orderBy = [];
            $limit = '';
            $noUsarRelaciones = true;

            $resultado = $modelo->obtenerDatosConRegistroId($registro['id'], $columnas, $orderBy, $limit, $noUsarRelaciones);
            $this->assertIsArray($resultado);
            $this->assertCount(7,$resultado);
        }
        return $registros;
    }

    /**
     * @test
     * @depends crearModelo
     * @depends obtenerDatosConRegistroId
     */
    public function obtenerNumeroRegistros($modelo,$registros)
    {
        $resultado = $modelo->obtenerNumeroRegistros();
        $this->assertSame((count($registros)+$this->registrosExtras),$resultado);
        return $registros;
    }

    /**
     * @test
     * @depends crearModelo
     * @depends obtenerNumeroRegistros
     */
    public function existeRegistroId($modelo,$registros)
    {
        $resultado = $modelo->existeRegistroId(-1);
        $this->assertIsBool($resultado);
        $this->assertSame(false,$resultado);

        foreach ($registros as $key => $registro) {

            $resultado = $modelo->existeRegistroId($registro['id']);
            $this->assertIsBool($resultado);
            $this->assertSame(true,$resultado);
        }
        return $registros;
    }

    /**
     * @test
     * @depends crearModelo
     * @depends existeRegistroId
     */
    public function buscarPorId($modelo,$registros)
    {
        foreach ($registros as $key => $registro) {

            $resultado = $modelo->buscarPorId($registro['id']);
            $this->assertIsArray($resultado);
            $this->assertCount(2,$resultado);
            $this->assertSame(1,$resultado['numeroRegistros']);
            $this->assertCount(1,$resultado['registros']);
            
        }
        return $registros;
    }

    /**
     * @test
     * @depends crearModelo
     * @depends buscarPorId
     */
    public function modificarPorId($modelo,$registros)
    {
        $campoTabla = 'nombre';
        foreach ($registros as $key => $registro) {

            $registro[$campoTabla] = $registro[$campoTabla].'_modificado';
            $registros[$key][$campoTabla] = $registro[$campoTabla]; 

            $resultado = $modelo->modificarPorId($registro['id'],$registro);
            $this->assertIsArray($resultado);
            $this->assertCount(1,$resultado);
            $mensajeEsperado = 'registro modificado';
            $this->assertSame($mensajeEsperado,$resultado['mensaje']);
        }

        for ($i = 1 ; $i < 4 ; $i++) {
            $registro = $registros[$i]; 
            $registro[$campoTabla] = $registros[0][$campoTabla];

            $error = null;
            try {
                $resultado = $modelo->modificarPorId($registro['id'],$registro);
            } catch (ErrorBase $e) {
                $error = $e;
            }
            $mensajeEsperado = "grupo:{$registro[$campoTabla]} ya registrad@";
            $this->assertSame($mensajeEsperado,$error->getMessage());
        }

        return $registros;
    }

    /**
     * @test
     * @depends crearModelo
     * @depends modificarPorId
     */
    public function eliminarPorId($modelo,$registros)
    {
        for ($i = 0 ; $i < 2 ; $i++) {
            $registro = $registros[$i];
            $resultado = $modelo->eliminarPorId($registro['id']);
            $this->assertIsArray($resultado);
            $this->assertCount(1,$resultado);
            $mensajeEsperado = 'registro eliminado';
            $this->assertSame($mensajeEsperado,$resultado['mensaje']);
            unset($registros[$i]);
        }

        $resultado = $modelo->obtenerNumeroRegistros();
        $this->assertSame((count($registros)+$this->registrosExtras),$resultado);

        return $registros;
    }

    /**
     * @test
     * @depends crearModelo
     * @depends eliminarPorId
     */
    public function eliminarTodo($modelo,$registrosl)
    {
        $resultado = $modelo->eliminarTodo();
        $this->assertIsArray($resultado);
        $this->assertCount(1,$resultado);
        $mensajeEsperado = 'registro eliminado';
        
        $resultado = $modelo->obtenerNumeroRegistros();
        $this->assertSame(0,$resultado);
    }
}