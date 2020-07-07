<?php

use Clase\Autentificacion; 
use Clase\Database;
use Error\Base AS ErrorBase;
use Error\Esperado AS ErrorEsperado;
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
        $password = md5('admin');
        $coneccion->ejecutaConsultaDelete('DELETE FROM sessiones');
        $coneccion->ejecutaConsultaDelete('DELETE FROM usuarios');
        $coneccion->ejecutaConsultaDelete('DELETE FROM grupos');
        $coneccion->ejecutaConsultaInsert("INSERT INTO grupos (id,nombre) VALUES (1,'programador')");
        $coneccion->ejecutaConsultaInsert("INSERT INTO usuarios (id,usuario,password,grupo_id,activo) VALUES (1,'admin','$password',1,true)");
        $coneccion->ejecutaConsultaInsert("INSERT INTO usuarios (id,usuario,password,grupo_id,activo) VALUES (2,'admin2','$password',1,false)");
        $autentificacion = new Autentificacion($coneccion);
        return $autentificacion;
    }

    /**
     * @test
     * @depends creaAutentificacion
     */
    public function login($autentificacion)
    {
        $error = null;
        try{
            $resultado = $autentificacion->login();
        }catch(ErrorBase $e){
            $error = $e;
        }
        $mensajeEsperado = 'Debe existir $_POST[\'usuarios\']';
        $this->assertSame($error->getMessage(),$mensajeEsperado);

        $_POST['usuario'] = '';

        $error = null;
        try{
            $resultado = $autentificacion->login();
        }catch(ErrorBase $e){
            $error = $e;
        }
        $mensajeEsperado = '$_POST[\'usuarios\'] no pude estar vacio';
        $this->assertSame($error->getMessage(),$mensajeEsperado);

        $_POST['usuario'] = 'juan';

        $error = null;
        try{
            $resultado = $autentificacion->login();
        }catch(ErrorBase $e){
            $error = $e;
        }
        $mensajeEsperado = 'Debe existir $_POST[\'password\']';
        $this->assertSame($error->getMessage(),$mensajeEsperado);

        $_POST['password'] = '';

        $error = null;
        try{
            $resultado = $autentificacion->login();
        }catch(ErrorBase $e){
            $error = $e;
        }
        $mensajeEsperado = '$_POST[\'password\'] no pude estar vacio';
        $this->assertSame($error->getMessage(),$mensajeEsperado);
        
        $_POST['password'] = 'asd';

        $error = null;
        try{
            $resultado = $autentificacion->login();
        }catch(ErrorBase $e){
            $error = $e;
        }
        $mensajeEsperado = "usuario o contraseña incorrecto";
        $this->assertSame($error->getMessage(),$mensajeEsperado);
        $this->assertInstanceOf(ErrorEsperado::class, $error);
        
        $_POST['password'] = 'admin';
        $_POST['usuario'] = 'admin';
        
        $resultado = $autentificacion->login();
        $this->assertIsArray($resultado);
        $this->assertArrayHasKey('session_id',$resultado);
        $this->assertArrayHasKey('usuario',$resultado);
        $this->assertIsArray($resultado['usuario']);
        $session_id = md5( md5( $_POST['usuario'].$_POST['password'].$resultado['fechaHora'] ) );
        $this->assertSame($session_id,$resultado['session_id']);
    }
}