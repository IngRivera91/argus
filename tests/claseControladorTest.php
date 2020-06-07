<?php 

use PHPUnit\Framework\TestCase;
use Clase\Controlador;

class ClaseControladorTest extends TestCase{
    
    public function test_obtene_numero_pagina()
    {
        $controlador = new Controlador;
        $_GET['pag'] = 5;
        $this->assertEquals($controlador->obtene_numero_pagina(),'5');

        unset($_GET['pag']);
        $this->assertEquals($controlador->obtene_numero_pagina(),'1');

        $_GET['pag'] = 'hola';
        $this->assertEquals($controlador->obtene_numero_pagina(),'1');
    }
}