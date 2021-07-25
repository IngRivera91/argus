<?php $teme = "bootstrap4"; ?>
    
    <script src="<?php echo RUTA_PROYECTO; ?>dist/bundle.js"></script>
    <!-- Main JS -->
    <script src="<?php echo RUTA_PROYECTO; ?>js/main.js"></script>
    <script>
        $(function () {

            //Initialize Select2 Elements
            $('.select2').select2();

            //Initialize Select2 Elements
            $('.select2bs4').select2({
            theme: '<?= $teme ?>'
            });
        });
    </script>
    <?php 
        $rutaArchivoJs = '';
        if (isset($controladorActual) && isset($metodoActual)) {
            $rutaArchivoJs = "js/{$controladorActual}.{$metodoActual}.js";
        }
        if(file_exists($rutaArchivoJs)) {
            echo "<script src='$rutaArchivoJs'></script>";
        }
    ?>
    </body>
</html>