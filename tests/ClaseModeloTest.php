<?php

use Clase\Modelo; 
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
        $claseDatabase = 'Clase\\'.DB_TIPO.'\\Database';
        $coneccion = new $claseDatabase();

        return $coneccion;
    }

    /**
     * @test
     * @depends creaConeccion
     */
    public function creaModelo($coneccion)
    {
        $claseGeneraConsultas = 'Clase\\'.DB_TIPO.'\\GeneraConsultas';
        $generaConsultas = new $claseGeneraConsultas($coneccion);
        
        $this->assertSame(1,1);
        $tabla = 'usuarios';
        $relaciones = ['grupos' => 'usuarios.grupo_id']; 
        $columnas = [
            'unicas' => ['usuario' => 'usuario','correo' => 'correo_electronico'],
            'obligatorias' => ['usuario','password','nombre_completo','grupo_id'],
            'protegidas' => ['password']
        ];
        return new Modelo($coneccion, $generaConsultas, $tabla, $relaciones, $columnas);
        
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
        $coneccion->ejecutaConsultaInsert("INSERT INTO grupos (id,nombre) VALUES (1,'administrador')");

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
            $this->assertCount(18,$resultado['registros'][0]);

            $columnas = [];
            $orderBy = [];
            $limit = '';
            $noUsarRelaciones = true;
            $resultado = $modelo->buscarPorId( $id , $columnas , $orderBy , $limit , $noUsarRelaciones );
            $this->assertIsArray($resultado);
            $this->assertSame(1,$resultado['n_registros']);
            $this->assertCount(11,$resultado['registros'][0]);
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
            $this->assertCount(18,$resultado['registros'][0]);

            $columnas = [];
            $orderBy = [];
            $limit = '';
            $noUsarRelaciones = true;
            $resultado = $modelo->buscarConFiltros( $filtros , $columnas , $orderBy , $limit , $noUsarRelaciones );
            $this->assertIsArray($resultado);
            $this->assertSame(1,$resultado['n_registros']);
            $this->assertCount(11,$resultado['registros'][0]);
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

    /**
     * @test
     * @depends creaModelo
     * @depends obtenerNumeroRegistros
     */
    public function eliminarPorId($modelo,$datosUsuarios)
    {
        $id = array_key_last($datosUsuarios);
        $usuario = end($datosUsuarios);

        $resultado = $modelo->eliminarPorId($usuario['id']);
        $this->assertIsArray($resultado);
        $this->assertSame('registro eliminado',$resultado['mensaje']);

        unset($datosUsuarios[$id]);

        $numeroRegistros = $modelo->obtenerNumeroRegistros();
        $this->assertSame( count($datosUsuarios) ,  $numeroRegistros );

        return $datosUsuarios;
    }

    /**
     * @test
     * @depends creaModelo
     * @depends eliminarPorId
     */
    public function eliminarConFiltro($modelo,$datosUsuarios)
    {
        $id = array_key_last($datosUsuarios);
        $usuario = $datosUsuarios[$id];

        $filtros = [
            ['campo' => 'usuario' , 'valor' =>  $usuario['usuario'] , 'signoComparacion' => '=' , 'conectivaLogica' => '']
        ];

        $resultado = $modelo->eliminarConFiltros($filtros);
        $this->assertIsArray($resultado);
        $this->assertSame('registro eliminado',$resultado['mensaje']);

        unset($datosUsuarios[$id]);

        $numeroRegistros = $modelo->obtenerNumeroRegistros();
        $this->assertSame( count($datosUsuarios) ,  $numeroRegistros );
        
        return $datosUsuarios;
    }

    /**
     * @test
     * @depends creaModelo
     * @depends eliminarConFiltro
     */
    public function eliminarTodo($modelo,$datosUsuarios)
    {

        $resultado = $modelo->eliminarTodo();
        $this->assertIsArray($resultado);
        $this->assertSame('registro eliminado',$resultado['mensaje']);

        $numeroRegistros = $modelo->obtenerNumeroRegistros();
        $this->assertSame( 0 ,  $numeroRegistros );
        
    }

}