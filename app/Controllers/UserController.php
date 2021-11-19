<?php

namespace App\Controllers;

use App\class\BaseController;
use App\Class\Html;
use App\Models\Group;
use App\Models\User;

class UserController extends BaseController
{
    private array $grupos;
    public function __construct()
    {
        $this->model = User::class;
        $this->nameController = 'User';
        $this->grupos = Group::query()->get()->toArray();

        $this->listaRelations = ['group'];

        parent::__construct();
    }

    public function lista()
    {
        $this->breadcrumb = false;

        $this->filtroRelations = [
            'Group' => 'group'
        ];

        $this->filtroTableRelations = [
            'Group' => 'groups'
        ];

        $this->camposLista = [
            'Id' => 'id',
            'Nombre' => 'name',
            'Apellidos' => 'last_name',
            'Usuario' => 'user',
            'Grupo' => 'group+name',
            'Activo' => 'activo',
        ];

        parent::lista();
    }

    public function generaInputFiltros (array $datosFiltros): void
    {
        $col = 3;
        $this->sizeColumnasInputsFiltros = $col;

        $datos['User+name'] = '';
        $datos['User+last_name'] = '';
        $datos['Group+id'] = '';

        foreach ($datosFiltros as $key => $filtro) {
            $datos[$key] = $filtro;
        }

        $placeholder = '';

        $tablaCampo = 'User+name';
        $this->htmlInputFiltros[$tablaCampo] = Html::inputText($col,'Nombre',1,$tablaCampo,$placeholder,$datos[$tablaCampo]);

        $tablaCampo = 'User+last_name';
        $this->htmlInputFiltros[$tablaCampo] = Html::inputText($col,'Apellidos',1,$tablaCampo,$placeholder,$datos[$tablaCampo]);

        $tablaCampo = 'Group+id';
        $this->htmlInputFiltros[$tablaCampo] = Html::selectConBuscador(
            'selectGroup',
            'id',
            'Grupo',
            $tablaCampo,
            $col,
            $this->grupos,
            'name',
            $datos[$tablaCampo],
            1,
            ''
        );
    }
}
