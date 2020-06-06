<?php use Ayuda\Redirect; ?>
<?php require_once('template/header.php'); ?>

    <title><?php echo NOMBRE_PROYECTO ?></title>
</head>
<?php if (isset($_GET['mensaje'])){ ?>
    <div class="row">
        
        <div class="col-md-12">
            <div class="alert <?php echo ALERTCOLORLOGIN ?> alert-dismissible"
                 style="background-color: white !important; color: black !important; border-color: white !important;">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                <p align="center"><?php echo $_GET['mensaje']; ?></p>
            </div>
        </div>
    </div>

<?php } ?>
<br>

<body class="hold-transition login-page">
<body class="hold-transition login-page">
<div class="login-box">
  <div class="login-logo">
    <b>Acc</b>eso
  </div>
  <!-- /.login-logo -->
  <div class="card">
    <div class="card-body login-card-body">
      <form autocomplete="off"  action="<?php echo Redirect::get_url('session','login_bd'); ?>" method="post">
        <div class="input-group mb-3">
          <input name="user" type="text" class="form-control" placeholder="Usuario" require>
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-user"></span>
            </div>
          </div>
        </div>
        <div class="input-group mb-3">
          <input name="password" type="password" class="form-control" placeholder="Contraseña" require>
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-lock"></span>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-8">
            
          </div>
          <!-- /.col -->
          <div class="col-4">
            <button type="submit" class="btn btn-<?php echo COLORBASE_BOOTSTRAP ?> btn-block">Entrar</button>
          </div>
          <!-- /.col -->
        </div>
      </form>
    </div>
    <!-- /.login-card-body -->
  </div>
</div>
<!-- /.login-box -->


<!-- Optional JavaScript -->
<!-- jQuery first, then Popper.js, then Bootstrap JS -->
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
</body>
</html>