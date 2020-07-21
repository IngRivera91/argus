<?php 

namespace Clase;

use Ayuda\Html;
use Clase\Modelo;
use Ayuda\Redireccion;

class Controlador
{
    public Modelo $modelo; // Modelo del menu con el que se esta trabajando
    public int $registrosPorPagina = 10; // numero de registros por pagina en la lista
    public string $nombreMenu; // Define el menu al cual se deben hacer la redirecciones
    public array $camposLista; // Define los campo que se van a mostrar en la lista
    public array $filtrosLista = []; // Define los filtros que se deben aplicar para obtener los registros de las listas
    public array $camposFiltrosLista = []; //Define los campos de los filtros
    public int $sizeColumnasInputsFiltros = 3; // define el tamaño de los elementos en el filtro de la lista
    public bool $usarFiltros = true; // Variable que determina si se usan o no los filtros en la lista
    public bool $breadcrumb = true; // define si se muestran o no los breadcrumb
    public string $htmlPaginador = ''; // codigo html del paginador
    public array $htmlInputFiltros = []; // codigo html de los inputs del filtro para la lista
    public array $registro; // almacena el registros para poder editarlo
    public array $registros; // almacena los resgistros para poder mostrarlos en la lista

    public function __construct(Modelo $modelo, string $nombreMenu, array $camposLista, array $camposFiltrosLista)
    {
        $this->modelo = $modelo;
        $this->nombreMenu = $nombreMenu;
        $this->camposLista = $camposLista;
        $this->camposFiltrosLista = $camposFiltrosLista;
        if (count($camposFiltrosLista) == 0) {
            $this->usarFiltros = false;
        }
    }

    public function activar_bd(){

        $registroId = $_GET['registro_id'];

        $datos["activo"] = 1;

        $resultado = $this->modelo->actualizarPorId($registroId, $datos);

        $url = Redireccion::obtener($this->nombreMenu,'lista',SESSION_ID)."&pag={$this->obteneNumeroPagina()}";
        header("Location: {$url}");
        exit;   
    }

    public function desactivar_bd(){

        $registroId = $_GET['registro_id'];

        $datos["activo"] = 0;

        $resultado = $this->modelo->actualizarPorId($registroId, $datos);

        $url = Redireccion::obtener($this->nombreMenu,'lista',SESSION_ID)."&pag={$this->obteneNumeroPagina()}";
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
        $this->htmlInputFiltros[] = Html::link_boton($url_destino, 'Limpiar', $cols);
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
            $this->htmlInputFiltros[] = Html::input($label,$_name,$cols,$label,$value,$type,$require);
        }
    }

    private function obteneLimitPaginador(){
        $numeroRegistros = $this->modelo->obtenerNumeroRegistros($this->filtrosLista);
        $numeroPaginas = (int) (($numeroRegistros-1) / (int)$this->registrosPorPagina );
        $numeroPaginas++;
        $numeroPagina = (int)$this->obteneNumeroPagina();

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

    private function obteneNumeroPagina(){
        $num_pagina = 1;
        if (isset($_GET['pag'])){
            $num_pagina = (int) $_GET['pag'];
        }
        return (int)$num_pagina;
    }
}