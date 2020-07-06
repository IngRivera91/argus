<?php
	date_default_timezone_set('America/Mexico_City');

	session_start();
	
	define('ES_PRODUCCION',false);

	if(!ES_PRODUCCION)
	{
		error_reporting(E_ALL);
		ini_set('display_errors', 1);
	}

	define('RUTA_PROYECTO','http://localhost/nombreProyecto/public/');
	define('NOMBRE_PROYECTO','');

	define('DB_HOST', 'localhost');
	define('DB_USER', '');
	define('DB_PASSWORD', '');
	define('DB_NAME', '');

    define('DB_USER_SESSION', DB_USER);
	define('DB_PASSWORD_SESSION', DB_PASSWORD);