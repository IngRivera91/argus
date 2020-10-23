<?php

    require_once __DIR__.'/../recursos/BD/BaseDatos.php';
    use Clase\MySQL\Database;
    $coneccion = new Database();
    BaseDatos::crear($coneccion);
    sleep(1);

