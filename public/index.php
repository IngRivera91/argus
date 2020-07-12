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
try {
    $coneccion = new Clase\DatabaseMySQL();
    $generaConsultas = new Clase\GeneraConsultasMySQL($coneccion);
}catch (ErrorBase $e) {
    $error = new ErrorBase('Error al conectarce a la base de datos',$e);
    $error->muestraError();
    exit;
}

$autentificacion = new Autentificacion($coneccion,$generaConsultas);

if ($_GET['controlador'] === 'session' && $_GET['metodo'] === 'login'){
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

try{
    $datos = $autentificacion->validaSessionId($_GET['session_id']);
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

if ($_GET['controlador'] === 'session' && $_GET['metodo'] === 'logout'){
    try{
        session_destroy();
        $resultado = $autentificacion->logout($_GET['session_id']);
    }catch(ErrorBase $e){
        
    }
    header('Location: login.php');
    exit;
}

$autentificacion->defineConstantes($datos,$_GET['session_id']);

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
    
    function valida_parametro_get(string $parameto_get){
        if (!isset($_GET[$parameto_get]) || is_null($_GET[$parameto_get]) || (string)$_GET[$parameto_get] === ''){
            header('Location: login.php');
            exit;
        }
    }
?>