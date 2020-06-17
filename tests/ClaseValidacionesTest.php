<?php
use Clase\Validaciones;
use Error\Base AS ErrorBase;
use PHPUnit\Framework\TestCase;

class ClaseValidacionesTest extends TestCase
{
    /**
     * @test
     */
    public function tabla()
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
}