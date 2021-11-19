<?php

namespace App\Controllers;

use App\Class\BaseController;
use App\Class\Html;
use App\Models\Group;

class GroupController extends BaseController
{
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
}
