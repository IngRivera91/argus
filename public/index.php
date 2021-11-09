<?php
$pathBase = __DIR__.'/../';
require_once $pathBase . "app/config/requires.php";

use App\ayudas\Html;
use App\ayudas\Redireccion;
use App\class\Auth;
use App\Errors\Base AS ErrorBase;

$controladoresSinPermisos = ['inicio','password'];
$parametrosGetRequeridos = array('controlador','metodo');

foreach ($parametrosGetRequeridos as $parametro){
    validaParametroGet($parametro);
}

$controladorActual = $_GET['controlador'];
$metodoActual = $_GET['metodo'];

if ($controladorActual === 'session' && $metodoActual === 'login'){
    try{
        $resultado = Auth::login();
    }catch(ErrorBase $e){
        if (DEBUG_MODE) {
            $e->muestraError();
            exit;
        }
        $mensaje = "El usuario o contraseña son incorrectos";
        header("Location: login.php?mensaje=$mensaje");
        exit;
    }
    Redireccion::enviar('inicio','index',$resultado['sessionId'],'Bienvenido');
    exit;
}

validaParametroGet('session_id');
$sessionId = $_GET['session_id'];

try{
    Auth::checkSessionId($sessionId);
}catch(ErrorBase $e){
    if (DEBUG_MODE) {
        $e->muestraError();
        exit;
    }
    $mensaje = "session_id no valido";
    header("Location: login.php?mensaje=$mensaje");
    exit;
}

if ($controladorActual === 'session' && $metodoActual === 'logout'){
    try{
        Auth::logout($sessionId);
        session_destroy();
    }catch(ErrorBase $e){
        if (DEBUG_MODE) {
            $e->muestraError();
            exit;
        }
    }
    header('Location: login.php');
    exit;
}

if (!in_array($controladorActual,$controladoresSinPermisos)){

    if (!Auth::hasPermission($controladorActual, $metodoActual)) {
        $mensaje  = "No tienes permisos para acceder al metodo:$metodoActual del controlador:$controladorActual";
        if (DEBUG_MODE) {
            echo $mensaje;
            exit;
        }
        Redireccion::enviar('inicio','index',SESSION_ID,$mensaje);
        exit;
    }

}

if (!file_exists("{$pathBase}app/controllers/$controladorActual.php")){
    Redireccion::enviar('inicio','index',SESSION_ID,"No existe el controlador:$controladorActual");
    exit;
}


$controladorNombre = 'App\\controllers\\'.$controladorActual;
$controlador = new $controladorNombre;

if (!method_exists($controlador,$metodoActual)){
    Redireccion::enviar('inicio','index',SESSION_ID,"No existe el metodo:$metodoActual del controlador:$controladorActual");
    exit;
}

$controlador->$metodoActual();

#seleciona la vista

$rutaVistasBase = $pathBase . '/app/vistas';
$rutaVista = '';
if ( $metodoActual == 'registrar') {
    $rutaVista = "$rutaVistasBase/1base/registrar.php";
}

if ($metodoActual == 'modificar') {
    $rutaVista = "$rutaVistasBase/1base/modificar.php";
}

if ($metodoActual == 'lista') {
    $rutaVista = "$rutaVistasBase/1base/lista.php";
}

$vista = "$rutaVistasBase/$controladorActual/$metodoActual.php";

if(file_exists($vista)) {
    $rutaVista = $vista;
}

if ($rutaVista == '') {
    print_r("No se puede cargar la vista controlador:$controladorActual metodo:$metodoActual");
    exit;
}

# El menu se carga hasta el final
$menu_navegacion = Html::menu(GRUPO_ID);

?>
<?php require_once $pathBase . "recursos/html/head.php"; ?>
<?php require_once $pathBase . "recursos/html/nav.php"; ?>
<?php require_once $pathBase . "recursos/html/menu.php"; ?>

<div class="container-fluid">
    
    <div class="content-wrapper">

        <section class="content">

        <?php if ($controlador->breadcrumb){ ?>
            <br>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item active" aria-current="page"><?php echo strtoupper($controladorActual); ?></li>
                    <li class="breadcrumb-item active" aria-current="page"><?php echo strtoupper($metodoActual); ?></li>
                </ol>
            </nav>
        <?php }// end if ($controlador->breadcrumb)  ?>

        <?php if (isset($_GET['mensaje'])){ ?>
            <br>
            <div class="row">
                <div class="col-md-1"></div>

                <div class="col-md-10">
                    <div class="alert alert-default alert-main alert-dismissible fade show" role="alert">
                        <strong><?php echo $_GET['mensaje']; ?></strong>.
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                </div>
                <div class="col-md-1"></div>
            </div>
        <?php } // end if (isset($_GET['mensaje'])) ?>

        <?php require_once ($rutaVista); ?>

        </section> <!-- end section content -->

    </div><!-- end content-wrapper -->

</div><!-- end container-fluit -->
    


<footer class="main-footer">
    <div class="float-right d-none d-sm-block">
        <b>Version</b> 1.0.0
    </div>
    <strong>Copyright © 2021. </strong>todos los derechos reservados.
    <!-- <strong>Copyright © 2020 Ing Rivera . </strong>todos los derechos reservados. -->
</footer>

<?php
    require_once $pathBase . "recursos/html/final.php";
    
    function validaParametroGet(string $parametro_get):void
    {
        if (!isset($_GET[$parametro_get]) || is_null($_GET[$parametro_get]) || (string)$_GET[$parametro_get] === ''){
            header('Location: login.php');
            exit;
        }
    }
?>