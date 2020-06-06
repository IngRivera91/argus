<?php $menus_metodos = $controlador->metodos_menu; ?>
<div class="card card-info">
    <input type="hidden" name="session_id" id="session_id" value="<?php echo $_GET['session_id'] ?>">
    <div class="card-header text-center">
        Grupo : <?php echo $controlador->nombre_grupo ?>
    </div>
    <div class="card-body">
        <div class="container-fluid">

            <div class="accordion" id="accordionExample">
                <?php foreach ($menus_metodos as $menu => $metodos ): ?>
                    <div class="card">
                        <div class="card-header" id="heading<?php echo $menu ?>">
                        <h2 class="mb-0">
                        <button class="btn btn-link collapsed" type="button" data-toggle="collapse" data-target="#<?php echo $menu ?>" aria-expanded="false" aria-controls="collapseTwo">
                            <b <?php echo COLORBASE ?> ><?php echo strtoupper ($menu) ?></b>  
                            </button>
                        </h2>
                        </div>
                        <div id="<?php echo $menu ?>" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionExample">
                        <div class="card-body">
                                    <?php
                                    foreach ($metodos as $metodo){
                                        $metodo_id = $metodo['id'];
                                        $grupo_id = $_GET['registro_id'];
                                        if($metodo['estado'] == 1){
                                            echo "<a onclick='asigna_permisos($metodo_id,$grupo_id);' id='$metodo_id' class='btn btn-". COLORBASE_BOOTSTRAP ." btn-flat'>".$metodo['metodo']."</a>";
                                        }else{
                                            echo "<a onclick='asigna_permisos($metodo_id,$grupo_id);' id='$metodo_id' class='btn btn-default btn-flat'>".$metodo['metodo']."</a>";
                                        }

                                    }
                                    ?>
                        </div>
                        </div>
                    </div>
                <?php endforeach; ?>
                
            </div>

        </div>
    </div>
</div>
