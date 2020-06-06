<!-- Main Sidebar Container -->
<aside class="main-sidebar sidebar-light-primary elevation-4">
    <!-- Brand Logo -->
    <a  href="<?php echo Redirect::get_url('inicio','index',SESSION_ID); ?>" class="brand-link">
      <img src="<?php echo RUTA_PROYECTO ?>template/adminlte3/dist/img/AdminLTELogo.png"
           class="brand-image img-circle elevation-3"
           style="opacity: .8">
      <span class="brand-text font-weight-light" <?php echo COLORBASE; ?>><b><?= NOMBRE_PROYECTO ?></b></span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">

    <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="image">
          <?php
            $avatar = '4';
            if (SEXO == 'femenino'){
              $avatar = '3';
            }
          ?>
          <img src="<?php echo RUTA_PROYECTO ?>template/adminlte3/dist/img/avatar<?php echo $avatar; ?>.png" class="img-circle elevation-2" alt="User Image">
        </div>
        <div class="info">
          <a class="d-block"><?php echo NOMBRE_USUARIO; ?></a>
        </div>
      </div>

      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">

          <?php foreach ($menu_navegacion as $item_menu => $menu) { ?>

            <?php
                $imprime = '<li class="nav-item has-treeview">';
                if ( CONTROLADOR == $menu_navegacion[$item_menu][0]){
                  $imprime =  '<li class="nav-item has-treeview menu-open">';
                }
                echo $imprime;
            ?>
            

              <a href="#" class="nav-link">
                <i class="nav-icon <?php echo $menu_navegacion[$item_menu][1]; ?>" <?php echo COLORBASE; ?>></i>
                <p>
                  <?php echo $menu_navegacion[$item_menu][2]; ?>
                  <i class="right fas fa-angle-left"></i>
                </p>
              </a>

              <ul class="nav nav-treeview">

                  <?php foreach ($menu as $metodo){ ?>
                    <?php if ( is_array($metodo) ){ ?>
                      <?php
                        $letra = 'r'; // esta es la letar que finaliza el fa ya sea far o fas
                        if ($metodo['metodo'] == METODO && CONTROLADOR == $menu_navegacion[$item_menu][0]){
                          $letra = 's';
                        }
                      
                      ?>
                      <li class="nav-item">
                        <a href="<?php echo Redirect::get_url($menu_navegacion[$item_menu][0],$metodo['metodo'],SESSION_ID);?>" class="nav-link">
                          <i class="fa<?php echo $letra ?> fa-circle nav-icon" <?php echo COLORBASE; ?>></i>
                          <p><?php echo $metodo['label']; ?></p>
                        </a>
                      </li>
                    <?php } // end if is array?>          
                  <?php }// end foreach ($menu as $metodo) ?>

              </ul>

            </li>
          <?php } ?>

        </ul>
        
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>