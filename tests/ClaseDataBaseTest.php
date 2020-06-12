<?php

use PHPUnit\Framework\TestCase;
use Clase\Database; 

class ClaseDatabaseTest extends TestCase
{ 
    /**
     * @test
     */
    public function ejecutaConsultas()
    {
        $coneccion = new Database();

        $res = $coneccion->ejecutaConsultaDelete('DELETE FROM usuarios');
        $this->assertCount(1, $res);
        $this->assertSame('registro eliminado', $res['mensaje']);

        $datos = array('id' => 1 , 'user' => 'juan' , 'password' => 'juan');
        $res = $coneccion->ejecutaConsultaInsert('INSERT INTO usuarios (id,user,password) VALUES (:id,:user,:password)',$datos);
        $this->assertCount(2, $res);
        $this->assertSame('registro insertado', $res['mensaje']);
        $this->assertSame(1, $res['registro_id']);

        $res = $coneccion->ejecutaConsultaSelect('SELECT * FROM usuarios');
        $this->assertCount(2, $res);
        $this->assertCount(12, $res['registros'][0]);

        $datos = array('user' => 'juan');
        $res = $coneccion->ejecutaConsultaSelect('SELECT * FROM usuarios WHERE user = :user',$datos);
        $this->assertCount(2, $res);
        $this->assertCount(1, $res['registros']);
        $this->assertCount(12, $res['registros'][0]);

        $datos = array('user' => 'pedro');
        $res = $coneccion->ejecutaConsultaSelect('SELECT * FROM usuarios WHERE user = :user',$datos);
        $this->assertCount(2, $res);
        $this->assertCount(0, $res['registros']);

        $datos = array('id' => 1 ,'user' => 'pedro');
        $res = $coneccion->ejecutaConsultaUpdate('UPDATE usuarios SET user = :user WHERE id = :id',$datos);
        $this->assertCount(1, $res);
        $this->assertSame('registro modificado', $res['mensaje']);

        $datos = array('user' => 'pedro');
        $res = $coneccion->ejecutaConsultaSelect('SELECT * FROM usuarios WHERE user = :user',$datos);
        $this->assertCount(2, $res);
        $this->assertCount(1, $res['registros']);
        $this->assertCount(12, $res['registros'][0]);

    }

}