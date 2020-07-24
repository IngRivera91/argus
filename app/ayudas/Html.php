<?php

namespace Ayuda;

use Ayuda\Redireccion;

class Html
{

    public static function input(
        string $label,
        string $name,
        int    $col,
        string $value       = '',
        string $placeholder = '',  
        string $type        = 'text',
        string $required    = 'required',
        bool   $saltarLinea = false,
        string $atributos   = ''
    ) :string {
        if ($placeholder == '') {
            $placeholder = $label;
        }
        $inputHtml = '';
        $inputHtml .= "<div class=col-md-$col>";
        $inputHtml .=   "<div class='form-group'>";

        $inputHtml .=       "<p style='margin-bottom:-.2em'><b>$label</b></p>";

        $inputHtml .=       "<input $required $atributos value='$value' name='$name' type='$type'";
        $inputHtml .=       "placeholder='$placeholder' class='form-control  form-control-sm'>";

        $inputHtml .=   "</div>";
        $inputHtml .= "</div>";
        
        if ($saltarLinea) {
            $inputHtml .= "<div class='col-md-12'></div>";
        }
        return $inputHtml;
    }

    private static function generaSelectOptions(string $nombreTabla, array $registros, string $elementos, string $value, string $chart):string
    {
        $elementosArray = explode(',',$elementos);

        $optionsGenerados = "<option hidden ></option>";

        foreach ($registros as $registro) {

            $valorRegistroId = $registro["{$nombreTabla}_id"];

            $textValueOption = '';

            foreach ($elementosArray as $elemento){
                $textValueOption .= $registro[$elemento].$chart;
            }
            $textValueOption = trim($textValueOption,$chart);

            $selected = '';
            if ($value == $valorRegistroId){
                $selected = "selected='true'";
            }
                
            $optionsGenerados .= "<option $selected value='$valorRegistroId'>$textValueOption</option>";
        }
        return $optionsGenerados;
    }

    private static function generaFinalSelects(bool $saltarLinea):string
    {
        $finalSelectGenerado = '';
        $finalSelectGenerado .= "</select>";
        $finalSelectGenerado .= "</div>";
        $finalSelectGenerado .= "</div>";
        if ($saltarLinea) {
            $finalSelectGenerado .= "<div class='col-md-12'></div>";
        }
        return $finalSelectGenerado;
    }

    public static function select(
        string $nombreTabla,
        string $label,
        string $name,
        int    $col,
        array  $registros   = array(),
        string $elementos   = '',
        string $value       = '-1',
        string $required    = 'required',
        string $chart       = ' ',
        bool   $saltarLinea = false
    ) :string {
        $selectHtml = '';
        $selectHtml .= "<div class=col-md-$col>";
        $selectHtml .= "<div class='form-group'>";
        $selectHtml .= "<label>$label</label>";
        $selectHtml .= "<select data-placeholder='$label' $required name='$name' class='form-control form-control-sm' >";
        $selectHtml .= self::generaSelectOptions($nombreTabla, $registros, $elementos, $value, $chart);
        $selectHtml .= self::generaFinalSelects($saltarLinea);
        return $selectHtml;
    }

    public static function selectConBuscador(
        string $nombreTabla, 
        string $label, 
        string $name, 
        int    $col, 
        array  $registros   = array(),
        string $elementos   = '', 
        string $value       = '-1', 
        int    $select2Id   = 1, 
        string $required    = 'required',
        string $chart       = ' ', 
        bool   $saltarLinea = false
    ) :string {
        $selectHtml = '';
        $selectHtml .= "<div class=col-md-$col>";
        $selectHtml .= "<div class='form-group'>";
        $selectHtml .= "<label>$label</label>";

        $selectHtml .= "<select $required name='$name' class='form-control form-control-sm select2'";
        $selectHtml .= " data-placeholder='$label'  data-select2-id='$select2Id' tabindex='-1' >";

        $selectHtml .= self::generaSelectOptions($nombreTabla, $registros, $elementos, $value, $chart);
        $selectHtml .= self::generaFinalSelects($saltarLinea);
        return $selectHtml;
    }

