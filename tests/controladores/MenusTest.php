<?php

use Modelo\Menu;
use Controlador\menus;
use Error\Base AS ErrorBase;
use PHPUnit\Framework\TestCase;

class CMenusTest extends TestCase
{
    /**
     * @test
     */
    public function crearConeccion()
    {
        $this->assertSame(1,1);
        $claseDatabase = 'Clase\\'.DB_TIPO.'\\Database';
        $coneccion = new $claseDatabase();
        return $coneccion;
    }

    /**
     * @test
     * @depends crearConeccion
     */
    public function crearControlador($coneccion)
    {
        $this->assertSame(1,1);
        $menus = new menus($coneccion);
        return $menus;
    }
}