<?php
require_once __DIR__.'/../config.php';
require_once __DIR__.'/../recursos/BD/BaseDatos.php';
require_once __DIR__.'/../vendor/autoload.php';

use Clase\MySQL\Database;

$coneccion = new Database();

BaseDatos::crear($coneccion);

BaseDatos::insertarRegistrosBase($coneccion,PROGRAMADOR_USER,PROGRAMADOR_PASSWORD,PROGRAMADOR_NOMBRE,PROGRAMADOR_EMAIL,PROGRAMADOR_SEXO);