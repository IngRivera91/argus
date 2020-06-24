<?php
use Clase\Validaciones;
use Error\Base AS ErrorBase;
use PHPUnit\Framework\TestCase;

class ClaseValidacionesTest extends TestCase
{

    /**
     * @test
     */
    public function creaValidaciones()
    {
        $this->assertSame(1,1);
        return new Validaciones();
    }

    /**
     * @test
     * @depends creaValidaciones
     */
    public function validaNombreTabla($valida)
    {
        $error = null;
        try{
            $valida->nombreTabla('');
        }catch(ErrorBase $e){
            $error = $e;
        }
        $mensajeEsperado = 'El nombre de tabla no puede venir vacio';
        $this->assertSame($error->getMessage(),$mensajeEsperado);

        $error = null;
        try{
            $valida->nombreTabla(' sessiones usuarios ');
        }catch(ErrorBase $e){
            $error = $e;
        }
        $mensajeEsperado = 'El nombre de la tabla no es valido';
        $this->assertSame($error->getMessage(),$mensajeEsperado);
    }

     /**
     * @test
     * @depends creaValidaciones
     */
    public function validaFiltros($valida)
    {
        $error = null;
        try{
            $valida->filtros('');
        }catch(ErrorBase $e){
            $error = $e;
        }
        $mensajeEsperado = 'Los filtros deben venir en un array';
        $this->assertSame($error->getMessage(),$mensajeEsperado);

        $error = null;
        try{
            $filtros = array();
            $valida->filtros($filtros);
        }catch(ErrorBase $e){
            $error = $e;
        }
        $mensajeEsperado = 'El array de filtros no puede estar vacio';
        $this->assertSame($error->getMessage(),$mensajeEsperado);

        $error = null;
        try{
            $filtros = array('');
            $valida->filtros($filtros);
        }catch(ErrorBase $e){
            $error = $e;
        }
        $mensajeEsperado = 'Los filtros deben ser un array de arrays';
        $this->assertSame($error->getMessage(),$mensajeEsperado);

        $error = null;
        try{
            $filtros = array([]);
            $valida->filtros($filtros);
        }catch(ErrorBase $e){
            $error = $e;
        }
        $mensajeEsperado = 'Cada filtro debe tener el key [\'campo\']';
        $this->assertSame($error->getMessage(),$mensajeEsperado);

        $error = null;
        try{
            $filtros = array(['campo' => 'id']);
            $valida->filtros($filtros);
        }catch(ErrorBase $e){
            $error = $e;
        }
        $mensajeEsperado = 'Cada filtro debe tener el key [\'valor\']';
        $this->assertSame($error->getMessage(),$mensajeEsperado);

        $error = null;
        try{
            $filtros = array(['campo' => 'id' , 'valor' => 1]);
            $valida->filtros($filtros);
        }catch(ErrorBase $e){
            $error = $e;
        }
        $mensajeEsperado = 'Cada filtro debe tener el key [\'signoComparacion\']';
        $this->assertSame($error->getMessage(),$mensajeEsperado);
    }

    /**
     * @test
     * @depends creaValidaciones
     */
    public function validaArray($valida)
    {
        $error = null;
        try{
            $nombreArray = 'Array';
            $valida->array($nombreArray,'');
        }catch(ErrorBase $e){
            $error = $e;
        }
        $mensajeEsperado = "Array:$nombreArray debe ser un array";
        $this->assertSame($error->getMessage(),$mensajeEsperado);

        $error = null;
        try{
            $nombreArray = 'Array';
            $valida->array($nombreArray,array());
        }catch(ErrorBase $e){
            $error = $e;
        }
        $mensajeEsperado = "Array:$nombreArray no puede ser un array vacio";
        $this->assertSame($error->getMessage(),$mensajeEsperado);
    }

    /**
     * @test
     * @depends creaValidaciones
     */
    public function validaArrayAsociativo($valida)
    {
        $error = null;
        try{
            $nombreArray = 'Array';
            $valida->arrayAsociativo($nombreArray,['juan','password']);
        }catch(ErrorBase $e){
            $error = $e;
        }
        $mensajeEsperado = "Array:$nombreArray debe ser un array asociativo";
        $this->assertSame($error->getMessage(),$mensajeEsperado);
    }

    /**
     * @test
     * @depends creaValidaciones
     */
    public function validaConsulta($valida)
    {
        $error = null;
        try{
            $valida->consulta('');
        }catch(ErrorBase $e){
            $error = $e;
        }
        $mensajeEsperado = 'La consulta no puede estar vacia';
        $this->assertSame($error->getMessage(),$mensajeEsperado);
    }
}