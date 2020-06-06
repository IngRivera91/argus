<?php

    namespace Ayuda;

    class Redirect{

        public static function header_url(string $controlador='',string $metodo='', string $session_id='',string $mensaje='',
                            string $registro_id = ''){
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
            if ($registro_id !== ''){
                $parametros .= "registro_id=$registro_id&";
            }
            if ($parametros === '?'){
                $parametros = trim($parametros,'?');
            }
            $parametros = trim($parametros,'&');
            header('Location: '.RUTA_BASE.$parametros);
    
        }
    
        public static function get_url(string $controlador='',string $metodo='', string $session_id='',string $mensaje='',
                                 string $registro_id = ''){
    
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
            if ($registro_id !== ''){
                $parametros .= "registro_id=$registro_id&";
            }
            if ($parametros === '?'){
                $parametros = trim($parametros,'?');
            }
            $parametros = trim($parametros,'&');
    
            return RUTA_BASE.$parametros;
        }

    }