    public static function selectMultiple(
        string $nombreTabla,
        string $label,
        string $name,
        int    $col,
        array  $registros   = array(),
        string $elementos   = '',
        array  $value       = array(),
        int    $select2Id   = 1,
        string $required    = 'required',
        string $chart       = ' ',
        bool   $saltarLinea = false
    ) :string {
        $selectHtml = '';
        $selectHtml .= "<div class=col-md-$col>";
        $selectHtml .= "<div class='form-group'>";
        $selectHtml .= "<label>$label</label>";
        $selectHtml .= "<select $required name='$name' class='form-control select2 select2-hidden-accessible' multiple='' data-placeholder='$label' style='width: 100%;' data-select2-id='$select2Id' tabindex='-1' aria-hidden='true'>";

        $selectHtml .= self::generaSelectOptions($nombreTabla, $registros, $elementos, $value, $chart);
        $selectHtml .= self::generaFinalSelects($saltarLinea);
        return $selectHtml;
    }

    public static function select_status(string $label, string $name, int $col, string $value = '-1',
                                  string $required = 'required',string $chart = ' ', bool $saltarLinea = false){
        $registros = array(
            array('id' => 'activo','value'=>'activo'),
            array('id' => 'inactivo','value'=>'inactivo')
        );
        return self::select($label,$name,$col,$registros,'value',$value,$required,$chart,$saltarLinea);

    }

    public static function submit(string $label, string $name, int $col, bool $saltarLinea = true):string
    {
        $submitHtml = '';
        if ($saltarLinea) {
            $submitHtml = "<div class='col-md-12'></div>";
        }
        $submitHtml .= "<div class=col-md-$col>";
        $submitHtml .= "<div class='form-group'>";
        $submitHtml .= "<button type='submit' name='$name' class='btn btn-block btn-" . COLORBASE_BOOTSTRAP . " btn-flat btn-sm'>$label</button>";
        $submitHtml .= "</div>";
        $submitHtml .= "</div>";

        return $submitHtml;
    }

    public static function paginador(int $numeroDePaginas, int $pagina, string $tabla):string
    {
        $urlBase = Redireccion::obtener($tabla,'lista',SESSION_ID).'&pag=';

        $liClass = 'page-item';
        $aClas = 'page-link';
        
        $paginadorHtml = '';
        $paginadorHtml .= "<br><nav aria-label='navigation'>"; // inicia <nav>
        $paginadorHtml .= "<ul class='pagination'>"; // inicia <ul>

        // inicia el <li> de el boton pagina anterior
        $paginadorHtml .= "<li class='$liClass' >";
        $paginaAnterior = (int)$pagina-1;
        $href = '';
        if ($pagina > 1) { $href = "href='{$urlBase}{$paginaAnterior}'"; }
        $paginadorHtml .= "<a class='$aClas'  $href aria-label='Anterior'>";
        $paginadorHtml .= "<span aria-hidden='true'>&laquo;</span>";
        $paginadorHtml .= "</a>";
        $paginadorHtml .= "</li>";
        // termina el <li> de el boton pagina anterior

        for ($i = 1 ; $i <= $numeroDePaginas ; $i++) {
            $active = '';
            if ($i == $pagina){ $active = 'active'; }
            $paginadorHtml .= "<li class='$active $liClass' ><a class='$aClas'  href='".$urlBase.$i."'>$i</a></li>";
        }

        // inicia el <li> de el boton pagina siguiente
        $paginadorHtml .= "<li class='$liClass' >";
        $paginaSiguiente = (int)$pagina+1;
        $href = '';
        if ($pagina < $numeroDePaginas) { $href = "href='{$urlBase}{$paginaSiguiente}'"; }
        $paginadorHtml .= "<a class='$aClas'  $href aria-label='Anterior'>";
        $paginadorHtml .= "<span aria-hidden='true'>&raquo;</span>";
        $paginadorHtml .= "</a>";
        $paginadorHtml .= "</li>";
        // termina el <li> de el boton pagina siguiente

        $paginadorHtml .= "</ul>"; // termina <ul>
        $paginadorHtml .= "</nav>"; // termina <nav>
        return $paginadorHtml;
    }

    public static function linkBoton(string $urlDestino, string $label, int $col, bool $saltarLinea = false):string
    {
        $linkBotonHtml = '';
        if ($saltarLinea) {
            $linkBotonHtml .= "<div class='col-md-12'></div>";
        }
        $linkBotonHtml .= "<div class=col-md-$col>";
        $linkBotonHtml .= "<div class='form-group'>";
        $linkBotonHtml .= "<a class='btn  btn-block btn-" . COLORBASE_BOOTSTRAP . " btn-flat btn-sm' href='$urlDestino'>$label</a>";
        $linkBotonHtml .= "</div>";
        $linkBotonHtml .= "</div>";

        return $linkBotonHtml;
    }

    public static function hr(){
        return '<hr style="border: 0;border-top: 1px solid #999;height:0;">';
    }
}