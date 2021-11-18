<?php

namespace App\Class;

use App\Errors\Base AS ErrorBase;
use App\Errors\Expected AS ErrorEsperado;
use Exception;
use Illuminate\Database\Eloquent\Builder;

class BaseController
{

    protected Builder $consulta;
    protected string  $nameSubmit;
    protected string  $llaveFormulario;                // Llave que se ocupa que los $_POST son de un formulario valido

    // ['campo' => 'tabla.campo', 'valor' => 'valor_campo', 'signoComparacion' => '=', 'relacion' => 'relacion'],
    protected array   $filtrosBaseLista = [];

    protected array   $listaRelations = [];            // [nameController => relation]
    protected array   $filtroTableRelations = [];      // [nameController => nameTabla]
    protected array   $filtroRelations = [];           // [nameController => relation]
    protected int     $registrosPorPagina = 10;        // Numero de registro por pagina en la lista
    protected int     $sizeColumnasInputsFiltros = 3;  // tamaño de los inputs de los filtros de la lista
    protected         $model;

    public string     $htmlPaginador = '';
    public string     $nameController;
    public array      $camposLista;
    public array      $htmlInputFiltros = [];
    public array      $htmlInputFormulario = [];
    public bool       $breadcrumb = true;
    public            $registro;
    public            $registros;

    public function __construct()
    {
        $this->llaveFormulario = md5(SESSION_ID);
    }

    public function registrarBd()
    {
        $datos = $_POST;
        $nombreLlaveFormulario = $this->llaveFormulario;
        if (!isset($datos[$nombreLlaveFormulario])) {
            $mensaje = 'llave no valida';
            if (DEBUG_MODE) {
                $e = new ErrorBase($mensaje);
                $e->muestraError();exit;
            }
            Redireccion::enviar($this->nameController,'registrar',SESSION_ID);
            exit;
        }

        unset($datos[$nombreLlaveFormulario]);

        try {
            $resultado = $this->model::create($datos);
        } catch (Exception $e) {
            if (DEBUG_MODE) {
                $error = new ErrorBase($e->getMessage());
                $error->muestraError();exit;
            }
            $mensaje = 'No se pudo efectuar el registro';
            Redireccion::enviar($this->nameController,'lista',SESSION_ID,$mensaje);
            exit;
        }

        $mensaje = 'datos registrados';

        Redireccion::enviar($this->nameController,'lista',SESSION_ID,$mensaje);
        exit;
    }

    public function eliminarBd()
    {
        $registroId = $this->validaRegistoId();
        $this->consulta = $this->model::query();
        try {
            $registro = $this->consulta->findOrFail($registroId);
            $registro->delete();
        } catch (Exception $e) {
            $codigoError = $e->getCode();
            if ($codigoError == REGISTRO_RELACIONADO) {
                $mensaje = 'No se puede eliminar un registro que esta relacionado';
                if (DEBUG_MODE) {
                    $error = new ErrorBase($e->getMessage());
                    $error->muestraError();exit;
                }
                $url = Redireccion::obtener($this->nameController,'lista',SESSION_ID,$mensaje)."&pag={$this->obtenerNumeroPagina()}";
                header("Location: $url");
                exit;
            }
        }

        $mensaje = 'registro eliminado';

        $url = Redireccion::obtener($this->nameController,'lista',SESSION_ID,$mensaje)."&pag={$this->obtenerNumeroPagina()}";
        header("Location: $url");
        exit;
    }

    protected function validaRegistoId(): int
    {
        if (!isset($_GET['registroId'])) {
            $mensaje = 'no se puede realizar la accion sin un registro id';
            $error = new ErrorEsperado($mensaje, $this->nameController, 'lista');

            if (DEBUG_MODE) {
                $error = new ErrorBase($mensaje);
            }

            $error->muestraError();
            exit;
        }

        $registroId = (int) $_GET['registroId'];

        if (!$this->existeRegistroId($registroId)) {
            $mensaje = 'no se puede realizar la accion si el registro no existe';
            $error = new ErrorEsperado($mensaje, $this->nameController, 'lista');
            if (DEBUG_MODE) {
                $error = new ErrorBase($mensaje);
            }
            $error->muestraError();
            exit;
        }

        return $registroId;
    }

    protected function existeRegistroId(int $registroId) : bool
    {
        $this->consulta = $this->model::query();
        return $this->consulta->where('id',$registroId)->get()->count();
    }

    /***
     * Star the functions for the list
     */
    protected function lista()
    {
        $this->nameSubmit = "{$this->nameController}ListaFiltro";
        $datosFiltros = $this->generaDatosFiltros();
        $this->generaInputFiltros($datosFiltros);

        $this->consulta = $this->model::query();

        $this->aplicarFiltrosBase();

        if (count($datosFiltros) != 0) {
             $this->aplicaFiltros($datosFiltros);
        }

        if ($this->existeFiltrosLista()) {
            $this->htmlInputFiltros[] = Html::submit('Filtrar', $this->nameSubmit, $this->sizeColumnasInputsFiltros);
            $urlDestino = Redireccion::obtener($this->nameController,'lista',SESSION_ID).'&limpiaFiltro';
            $this->htmlInputFiltros[] = Html::linkBoton($urlDestino, 'Limpiar', $this->sizeColumnasInputsFiltros);
        }

        $this->addRelations();
        $this->obtenerPaginador();

        $this->registros = $this->registros->toArray();
    }

    private function existeFiltrosLista() : bool
    {
        return count($this->htmlInputFiltros) != 0;
    }

    private function aplicarFiltrosBase()
    {
        /**
         * $this->filtrosBaseLista = [
         *      ['campo' => 'tabla.compo', 'valor' => valor_campo, 'signoComparacion' => '=', 'relacion' => 'relacion'],
         * ];
         */

        foreach ($this->filtrosBaseLista AS $filtro) {
            if ($filtro['relacion'] == '') {
                $this->consulta->where($filtro['campo'],$filtro['signoComparacion'],$filtro['valor']);
            }

            if ($filtro['relacion'] != '') {
                $this->consulta->whereRelation(
                    $filtro['relacion'],
                    $filtro['campo'],
                    $filtro['signoComparacion'],
                    $filtro['valor']
                );
            }
        }
    }

    private function addRelations()
    {
        foreach ($this->listaRelations as $listaRelation) {
            $this->consulta->with($listaRelation);
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

            if ($nameController == $this->nameController) {
                $tableField = "$tabla.$field";
                $this->consulta->where($tableField,'LIKE',"%$datosFiltros[$tablaCampo]%");
            }

            if ($nameController != $this->nameController) {
                $this->consulta->whereRelation(
                    $this->filtroRelations[$nameController],
                    "{$this->filtroTableRelations[$nameController]}.$field",
                    "=",
                    $datosFiltros[$tablaCampo]
                );
            }

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