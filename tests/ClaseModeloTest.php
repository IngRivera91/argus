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
        $coneccion->ejecutaConsultaInsert("INSERT INTO grupos (id,nombre_grupo) VALUES (1,'administrador')");

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

    /**
     * @test
     * @depends creaModelo
     * @depends registrar
     */
    public function actualizarPorId($modelo,$datosUsuarios)
    {
        $idUsuarioRicardo = 2;
        $idUsuarioJuan = 0;

        $id = $datosUsuarios[$idUsuarioRicardo]['id'];
        unset($datosUsuarios[$idUsuarioRicardo]['id']);
        $datosUsuarios[$idUsuarioRicardo]['correo_electronico'] = $datosUsuarios[$idUsuarioJuan]['correo_electronico'];
        $datosUsuarios[$idUsuarioRicardo]['password'] = 'password';
        
        $error = null;
        try{
            $resultado = $modelo->actualizarPorId($id,$datosUsuarios[$idUsuarioRicardo]);
        }catch(ErrorBase $e){
            $error = $e;
        }
        $mensajeEsperado = "correo:{$datosUsuarios[$idUsuarioJuan]['correo_electronico']} ya registrad@";
        $this->assertSame($error->getMessage(),$mensajeEsperado);

        $datosUsuarios[$idUsuarioRicardo]['correo_electronico'] = $datosUsuarios[$idUsuarioRicardo]['correo_electronico'].'_nuevo';
        $resultado = $modelo->actualizarPorId($id,$datosUsuarios[$idUsuarioRicardo]);
        $mensajeEsperado = 'registro modificado';
        $this->assertIsArray($resultado);
        $this->assertSame($resultado['mensaje'],$mensajeEsperado);

        $datosUsuarios[$idUsuarioRicardo]['id'] = $id;
        return $datosUsuarios;
    }

    /**
     * @test
     * @depends creaModelo
     * @depends actualizarPorId
     */
    public function buscarPorId($modelo,$datosUsuarios)
    {
        foreach ($datosUsuarios as $datosUsuario)
        {
            $id = $datosUsuario['id'];
            $resultado = $modelo->buscarPorId($id);
            $this->assertIsArray($resultado);
            $this->assertSame(1,$resultado['n_registros']);
            $this->assertCount(13,$resultado['registros'][0]);
        }
        return $datosUsuarios;
    }

    /**
     * @test
     * @depends creaModelo
     * @depends buscarPorId
     */
    public function buscarConFiltros($modelo,$datosUsuarios)
    {
        foreach ($datosUsuarios as $datosUsuario)
        {
            $filtros = [
                ['campo' => 'usuarios.id' , 'valor' =>  $datosUsuario['id'] , 'signoComparacion' => '=' , 'conectivaLogica' => '']
            ];
            
            $resultado = $modelo->buscarConFiltros($filtros);
            $this->assertIsArray($resultado);
            $this->assertSame(1,$resultado['n_registros']);
            $this->assertCount(13,$resultado['registros'][0]);
        }
        return $datosUsuarios;
    }

    /**
     * @test
     * @depends creaModelo
     * @depends buscarConFiltros
     */
    public function buscarTodo($modelo,$datosUsuarios)
    {
        $resultado = $modelo->buscarTodo();
        $this->assertIsArray($resultado);
        $this->assertSame( count($datosUsuarios) ,$resultado['n_registros']);
        return $datosUsuarios;
    }

    /**
     * @test
     * @depends creaModelo
     * @depends buscarTodo
     */
    public function obtenerNumeroRegistros($modelo,$datosUsuarios)
    {
        $resultado = $modelo->obtenerNumeroRegistros();
        $this->assertSame( count($datosUsuarios) ,  $resultado );
        return $datosUsuarios;
    }

}