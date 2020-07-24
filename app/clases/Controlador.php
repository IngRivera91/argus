<?php 

namespace Clase;

use Ayuda\Html;
use Clase\Modelo;
use Error\Esperado AS ErrorEsperado;
use Error\Base AS ErrorBase;
use Ayuda\Redireccion;

class Controlador
{
    public int    $sizeColumnasInputsFiltros = 3; // Define el tamaño de los elementos en el filtro de la lista
    public int    $registrosPorPagina = 10;       // Numero de registros por pagina en la lista
    public bool   $breadcrumb = true;             // Define si se muestran o no los breadcrumb
    public bool   $usarFiltros = true;            // Variable que determina si se usan o no los filtros en la lista
    public array  $camposFiltrosLista = [];       // Define los campos de los filtros
    public array  $camposLista;                   // Define los campo que se van a mostrar en la lista
    public array  $filtrosLista = [];             // Define los filtros que se deben aplicar para obtener los registros de las listas
    public array  $htmlInputFiltros = [];         // Codigo html de los inputs del filtro para la lista
    public array  $htmlInputFormulario = [];      // Codigo html de los inputs del del formulario de registro y modificacion
    public array  $registro;                      // Almacena el registros para poder editarlo
    public array  $registros;                     // Almacena los resgistros para poder mostrarlos en la lista
    public string $htmlPaginador = '';            // Codigo html del paginador
    public string $llaveFormulario;               // Llave que se ocupa que los $_POST son de un formulario valido
    public string $nombreMenu;                    // Define el menu al cual se deben hacer la redirecciones
    public Modelo $modelo;                        // Modelo del menu con el que se esta trabajando

    public function __construct(Modelo $modelo, string $nombreMenu, array $camposLista, array $camposFiltrosLista)
    {
        $this->llaveFormulario = md5(SESSION_ID);
        $this->modelo = $modelo;
        $this->nombreMenu = $nombreMenu;
        $this->camposLista = $camposLista;
        $this->camposFiltrosLista = $camposFiltrosLista;
        if (count($camposFiltrosLista) == 0) {
            $this->usarFiltros = false;
        }
    }

    public function modificar()
    {
        $registroId = $this->validaRegistoIdModificar();

        try {
            $resultado = $this->modelo->buscarPorId($registroId);
        } catch (ErrorBase $e) {
            $error = new ErrorBase('Error al obtener datos de el registro a modificar',$e);
            $error->muestraError();
            exit;
        }

        $this->registro = $resultado['registros'][0];

    }

    private function validaRegistoIdModificar():int
    {
        if (!isset($_GET['registro_id'])) {
            $error = new ErrorEsperado('no se puede modificar un registro sin su id', $this->nombreMenu, 'lista');
            $error->muestraError();
            exit;
        }

        $registroId = (int) $_GET['registro_id'];

        if (!$this->modelo->existeRegistroId($registroId)) {
            $error = new ErrorEsperado('no se puede modificar un registro que no existe', $this->nombreMenu, 'lista');
            $error->muestraError();
            exit;
        }

        return $registroId;
    }

    public function modificar_bd()
    {
        $registroId = $this->validaRegistoIdModificar();

        $datos = $_POST;
        $nombreLlaveFormulario = $this->llaveFormulario;
        if (!isset($datos[$nombreLlaveFormulario])) {
            Redireccion::enviar($this->nombreMenu,'lista',SESSION_ID);
        }

        unset($datos[$nombreLlaveFormulario]);

        try {
            $resultado = $this->modelo->actualizarPorId($registroId, $datos);
        } catch (ErrorBase $e) {
            $error = new ErrorBase('Error al modificar datos',$e);
            $error->muestraError();
            exit;
        }

        $url = Redireccion::obtener($this->nombreMenu,'lista',SESSION_ID,'registro modificado')."&pag={$this->obtenerNumeroPagina()}";
        header("Location: {$url}");
        exit;   
    }

    public function registrar_bd()
    {
        $datos = $_POST;
        $nombreLlaveFormulario = $this->llaveFormulario;
        if (!isset($datos[$nombreLlaveFormulario])) {
            Redireccion::enviar($this->nombreMenu,'registrar',SESSION_ID);
        }
        
        unset($datos[$nombreLlaveFormulario]);

        try {
            $resultado = $this->modelo->registrar($datos);
        } catch (ErrorBase $e) {
            $error = new ErrorBase('Error al registrar datos',$e);
            $error->muestraError();
            exit;
        }

        Redireccion::enviar($this->nombreMenu,'lista',SESSION_ID,'registro exitoso');
    }

    public function activar_bd(){

        if (!isset($_GET['registro_id'])) {
            $error = new ErrorEsperado('no se puede activar un registro sin su id', $this->nombreMenu, 'lista');
            $error->muestraError();
            exit;
        }

        $registroId = (int) $_GET['registro_id'];

        if (!$this->modelo->existeRegistroId($registroId)) {
            $error = new ErrorEsperado('no se puede activar un registro que no existe', $this->nombreMenu, 'lista');
            $error->muestraError();
            exit;
        }


        $datos["activo"] = 1;

        try {
            $resultado = $this->modelo->actualizarPorId($registroId, $datos);
        } catch (ErrorBase $e) {
            $error = new ErrorBase('Error al activar registro',$e);
            $error->muestraError();
            exit;
        }

        $url = Redireccion::obtener($this->nombreMenu,'lista',SESSION_ID)."&pag={$this->obtenerNumeroPagina()}";
        header("Location: {$url}");
        exit;   
    }

