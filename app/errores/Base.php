<?php

namespace Error;
use Exception;

class Base extends Exception
{

    private $errorInformacion;

    public function __construct($mensaje = '', Exception $errorAnterior = null) 
    {
        parent::__construct($mensaje, 0 ,$errorAnterior);
    }

    public function muestraError($esRecursivo = false)
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
            'anterior'=>$errorAnterrior
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
            'anterior'=>$errorAnterrior
        ];
    }

    private function obtenErrorAnterior()
    {
        $errorAnterior = '<br>';
        if (!is_null($this->getPrevious())) 
        {
            $errorAnterior = $this->getPrevious()->muestraError(true);
        }
        return $errorAnterior;
    }
}