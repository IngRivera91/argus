<?php

namespace Clase;

use Exception;

class Error extends Exception
{

    private $consulta;
    private $errorInformacion;
    public function __construct($mensaje = '', Exception $errorAnterior = null, $codigo = 0,string $consulta = '') 
    {
        $this->consulta = $consulta;
        parent::__construct($mensaje, $codigo ,$errorAnterior);
        if (!is_null($errorAnterior))
        {
            $this->previous = $previous;
        }
    }

    public function muestraError()
    {
        if (ES_PRODUCCION)
        {
            header('Location: '.RUTA_PROYECTO.'error.php');
        }
        $this->configuraErrorHtml();
        print_r($this->errorInformacion);
        exit;
    }

    private function configuraErrorHtml():void
    {
        $errorAnterrior = '';
        if (!is_null($this->getPrevious())) 
        {
            $errorAnterrior = $this->getPrevious();
        }
        $this->errorInformacion = 
        [
            'mensaje'=> '<font size="3"><div><b style="color: brown">'.$this->message.'</b></div>',
            'origen'=> '<div><b>'.$this->getTraceAsString().'</b></div>',
            'file'=> '<div><b>'.$this->file.'</b></div>',
            'line'=> '<div><b>'.$this->line.'</b></div><hr>',
            'data'=>$errorAnterrior.'</font>'
        ];
    }

    private function configuraErrorJson():void
    {
        $errorAnterrior = '';
        if (!is_null($this->getPrevious())) 
        {
            $errorAnterrior = $this->getPrevious();
        }
        $this->errorInformacion = 
        [
            'mensaje'=> $this->message,
            'origen'=> $this->getTraceAsString(),
            'file'=> $this->file,
            'line'=> $this->line,
            'data'=>$errorAnterrior
        ];
    }
}