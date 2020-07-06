<?php 

require_once __DIR__.'/../config.php'; 
require_once __DIR__.'/../vendor/autoload.php';

use Ayuda\Redireccion;
use Clase\Database;
use Error\Base AS ErrorBase;

$parametros_get_requeridos = array('controlador','metodo');

foreach ($parametros_get_requeridos as $parametro){
    valida_parametro_get($parametro);
}
try {
    $coneccion = new Database();
}catch (ErrorBase $e) {
    $error = new ErrorBase('Error al conectarce a la base de datos',$e);
    $error->muestraError();
    exit;
}

if ($_GET['controlador'] === 'session' && $_GET['metodo'] === 'login_bd'){
    
}
    

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