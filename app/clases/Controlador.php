<?php 

namespace Clase;

use Ayuda\Html;
use Clase\Modelo;
use Ayuda\Redireccion;

class Controlador
{
    private Modelo $modelo; // Modelo del menu con el que se esta trabajando
    private int $registrosPorPagina = 10; // numero de registros por pagina en la lista
    public string $nombreMenu; // Define el menu al cual se deben hacer la redirecciones
    public array $camposLista; // Define los campo que se van a mostrar en la lista
    public array $filtrosLista = []; // Define los filtros que se deben aplicar para obtener los registros de las listas
    public bool $breadcrumb = true; // define si se muestran o no los breadcrumb
    public string $htmlPaginador; // codigo html del paginador
    public string $htmlInputFiltros; // codigo html de los inputs del filtro para la lista
    public array $registro; // almacena el registros para poder editarlo
    public array $registros; // almacena los resgistros para poder mostrarlos en la lista

    public function __construct(Modelo $modelo, string $nombreMenu, array $camposLista)
    {
        $this->modelo = $modelo;
        $this->nombreMenu = $nombreMenu;
        $this->camposLista = $camposLista;
    }

    public function lista()
    {
        $columnas = [];
        $orderBy = [];
        $limit = $this->obteneLimitPaginador();
        foreach ($this->camposLista as $nombre => $campo){
            $columnas[] = $campo;
        }
        $resultado = $this->modelo->buscarConFiltros($this->filtrosLista, $columnas, $orderBy, $limit);
        $this->registros = $resultado['registros'];
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
            $this->htmlPaginador = \Ayuda\Html::paginador($numeroPaginas,$numeroPagina,$this->nombreMenu);
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