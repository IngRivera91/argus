<?php
use Clase\Validaciones;
use Error\Base AS ErrorBase;
use PHPUnit\Framework\TestCase;

class ClaseValidacionesTest extends TestCase
{
    /**
     * @test
     */
    public function validaTabla()
    {
        $valida = new Validaciones();

        $erro = null;
        try{
            $valida->tabla('');
        }catch(ErrorBase $e){
            $error = $e;
        }
        $mensajeEsperado = 'El nombre de tabla no puede venir vacio';
        $this->assertSame($error->getMessage(),$mensajeEsperado);

        $erro = null;
        try{
            $valida->tabla(' sessiones usuarios ');
        }catch(ErrorBase $e){
            $error = $e;
        }
        $mensajeEsperado = 'El nombre de la tabla no es valido';
        $this->assertSame($error->getMessage(),$mensajeEsperado);

    }

    /**
     * @test
     */
    public function validaDatos()
    {
        $valida = new Validaciones();

        $erro = null;
        try{
            $valida->datos('');
        }catch(ErrorBase $e){
            $error = $e;
        }
        $mensajeEsperado = 'Los datos deben venir en un array';
        $this->assertSame($error->getMessage(),$mensajeEsperado);

        $erro = null;
        try{
            $valida->datos(array());
        }catch(ErrorBase $e){
            $error = $e;
        }
        $mensajeEsperado = 'El array de datos no puede estar vacio';
        $this->assertSame($error->getMessage(),$mensajeEsperado);

        $erro = null;
        try{
            $valida->datos(['juan','password']);
        }catch(ErrorBase $e){
            $error = $e;
        }
        $mensajeEsperado = 'Los datos deben venir en un array asociativo';
        $this->assertSame($error->getMessage(),$mensajeEsperado);
    }

    /**
     * @test
     */
    public function validaConsulta()
    {
        $valida = new Validaciones();

        $erro = null;
        try{
            $valida->consulta('');
        }catch(ErrorBase $e){
            $error = $e;
        }
        $mensajeEsperado = 'La consulta no puede estar vacia';
        $this->assertSame($error->getMessage(),$mensajeEsperado);

    }
}