<?php

namespace App\Class;


class BaseController
{

    public int    $sizeColumnasInputsFiltros = 3;
    public array  $filtrosBaseLista = [];
    public array  $htmlInputFiltros = [];
    public string $nameSubmit;
    public int    $registrosPorPagina = 2;
    public string $htmlPaginador = '';

    public array  $camposLista;
    public bool $breadcrumb = true;
    public $registro;
    public $registros;
    public string $nameController;
    public $model;

    public function lista()
    {
        $this->nameSubmit = "{$this->nameController}ListaFiltro";
        $datosFiltros = $this->generaDatosFiltros();
        $this->generaInputFiltros($datosFiltros);

        $consulta = $this->model::query();

        foreach ($this->filtrosBaseLista AS $filtro) {
            $consulta->where($filtro['campo'],$filtro['signoComparacion'],$filtro['valor']);
        }

        if (count($datosFiltros) != 0) {
             $consulta = $this->aplicaFiltros($datosFiltros, $consulta);
        }

        if (count($this->htmlInputFiltros) != 0) {
            $this->htmlInputFiltros[] = Html::submit('Filtrar', $this->nameSubmit, $this->sizeColumnasInputsFiltros);
            $urlDestino = Redireccion::obtener($this->nameController,'lista',SESSION_ID).'&limpiaFiltro';
            $this->htmlInputFiltros[] = Html::linkBoton($urlDestino, 'Limpiar', $this->sizeColumnasInputsFiltros);
        }

        $this->obtenePaginador($consulta);

        $this->registros = $this->registros->toArray();
    }

    public function obtenePaginador($consulta): void
    {
        $numeroRegistros = $consulta->get()->count();
        $numeroPaginas = (int) (($numeroRegistros-1) / (int)$this->registrosPorPagina );
        $numeroPaginas++;
        $numeroPagina = (int)$this->obtenerNumeroPagina();

        if ($numeroPagina > $numeroPaginas){
            Redireccion::enviar($this->nameController,'lista',SESSION_ID,'');
            exit;
        }

        $skip = ( ($numeroPagina-1) * (int)$this->registrosPorPagina );
        $take = $this->registrosPorPagina;

        $this->registros = $consulta->skip($skip)->take($take)->get();
        if ($numeroPaginas > 1){
            $this->htmlPaginador = Html::paginador($numeroPaginas,$numeroPagina,$this->nameController);
        }

    }

    private function aplicaFiltros(array $datosFiltros, $consulta)
    {
        foreach ($this->htmlInputFiltros as $tablaCampo => $value) {
            $campo = str_replace('+','.',$tablaCampo);
            $consulta->where($campo,'LIKE',"%$datosFiltros[$tablaCampo]%");
        }
        return $consulta;
    }

    private function generaDatosFiltros(): array
    {
        $datosFiltros = [];

        if  (isset($_GET['limpiaFiltro'])) {
            unset($_SESSION[SESSION_ID][$this->nameSubmit]);
        }

        if (isset($_SESSION[SESSION_ID][$this->nameSubmit]) && !isset($_POST[$this->nameSubmit])){
            $_POST = $_SESSION[SESSION_ID][$this->nameSubmit];
        }

        if (isset($_POST[$this->nameSubmit])) {
            $_SESSION[SESSION_ID][$this->nameSubmit] = $_POST;
            $datosFiltros = $_POST;
        }

        return $datosFiltros;
    }

    public function obtenerNumeroPagina(): int
    {
        $num_pagina = 1;
        if (isset($_GET['pag'])){
            $num_pagina = (int) $_GET['pag'];
        }
        return (int)$num_pagina;
    }

    protected function generaInputFiltros (array $datosFiltros): void
    {

    }


}