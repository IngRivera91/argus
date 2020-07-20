<?php

namespace Ayuda;

use Ayuda\Redireccion;

class Html
{

    public static function input(
        string $label,
        string $name,
        int $col,
        string $placeholder = '',             
        string $value = '',
        string $type = 'text',
        string $required = 'required',
        bool $ln = false,
        string $atributos = ''
    ) :string {
        $input_html = '';
        $input_html .= "<div class=col-md-$col>";
        $input_html .= "<div class='form-group'>";
        $input_html .= "<label>$label</label>";
        $input_html .= "<input $required $atributos value='$value' name='$name' type='$type' placeholder='$placeholder' class='form-control'>";
        $input_html .= "</div>";
        $input_html .= "</div>";
        if ($ln) {
            $input_html .= "<div class='col-md-12'></div>";
        }
        return $input_html;
    }

    public static function select(string $label, string $name, int $col, array $registros = array(),
                           string $elementos = '', string $value = '-1', string $required = 'required',
                           string $chart = ' ', bool $ln = false){
        $array_elementos = explode(',',$elementos);
        $select_html = '';
        $select_html .= "<div class=col-md-$col>";
        $select_html .= "<div class='form-group'>";
        $select_html .= "<label>$label</label>";
        $select_html .= "<select $required name='$name' class='form-control'>";

        foreach ($registros as $registro){
            $text = '';
            foreach ($array_elementos as $elemento){
                $text .= $registro[$elemento].$chart;
            }
            $text = trim($text,$chart);
            if ($value == $registro['id']){
                $select_html .= "<option selected='true' value='".$registro['id']."'>$text</option>";
            }else{
                $select_html .= "<option value='".$registro['id']."'>$text</option>";
            }

        }

        $select_html .= "</select>";
        $select_html .= "</div>";
        $select_html .= "</div>";
        if ($ln) {
            $select_html .= "<div class='col-md-12'></div>";
        }
        return $select_html;

    }

    public static function select_buscador(string $label, string $name, int $col, array $registros = array(),
                                    string $elementos = '', string $value = '-1', string $required = 'required',
                                    string $chart = ' ', bool $ln = false, int $select2id = 1){
        $array_elementos = explode(',',$elementos);
        $select_html = '';
        $select_html .= "<div class=col-md-$col>";
        $select_html .= "<div class='form-group'>";
        $select_html .= "<label>$label</label>";
        $select_html .= "<select $required name='$name' class='form-control select2'  data-placeholder='$label'  data-select2-id='$select2id' tabindex='-1' >";

        foreach ($registros as $registro){
            $text = '';
            foreach ($array_elementos as $elemento){
                $text .= $registro[$elemento].$chart;
            }
            $text = trim($text,$chart);
            if ($value == $registro['id']){
                $select_html .= "<option selected='true' value='".$registro['id']."'>$text</option>";
            }else{
                $select_html .= "<option value='".$registro['id']."'>$text</option>";
            }

        }

        $select_html .= "</select>";
        $select_html .= "</div>";
        $select_html .= "</div>";
        if ($ln) {
            $select_html .= "<div class='col-md-12'></div>";
        }
        return $select_html;

    }

    public static function select_multiple(string $label, string $name, int $col, array $registros = array(),
                                    string $elementos = '', array $value = array(), string $required = 'required',
                                    string $chart = ' ', bool $ln = false, int $select2id = 1){
        $array_elementos = explode(',',$elementos);
        $select_html = '';
        $select_html .= "<div class=col-md-$col>";
        $select_html .= "<div class='form-group'>";
        $select_html .= "<label>$label</label>";
        $select_html .= "<select $required name='$name' class='form-control select2 select2-hidden-accessible' multiple='' data-placeholder='$label' style='width: 100%;' data-select2-id='$select2id' tabindex='-1' aria-hidden='true'>";

        foreach ($registros as $registro){
            $text = '';
            foreach ($array_elementos as $elemento){
                $text .= $registro[$elemento].$chart;
            }
            $text = trim($text,$chart);
            if (in_array($registro['id'],$value)){
                $select_html .= "<option selected='true' value='".$registro['id']."'>$text</option>";
            }else{
                $select_html .= "<option value='".$registro['id']."'>$text</option>";
            }

        }

        $select_html .= "</select>";
        $select_html .= "</div>";
        $select_html .= "</div>";
        if ($ln) {
            $select_html .= "<div class='col-md-12'></div>";
        }
        return $select_html;

    }

