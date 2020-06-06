<?php
use Ayuda\Redirect;
$registros = $controlador->registros;
$inputs = $controlador->inputs_filtro_lista;
?>
    <form autocomplete="off" role="form" method="POST"
          action="<?php echo Redirect::get_url($controlador->tabla,'lista',SESSION_ID) ?>">
        <div class="row">
            <?php
            foreach ($inputs as $input) {
                echo $input;
            }
            ?>
        </div>
    </form>
<?php    if ($controlador->lista_usar_filtro){
    echo $HTML->hr();
}

    ?>
<div style="background-color: white;  " class="table-responsive">
    <table class="table table-hover">

        <tbody>
        <?php if (count($registros) > 0) { ?>
            <tr>
                <?php foreach ($controlador->nombre_columnas_lista as $label): ?>
                    <th><?php echo ucwords($label); ?></th>
                <?php endforeach; ?>

                <th><p class="text-center">Acciones</p></th>
            </tr>
            <?php foreach ($registros as $registro ) { ?>
                <?php if ($registro['status'] == 'inactivo'): ?>
                    <tr style="background-color: #bbbbbb">
                <?php else: ?>
                    <tr>
                <?php endif; ?>


                    <?php foreach ($controlador->columnas_lista as $campo): ?>
                        <?php
                            $campo_explode = explode('.',$campo);
                            $campo_end = end($campo_explode);
                            $campo_end_explode = explode(' ',$campo_end);
                            if (count($campo_end_explode) == 1 ){
                                $field = $campo_end_explode[0];
                            }else{
                                $field = end($campo_end_explode);
                            }

                    ?>
                        <td><?php echo $registro[$field] ?></td>
                    <?php endforeach; ?>

                    <td>
                        <p class="text-center">
                            <?php foreach ($acciones as $accion): ?>
                                <a <?php echo COLORBASE; ?> title="<?php echo $accion['label'] ?>" href="<?php echo Redirect::get_url($accion['controlador'],
                                    $accion['metodo'],SESSION_ID,'',
                                    $registro['id']) ?>"><i class="<?php echo $accion['icon'] ?>"></i></a>
                            <?php endforeach; ?>

                        </p>
                    </td>
                </tr>
            <?php } // foreach?>


        <?php }else{ ?>
            <td align="center">
                <span <?php echo COLORBASE; ?> class="fas fa-times"></span> no existen registros
            </td>
        <?php } // end if count ?>
        </tbody>

    </table>
</div>

<?php echo $controlador->paginador ?>