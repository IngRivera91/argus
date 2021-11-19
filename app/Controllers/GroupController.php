<?php

namespace App\Controllers;

use App\Class\BaseController;
use App\Class\Html;
use App\Models\Group;
use App\Errors\Base AS ErrorBase;
use App\Models\Method;

class GroupController extends BaseController
{
    public array $metodosAgrupadosPorMenu;
    public string $nombreGrupo;
    public int $grupoId;
    public function __construct()
    {
        $this->model = Group::class;
        $this->nameController = 'Group';
        parent::__construct();
    }

    public function lista()
    {
        $this->breadcrumb = false;

        $this->camposLista = [
            'Id' => 'id',
            'Grupo' => 'name',
            'Activo' => 'activo'
        ];

        parent::lista();
    }

    public function generaInputFiltros (array $datosFiltros): void
    {
        $col = 3;
        $this->sizeColumnasInputsFiltros = $col;

        $datos['Group+name'] = '';

        foreach ($datosFiltros as $key => $filtro) {
            $datos[$key] = $filtro;
        }

        $placeholder = '';
        $tablaCampo = 'Group+name';
        $this->htmlInputFiltros[$tablaCampo] = Html::inputText($col,'Grupo',1,$tablaCampo,$placeholder,$datos[$tablaCampo]);
    }

    public function registrar()
    {
        $this->breadcrumb = true;
        $this->htmlInputFormulario[] = Html::inputTextRequired(4,'Grupo',1,'name');
        $this->htmlInputFormulario[] = Html::selectActivo('Activo','activo',4,'-1',2);
        $this->htmlInputFormulario[] = Html::submit('Registrar',$this->llaveFormulario,4);
    }

    public function modificar()
    {
        parent::obtenerRegistroArrayConGetRegistroId();
        $this->breadcrumb = true;
        $registro = $this->registro;
        $this->htmlInputFormulario[] = Html::inputTextRequired(4,'Grupo',1,'name','',$registro['name']);
        $this->htmlInputFormulario[] = Html::selectActivo('Activo','activo',4,$registro['activo'],2);
        $this->htmlInputFormulario[] = Html::submit('Modificar',$this->llaveFormulario,4);
    }

    public function permisos()
    {
        $grupoId = $this->validaRegistoId();
        $this->grupoId = $grupoId;
        $this->metodosAgrupadosPorMenu = Group::obtenerMetodosAgrupadosPorMenu($grupoId);
        $this->nombreGrupo = Group::query()->find($grupoId)->name;

    }

    public function altaPermiso()
    {
        try {

            $metodoId = $this->validaMetodoId();
            $grupoId = $this->validaGrupoId();

            $datos = ['grupo_id' => $grupoId, 'metodo_id' => $metodoId, 'activo' => 1];
            // Todo: ver como hacer el registro con atach

        } catch (ErrorBase $e) {
            header('Content-Type: application/json');
            $json = json_encode(['respuesta' => false,'error' => $e->getMessage()]);
            echo $json;
            exit;
        }

        header('Content-Type: application/json');
        $json = json_encode(['respuesta' => true,'error' => '']);
        echo $json;
        exit;

    }

    public function bajaPermiso()
    {
        try {

            $metodoId = $this->validaMetodoId();
            $grupoId = $this->validaGrupoId();

            // Todo: ver como eliminar el registro con detach

        } catch (ErrorBase $e) {
            header('Content-Type: application/json');
            $json = json_encode(['respuesta' => false,'error' => $e->getMessage()]);
            echo $json;
            exit;
        }

        header('Content-Type: application/json');
        $json = json_encode(['respuesta' => true,'error' => '']);
        echo $json;
        exit;

    }

    /**
     * @throws ErrorBase
     */
    private function validaMetodoId(): int
    {
        if (!isset($_GET['metodoId'])) throw new ErrorBase('se esperaba el parametro GET metodoId');

        $metodoId = (int) $_GET['metodoId'];

        if (!$this->existeModelRegistroId($metodoId, Method::class)) throw new ErrorBase('el metodoId no existe');

        return $metodoId;

    }

    /**
     * @throws ErrorBase
     */
    private function validaGrupoId(): int
    {
        if (!isset($_GET['grupoId'])) throw new ErrorBase('se esperaba el parametro GET grupoId');

        $grupoId = (int) $_GET['grupoId'];

        if (!$this->existeModelRegistroId($grupoId,Group::class)) throw new ErrorBase('el grupoId no existe');

        return $grupoId;
    }

    private function existeModelRegistroId(int $registroId, $model) : bool
    {
        $this->consulta = $model::query();
        return $this->consulta->where('id',$registroId)->get()->count();
    }
}
