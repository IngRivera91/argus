<?php

use Ayuda\Html;
use Ayuda\Redireccion;

$inputs = $controlador->htmlInputFormulario;

?>
<br>
<?php echo Html::hr(); ?>
<form autocomplete="off" role="form" method="POST"
      action="<?php echo Redireccion::obtener($controlador->nombreMenu,'registrar_bd',SESSION_ID) ?>">
    <div class="row">
        <?php
            foreach ($inputs as $input) {
                echo $input;
            }
        ?>
    </div>
</form>
<?php echo Html::hr(); ?>