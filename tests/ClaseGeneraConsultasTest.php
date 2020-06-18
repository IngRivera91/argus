<?php

use Clase\GeneraConsultas; 
use PHPUnit\Framework\TestCase;

class ClaseGeneraConsultasTest extends TestCase
{

    /**
     * @test
     */
    public function generaConsultaDelete()
    {
        $generaConsulta = new GeneraConsultas();
        $tabla = 'usuarios';

        $consultaEsperada = 'DELETE FROM usuarios';
        $consulta = $generaConsulta->delete($tabla);
        $this->assertSame($consulta,$consultaEsperada);

        $filtros = [
            ['campo' => 'id' , 'valor' => '1' , 'signoComparacion' => '=']
        ];

        $consultaEsperada = 'DELETE FROM usuarios WHERE id = :id';
        $consulta = $generaConsulta->delete($tabla,$filtros);
        $this->assertSame($consulta,$consultaEsperada);
        
    }

    /**
     * @test
     */
    public function generaConsultaInsert()
    {
        $generaConsulta = new GeneraConsultas();

        $tabla = 'usuarios';
        $datos = ['user' => 'pedro' , 'password' => 'contra'];

        $consultaEsperada = 'INSERT INTO usuarios (user,password) VALUES (:user,:password)';
        $consulta = $generaConsulta->insert($tabla,$datos);
        
        $this->assertSame($consulta,$consultaEsperada);
        
    }


    /**
     * @test
     */
    public function generaConsultaSelect()
    {
        $generaConsulta = new GeneraConsultas();

        $tabla = 'usuarios';       
        $consultaEsperada = 'SELECT * FROM usuarios';
        $consulta = $generaConsulta->select($tabla);
        $this->assertSame($consulta,$consultaEsperada);

        $tabla = 'usuarios';
        $colunmas = array('id');        
        $consultaEsperada = 'SELECT usuarios.id FROM usuarios';
        $consulta = $generaConsulta->select($tabla,$colunmas);
        $this->assertSame($consulta,$consultaEsperada);

        $tabla = 'usuarios';
        $colunmas = array('usuarios.id');        
        $consultaEsperada = 'SELECT usuarios.id FROM usuarios';
        $consulta = $generaConsulta->select($tabla,$colunmas);
        $this->assertSame($consulta,$consultaEsperada);

        $tabla = 'usuarios';
        $colunmas = array('grupos.id');        
        $consultaEsperada = 'SELECT grupos.id FROM usuarios';
        $consulta = $generaConsulta->select($tabla,$colunmas);
        $this->assertSame($consulta,$consultaEsperada);

        $tabla = 'usuarios';
        $colunmas = array('id'); 
        $filtros = [
            ['campo' => 'id' , 'valor' => '1' , 'signoComparacion' => '=']
        ];       
        $consultaEsperada = 'SELECT usuarios.id FROM usuarios WHERE id = :id';
        $consulta = $generaConsulta->select($tabla,$colunmas,$filtros);
        $this->assertSame($consulta,$consultaEsperada);

        $tabla = 'usuarios';
        $colunmas = array('usuarios.id','grupos.id'); 
        $filtros = [
            ['campo' => 'id' , 'valor' => '1' , 'signoComparacion' => '=']
        ];
        $relaciones = ['grupos' => 'usuarios.grupo_id'];
        $limit = '';
        $orderBy = [];
        $consultaEsperada = 'SELECT usuarios.id,grupos.id FROM usuarios LEFT JOIN grupos ON grupos.id = usuarios.grupo_id WHERE id = :id';
        $consulta = $generaConsulta->select($tabla,$colunmas,$filtros,$limit,$orderBy,$relaciones);
        $this->assertSame($consulta,$consultaEsperada);

        $tabla = 'usuarios';
        $colunmas = array('usuarios.id','grupos.id'); 
        $filtros = [
            ['campo' => 'id' , 'valor' => '1' , 'signoComparacion' => '=']
        ];
        $relaciones = ['grupos' => 'usuarios.grupo_id'];
        $limit = 2;
        $orderBy = [];
        $consultaEsperada = 'SELECT usuarios.id,grupos.id FROM usuarios LEFT JOIN grupos ON grupos.id = usuarios.grupo_id WHERE id = :id LIMIT 2';
        $consulta = $generaConsulta->select($tabla,$colunmas,$filtros,$limit,$orderBy,$relaciones);
        $this->assertSame($consulta,$consultaEsperada);

        $tabla = 'usuarios';
        $colunmas = array('usuarios.id','grupos.id'); 
        $filtros = [
            ['campo' => 'id' , 'valor' => '1' , 'signoComparacion' => '=']
        ];
        $relaciones = ['grupos' => 'usuarios.grupo_id'];
        $limit = 2;
        $orderBy = ['usuarios.nombre' => 'DESC'];
        $consultaEsperada = 'SELECT usuarios.id,grupos.id FROM usuarios LEFT JOIN grupos ON grupos.id = usuarios.grupo_id WHERE id = :id ORDER BY usuarios.nombre DESC LIMIT 2';
        $consulta = $generaConsulta->select($tabla,$colunmas,$filtros,$limit,$orderBy,$relaciones);
        $this->assertSame($consulta,$consultaEsperada);

    }

    /**
     * @test
     */
    public function generaConsultaUpdate()
    {
        $generaConsulta = new GeneraConsultas();

        $tabla = 'usuarios';
        $datos = ['user' => 'pedro' , 'password' => 'contra'];
        

        $consultaEsperada = 'UPDATE usuarios SET user = :user , password = :password';
        $consulta = $generaConsulta->update($tabla,$datos);
        $this->assertSame($consulta,$consultaEsperada);

        $filtros = [
            ['campo' => 'id' , 'valor' => '1' , 'signoComparacion' => '=']
        ];

        $consultaEsperada = 'UPDATE usuarios SET user = :user , password = :password WHERE id = :id';
        $consulta = $generaConsulta->update($tabla,$datos,$filtros);
        $this->assertSame($consulta,$consultaEsperada);
        
    }
}