<?php

use Clase\Database;
use Modelo\Usuarios;
use Error\Base AS ErrorBase;
use PHPUnit\Framework\TestCase;

class ModeloUsuariosTest extends TestCase
{
    /**
     * @test
     */
    public function creaModelo()
    {
        $this->assertSame(1,1);
        $coneccion = new Database();
        $consultaDeleteBase = 'DELETE FROM';
        $coneccion->ejecutaConsultaDelete("$consultaDeleteBase usuarios");
        $coneccion->ejecutaConsultaDelete("$consultaDeleteBase grupos");
        $coneccion->ejecutaConsultaInsert("INSERT INTO grupos (id,nombre) VALUES (1,'administrador')");
        return new Usuarios($coneccion);
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

    /**
     * @test
     * @depends creaModelo
     */
    public function registrar($modelo)
    {
        $datosUsuarios = [
            [
                'id' => 1,
                'usuario' => 'juan',
                'correo_electronico' => 'juan@mail.com',
                'password' => 'juan123',
                'nombre_completo' => 'Juan Perez Lopez',
                'grupo_id' => '1'
            ],
            [
                'id' => 2,
                'usuario' => 'pedro',
                'correo_electronico' => 'pedro@mail.com',
                'password' => 'pedro123',
                'nombre_completo' => 'Pedro Martines Wong',
                'grupo_id' => '1'
            ],
            [
                'id' => 3,
                'usuario' => 'ricardo',
                'correo_electronico' => 'ricardo@mail.com',
                'password' => 'ricardo123',
                'nombre_completo' => 'Ricardo Rivera Sanchez',
                'grupo_id' => '1'
            ],
            [
                'id' => 4,
                'usuario' => 'maria',
                'correo_electronico' => 'maria@mail.com',
                'password' => 'ricardo123',
                'nombre_completo' => 'Maria Rivera Sanchez',
                'grupo_id' => '1'
            ]

        ];

        foreach ($datosUsuarios as $datosUsuario) 
        {
            $resultado = $modelo->registrar($datosUsuario);
            $mensajeEsperado = 'registro insertado';
            $this->assertIsArray($resultado);
            $this->assertSame($resultado['mensaje'],$mensajeEsperado);
            $this->assertSame($resultado['registro_id'],$datosUsuario['id']);

            $error = null;
            try{
                $resultado = $modelo->registrar($datosUsuario);
            }catch(ErrorBase $e){
                $error = $e;
            }
            $mensajeEsperado = "usuario:{$datosUsuario['usuario']} ya registrad@";
            $this->assertSame($error->getMessage(),$mensajeEsperado);

            $error = null;
            try{
                $datosUsuario['usuario'] = $datosUsuario['usuario'].'_nuevo';
                $resultado = $modelo->registrar($datosUsuario);
            }catch(ErrorBase $e){
                $error = $e;
            }
            $mensajeEsperado = "correo:{$datosUsuario['correo_electronico']} ya registrad@";
            $this->assertSame($error->getMessage(),$mensajeEsperado);

            $error = null;
            try{
                $datosUsuario['usuario'] = '';
                $resultado = $modelo->registrar( $datosUsuario);
            }catch(ErrorBase $e){
                $error = $e;
            }
            $mensajeEsperado = "El campo usuario no pude ser vacio o null";
            $this->assertSame($error->getMessage(),$mensajeEsperado);

            $error = null;
            try{
                unset($datosUsuario['usuario']);
                $resultado = $modelo->registrar($datosUsuario);
            }catch(ErrorBase $e){
                $error = $e;
            }
            $mensajeEsperado = "El campo usuario debe existir en el array de datos";
            $this->assertSame($error->getMessage(),$mensajeEsperado);
        }

        

        return $datosUsuarios;

    }
}