<?php

use App\Class\Redireccion;

$inputs = $controlador->htmlInputFormulario;
$pagina = "&pag={$controlador->obtenerNumeroPagina()}";

?>
<br>
<form autocomplete="off" role="form" method="POST"
      action="<?php echo Redireccion::obtener($controlador->nameController,'modificarBd',SESSION_ID,'',$_GET['registroId']).$pagina ?>">
    <div class="row">
        <?php
            foreach ($inputs as $input) {
                echo $input;
            }
        ?>
    </div>
</form>