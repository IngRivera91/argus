<?php 

require_once __DIR__.'/../config.php'; 
require_once __DIR__.'/../vendor/autoload.php';

use Ayuda\Redireccion;
use Clase\Autentificacion;
use Error\Base AS ErrorBase;

$parametros_get_requeridos = array('controlador','metodo');

foreach ($parametros_get_requeridos as $parametro){
    valida_parametro_get($parametro);
}

$controladorActual = $_GET['controlador'];
$metodoActual = $_GET['metodo'];

try {

    $claseDatabase = 'Clase\\'.DB_TIPO.'\\Database';
    $coneccion = new $claseDatabase();

    $claseGeneraConsultas = 'Clase\\'.DB_TIPO.'\\GeneraConsultas';
    $generaConsultas = new $claseGeneraConsultas($coneccion);

}catch (ErrorBase $e) {
    $error = new ErrorBase('Error al conectarce a la base de datos',$e);
    $error->muestraError();
    exit;
}

$autentificacion = new Autentificacion($coneccion,$generaConsultas);

if ($controladorActual === 'session' && $metodoActual === 'login'){
    try{
        $resultado = $autentificacion->login();
    }catch(ErrorBase $e){
        if (get_class($e) == 'Error\Base') 
        {
            print_r( get_class($e) );
            $error = new ErrorBase('Error al hacer login',$e);
            $error->muestraError();
            exit;
        }
        $e->muestraError();
        exit;
    }
    Redireccion::enviar('inicio','index',$resultado['sessionId'],'Bienvenido');
    exit;
}

valida_parametro_get('session_id');
$sessionId = $_GET['session_id'];

try{
    $datos = $autentificacion->validaSessionId($sessionId);
}catch(ErrorBase $e){
    if (get_class($e) == 'Error\Base') 
    {
        print_r( get_class($e) );
        $error = new ErrorBase('Error al validar session_id',$e);
        $error->muestraError();
        exit;
    }
    $e->muestraError();
    exit;
}

if ($controladorActual === 'session' && $metodoActual === 'logout'){
    try{
        session_destroy();
        $resultado = $autentificacion->logout($_GET['session_id']);
    }catch(ErrorBase $e){
        
    }
    header('Location: login.php');
    exit;
}

# falta validar permiso

if (!file_exists('../app/controladores/'.$controladorActual.'.php')){
    # Esto es para hacer pruebas al final si no existe el controlador redirecciona al controlador inicio
    print_r("El controlador:{$controladorActual} no existe");
}

$controladorNombre = 'Controlador\\'.$controladorActual;
$controlador = new $controladorNombre($coneccion, $generaConsultas);

if (!method_exists($controlador,$metodoActual)){
    # Esto es para hacer pruebas al final si no existe el metodo redirecciona al controlador inicio
    print_r("El metodo:{$metodoActual} no existe no existe en el controlado:{$controladorActual}");
}

$controlador->$metodoActual();

$autentificacion->defineConstantes($datos,$_GET['session_id']);

$menu_navegacion = Ayuda\Menu::crear($coneccion,$generaConsultas,GRUPO_ID);

?>
<?php require_once __DIR__.'/../recursos/html/head.php'; ?>
<?php require_once __DIR__.'/../recursos/html/nav.php'; ?>
<?php require_once __DIR__.'/../recursos/html/menu.php'; ?>

<div class="container-fluid">
    
    <div class="content-wrapper">

        <section class="content">
                
        </section>

    </div>

</div>
    


<footer class="main-footer">
    <div class="float-right d-none d-sm-block">
        <b>Version</b> 1.0.0
    </div>
    <strong>Copyright © 2020 Ing Rivera . </strong>todos los derechos reservados.
</footer>

</div>
<?php
    require_once __DIR__.'/../recursos/html/final.php'; 
    
    function valida_parametro_get(string $parameto_get):void
    {
        if (!isset($_GET[$parameto_get]) || is_null($_GET[$parameto_get]) || (string)$_GET[$parameto_get] === ''){
            header('Location: login.php');
            exit;
        }
    }
?>