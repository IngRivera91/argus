<?php

use Ayuda\Html;
use Ayuda\Redireccion;

$inputs = $controlador->htmlInputFormulario;

?>
<br>
<h3>Cambiar Contraseña</h3>
<br>

<?php $rutaPOST = Redireccion::obtener('password','cambiarPasswordBd',SESSION_ID); ?>
<form autocomplete="off" role="form" method="POST" action="<?= $rutaPOST  ?>">
    <div class="row">
        <?php
            foreach ($inputs as $input) {
                echo $input;
            }
        ?>
    </div>
</form>