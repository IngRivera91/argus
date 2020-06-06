<?php

	define('EN_PRODUCCION' , false);

	if (EN_PRODUCCION){
		error_reporting(E_ALL);
		ini_set('display_errors', 1);
	}
	
	date_default_timezone_set('America/Mexico_City');

    // config BD
	define('DB_HOST', 'localhost');
	define('DB_USER', '');
	define('DB_PASSWORD', '');
	define('DB_NAME', '');

    // usuario y contra para el inicio de session
    define('DB_USER_SESSION', DB_USER);
	define('DB_PASSWORD_SESSION', DB_PASSWORD);
	
	// config RUTA
	define('RUTA_PROYECTO','http://localhost/');
	define('NOMBRE_PROYECTO','');
	define('RUTA_BASE',RUTA_PROYECTO.'index.php');

    // COLORES
    define('COLORBASE','style="color:#17a2b8"');
	define('COLORBASE_BOOTSTRAP','info');