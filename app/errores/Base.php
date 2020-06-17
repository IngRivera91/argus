<?php

namespace Error;
use Exception;

class Base extends Exception
{

    private $errorInformacion;

    public function __construct($mensaje = '', Exception $errorAnterior = null) 
    {
        parent::__construct($mensaje, $codigo ,$errorAnterior);
    }

    public function muestraError($esRecursivo = false)
    {
        if (ES_PRODUCCION)
        {
            header('Location: '.RUTA_PROYECTO.'error.php');
            exit;
        }
        if ($esRecursivo)
        {
            return $this->errorInformacion;
        }
        $this->configuraErrorHtml();
        print_r($this->errorInformacion);
    }

    private function configuraErrorHtml():void
    {
        $errorAnterrior = $this->obtenErrorAnterior();
        $this->errorInformacion = 
        [
            'mensaje'=> '<font size="3"><div><b style="color: brown">'.$this->message.'</b></div>',
            'file'=> '<div><b>'.$this->file.'</b></div>',
            'line'=> '<div><b>'.$this->line.'</b></div><hr>',
            'data'=>$errorAnterrior.'</font>'
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
            'data'=>$errorAnterrior
        ];
    }

    private function obtenErrorAnterior()
    {
        $errorAnterior = '';
        if (!is_null($this->getPrevious())) 
        {
            $errorAnterior = $this->getPrevious()->muestraError(true);
        }
        return $errorAnterior;
    }
}