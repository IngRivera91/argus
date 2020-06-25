<?php

use Clase\Modelo; 
use Clase\Database;
use Error\Base AS ErrorBase;
use PHPUnit\Framework\TestCase;

class ClaseModeloTest extends TestCase
{
    /**
     * @test
     */
    public function creaConeccion()
    {
        $this->assertSame(1,1);
        return new Database();  
    }

    /**
     * @test
     * @depends creaConeccion
     */
    public function creaModelo($coneccion)
    {
        $this->assertSame(1,1);
        $tabla = 'usuarios';
        $relaciones = ['grupos' => 'usuarios.grupo_id']; 
        $columnas = [
            'unicas' => ['usuario' => 'usuario','correo' => 'correo_electronico'],
            'obligatorias' => ['usuario','password','nombre_completo','grupo_id'],
            'protegidas' => ['password']
        ];
        return new Modelo($coneccion,$tabla,$relaciones, $columnas);
        
    }

    /**
     * @test
     * @depends creaConeccion
     * @depends creaModelo
     */
    public function registrar($coneccion,$modelo)
    {
        $consultaDeleteBase = 'DELETE FROM';
        $coneccion->ejecutaConsultaDelete("$consultaDeleteBase usuarios");
        $coneccion->ejecutaConsultaDelete("$consultaDeleteBase grupos");
        $coneccion->ejecutaConsultaInsert("INSERT INTO grupos (id) VALUES (1)");

        $datos = [
            'id' => 7,
            'usuario' => 'pedro',
            'correo_electronico' => 'pedro@mail.com',
            'password' => 'pedro123',
            'nombre_completo' => 'Pedro Lopez Lopez',
            'grupo_id' => '1'
        ];

        $resultado = $modelo->registrar($datos);
        $mensajeEsperado = 'registro insertado';
        $this->assertIsArray($resultado);
        $this->assertSame($resultado['mensaje'],$mensajeEsperado);
        $this->assertSame($resultado['registro_id'],7);

        $datos = [
            'id' => 8,
            'usuario' => 'ricardo',
            'correo_electronico' => 'mail@mail.com',
            'password' => '123asd',
            'nombre_completo' => 'Ricardo Rivera Sanchez',
            'grupo_id' => '1'
        ];

        $resultado = $modelo->registrar($datos);
        $mensajeEsperado = 'registro insertado';
        $this->assertIsArray($resultado);
        $this->assertSame($resultado['mensaje'],$mensajeEsperado);
        $this->assertSame($resultado['registro_id'],8);

        $error = null;
        try{
            $resultado = $modelo->registrar($datos);
        }catch(ErrorBase $e){
            $error = $e;
        }
        $mensajeEsperado = "usuario:ricardo ya registrad@";
        $this->assertSame($error->getMessage(),$mensajeEsperado);

        $error = null;
        try{
            $datos['usuario'] = 'ricardo2';
            $resultado = $modelo->registrar($datos);
        }catch(ErrorBase $e){
            $error = $e;
        }
        $mensajeEsperado = "correo:mail@mail.com ya registrad@";
        $this->assertSame($error->getMessage(),$mensajeEsperado);

        $error = null;
        try{
            $datos['usuario'] = '';
            $resultado = $modelo->registrar($datos);
        }catch(ErrorBase $e){
            $error = $e;
        }
        $mensajeEsperado = "El campo usuario no pude ser vacio o null";
        $this->assertSame($error->getMessage(),$mensajeEsperado);

        $error = null;
        try{
            unset($datos['usuario']);
            $resultado = $modelo->registrar($datos);
        }catch(ErrorBase $e){
            $error = $e;
        }
        $mensajeEsperado = "El campo usuario debe existir en el array de datos";
        $this->assertSame($error->getMessage(),$mensajeEsperado);

    }

    /**
     * @test
     * @depends creaConeccion
     * @depends creaModelo
     * @depends registrar
     */
    public function actualizarPorId($coneccion,$modelo)
    {
        $id = 8;
        $datos = [
            'correo_electronico' => 'pedro@mail.com',
            'password' => 'password',
        ];

        try{
            $resultado = $modelo->actualizarPorId($id,$datos);
        }catch(ErrorBase $e){
            $error = $e;
        }
        $mensajeEsperado = "correo:pedro@mail.com ya registrad@";
        $this->assertSame($error->getMessage(),$mensajeEsperado);

        $datos['correo_electronico'] = 'mail@mail.com';
        $resultado = $modelo->actualizarPorId($id,$datos);
        $mensajeEsperado = 'registro modificado';
        $this->assertIsArray($resultado);
        $this->assertSame($resultado['mensaje'],$mensajeEsperado);
    }    

}