<?php
class Errores{

    public $mensaje = 'Error desconocido';
    public $class;
    public $line;
    public $file;
    public $data;
    public $error;
    public $function;
    public $data_error;
    public $array_error;
    public $header;
    public $n_error_mysql;
    public $error_mysql;


    public function datos($error,$mensaje , $class, $line,$file,$data, $function,  $n_error_mysql = 0,
                          $error_mysql = '',$referencias = array()): array{
        $this->error = $error;
        $this->mensaje = "<font size='2'><div><b style='color: brown'>$mensaje</b></div>";
        $this->class = "<div><b>$class</b></div>";
        $this->function = "<div><b>$function</b></div>";
        $this->file = "<div><b>$file</b></div>";
        $this->line = "<div><b>$line</b></div><br></font>";
        $this->data = $data;


        $this->data_error = array('<font size="2">','mensaje'=>'Exito','class'=>$this->class,'function'=>$this->function,
            'file'=>$this->file,'line'=>$this->line,'</font><hr><font size="1">',
            'data'=>$this->data,'</font>','n_error_mysql'=>$this->n_error_mysql,'error_mysql'=>$this->error_mysql);
        if($error === 1){
            $this->data_error['error'] = 1;
            $this->data_error['mensaje'] = $this->mensaje;
            $this->data_error['n_error_mysql'] = $this->n_error_mysql;
            $this->data_error['error_mysql'] = $this->error_mysql;
            $this->data_error['referencias'] = $referencias;
        }
        return $this->data_error;
    }

    public function limpia_html_error(array $error){
        $array_error_limpio = array();
        foreach ($error as $label => $dato){
            if (is_array($dato)){
                $array_error_limpio[$label] = $this->limpia_html_error($dato);
            }else{
                $array_error_limpio[$label] = strip_tags($dato);
            }
        }
        return $array_error_limpio;
    }

}