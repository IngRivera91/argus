<?php
    require_once('config.php');
    require_once('vendor/autoload.php');

    use Ayuda\Creador;
    use Ayuda\Redirect;

    use Clase\Controlador;
    use Clase\Database;
    use Clase\Html;
    use Clase\Seguridad;

    function valida_parametro_get(string $get){
        if (!isset($_GET[$get]) || is_null($_GET[$get]) || (string)$_GET[$get] === ''){
            require_once('views/inicio/login.php');
            exit;
        }
    }

    $parametros_get_requeridos = array('controlador','metodo');

    foreach ($parametros_get_requeridos as $parametro){
        valida_parametro_get($parametro);
    }

    if ($_GET['controlador'] === 'session' && $_GET['metodo'] === 'login_bd'){

        $link = new Database(DB_USER_SESSION,DB_PASSWORD_SESSION);
        if(!is_null($link->error)){
            print_r($link->error);
            exit;
        }
        $seguridad = new Seguridad($link);

        $res = $seguridad->login_bd();
        if (isset($res['error'])){
            Redirect::header_url('','','',$res['mensaje']);
            exit;
        }
        Redirect::header_url('inicio','index',$res['session_id'],'Bienvenido');

    }

    if ($_GET['controlador'] === 'session' && $_GET['metodo'] === 'login_off'){

        $link = new Database();
        if(!is_null($link->error)){
            print_r($link->error);
            exit;
        }
        $seguridad = new Seguridad($link);

        $res = $seguridad->login_off();
        if (isset($res['error'])){
            Redirect::header_url('','','',$res['mensaje']);
            exit;
        }
        header('Location: '.RUTA_PROYECTO);
        exit;
    }

    valida_parametro_get('session_id');

    $link = new Database();
    if(!is_null($link->error)){
        print_r($link->error);
        exit;
    }

    $seguridad = new Seguridad($link);

    $valida_session = $seguridad->valida_session_id();

    if (isset($valida_session['error']) ){
        Redirect::header_url('','','',strip_tags($valida_session['mensaje']));
        exit;
    }

    $menu_navegacion = $seguridad->genera_menu();

    if (isset($menu_navegacion['error'])){
        print_r($menu_navegacion);
        exit;
    }

    $HTML = new Html();

    $valida_permiso = $seguridad->valida_permiso();

    if (isset($valida_permiso['error'])){
        print_r($valida_permiso);
        exit;
    }
    // ver todas las clases declaradas
    //print_r(get_declared_classes());exit;
    if ($valida_permiso){
        define('CONTROLADOR',$_GET['controlador']);
        define('METODO',$_GET['metodo']);

        $nombre_controlador = 'Controlador_'.ucwords(CONTROLADOR);
        if (file_exists('controladores/'.$nombre_controlador.'.php')){
            $controlador = Creador::controlador($nombre_controlador,$link);

            if (method_exists($controlador,METODO)){
                $acciones = $seguridad->genera_acciones_base();
                $metdo = METODO;
                $resultado = $controlador->$metdo();
            }
            else{
                $_GET['mensaje'] = 'El metodo '.METODO.' no existe';
            }
            
        }
        else{
            $_GET['mensaje'] = 'El controldaor '.CONTROLADOR.' no existe';
        }
    }
    else{
        if ($_GET['controlador'] == 'inicio'){
            define('CONTROLADOR','inicio');
            define('METODO','index');
            $controlador = Creador::controlador('Controlador_Inicio',$link);
        }else{

            define('CONTROLADOR','');
            define('METODO','');
            $_GET['mensaje'] = 'Permiso Denegado';

        }
    }


    ?>
    <?php require_once ('template/header.php'); ?>
    <?php
        $css = 'views/CSS/'.CONTROLADOR.'.'.METODO.'.css';
        if (file_exists($css)){?><link rel="stylesheet" href="<?php echo RUTA_PROYECTO.$css ?>">
    <?php } ?>
    <?php require_once ('template/header2.php'); ?>
    <?php require_once ('template/nav.php'); ?>
    <?php require_once ('template/menu.php'); ?>

    <div class="container-fluid">
        
        <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content">

                <?php if ($controlador->breadcrumb){ ?>
                <br>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item active" aria-current="page"><?php echo strtoupper(CONTROLADOR); ?></li>
                            <li class="breadcrumb-item active" aria-current="page"><?php echo strtoupper(METODO); ?></li>
                        </ol>
                    </nav>
                <?php }// end if ($controlador->breadcrumb)  ?>

                <?php if (isset($_GET['mensaje'])){ ?>
                    <br>
                    <div class="row">
                        <div class="col-md-1"></div>

                        <div class="col-md-10">
                            <div class="alert alert-info alert-dismissible fade show" role="alert">
                                <strong><?php echo $_GET['mensaje']; ?></strong>.
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                        </div>
                        <div class="col-md-1"></div>
                    </div>

                <?php } // end if (isset($_GET['mensaje'])) ?>
               <br>
                <?php
                $view = 'views/'.CONTROLADOR.'/'.METODO.'.php';
                if(file_exists($view)) {
                    require_once ('views/'.CONTROLADOR.'/'.METODO.'.php');
                }else{

                    if ( METODO == 'alta' ){
                        require_once ('views/1base/alta.php');
                    }

                    if (METODO == 'modifica'){
                        require_once ('views/1base/modifica.php');
                    }

                    if (METODO == 'lista'){
                        require_once ('views/1base/lista.php');
                    }
                }// end if(file_exists($view))


                ?>
            </section><!-- /.content -->
        </div>

    </div>
    


    <footer class="main-footer">
    <div class="float-right d-none d-sm-block">
        <b>Version</b> 3.0.0
    </div>
    <strong>Copyright © 2020 Ing Rivera . </strong>todos los derechos reservados.
  </footer>

