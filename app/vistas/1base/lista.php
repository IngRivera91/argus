<?php
use Ayuda\Redireccion;
use Ayuda\Html;
$registros = $controlador->registros;
$inputs = $controlador->htmlInputFiltros;
$nombreMenu = $controlador->nombreMenu;
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
            <tr>
                <?php foreach ($controlador->camposLista as $label => $campo): ?>
                    <td><?= $registro[$campo]; ?></td>
                <?php endforeach; ?>
                <td class='text-center'>acciones</td>
            </tr>
            <?php endforeach; ?>
        
        </tbody>
        <?php }else{ ?>
            <thead>
                <tr><h3 style="margin-top:.7em" class='text-center'><span <?php echo COLORBASE; ?> class="fas fa-times"></span> no existen registros</h3></tr>
            </thead>
        <?php } // end if count ?>

    </table>
</div>

<?= $controlador->htmlPaginador; ?>

<br>