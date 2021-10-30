<?php

use Illuminate\Database\Capsule\Manager as DB;
use Illuminate\Events\Dispatcher;
use Illuminate\Container\Container;

try {

    $db = new DB;
    $db->addConnection([
        'driver' => DB_TIPO,
        'host' => DB_HOST,
        'database' => DB_NAME,
        'username' => DB_USER,
        'password' => DB_PASSWORD,
        'charset' => 'utf8',
        'collation' => 'utf8_unicode_ci',
        'prefix' => '',
    ]);

    $db->setEventDispatcher(new Dispatcher(new Container));
    $db->setAsGlobal();
    $db->bootEloquent();

}catch (\Exception $e) {
    print_r('Error al conectarce a la base de datos, favor de contactar al equipo de desarrollo');
    exit;
}