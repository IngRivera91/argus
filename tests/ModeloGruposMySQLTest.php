<?php

use Clase\DatabaseMySQL;
use Clase\GeneraConsultasMySQL;
use Modelo\Grupos;
use Error\Base AS ErrorBase;
use PHPUnit\Framework\TestCase;

class ModeloGruposMySQLTest extends TestCase
{
    /**
     * @test
     */
    public function creaModelo()
    {
        $this->assertSame(1,1);
        $coneccion = new DatabaseMySQL();
        $generaConsultas = new GeneraConsultasMySQL($coneccion);
        $coneccion->ejecutaConsultaDelete('DELETE FROM grupos');
        return new Grupos($coneccion,$generaConsultas);
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
        $grupos = [
            ['id' => 1 ,'nombre' => 'administradores' , 'usuario_registro_id' => 1],
            ['id' => 2 ,'nombre' => 'programadores' , 'usuario_registro_id' => 2],
            ['id' => 3 ,'nombre' => 'vendedores' , 'usuario_registro_id' => 2]
        ];
        foreach($grupos as $key => $grupo)
        {
            $resultado = $modelo->registrar($grupo);
            $this->assertIsArray($resultado);
            $mensajeEsperado = 'registro insertado';
            $this->assertSame($mensajeEsperado,$resultado['mensaje']);
            $this->assertSame($grupo['id'],$resultado['registro_id']);
            
            
            $error = null;
            try{
                $resultado = $modelo->registrar($grupo);
            }catch(ErrorBase $e){
                $error = $e;
            }
            $mensajeEsperado = "grupo:{$grupo['nombre']} ya registrad@";
            $this->assertSame($error->getMessage(),$mensajeEsperado);
        }
        return $grupos;
    }

    /**
     * @test
     * @depends creaModelo
     * @depends registrar
     */
    public function buscarConFiltros($modelo,$grupos)
    {
        $numero = 2;
        $filtros = [
            ['campo' => 'usuario_registro_id' , 'valor' => $numero , 'signoComparacion' => '=' , 'conectivaLogica' => '' ]
        ];
        $resultado = $modelo->buscarConFiltros($filtros);
        $this->assertIsArray($resultado);
        $this->assertSame($numero,$resultado['n_registros']);
        $this->assertCount($numero,$resultado['registros']);

        $numero = 1;
        $filtros = [
            ['campo' => 'usuario_registro_id' , 'valor' => $numero , 'signoComparacion' => '=' , 'conectivaLogica' => '' ]
        ];
        $resultado = $modelo->buscarConFiltros($filtros);
        $this->assertIsArray($resultado);
        $this->assertSame($numero,$resultado['n_registros']);
        $this->assertCount($numero,$resultado['registros']);

        
        return $grupos;
    }

    /**
     * @test
     * @depends creaModelo
     * @depends buscarConFiltros
     */
    public function buscarPorId($modelo,$grupos)
    {
        
        foreach ($grupos as $grupo)
        {
            $resultado = $modelo->buscarPorId($grupo['id']);
            $this->assertIsArray($resultado);
            $this->assertSame(1,$resultado['n_registros']);
            $this->assertCount(1,$resultado['registros']);
        }

        $resultado = $modelo->buscarPorId(-1);
        $this->assertIsArray($resultado);
        $this->assertSame(0,$resultado['n_registros']);
        $this->assertCount(0,$resultado['registros']);
        
        return $grupos;
    }

    /**
     * @test
     * @depends creaModelo
     * @depends buscarPorId
     */
    public function actualizarPorId($modelo,$grupos)
    {
        $cantidadGrupos = count($grupos);
        for ($i = 0 ; $i < ($cantidadGrupos-2) ; $i++ ){

            $datosNuevos = [ 'nombre' => $grupos[$cantidadGrupos-1]['nombre'] ];
            $id = $grupos[$i]['id'];
        
            $error = null;
            try{
                $resultado = $modelo->actualizarPorId($id,$datosNuevos);
            }catch(ErrorBase $e){
                $error = $e;
            }
            $mensajeEsperado = "grupo:{$grupos[$cantidadGrupos-1]['nombre']} ya registrad@";
            $this->assertSame($error->getMessage(),$mensajeEsperado);

        }

        foreach ($grupos as $key => $grupo)
        {
            $grupos[$key]['nombre'] = "{$grupo['nombre']}_nuevo";
            $resultado = $modelo->actualizarPorId($grupo['id'],$grupos[$key]);
            $this->assertIsArray($resultado);
            $mensajeEsperado = 'registro modificado';
            $this->assertSame($mensajeEsperado,$resultado['mensaje']);
        }

        return $grupos;
    }

}