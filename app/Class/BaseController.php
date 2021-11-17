<?php

namespace App\Class;

use Illuminate\Database\Eloquent\Builder;

class BaseController
{

    public int    $sizeColumnasInputsFiltros = 3;
    public array  $filtrosBaseLista = [];
    public array  $htmlInputFiltros = [];
    public string $nameSubmit;
    public int    $registrosPorPagina = 10;
    public string $htmlPaginador = '';
    public array  $withs = [];
    public Builder $consulta;

    public array  $camposLista;
    public bool $breadcrumb = true;
    public $registro;
    public $registros;
    public string $nameController;
    public $model;

    protected function lista()
    {
        $this->nameSubmit = "{$this->nameController}ListaFiltro";
        $datosFiltros = $this->generaDatosFiltros();
        $this->generaInputFiltros($datosFiltros);

        $this->consulta = $this->model::query();

        foreach ($this->filtrosBaseLista AS $filtro) {
            $this->consulta->where($filtro['campo'],$filtro['signoComparacion'],$filtro['valor']);
        }

        if (count($datosFiltros) != 0) {
             $this->aplicaFiltros($datosFiltros);
        }

        if (count($this->htmlInputFiltros) != 0) {
            $this->htmlInputFiltros[] = Html::submit('Filtrar', $this->nameSubmit, $this->sizeColumnasInputsFiltros);
            $urlDestino = Redireccion::obtener($this->nameController,'lista',SESSION_ID).'&limpiaFiltro';
            $this->htmlInputFiltros[] = Html::linkBoton($urlDestino, 'Limpiar', $this->sizeColumnasInputsFiltros);
        }

        $this->addRelations();
        $this->obtenerPaginador();

        $this->registros = $this->registros->toArray();
    }

    private function addRelations()
    {
        foreach ($this->withs as $with) {
            $this->consulta->with($with);
        }
    }

    private function obtenerPaginador(): void
    {
        $numeroRegistros = $this->consulta->get()->count();
        $numeroPaginas = (int) (($numeroRegistros-1) / $this->registrosPorPagina);
        $numeroPaginas++;
        $numeroPagina = $this->obtenerNumeroPagina();

        if ($numeroPagina > $numeroPaginas){
            Redireccion::enviar($this->nameController,'lista',SESSION_ID);
            exit;
        }

        $skip = ( ($numeroPagina-1) * $this->registrosPorPagina);
        $take = $this->registrosPorPagina;

        $this->registros = $this->consulta->skip($skip)->take($take)->get();
        if ($numeroPaginas > 1){
            $this->htmlPaginador = Html::paginador($numeroPaginas,$numeroPagina,$this->nameController);
        }

    }

    private function aplicaFiltros(array $datosFiltros)
    {
        foreach ($this->htmlInputFiltros as $tablaCampo => $value) {
            $arrayCampo = explode('+',$tablaCampo);
            $tabla = $this->model::NOMBRE_TABLA;
            $nameController = $arrayCampo[0];
            $field = $arrayCampo[1];
            $tableField = "$tabla.$field";

            $this->consulta->where($tableField,'LIKE',"%$datosFiltros[$tablaCampo]%");
        }

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

    protected function obtenerNumeroPagina(): int
    {
        $num_pagina = 1;
        if (isset($_GET['pag'])){
            $num_pagina = (int) $_GET['pag'];
        }
        return $num_pagina;
    }

    protected function generaInputFiltros (array $datosFiltros): void
    {

    }


}