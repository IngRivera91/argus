<?php
require_once __DIR__.'/../app/config/requires.php';
require_once __DIR__.'/../recursos/BD/BaseDatos.php';

use Clase\MySQL\Database;

$coneccion = new Database();

BaseDatos::crear($coneccion);

BaseDatos::insertarRegistrosBase($coneccion,$_ENV['USER'],$_ENV['PASSWORD'],$_ENV['NOMBRE'],$_ENV['MAIL'],'m');