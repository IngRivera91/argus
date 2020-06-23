<?php

use Clase\Modelo; 
use Clase\Database;
use Error\Base AS ErrorBase;
use PHPUnit\Framework\TestCase;

class ClaseModeloTest extends TestCase
{

    /**
     * @test
     */
    public function registrarBd()
    {
        $coneccion = new Database();

        $coneccion->ejecutaConsultaDelete("DELETE FROM grupos");
        $coneccion->ejecutaConsultaInsert("INSERT INTO grupos (id) VALUES (1)");

        $tabla = 'usuarios';
        $columnasUnicas = ['usuario','correo_electronico'];
        $columnasObligatorias = ['usuario','password','nombre_completo','grupo_id'];
        $columnasProtegidas = ['password'];
        $relaciones = ['grupos' => 'usuarios.grupo_id'];
        $modelo = new Modelo($coneccion,$tabla,$columnasUnicas,$columnasObligatorias,$columnasProtegidas,$relaciones);

        $datos = [
            'id' => 8,
            'usuario' => 'ricardo',
            'correo_electronico' => 'mail@mail.com',
            'password' => '123asd',
            'nombre_completo' => 'Ricardo Rivera Sanchez',
            'grupo_id' => '1'
        ];

        $resultado = $modelo->registrarBd($datos);
        $mensajeEsperado = 'registro insertado';
        $this->assertIsArray($resultado);
        $this->assertSame($resultado['mensaje'],$mensajeEsperado);
        $this->assertSame($resultado['registro_id'],8);

        $this->assertSame(1,1);

        $coneccion->ejecutaConsultaDelete("DELETE FROM usuarios");
        $coneccion->ejecutaConsultaDelete("DELETE FROM grupos");
    }

}