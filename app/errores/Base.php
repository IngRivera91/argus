<?php
// https://www.php.net/manual/es/language.exceptions.php
// https://www.php.net/manual/es/language.exceptions.extending.php

namespace Error;
use Exception;

class Base extends Exception
{

    private $errorInformacion;
    private $consultaSQL;

    public function __construct(string $mensaje = '' , Base $errorAnterior = null , $code = 0 , $consultaSQL = null ) 
    {
        $this->consultaSQL = $consultaSQL;
        parent::__construct($mensaje, $code ,$errorAnterior);
    }

    public function muestraError(bool $esRecursivo = false)
    {
        if (ES_PRODUCCION)
        {
            header('Location: '.RUTA_PROYECTO.'error.php');
            exit;
        }
        $this->configuraErrorHtml();

        if ($esRecursivo)
        {
            return $this->errorInformacion;
        }
        echo '<font size="3">';
        print_r($this->errorInformacion);
        echo '</font>';
    }

    private function configuraErrorHtml():void
    {
        $errorAnterrior = $this->obtenErrorAnterior();
        $this->errorInformacion = 
        [
            'mensaje'=> '<div><b style="color: brown">'.$this->message.'</b></div>',
            'file'=> '<div><b>'.$this->file.'</b></div>',
            'line'=> '<div><b>'.$this->line.'</b></div><hr>',
            'datos'=>$errorAnterrior
        ];
    }

    private function configuraErrorJson():void
    {
        $errorAnterrior = $this->obtenErrorAnterior();
        $this->errorInformacion = 
        [
            'mensaje'=> $this->message,
            'file'=> $this->file,
            'line'=> $this->line,
            'datos'=>$errorAnterrior
        ];
    }

    private function obtenErrorAnterior()
    {
        $errorAnterior = $this->consultaSQL;
        if (!is_null($this->getPrevious())) 
        {
            $errorAnterior = $this->getPrevious()->muestraError(true);
        }
        return $errorAnterior;
    }
}