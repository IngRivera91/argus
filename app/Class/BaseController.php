<?php

namespace App\Class;


class BaseController
{

    public int    $sizeColumnasInputsFiltros = 3;
    public array  $filtrosBaseLista = [];
    public array  $htmlInputFiltros = [];
    public string $nameSubmit;
    public int    $registrosPorPagina = 10;

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

        if (count($datosFiltros) == 0) {
            $this->registros = $consulta->get();
        }

        if (count($datosFiltros) != 0) {
             $this->aplicaFiltros($datosFiltros, $consulta);
        }

        if (count($this->htmlInputFiltros) != 0) {
            $this->htmlInputFiltros[] = Html::submit('Filtrar', $this->nameSubmit, $this->sizeColumnasInputsFiltros);
            $urlDestino = Redireccion::obtener($this->nameController,'lista',SESSION_ID).'&limpiaFiltro';
            $this->htmlInputFiltros[] = Html::linkBoton($urlDestino, 'Limpiar', $this->sizeColumnasInputsFiltros);
        }

        $this->registros = $this->registros->toArray();
    }

    private function aplicaFiltros(array $datosFiltros, $consulta)
    {
        foreach ($this->htmlInputFiltros as $tablaCampo => $value) {
            $campo = str_replace('+','.',$tablaCampo);
            $consulta->where($campo,'LIKE',"%$datosFiltros[$tablaCampo]%");
        }

        $this->registros = $consulta->get();
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

    protected function generaInputFiltros (array $datosFiltros): void
    {

    }


}