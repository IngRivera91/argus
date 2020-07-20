<?php
	date_default_timezone_set('America/Mexico_City');

	session_start();
	
	define('ES_PRODUCCION',false);

	if(!ES_PRODUCCION)
	{
		error_reporting(E_ALL);
		ini_set('display_errors', 1);
	}

	// la ruta del proyecto siempre debe terminar con /
	define('RUTA_PROYECTO','http://localhost/nombreProyecto/public/');
	define('NOMBRE_PROYECTO','');

	define('TEXTO_REGISTRO_ACTIVO','si');
	define('TEXTO_REGISTRO_INACTIVO','no');
	define('STYLE_REGISTRO_INACTIVO',"style='color:red;'");
	
	// datos para conectarse a la base de datos
	define('DB_TIPO', 'MySQL');
	define('DB_HOST', 'localhost');
	define('DB_USER', '');
	define('DB_PASSWORD', '');
	define('DB_NAME', '');

	// datos para crear un usuario en el sistema con privilegios de administrador
	define('PROGRAMADOR_USER','');
	define('PROGRAMADOR_PASSWORD','');
	define('PROGRAMADOR_NOMBRE','');
	define('PROGRAMADOR_EMAIL','');
	define('PROGRAMADOR_SEXO',''); // m = masculino : f = femenino

	// COLORES
    define('COLORBASE','style="color:#17a2b8"');
	define('COLORBASE_BOOTSTRAP','info');