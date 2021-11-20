<?php

namespace App\Class;

class Redireccion
{
    public static function enviar_login(string $mensaje)
    {
        header('Location: '.APP_URL."login.php?mensaje=$mensaje");
    }

    public static function enviar(string $controlador='',string $metodo='',string $session_id='',string $mensaje='',string $registroId = '',string $pagina = 'index')
    {
        $parametros = "?";

        if ($controlador !== ''){
            $parametros .= "controlador=$controlador&";
        }

        if ($metodo !== ''){
            $parametros .= "metodo=$metodo&";
        }
        
        if ($session_id !== ''){
            $parametros .= "session_id=$session_id&";
        }

        if ($mensaje !== ''){
            $parametros .= "mensaje=$mensaje&";
        }

        if ($registroId !== ''){
            $parametros .= "registroId=$registroId&";
        }

        if ($parametros === '?'){
            $parametros = trim($parametros,'?');
        }

        $parametros = trim($parametros,'&');

        header('Location: '.APP_URL.$pagina.'.php'.$parametros);
    }

    public static function obtener(string $controlador='',string $metodo='',string $session_id='',string $mensaje='',string $registroId = '',string $pagina = 'index')
    {

        $parametros = "?";
        if ($controlador !== ''){
            $parametros .= "controlador=$controlador&";
        }

        if ($metodo !== ''){
            $parametros .= "metodo=$metodo&";
        }

        if ($session_id !== ''){
            $parametros .= "session_id=$session_id&";
        }

        if ($mensaje !== ''){
            $parametros .= "mensaje=$mensaje&";
        }

        if ($registroId !== ''){
            $parametros .= "registroId=$registroId&";
        }

        if ($parametros === '?'){
            $parametros = trim($parametros,'?');
        }

        $parametros = trim($parametros,'&');

        return APP_URL.$pagina.'.php'.$parametros;
    }

}