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
        $this->assertSame(1, count($res));

        $res = $coneccion->ejecutaQuery("INSERT INTO usuarios (id,user,password) VALUES ('1','juan','juan')");
        $this->assertSame(2, count($res));
        $this->assertEquals(1, $res['registro_id']);

        $res = $coneccion->ejecutaQuery('SELECT * FROM usuarios');
        $this->assertSame(2, count($res));
        $this->assertSame(12, count($res['registros'][0]));

        $res = $coneccion->ejecutaQuery('SELECT * FROM usuarios WHERE user = "juan"');
        $this->assertSame(2, count($res));
        $this->assertSame(1, count($res['registros']));
        $this->assertSame(12, count($res['registros'][0]));

        $res = $coneccion->ejecutaQuery('SELECT * FROM usuarios WHERE user = "pedro"');
        $this->assertSame(2, count($res));
        $this->assertSame(0, count($res['registros']));

    }

}