    public function desactivar_bd(){

        if (!isset($_GET['registro_id'])) {
            $error = new ErrorEsperado('no se puede desactivar un registro sin su id', $this->nombreMenu, 'lista');
            $error->muestraError();
            exit;
        }

        $registroId = (int) $_GET['registro_id'];

        if (!$this->modelo->existeRegistroId($registroId)) {
            $error = new ErrorEsperado('no se puede desactivar un registro que no existe', $this->nombreMenu, 'lista');
            $error->muestraError();
            exit;
        }

        $datos["activo"] = 0;

        try {
            $resultado = $this->modelo->actualizarPorId($registroId, $datos);
        } catch (ErrorBase $e) {
            $error = new ErrorBase('Error al desactivar registro',$e);
            $error->muestraError();
            exit;
        }

        $url = Redireccion::obtener($this->nombreMenu,'lista',SESSION_ID)."&pag={$this->obtenerNumeroPagina()}";
        header("Location: {$url}");
        exit;
        
    }

    public function eliminar_bd()
    {
        if (!isset($_GET['registro_id'])) {
            $error = new ErrorEsperado('no se puede eliminar un registro sin su id', $this->nombreMenu, 'lista');
            $error->muestraError();
            exit;
        }

        $registroId = (int) $_GET['registro_id'];

        if (!$this->modelo->existeRegistroId($registroId)) {
            $error = new ErrorEsperado('no se puede eliminar un registro que no existe', $this->nombreMenu, 'lista');
            $error->muestraError();
            exit;
        }

        try {
            $resultado = $this->modelo->eliminarPorId($registroId);
        } catch (ErrorBase $e) {
            $codigoError = $e->getCode();
            if ($codigoError == 23000) {
                $mensaje = 'No se puede eliminar un registro que esta relacionado';
                $url = Redireccion::obtener($this->nombreMenu,'lista',SESSION_ID,$mensaje)."&pag={$this->obtenerNumeroPagina()}";
                header("Location: {$url}");
                exit;
            }
            $error = new ErrorBase('Error al eliminar registro',$e);
            $error->muestraError();
            exit;
        }

        $url = Redireccion::obtener($this->nombreMenu,'lista',SESSION_ID)."&pag={$this->obtenerNumeroPagina()}";
        header("Location: {$url}");
        exit;
    }

    public function lista()
    {
        $columnas = [];
        $orderBy = [];

        if ($this->usarFiltros) {
            $this->analizaInputsFiltros();
        }

        $limit = $this->obteneLimitPaginador();
        foreach ($this->camposLista as $nombre => $campo){
            $columnas[] = $campo;
        }
        $resultado = $this->modelo->buscarConFiltros($this->filtrosLista, $columnas, $orderBy, $limit);
        $this->registros = $resultado['registros'];
    }

    private function analizaInputsFiltros()
    {
        $cols = $this->sizeColumnasInputsFiltros;
        $nameSubmit = $this->nombreMenu.'_lista';
        if  (isset($_GET['limpiaFiltro'])) {    
            unset($_SESSION[SESSION_ID][$nameSubmit]);
        }

        if (isset($_SESSION[SESSION_ID][$nameSubmit]) && !isset($_POST[$nameSubmit])){
            $_POST = $_SESSION[SESSION_ID][$nameSubmit];
        }

        if (isset($_POST[$nameSubmit])) {
            $_SESSION[SESSION_ID][$nameSubmit] = $_POST;
            $this->generaHtmlInputFiltros($cols,$_POST);
        }

        if (!isset($_POST[$nameSubmit])) {
            $this->generaHtmlInputFiltros($cols);
        }
        $this->htmlInputFiltros[] = Html::submit('Filtrar', $nameSubmit, $cols);
        $url_destino = Redireccion::obtener($this->nombreMenu,'lista',SESSION_ID).'&limpiaFiltro';
        $this->htmlInputFiltros[] = Html::linkBoton($url_destino, 'Limpiar', $cols);
    }

    private function generaHtmlInputFiltros(string $cols, array $datosValue = []): void
    {
        $this->filtrosLista[] = ['campo' =>'1', 'valor'=>'1', 'signoComparacion'=>'=', 'conectivaLogica'=>''];
        $type = 'text';
        $require = '';
        $value= '';
        foreach ($this->camposFiltrosLista as $label => $name) {
            $_name = str_replace('.','_',$name); 
            if (isset($datosValue[$_name])) {
                $value = $datosValue[$_name];
                $this->filtrosLista[] = ['campo' =>$name, 'valor'=>"%{$value}%", 'signoComparacion'=>'LIKE', 'conectivaLogica'=>'AND'];
            }
            $this->htmlInputFiltros[] = Html::input($label, $_name, $cols, '', $value, $type, $require);
        }
    }

    private function obteneLimitPaginador(){
        $numeroRegistros = $this->modelo->obtenerNumeroRegistros($this->filtrosLista);
        $numeroPaginas = (int) (($numeroRegistros-1) / (int)$this->registrosPorPagina );
        $numeroPaginas++;
        $numeroPagina = (int)$this->obtenerNumeroPagina();

        if ($numeroPagina > $numeroPaginas){
            Redireccion::enviar($this->nombreMenu,'lista',SESSION_ID,'');
            exit;
        }

        $limit = ( ( ($numeroPagina-1) * (int)$this->registrosPorPagina ) ).','.$this->registrosPorPagina.' ';

        if ($numeroPaginas > 1){
            $this->htmlPaginador = Html::paginador($numeroPaginas,$numeroPagina,$this->nombreMenu);
        }

        return $limit;
    }

    public function obtenerNumeroPagina(){
        $num_pagina = 1;
        if (isset($_GET['pag'])){
            $num_pagina = (int) $_GET['pag'];
        }
        return (int)$num_pagina;
    }
}