<aside class="main-sidebar sidebar-light-primary elevation-4">

  <a  href="#" class="brand-link">
    <img src="img/AdminLTELogo.png"
        class="brand-image img-circle elevation-3"
        style="opacity: .8">
    <span class="brand-text font-weight-light" <?php echo COLORBASE; ?>><b><?= NOMBRE_PROYECTO ?></b></span>
  </a>

  
  <div class="sidebar">

  <div class="user-panel mt-3 pb-3 mb-3 d-flex">
      <div class="image">
      <?php 
        $numero = '4';
        if (SEXO == 'f'){
          $numero = '3';
        } 
      ?>
        <img src="img/avatar<?=$numero?>.png" class="img-circle elevation-2" alt="User Image">
      </div>
      <div class="info">
        <a class="d-block" <?php echo COLORBASE; ?>><?= NOMBRE_USUARIO ?></a>
      </div>
    </div>

    <nav class="mt-2">
      <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">

        

      </ul>
      
    </nav>
    
  </div>
  
</aside>