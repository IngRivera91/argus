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
    public function registrarBd()
    {
        $coneccion = new Database();

        $coneccion->ejecutaConsultaDelete("DELETE FROM grupos");
        $coneccion->ejecutaConsultaInsert("INSERT INTO grupos (id) VALUES (1)");

        $tabla = 'usuarios';
        $relaciones = ['grupos' => 'usuarios.grupo_id'];
        
        $columnas = [
            'unicas' => ['usuario' => 'usuario','correo' => 'correo_electronico'],
            'obligatorias' => ['usuario','password','nombre_completo','grupo_id'],
            'protegidas' => ['password']
        ];
        
        $modelo = new Modelo($coneccion,$tabla,$relaciones, $columnas);

        $datos = [
            'id' => 8,
            'usuario' => 'ricardo',
            'correo_electronico' => 'mail@mail.com',
            'password' => '123asd',
            'nombre_completo' => 'Ricardo Rivera Sanchez',
            'grupo_id' => '1'
        ];

        $resultado = $modelo->registrarBd($datos);
        $mensajeEsperado = 'registro insertado';
        $this->assertIsArray($resultado);
        $this->assertSame($resultado['mensaje'],$mensajeEsperado);
        $this->assertSame($resultado['registro_id'],8);

        

        $error = null;
        try{
            $resultado = $modelo->registrarBd($datos);
        }catch(ErrorBase $e){
            $error = $e;
        }
        $mensajeEsperado = "usuario:ricardo ya registrad@";
        $this->assertSame($error->getMessage(),$mensajeEsperado);

        $error = null;
        try{
            $datos['usuario'] = 'ricardo2';
            $resultado = $modelo->registrarBd($datos);
        }catch(ErrorBase $e){
            $error = $e;
        }
        $mensajeEsperado = "correo:mail@mail.com ya registrad@";
        $this->assertSame($error->getMessage(),$mensajeEsperado);

        $error = null;
        try{
            $datos['usuario'] = '';
            $resultado = $modelo->registrarBd($datos);
        }catch(ErrorBase $e){
            $error = $e;
        }
        $mensajeEsperado = "El campo usuario no pude ser vacio o null";
        $this->assertSame($error->getMessage(),$mensajeEsperado);

        $error = null;
        try{
            unset($datos['usuario']);
            $resultado = $modelo->registrarBd($datos);
        }catch(ErrorBase $e){
            $error = $e;
        }
        $mensajeEsperado = "El campo usuario debe existir en el array de datos";
        $this->assertSame($error->getMessage(),$mensajeEsperado);

        $coneccion->ejecutaConsultaDelete("DELETE FROM usuarios");
        $coneccion->ejecutaConsultaDelete("DELETE FROM grupos");
    }

}