</div>

<!-- Optional JavaScript -->
<!-- jQuery first, then Popper.js, then Bootstrap JS -->
<script src="<?php echo RUTA_PROYECTO ?>template/adminlte3/jquery/jquery.min.js"></script>
<!-- Select2 -->
<script src="<?php echo RUTA_PROYECTO ?>template/adminlte3/select2/js/select2.full.min.js"></script>
<!-- Bootstrap4 Duallistbox -->
<script src="<?php echo RUTA_PROYECTO ?>template/adminlte3/bootstrap4-duallistbox/jquery.bootstrap-duallistbox.min.js"></script>
<!-- InputMask -->
<script src="<?php echo RUTA_PROYECTO ?>template/adminlte3//moment/moment.min.js"></script>
<script src="<?php echo RUTA_PROYECTO ?>template/adminlte3/inputmask/min/jquery.inputmask.bundle.min.js"></script>
<!-- date-range-picker -->
<script src="<?php echo RUTA_PROYECTO ?>template/adminlte3/daterangepicker/daterangepicker.js"></script>
<!-- bootstrap color picker -->
<script src="<?php echo RUTA_PROYECTO ?>template/adminlte3/bootstrap-colorpicker/js/bootstrap-colorpicker.min.js"></script>
<!-- Tempusdominus Bootstrap 4 -->
<script src="<?php echo RUTA_PROYECTO ?>template/adminlte3/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js"></script>
<!-- Bootstrap Switch -->
<script src="<?php echo RUTA_PROYECTO ?>template/adminlte3/bootstrap-switch/js/bootstrap-switch.min.js"></script>

<script src="<?php echo RUTA_PROYECTO ?>template/adminlte3/bootstrap/js/bootstrap.min.js"></script>
<!-- AdminLTE App -->
<script src="<?php echo RUTA_PROYECTO ?>template/adminlte3/dist/js/adminlte.min.js"></script>
<?php
echo "<script>";
echo "var COLORBASE_BOOTSTRAP = '".COLORBASE_BOOTSTRAP."';";
echo "</script>";
$js = 'views/JS/'.CONTROLADOR.'.'.METODO.'.js';
if (file_exists($js)){?><script src="<?php echo RUTA_PROYECTO.$js ?>"></script>">
<?php } ?>

<script>
    $(function () {

        //Initialize Select2 Elements
        $('.select2').select2();

        //Initialize Select2 Elements
        $('.select2bs4').select2({
        theme: 'bootstrap4'
        });
    });
</script>
</body>
</html>


