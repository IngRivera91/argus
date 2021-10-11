    <script src="<?php echo RUTA_PROYECTO; ?>js/jquery.min.js"></script>
    <script src="<?php echo RUTA_PROYECTO; ?>js/select2.min.js"></script>
    <script src="<?php echo RUTA_PROYECTO; ?>dist/bundle.js"></script>
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
        $(function () {
            //Initialize Select2 Elements
            $('.select2').select2();
        });
    </script>
    </body>
</html>