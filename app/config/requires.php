<?php
$pathBase = __DIR__.'/../../';

require_once $pathBase . '/vendor/autoload.php';
$dotenv = Dotenv\Dotenv::createImmutable($pathBase);
$dotenv->load();

define('DEBUG_MODE', $_ENV['APP_DEBUG'] );
if (DEBUG_MODE) {
    error_reporting(E_ALL);
    ini_set('display_errors', 1);
}

session_start();
date_default_timezone_set($_ENV['APP_TIMEZONE']);

require_once 'constants.php';
require_once 'configApp.php';
require_once 'configDatabase.php';
require_once 'loadEloquent.php';
