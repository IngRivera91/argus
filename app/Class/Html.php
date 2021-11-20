<?php

namespace App\Class;

use App\models\Group;
use App\models\Menu;
use JetBrains\PhpStorm\Pure;


class Html
{
    public static function Debug($variable) : void
    {
        echo '<pre>';
        print_r($variable);
        echo '</pre>';
    }

    public static function inputHidden(
        string $name,
        string $value
    ) :string {

        return "<input  name='$name'  value='$value' type='hidden'>";
    }

    #[Pure] public static function inputText(
        int    $col,
        string $label,
        string $id,
        string $name,
        string $placeholder = '',
        string|null $value       = '',
        bool   $saltarLinea = false
    ) :string {
        $placeholder = self::obtenerPlaceholder($label,$placeholder);
        $inputTextHtml = self::generaPrincipioInput($col, $label);
        $inputTextHtml .= "<input title='$label' id='$id' name='$name' placeholder='$placeholder' value='$value' Class='form-control  form-control-sm' type='text'>";
        $inputTextHtml .= self::generaFinalInput($saltarLinea);
        
        return $inputTextHtml;
    }

    #[Pure] public static function inputTextRequired(
        int    $col,
        string $label,
        string $id,
        string $name,
        string $placeholder = '',
        string|null $value       = '',
        bool   $saltarLinea = false
    ) :string {
        $placeholder = self::obtenerPlaceholder($label,$placeholder);
        $inputTextRequiredHtml = self::generaPrincipioInput($col, $label);
        $inputTextRequiredHtml .= "<input title='$label' id='$id' name='$name' placeholder='$placeholder' value='$value' required Class='form-control  form-control-sm' type='text'>";
        $inputTextRequiredHtml .= self::generaFinalInput($saltarLinea);
        
        return $inputTextRequiredHtml;
    }

    #[Pure] public static function inputDate(
        int    $col,
        string $label,
        string $id,
        string $name,
        string $placeholder = '',
        string|null $value       = '',
        bool   $saltarLinea = false
    ) :string {
        $placeholder = self::obtenerPlaceholder($label,$placeholder);
        $inputDateHtml = self::generaPrincipioInput($col, $label);
        $inputDateHtml .= "<input title='$label' id='$id' name='$name' placeholder='$placeholder' value='$value' Class='form-control  form-control-sm' type='date'>";
        $inputDateHtml .= self::generaFinalInput($saltarLinea);
        
        return $inputDateHtml;
    }

    #[Pure] public static function inputDateRequired(
        int    $col,
        string $label,
        string $id,
        string $name,
        string $placeholder = '',
        string|null $value       = '',
        bool   $saltarLinea = false
    ) :string {
        $placeholder = self::obtenerPlaceholder($label,$placeholder);
        $inputDateHtml = self::generaPrincipioInput($col, $label);
        $inputDateHtml .= "<input title='$label' id='$id' name='$name' placeholder='$placeholder' value='$value' required Class='form-control  form-control-sm' type='date'>";
        $inputDateHtml .= self::generaFinalInput($saltarLinea);
        
        return $inputDateHtml;
    }

    #[Pure] public static function inputNumber(
        int    $col,
        string $label,
        string $id,
        string $name,
        string $placeholder = '',
        string|null $value       = '',
        bool   $saltarLinea = false
    ) :string {
        $placeholder = self::obtenerPlaceholder($label,$placeholder);
        $inputNumbertHtml = self::generaPrincipioInput($col, $label);
        $inputNumbertHtml .= "<input title='$label' id='$id' name='$name' placeholder='$placeholder' value='$value' Class='form-control  form-control-sm' type='number'>";
        $inputNumbertHtml .= self::generaFinalInput($saltarLinea);
        
        return $inputNumbertHtml;
    }

    #[Pure] public static function inputNumberRequired(
        int    $col,
        string $label,
        string $id,
        string $name,
        string $placeholder = '',
        string|null $value       = '',
        bool   $saltarLinea = false
    ) :string {
        $placeholder = self::obtenerPlaceholder($label,$placeholder);
        $inputNumberRequiredHtml = self::generaPrincipioInput($col, $label);
        $inputNumberRequiredHtml .= "<input title='$label' id='$id' name='$name' placeholder='$placeholder' value='$value' required Class='form-control  form-control-sm' type='number'>";
        $inputNumberRequiredHtml .= self::generaFinalInput($saltarLinea);
        
        return $inputNumberRequiredHtml;
    }

    #[Pure] public static function inputFloat(
        int    $col,
        string $label,
        string $id,
        string $name,
        string $placeholder = '',
        string|null $value       = '',
        bool   $saltarLinea = false
    ) :string {
        $placeholder = self::obtenerPlaceholder($label,$placeholder);
        $inputNumbertHtml = self::generaPrincipioInput($col, $label);
        $inputNumbertHtml .= "<input title='$label' id='$id' name='$name' placeholder='$placeholder' value='$value' Class='form-control  form-control-sm' type='number' step='any'>";
        $inputNumbertHtml .= self::generaFinalInput($saltarLinea);
        
        return $inputNumbertHtml;
    }

    #[Pure] public static function inputFloatRequired(
        int    $col,
        string $label,
        string $id,
        string $name,
        string $placeholder = '',
        string|null $value       = '',
        bool   $saltarLinea = false
    ) :string {
        $placeholder = self::obtenerPlaceholder($label,$placeholder);
        $inputNumbertHtml = self::generaPrincipioInput($col, $label);
        $inputNumbertHtml .= "<input title='$label' id='$id' name='$name' placeholder='$placeholder' value='$value' required Class='form-control  form-control-sm' type='number' step='any'>";
        $inputNumbertHtml .= self::generaFinalInput($saltarLinea);
        
        return $inputNumbertHtml;
    }

    #[Pure] public static function inputPassword(
        int    $col,
        string $label,
        string $id,
        string $name,
        string $placeholder = '',
        string|null $value       = '',
        bool   $saltarLinea = false
    ) :string {
        $placeholder = self::obtenerPlaceholder($label,$placeholder);
        $inputPasswordHtml = self::generaPrincipioInput($col, $label);
        $inputPasswordHtml .= "<input title='$label' id='$id' name='$name' placeholder='$placeholder' value='$value' required Class='form-control  form-control-sm' type='password'>";
        $inputPasswordHtml .= self::generaFinalInput($saltarLinea);
        
        return $inputPasswordHtml;
    }

    private static function generaPrincipioInput(int $col, string $label):string
    {
        $principioInputHtml = "<div Class=col-md-$col>";
        $principioInputHtml .= "<div Class='input-group input-group-sm mb-3'>";
        $principioInputHtml .= "<div Class='input-group-prepend'>";
        $principioInputHtml .= "<label id='inputGroup-sizing-sm' Class='input-group-text'>$label</label>";
        $principioInputHtml .= "</div>";

        return $principioInputHtml;
    }

    private static function generaFinalInput(bool $saltarLinea):string
    {
        $finalInputHtml = "</div>";
        $finalInputHtml .= "</div>";
        
        if ($saltarLinea) {
            $finalInputHtml .= "<div Class='col-md-12'></div>";
        }
      
        return $finalInputHtml;
    }

    private static function obtenerPlaceholder(string $label, string $placeholder):string
    {
        if ($placeholder == '') {
            $placeholder = $label;
        }
        return $placeholder;
    }

    public static function selectConBuscador(
        string $id,
        string $nombreCampoId, 
        string $label, 
        string $name, 
        int    $col, 
        array  $registros   = array(),
        string $elementos   = '', 
        string|null $value       = '-1',
        int    $select2Id   = 1, 
        string $required    = 'required',
        string $chart       = ' ', 
        bool   $saltarLinea = false
    ) :string {
        $selectHtml = self::generaPrincipioSelect($col, $label);
        
        $selectHtml .= "<select id='$id' title='$label' $required name='$name' Class='form-control form-control-sm select2'";
        $selectHtml .= " data-placeholder='$label'  data-select2-id='$select2Id' tabindex='-1' >";

        $selectHtml .= self::generaSelectOptions($nombreCampoId, $registros, $elementos, $value, $chart);
        $selectHtml .= self::generaFinalSelect($saltarLinea);
        return $selectHtml;
    }

    #[Pure] public static function selectMultiple(
        string $id,
        string $nombreCampoId,
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
        $selectHtml = self::generaPrincipioSelect($col, $label);

        $selectHtml .= "<select id='$id' title='$label' $required name='$name' Class='form-control form-control-sm select2'";
        $selectHtml .= " multiple='multiple' data-placeholder='$label'  data-select2-id='$select2Id' tabindex='-1' >";

        $elementosArray = explode(',',$elementos);

        $selectHtml .= "<option hidden ></option>";

        foreach ($registros as $registro) {

            $valorRegistroId = $registro[$nombreCampoId];

            $textValueOption = '';

            foreach ($elementosArray as $elemento){
                $textValueOption .= $registro[$elemento].$chart;
            }
            $textValueOption = trim($textValueOption,$chart);

            $selected = '';
            if (in_array($valorRegistroId,$value)) {
                $selected = "selected='true'";
            }
                
            $selectHtml .= "<option $selected value='$valorRegistroId'>$textValueOption</option>";
        }

        
        $selectHtml .= self::generaFinalSelect($saltarLinea);
        return $selectHtml;
    }

    private static function generaSelectOptions(string $nombreCampoId, array $registros, string $elementos, string $value, string $chart):string
    {
        $elementosArray = explode(',',$elementos);

        $optionsGenerados = "<option hidden ></option>";

        foreach ($registros as $registro) {

            $valorRegistroId = $registro[$nombreCampoId];

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

    private static function generaPrincipioSelect(int $col, string $label):string
    {
        $principioSelectGenerado = "<div Class=col-md-$col>";
        $principioSelectGenerado .= "<div Class='input-group input-group-sm mb-3'>";
        $principioSelectGenerado .= "<div Class='input-group-prepend'>";
        $principioSelectGenerado .= "<label id='inputGroup-sizing-sm' Class='input-group-text'>$label</label>";
        $principioSelectGenerado .= "</div>";
        return $principioSelectGenerado;
    }

    private static function generaFinalSelect(bool $saltarLinea):string
    {
        $finalSelectGenerado = "</select>";
        $finalSelectGenerado .= "</div>";
        $finalSelectGenerado .= "</div>";
        if ($saltarLinea) {
            $finalSelectGenerado .= "<div Class='col-md-12'></div>";
        }
        return $finalSelectGenerado;
    }

    public static function selectActivo(
        string $label,
        string $name,
        int    $col,
        string $value       = '-1',
        int    $select2Id   = 1,
        string $required    = 'required',
        string $chart       = ' ',
        bool   $saltarLinea = false
    ) :string {

        $registros = [
            ["id" => 1, 'texto' => TEXTO_REGISTRO_ACTIVO],
            ["id" => 0, 'texto' => TEXTO_REGISTRO_INACTIVO]
        ];

        return self::selectConBuscador('id','id', $label, $name, $col, $registros, 'texto', $value, $select2Id, $required, $chart, $saltarLinea);
    }

    public static function submit(string $label, string $name, int $col, bool $saltarLinea = true):string
    {
        $submitHtml = '';
        if ($saltarLinea) {
            $submitHtml = "<div Class='col-md-12'></div>";
        }
        $submitHtml .= "<div Class=col-md-$col>";
        $submitHtml .= "<div Class='form-group'>";
        $submitHtml .= "<button type='submit' name='$name' Class='btn btn-default btn-main btn-block  btn-flat btn-sm'>$label</button>";
        $submitHtml .= "</div>";
        $submitHtml .= "</div>";

        return $submitHtml;
    }

    public static function linkBoton(string $urlDestino, string $label, int $col, bool $saltarLinea = false):string
    {
        $linkBotonHtml = '';
        if ($saltarLinea) {
            $linkBotonHtml .= "<div Class='col-md-12'></div>";
        }
        $linkBotonHtml .= "<div Class=col-md-$col>";
        $linkBotonHtml .= "<div Class='form-group'>";
        $linkBotonHtml .= "<a Class='btn btn-default btn-main btn-block  btn-flat btn-sm' href='$urlDestino'>$label</a>";
        $linkBotonHtml .= "</div>";
        $linkBotonHtml .= "</div>";

        return $linkBotonHtml;
    }

    #[Pure] public static function paginador(int $numeroDePaginas, int $pagina, string $tabla):string
    {
        $urlBase = Redireccion::obtener($tabla,'lista',SESSION_ID).'&pag=';

        $liClass = 'page-item';
        $aClas = 'page-link';

        $paginadorHtml = "<br><nav aria-label='navigation'>"; // inicia <nav>
        $paginadorHtml .= "<ul class='pagination flex-wrap'>"; // inicia <ul>

        // inicia el <li> de el boton pagina anterior
        $paginadorHtml .= "<li class='$liClass' >";
        $paginaAnterior = $pagina -1;
        $href = '';
        if ($pagina > 1) { $href = "href='$urlBase$paginaAnterior'"; }
        $paginadorHtml .= "<a class='$aClas'  $href aria-label='Anterior'>";
        $paginadorHtml .= "<span aria-hidden='true'>&laquo;</span>";
        $paginadorHtml .= "</a>";
        $paginadorHtml .= "</li>";
        // termina el <li> de el boton pagina anterior

        if ($pagina > 5) {

            // inicia el <li> de el boton pagina uno
            $paginadorHtml .= "<li class='$liClass' >";
            $href = "href='{$urlBase}1'";
            $paginadorHtml .= "<a class='$aClas'  $href aria-label='Anterior'>";
            $paginadorHtml .= "<span aria-hidden='true'>1</span>";
            $paginadorHtml .= "</a>";
            $paginadorHtml .= "</li>";
            // termina el <li> de el boton pagina uno

            // inicia el <li> de el boton ...
            $paginadorHtml .= "<li class='$liClass' >";
            $paginadorHtml .= "<a class='$aClas' aria-label='Anterior'>";
            $paginadorHtml .= "<span aria-hidden='true'> ... </span>";
            $paginadorHtml .= "</a>";
            $paginadorHtml .= "</li>";
            // termina el <li> de el boton ...

        }


        $paginaInicial = $pagina - 4;
        $paginaFinal = $pagina + 4;

        if ($paginaInicial < 1) {
            $paginaInicial = 1;
        }

        if ($paginaFinal > $numeroDePaginas) {
            $paginaFinal = $numeroDePaginas;
        }

        for ($i = $paginaInicial ; $i <= $paginaFinal ; $i++) {
            $active = '';
            if ($i == $pagina){ $active = 'active'; }
            $paginadorHtml .= "<li class='$active $liClass' ><a class='$aClas'  href='".$urlBase.$i."'>$i</a></li>";
        }

        if ($pagina < ($numeroDePaginas - 4)) {

            // inicia el <li> de el boton ...
            $paginadorHtml .= "<li class='$liClass' >";
            $paginadorHtml .= "<a class='$aClas' aria-label='Anterior'>";
            $paginadorHtml .= "<span aria-hidden='true'> ... </span>";
            $paginadorHtml .= "</a>";
            $paginadorHtml .= "</li>";
            // termina el <li> de el boton ...

            // inicia el <li> de el boton ultima pagina
            $paginadorHtml .= "<li class='$liClass' >";
            $href = '';
            if ($pagina < $numeroDePaginas) { $href = "href='$urlBase$numeroDePaginas'"; }
            $paginadorHtml .= "<a class='$aClas'  $href aria-label='Anterior'>";
            $paginadorHtml .= "<span aria-hidden='true'>$numeroDePaginas</span>";
            $paginadorHtml .= "</a>";
            $paginadorHtml .= "</li>";
            // termina el <li> de el boton ultima pagina
        }

        // inicia el <li> de el boton pagina siguiente
        $paginadorHtml .= "<li class='$liClass' >";
        $paginaSiguiente = $pagina +1;
        $href = '';
        if ($pagina < $numeroDePaginas) { $href = "href='$urlBase$paginaSiguiente'"; }
        $paginadorHtml .= "<a class='$aClas'  $href aria-label='Anterior'>";
        $paginadorHtml .= "<span aria-hidden='true'>&raquo;</span>";
        $paginadorHtml .= "</a>";
        $paginadorHtml .= "</li>";
        // termina el <li> de el boton pagina siguiente

        $paginadorHtml .= "</ul>"; // termina <ul>
        $paginadorHtml .= "</nav>"; // termina <nav>
        return $paginadorHtml;
    }

    public static function acciones(int $grupoId, string $controladorActual)
    {
        if (isset($_SESSION[SESSION_ID]["{$controladorActual}Acciones"]) && GUARDAR_ACCIONES_SESSION) {
            return $_SESSION[SESSION_ID]["{$controladorActual}Acciones"];
        }

        $acciones = [];
        $menu = Menu::where('name',$controladorActual)->first();

        if (!$menu) {
            return $acciones;
        }

        $menuId = $menu->id;
        $menuName = $menu->name;

        $methods = Group::find($grupoId)->methods()
            ->where('is_action',1)
            ->where('menu_id',$menuId)
            ->where('activo',1)
            ->orderBy('name','ASC')
            ->get();

        foreach ($methods as $method) {
            $acciones[$method->name] = [
                'metodos_nombre' => $method->name,
                'metodos_accion' => $method->action,
                'metodos_icono' => $method->icon,
                'menus_nombre' => $menuName,

            ];
        }

        $_SESSION[SESSION_ID]["{$controladorActual}Acciones"] = $acciones;
        return $acciones;
    }

    public static function menu(int $grupoId)
    {

        if (isset($_SESSION[SESSION_ID]['menuDefinido']) && GUARDAR_MENU_SESSION) {
            return $_SESSION[SESSION_ID]['menuDefinido'];
        }

        $menu_navegacion = [];
        $menus = Menu::where('activo',1)->orderBy('name','ASC')->get();

        foreach ($menus as $menu) {
            $parteMenu = [
                $menu->name,
                $menu->icon,
                $menu->label,
            ];

            $methods = Group::find($grupoId)->methods()
                ->where('menu_id',$menu->id)
                ->where('activo',1)
                ->where('is_menu',1)
                ->get()->toArray();

            if (count($methods) == 0) {
                continue;
            }

            foreach ($methods as $method) {
                $parteMenu[] = [
                    'label' => $method['label'],
                    'metodo' => $method['name'],
                ];
            }

            $menu_navegacion[$menu->label] = $parteMenu;
        }

        $_SESSION[SESSION_ID]['menuDefinido'] = $menu_navegacion;
        return $menu_navegacion;

    }

}
