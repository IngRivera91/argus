<?php

use Error\Base AS ErrorBase;
use Clase\Database; 
use PHPUnit\Framework\TestCase;

class ClaseDatabaseTest extends TestCase
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
    public function ejecutaConsultaDelete($coneccion)
    {
        $tabla = 'usuarios';
        $error = null;
        try{
            $coneccion->ejecutaConsultaDelete("DELETEasdS FROM $tabla");
        }catch(ErrorBase $e){
            $error = $e;
        }
        $this->assertInstanceOf(ErrorBase::class, $error);
        $this->assertEquals($error->getCode(),42000);

        $resultado = $coneccion->ejecutaConsultaDelete("DELETE FROM $tabla");
        $this->assertCount(1,$resultado);
        
    }
    
    /**
     * @test
     * @dataProvider datosUsuarios
     * @depends creaConeccion
     */
    public function ejecutaConsultaInsert($datos,$coneccion)
    {
        $consulta_base = 'INSERT INTO usuarios (id,usuario,password) VALUES (:id,:usuario,:password)';
        try{
            $resultado = $coneccion->ejecutaConsultaInsert("$consulta_base ");
        }catch(ErrorBase $e){
            $error = $e;
        }
        $this->assertInstanceOf(ErrorBase::class, $error);
        $this->assertEquals($error->getCode(),42000);
        
        $resultado = $coneccion->ejecutaConsultaInsert("$consulta_base ",$datos);
        $this->assertCount(2,$resultado);
        $this->assertSame('registro insertado',$resultado['mensaje']);
        $this->assertSame($datos['id'],$resultado['registro_id']);

        $error = null;
        try{
            $resultado = $coneccion->ejecutaConsultaInsert("$consulta_base ",$datos);
        }catch(ErrorBase $e){
            $error = $e;
        }
        $this->assertInstanceOf(ErrorBase::class, $error);
        $this->assertEquals($error->getCode(),23000);
        
    }

    /**
     * @test
     * @dataProvider datosUsuarios
     * @depends creaConeccion
     */
    public function ejecutaConsultaUpdate($datos,$coneccion)
    {
        $consulta_base = 'UPDATE usuarios SET usuario = :usuario';
        $error = null;
        try{
            $coneccion->ejecutaConsultaUpdate("$consulta_base WHERE id = :id");
        }catch(ErrorBase $e){
            $error = $e;
        }
        $this->assertInstanceOf(ErrorBase::class, $error);
        $this->assertEquals($error->getCode(),42000);

        $resultado = $coneccion->ejecutaConsultaUpdate("$consulta_base, password = :password WHERE id = :id ",$datos);
        $this->assertCount(1,$resultado);
        $this->assertSame('registro modificado',$resultado['mensaje']);
    }

    /**
     * @test
     * @dataProvider datosUsuarios
     * @depends creaConeccion
     */
    public function ejecutaConsultaSelect($datos,$coneccion)
    {
        $consulta_base = 'SELECT * FROM usuarios WHERE id = :id AND usuario = :usuario AND password = :password';
        $error = null;
        try{
            $coneccion->ejecutaConsultaSelect("$consulta_base");
        }catch(ErrorBase $e){
            $error = $e;
        }
        $this->assertInstanceOf(ErrorBase::class, $error);
        $this->assertEquals($error->getCode(),42000);

        $resultado = $coneccion->ejecutaConsultaSelect("$consulta_base",$datos);
        $this->assertCount(2,$resultado);
        $this->assertSame(1,$resultado['n_registros']);
        $this->assertCount(12,$resultado['registros'][0]);
        $this->assertEquals($datos['id'],$resultado['registros'][0]['id']);
        $this->assertSame($datos['usuario'],$resultado['registros'][0]['usuario']);
        $this->assertSame($datos['password'],$resultado['registros'][0]['password']);
    }


    public function datosUsuarios()
    {
        return [
            'juan' => [['id' => 1, 'usuario' =>'juan', 'password' =>'juan']],
            'pedro' => [['id' => 2, 'usuario' =>'pedro', 'password' =>'pedro']],
            'maria' => [['id' => 3, 'usuario' =>'maria', 'password' =>'maria']],
            'monica' => [['id' => 4, 'usuario' =>'monica', 'password' =>'monica']]
        ];
    }

}