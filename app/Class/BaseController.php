<?php

namespace App\Class;

use App\Errors\Base AS ErrorBase;
use App\Errors\Expected AS ErrorEsperado;
use Exception;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

class BaseController
{

    protected Builder $consulta;
    protected string $nameSubmit;
    protected string $nameModel;
    protected string $llaveFormulario; // Llave que se ocupa que los $_POST son de un formulario valido
    // ['campo' => 'tabla.campo', 'valor' => 'valor_campo', 'signoComparacion' => '=', 'relacion' => 'relacion'],
    protected array $filtrosBase = []; // Se debe declarar en el constructor
    protected array $listaRelations = []; // [nameModel => relation]
    protected array $filtroTableRelations = []; // [nameModel => nameTabla]
    protected array $filtroRelations = []; // [nameModel => relation]
    protected int $registrosPorPagina = 10; // Numero de registro por pagina en la lista
    protected int $sizeColumnasInputsFiltros = 3; // tamaño de los inputs de los filtros de la lista
    protected $model;

    public Collection|Model|array $registro;
    public Collection|array $registros;
    public string $htmlPaginador = '';
    public string $nameController;
    public array $camposLista;
    public array $htmlInputFiltros = [];
    public array $htmlInputFormulario = [];
    public bool $breadcrumb = true;

    public function __construct()
    {
        $this->llaveFormulario = md5(SESSION_ID);
    }

    public function registrarBd()
    {
        $datos = $this->validaDatosFormulario();

        $datos['created_user_id'] = USUARIO_ID;
        $datos['updated_user_id'] = USUARIO_ID;

        try {
            $this->consulta = $this->model::query();
            $resultado = $this->consulta->create($datos);
        } catch (Exception $e) {
            if (DEBUG_MODE) {
                $error = new ErrorBase($e->getMessage());
                $error->muestraError();exit;
            }
            $mensaje = 'error al crear el registro';
            Redireccion::enviar($this->nameController,'lista',SESSION_ID,$mensaje);
            exit;
        }

        $mensaje = 'datos registrados';

        Redireccion::enviar($this->nameController,'lista',SESSION_ID,$mensaje);
        exit;
    }

    public function modificarBd()
    {
        $registroId = $this->validaRegistoId();

        $datos = $this->validaDatosFormulario();

        try {
            $this->consulta = $this->model::query();
            $this->registro = $this->consulta->find($registroId);

            foreach ($datos AS $key => $valor) {
                $this->registro->$key = $valor;
            }
            $this->registro->updated_user_id = USUARIO_ID;
            $this->registro->save();
        } catch (Exception $e) {
            if (DEBUG_MODE) {
                $error = new ErrorBase($e->getMessage());
                $error->muestraError();exit;
            }
            $mensaje = 'error al modificar el registro';
            Redireccion::enviar($this->nameController,'lista',SESSION_ID,$mensaje);
            exit;
        }

        $mensaje = 'registro modificado';

        $url = Redireccion::obtener($this->nameController,'lista',SESSION_ID,$mensaje)."&pag={$this->obtenerNumeroPagina()}";
        header("Location: {$url}");
        exit;
    }

    public function activarBd(){
        $this->baseActivaDesactiva(1,'activar','activado');
    }

    public function desactivarBd(){
        $this->baseActivaDesactiva(0,'desactivar','desactivado');
    }

    public function eliminarBd()
    {
        $registroId = $this->validaRegistoId();
        $this->consulta = $this->model::query();

        try {
            $this->registro = $this->consulta->find($registroId);
            $this->registro->delete();
        } catch (Exception $e) {
            $codigoError = $e->getCode();
            $mensaje = 'error al intentar eliminar el registro';
            if ($codigoError == REGISTRO_RELACIONADO) {
                $mensaje = 'No se puede eliminar un registro que esta relacionado';
            }
            if (DEBUG_MODE) {
                $error = new ErrorBase($e->getMessage());
                $error->muestraError();exit;
            }
            $url = Redireccion::obtener($this->nameController,'lista',SESSION_ID,$mensaje)."&pag={$this->obtenerNumeroPagina()}";
            header("Location: $url");
            exit;
        }

        $mensaje = 'registro eliminado';

        $url = Redireccion::obtener($this->nameController,'lista',SESSION_ID,$mensaje)."&pag={$this->obtenerNumeroPagina()}";
        header("Location: $url");
        exit;
    }

    /***
     * Star the functions private & protected
     */

    protected function obtenerRegistroArrayConGetRegistroId()
    {
        $registroId = $this->validaRegistoId();

        try {
            $this->consulta = $this->model::query();
            $this->addRelations();
            $this->registro = $this->consulta->find($registroId)->toArray();
        } catch (Exception $e) {
            if (DEBUG_MODE) {
                $error = new ErrorBase($e->getMessage());
                $error->muestraError();exit;
            }
            $mensaje = 'error al obtener los datos del registro';
            Redireccion::enviar($this->nameController,'lista',SESSION_ID,$mensaje);
            exit;
        }

    }

    protected function validaDatosFormulario() : array
    {
        $datos = $_POST;
        $nombreLlaveFormulario = $this->llaveFormulario;
        if (!isset($datos[$nombreLlaveFormulario])) {
            $mensaje = 'llave no valida';
            if (DEBUG_MODE) {
                $e = new ErrorBase($mensaje);
                $e->muestraError();exit;
            }
            Redireccion::enviar($this->nameController,'lista',SESSION_ID);
            exit;
        }

        unset($datos[$nombreLlaveFormulario]);

        return $datos;
    }

    private function baseActivaDesactiva(int $value, string $action, string $success)
    {
        $registroId = $this->validaRegistoId();
        $this->consulta = $this->model::query();

        try {
            $this->registro = $this->consulta->find($registroId);
            $this->registro->activo = $value;
            $this->registro->save();
        } catch (Exception $e) {
            $mensaje = "error al intentar $action el registro";
            if (DEBUG_MODE) {
                $error = new ErrorBase($e->getMessage());
                $error->muestraError();exit;
            }
            $url = Redireccion::obtener($this->nameController,'lista',SESSION_ID,$mensaje)."&pag={$this->obtenerNumeroPagina()}";
            header("Location: $url");
            exit;
        }

        $mensaje = "registro $success";

        $url = Redireccion::obtener($this->nameController,'lista',SESSION_ID,$mensaje)."&pag={$this->obtenerNumeroPagina()}";
        header("Location: {$url}");
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
        $this->aplicarFiltrosBase();
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
         * $this->filtrosBase = [
         *      ['campo' => 'tabla.compo', 'valor' => valor_campo, 'signoComparacion' => '=', 'relacion' => 'relacion'],
         * ];
         */

        foreach ($this->filtrosBase AS $filtro) {
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
            if ($datosFiltros[$tablaCampo] == '') {
                continue;
            }
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

    public function obtenerNumeroPagina(): int
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