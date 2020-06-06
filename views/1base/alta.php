<?php
use Ayuda\Redirect;
    $inputs = $controlador->inputs;
?>
<?php echo $HTML->hr(); ?>
<form autocomplete="off" role="form" method="POST"
      action="<?php echo Redirect::get_url($controlador->tabla,'alta_bd',SESSION_ID) ?>">
    <div class="row">
        <?php
            foreach ($inputs as $input) {
                echo $input;
            }
        ?>
    </div>
</form>
<?php echo $HTML->hr(); ?>