    public static function select_status(string $label, string $name, int $col, string $value = '-1',
                                  string $required = 'required',string $chart = ' ', bool $ln = false){
        $registros = array(
            array('id' => 'activo','value'=>'activo'),
            array('id' => 'inactivo','value'=>'inactivo')
        );
        return $this->select($label,$name,$col,$registros,'value',$value,$required,$chart,$ln);

    }

    public static function submit(string $label, string $name, int $col, bool $ln = true)
    {

        if ($ln) {
            $submit_html = "<div class='col-md-12'></div>";
        }
        $submit_html .= "<div class=col-md-$col>";
        $submit_html .= "<div class='form-group'>";
        $submit_html .= "<button type='submit' name='$name' class='btn btn-block btn-" . COLORBASE_BOOTSTRAP . " btn-flat'>$label</button>";
        $submit_html .= "</div>";
        $submit_html .= "</div>";

        return $submit_html;
    }// end submit

    public static function paginador(int $numero_paginas, int $pagina, string $tabla){
        $url_base = Redireccion::obtener($tabla,'lista',SESSION_ID).'&pag=';
        $paginador_html = '';
        $paginador_html .= "<br><nav aria-label='navigation'>";
        $paginador_html .= "    <ul class='pagination'>";

        $paginador_html .= "        <li class='page-item'>";
        if ($pagina > 1){
            $paginador_html .= "            <a class='page-link' href='".$url_base.($pagina-1)."' aria-label='Anterior'>";
        }else{
            $paginador_html .= "            <a class='page-link' aria-label='Anterior'>";
        }
        $paginador_html .= "                <span aria-hidden='true'>&laquo;</span>";
        $paginador_html .= "            </a>";
        $paginador_html .= "        </li>";

        for ($i = 1 ; $i <= $numero_paginas ; $i++){

            if ($i == $pagina){
                $paginador_html .= "        <li class='page-item active'><a class='page-link' href='".$url_base.$i."'>$i</a></li>";
            }else{
                $paginador_html .= "        <li class='page-item'><a class='page-link' href='".$url_base.$i."'>$i</a></li>";
            }

        }
        $paginador_html .= "        <li class='page-item'>";
        if ($pagina < $numero_paginas){
            $paginador_html .= "            <a class='page-link' href='".$url_base.($pagina+1)."' aria-label='Siguiente'>";
        }else{
            $paginador_html .= "            <a class='page-link' aria-label='Siguiente'>";
        }
        $paginador_html .= "                <span aria-hidden='true'>&raquo;</span>";
        $paginador_html .= "            </a>";
        $paginador_html .= "        </li>";
        $paginador_html .= "    </ul>";
        $paginador_html .= "</nav>";

        return $paginador_html;
    }

    public static function link_boton(string $url_destino, string $label, int $col, bool $ln = false){
        $link_boton_html = '';
        if ($ln) {
            $link_boton_html .= "<div class='col-md-12'></div>";
        }
        $link_boton_html .= "<div class=col-md-$col>";
        $link_boton_html .= "<div class='form-group'>";
        $link_boton_html .= "<a class='btn btn-block btn-" . COLORBASE_BOOTSTRAP . " btn-flat' href='$url_destino'>$label</a>";
        $link_boton_html .= "</div>";
        $link_boton_html .= "</div>";

        return $link_boton_html;
    }

    public static function hr(){
        return '<hr style="border: 0;border-top: 1px solid #999;height:0;">';
    }
}