<?php use Ayuda\Redirect; ?>
<body class="hold-transition sidebar-mini">
<!-- Site wrapper -->
<div class="wrapper">
  <!-- Navbar -->
  <nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
      <li class="nav-item">
        <a <?php echo COLORBASE; ?>  class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
      </li>
    </ul>

    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">
      <!-- Messages Dropdown Menu -->
      <li class="nav-item" >
        <a <?php echo COLORBASE; ?> href="<?php echo Redirect::get_url('session','login_off',SESSION_ID); ?>" >Salir <i class="fas fa-power-off"></i></a>
      </li>
    </ul>
  </nav>
  <!-- /.navbar -->