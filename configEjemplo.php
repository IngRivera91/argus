<?php
	date_default_timezone_set('America/Mexico_City');

	session_start();
	
	define('ES_PRODUCCION',false);

	if(!ES_PRODUCCION)
	{
		error_reporting(E_ALL);
		ini_set('display_errors', 1);
	}

	define('RUTA_PROYECTO','http://localhost/argus/public/');
	define('NOMBRE_PROYECTO','ARGUS');

	// texto de los campos activo
	define('TEXTO_REGISTRO_ACTIVO','si');
	define('TEXTO_REGISTRO_INACTIVO','no');

	// datos para conectarse a la base de datos
	define('DB_TIPO', 'MySQL');
	define('DB_HOST', 'localhost');
	define('DB_USER', 'root');
	define('DB_PASSWORD', '');
	define('DB_NAME', 'argus');

	// datos usuario super usuario
	define('PROGRAMADOR_USER','admin');
	define('PROGRAMADOR_PASSWORD','admin');
	define('PROGRAMADOR_NOMBRE','Ricardo');
	define('PROGRAMADOR_EMAIL','mail@mail.com');
	define('PROGRAMADOR_SEXO','m');

	// codigos de error SQL
	define('REGISTRO_RELACIONADO', '23000');
