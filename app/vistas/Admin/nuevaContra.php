<?php

use App\Class\Redireccion;

$inputs = $controlador->htmlInputFormulario;
$registro = $controlador->registro;

?>
<br>
<h3><?= "Nombre: {$registro['name']} {$registro['last_name']}"; ?></h3>
<h3><?= "Usuario: {$registro['user']}"; ?></h3>
<br>

<?php $rutaPOST = Redireccion::obtener($controlador->nameController,'nuevaContraBd',SESSION_ID); ?>
<form autocomplete="off" role="form" method="POST" action="<?= $rutaPOST  ?>">
    <input type="hidden" name="usuarioId" value="<?= $registro['id']; ?>">
    <div class="row">
        <?php
        foreach ($inputs as $input) {
            echo $input;
        }
        ?>
    </div>
</form>
