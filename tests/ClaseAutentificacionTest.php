<?php

use Clase\Autentificacion; 
use Clase\Database;
use Error\Base AS ErrorBase;
use PHPUnit\Framework\TestCase;

class ClaseAutentificacionTest extends TestCase
{

    /**
     * @test
     */
    public function creaAutentificacion()
    {
        $this->assertSame(1,1);
        $coneccion = new Database();
        $coneccion->ejecutaConsultaDelete('DELETE FROM usuarios');
        $coneccion->ejecutaConsultaDelete('DELETE FROM grupos');
        $coneccion->ejecutaConsultaInsert("INSERT INTO grupos (id,nombre) VALUES (1,'programador')");
        $coneccion->ejecutaConsultaInsert("INSERT INTO usuarios (id,usuario,password,grupo_id,activo) VALUES (1,'admin','admin',1,true)");
        $coneccion->ejecutaConsultaInsert("INSERT INTO usuarios (id,usuario,password,grupo_id,activo) VALUES (2,'admin2','admin2',1,false)");
        $autentificacion = new Autentificacion($coneccion);

    }
}