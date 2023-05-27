    <script src="<?php echo APP_URL; ?>adminlte/plugins/jquery/jquery.min.js"></script>
    <script src="<?php echo APP_URL; ?>adminlte/plugins/select2/js/select2.full.min.js"></script>
    <script src="<?php echo APP_URL; ?>adminlte/plugins/bootstrap/js/bootstrap.min.js"></script>
    <script src="<?php echo APP_URL; ?>adminlte/dist/js/adminlte.min.js"></script>

    <?php
        $rutaArchivoJs = '';
        if (isset($controladorActual) && isset($metodoActual)) {
            $rutaArchivoJs = "js/{$controladorActual}.{$metodoActual}.js";
        }
        if(file_exists($rutaArchivoJs)) {
            echo "<script src='$rutaArchivoJs'></script>";
        }
    ?>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            $('.select2').select2();
        });
    </script>

    </body>
</html>