<?php

use PHPUnit\Framework\TestCase;
use Clase\Database; 

class ClaseDatabaseTest extends TestCase
{ 
    /**
     * @test
     */
    public function ejecutaQuery()
    {
        $coneccion = new Database();

        $res = $coneccion->ejecutaQuery('DELETE FROM usuarios');
        $this->assertCount(1, $res);
        $this->assertSame('registro eliminado', $res['mensaje']);

        $datos = array('id' => 1 , 'user' => 'juan' , 'password' => 'juan');
        $res = $coneccion->ejecutaQuery('INSERT INTO usuarios (id,user,password) VALUES (:id,:user,:password)',$datos);
        $this->assertCount(2, $res);
        $this->assertSame('registro insertado', $res['mensaje']);
        $this->assertSame(1, $res['registro_id']);

        $res = $coneccion->ejecutaQuery('SELECT * FROM usuarios');
        $this->assertCount(2, $res);
        $this->assertCount(12, $res['registros'][0]);

        $datos = array('user' => 'juan');
        $res = $coneccion->ejecutaQuery('SELECT * FROM usuarios WHERE user = :user',$datos);
        $this->assertCount(2, $res);
        $this->assertCount(1, $res['registros']);
        $this->assertCount(12, $res['registros'][0]);

        $datos = array('user' => 'pedro');
        $res = $coneccion->ejecutaQuery('SELECT * FROM usuarios WHERE user = :user',$datos);
        $this->assertCount(2, $res);
        $this->assertCount(0, $res['registros']);

        $datos = array('id' => 1 ,'user' => 'pedro');
        $res = $coneccion->ejecutaQuery('UPDATE usuarios SET user = :user WHERE id = :id',$datos);
        $this->assertCount(1, $res);
        $this->assertSame('registro modificado', $res['mensaje']);

        $datos = array('user' => 'pedro');
        $res = $coneccion->ejecutaQuery('SELECT * FROM usuarios WHERE user = :user',$datos);
        $this->assertCount(2, $res);
        $this->assertCount(1, $res['registros']);
        $this->assertCount(12, $res['registros'][0]);

    }

}