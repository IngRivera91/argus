<?php

use Error\Base AS ErrorBase;
use Clase\Database; 
use PHPUnit\Framework\TestCase;

class ClaseDatabaseTest extends TestCase
{ 
    protected $coneccion;

    /**
     * @test
     */
    public function ejecutaConsultaDelete()
    {
        $coneccion = new Database();

        $error = null;
        try{
            $coneccion->ejecutaConsultaDelete('DELETEasdS FROM usuarios');
        }catch(ErrorBase $e){
            $error = $e;
        }
        $this->assertInstanceOf(ErrorBase::class, $error);
        $this->assertEquals($error->getCode(),42000);

        $resultado = $coneccion->ejecutaConsultaDelete('DELETE FROM usuarios');
        $this->assertCount(1,$resultado);
        
    }
    
    /**
     * @test
     * @dataProvider datosUsuarios
     */
    public function ejecutaConsultaInsert($datos)
    {
        $coneccion = new Database();

        try{
            $resultado = $coneccion->ejecutaConsultaInsert('INSERT INTO usuarios (id,usuario,password) VALUES (:id,:usuario,:password) ');
        }catch(ErrorBase $e){
            $error = $e;
        }
        $this->assertInstanceOf(ErrorBase::class, $error);
        $this->assertEquals($error->getCode(),42000);
        
        $resultado = $coneccion->ejecutaConsultaInsert('INSERT INTO usuarios (id,usuario,password) VALUES (:id,:usuario,:password) ',$datos);
        $this->assertCount(2,$resultado);
        $this->assertSame('registro insertado',$resultado['mensaje']);
        $this->assertSame($datos['id'],$resultado['registro_id']);

        $error = null;
        try{
            $resultado = $coneccion->ejecutaConsultaInsert('INSERT INTO usuarios (id,usuario,password) VALUES (:id,:usuario,:password) ',$datos);
        }catch(ErrorBase $e){
            $error = $e;
        }
        $this->assertInstanceOf(ErrorBase::class, $error);
        $this->assertEquals($error->getCode(),23000);
        
    }

    /**
     * @test
     * @dataProvider datosUsuarios
     */
    public function ejecutaConsultaUpdate($datos)
    {
        $coneccion = new Database();

        $error = null;
        try{
            $coneccion->ejecutaConsultaUpdate('UPDATE usuarios SET usuario = :usuario WHERE id = :id ');
        }catch(ErrorBase $e){
            $error = $e;
        }
        $this->assertInstanceOf(ErrorBase::class, $error);
        $this->assertEquals($error->getCode(),42000);

        $resultado = $coneccion->ejecutaConsultaUpdate('UPDATE usuarios SET usuario = :usuario, password = :password WHERE id = :id ',$datos);
        $this->assertCount(1,$resultado);
        $this->assertSame('registro modificado',$resultado['mensaje']);
        
    }

    /**
     * @test
     * @dataProvider datosUsuarios
     */
    public function ejecutaConsultaSelect($datos)
    {
        $coneccion = new Database();

        $error = null;
        try{
            $coneccion->ejecutaConsultaSelect('SELECT * FROM usuarios WHERE id = :id AND usuario = :usuario AND password = :password ');
        }catch(ErrorBase $e){
            $error = $e;
        }
        $this->assertInstanceOf(ErrorBase::class, $error);
        $this->assertEquals($error->getCode(),42000);

        $resultado = $coneccion->ejecutaConsultaSelect('SELECT * FROM usuarios WHERE id = :id AND usuario = :usuario AND password = :password',$datos);
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