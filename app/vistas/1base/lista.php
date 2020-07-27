<?php

use Ayuda\Html;
use Ayuda\Acciones;
use Ayuda\Redireccion;

$registros = $controlador->registros;
$inputs = $controlador->htmlInputFiltros;
$nombreMenu = $controlador->nombreMenu;
$acciones = Acciones::crear($coneccion, GRUPO_ID, $controladorActual);

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
            <?php 
                
            ?>
            <?php foreach ($registros as $registro): ?>
                <?php 
                    $id = $registro["{$nombreMenu}_id"]; 
                    $registroActivo = $registro["{$nombreMenu}_activo"];
                    $styleRegistros = '';

                    if (!$registroActivo) {
                        $styleRegistros = STYLE_REGISTRO_INACTIVO; 
                    }

                    $respaldoAcciones = $acciones;

                    if ($registroActivo) {
                        unset($acciones['activar_bd']);
                    }

                    if (!$registroActivo) {
                        unset($acciones['desactivar_bd']);
                    } 
                ?>
                <tr <?= $styleRegistros; ?> >

                    <?php foreach ($controlador->camposLista as $label => $campo): ?>
                        <?php
                            $campoRegistro = $registro[$campo];
                            # https://www.php.net/manual/es/function.stristr.php Ejemplo 2
                            if (!stristr($campo, "{$nombreMenu}_activo") === false) {
                                $campoRegistro = TEXTO_REGISTRO_INACTIVO;
                                if ($registro[$campo]) {
                                    $campoRegistro = TEXTO_REGISTRO_ACTIVO; 
                                }
                            }
                        ?>
                        <td><?= $campoRegistro; ?></td>
                    <?php endforeach; ?>

                    <td class='text-center'>
                        <?php foreach ($acciones as $nombre => $accion): ?>
                                <?php
                                    $metodo = $accion['metodos_nombre'];
                                    $numeroPagina = 1;
                                    if (isset($_GET['pag'])) {
                                        $numeroPagina = $_GET['pag'];
                                    }
                                    $url = Redireccion::obtener($accion['menus_nombre'],$metodo,SESSION_ID,'',$id)."&pag={$numeroPagina}";
                                    $accionString =  $accion['metodos_accion'];
                                    $icono =  $accion['metodos_icono'];
                                ?>
                                <a title="<?= $accionString ?>" href="<?= $url; ?>">
                                    <i class="<?= $icono ?>"></i>
                                </a>
                        <?php endforeach; ?>
                    </td>

                </tr>
                <?php $acciones = $respaldoAcciones; ?>
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