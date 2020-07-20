<?php

use Ayuda\Html;
use Ayuda\Acciones;
use Ayuda\Redireccion;

$registros = $controlador->registros;
$inputs = $controlador->htmlInputFiltros;
$nombreMenu = $controlador->nombreMenu;
$acciones = Acciones::crear($coneccion, $generaConsultas, GRUPO_ID, $controladorActual);

?>
<br>
<form autocomplete="off" role="form" method="POST" action="<?php echo Redireccion::obtener($nombreMenu,'lista',SESSION_ID) ?>">
    <div class="row">
        <?php
        foreach ($inputs as $input) {
            echo $input;
        }
        ?>
    </div>
</form>

<?php if ($controlador->usarFiltros) { echo Html::hr(); } ?>

<div style="background-color: white;" class="table-responsive">
    <table class="table table-hover">

        <?php if (count($registros) > 0) { ?>
        
        <thead>
            <tr>
                <?php foreach ($controlador->camposLista as $label => $campo): ?>
                    <th><?php echo ucwords($label); ?></th>
                <?php endforeach; ?>
                <th class="text-center">Acciones</th>
            </tr>
        </thead>
        <tbody>
            
            <?php foreach ($registros as $registro): ?>
                <?php 
                    $id = $registro["{$nombreMenu}_id"]; 
                    $registroActivo = $registro["{$nombreMenu}_activo"];

                    if ($registroActivo) {
                        unset($acciones['activar_bd']);
                    }

                    if (!$registroActivo) {
                        unset($acciones['desactivar_bd']);
                    } 
                ?>
                <tr>

                    <?php foreach ($controlador->camposLista as $label => $campo): ?>
                        <td><?= $registro[$campo]; ?></td>
                    <?php endforeach; ?>

                    <td class='text-center'>
                        <?php foreach ($acciones as $nombre => $accion): ?>
                                <?php
                                    $metodo = $accion['metodos_nombre'];
                                    $url = Redireccion::obtener($accion['menus_nombre'],$metodo,SESSION_ID,'',$id);
                                    $accionString =  $accion['metodos_accion'];
                                    $icono =  $accion['metodos_icono'];
                                ?>
                                <a <?= COLORBASE; ?> title="<?= $accionString ?>" href="<?= $url; ?>">
                                    <i class="<?= $icono ?>"></i>
                                </a>
                        <?php endforeach; ?>
                    </td>

                </tr>
            <?php endforeach; ?>
        
        </tbody>
        <?php }else{ ?>
            <thead>
                <tr>
                    <h3 style="margin-top:.7em" class='text-center'>
                        <span <?php echo COLORBASE; ?> class="fas fa-times"></span> no existen registros
                    </h3>
                </tr>
            </thead>
        <?php } // end if count ?>

    </table>
</div>

<?= $controlador->htmlPaginador; ?>

<br>