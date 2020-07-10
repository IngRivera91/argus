<?php 
    require_once __DIR__.'/../config.php'; 
    require_once __DIR__.'/../vendor/autoload.php'; 

?>
<?php require_once __DIR__.'/../recursos/html/head.php'; ?>


<body class="hold-transition login-page">
<div class="login-box">
  <div class="login-logo">
    <b>Acc</b>eso
  </div>
  <!-- /.login-logo -->
  <div class="card">
    <div class="card-body login-card-body">
      <form autocomplete="off"  action="index.php?controlador=session&metodo=login" method="post">
        <div class="input-group mb-3">
          <input name="usuario" type="text" class="form-control" placeholder="Usuario" require>
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
            <button type="submit" class="btn btn-default btn-block">Entrar</button>
          </div>
          <!-- /.col -->
        </div>
      </form>
    </div>
  </div>
</div>


<?php require_once __DIR__.'/../recursos/html/final.php'; ?>