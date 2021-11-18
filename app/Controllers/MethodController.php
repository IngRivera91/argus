<?php

namespace App\Controllers;

use App\class\BaseController;
use App\Class\Html;
use App\Models\Menu;
use App\Models\Method;

class MethodController extends BaseController
{
    private array $menus;
    public function __construct()
    {
        $this->model = Method::class;
        $this->nameController = 'Method';
        $this->menus = Menu::query()->get()->toArray();

        $this->listaRelations = ['menu'];

        parent::__construct();
    }

    public function lista()
    {
        $this->breadcrumb = false;

        $this->filtroRelations = [
            'Menu' => 'menu'
        ];

        $this->filtroTableRelations = [
            'Menu' => 'menus'
        ];

        $this->camposLista = [
            'Id' => 'id',
            'Menu' => 'menu+label',
            'Metodo' => 'name',
            'Etiqueta' => 'label',
            'Icono' => 'icon',
            'Activo' => 'activo',
            'Activo Accion' => 'is_action',
            'Activo Menu' => 'is_menu',
        ];

        parent::lista();
    }

    public function generaInputFiltros (array $datosFiltros): void
    {
        $col = 3;
        $this->sizeColumnasInputsFiltros = $col;

        $datos['Method+name'] = '';
        $datos['Menu+id'] = '';

        foreach ($datosFiltros as $key => $filtro) {
            $datos[$key] = $filtro;
        }

        $placeholder = '';

        $tablaCampo = 'Menu+id';
        $this->htmlInputFiltros[$tablaCampo] = Html::selectConBuscador(
            'selectMenu',
            'id',
            'Menu',
            $tablaCampo,
            $col,
            $this->menus,
            'label',
            $datos[$tablaCampo],
            1,
            ''
        );

        $tablaCampo = 'Method+name';
        $this->htmlInputFiltros[$tablaCampo] = Html::inputText($col,'Metodo',1,$tablaCampo,$placeholder,$datos[$tablaCampo]);
    }

    public function registrar(){
        $this->breadcrumb = true;

        $this->htmlInputFormulario[] = Html::inputTextRequired(3,'Metodo',1,'name');
        $this->htmlInputFormulario[] = Html::inputText(3,'Accion',2,'action');
        $this->htmlInputFormulario[] = Html::inputText(3,'Etiqueta',3,'label');
        $this->htmlInputFormulario[] = Html::inputText(3,'Icono',4,'icon');

        $this->htmlInputFormulario[] = Html::selectConBuscador(
            'id',
            'id',
            'Menu',
            'menu_id',
            3,
            $this->menus,
            'label',
            '-1',
            1
        );

        $this->htmlInputFormulario[] = Html::selectActivo('Activo','activo',3,'-1',2);
        $this->htmlInputFormulario[] = Html::selectActivo('Activo Accion','is_action',3,'-1',3);
        $this->htmlInputFormulario[] = Html::selectActivo('Activo Menu','is_menu',3,'-1',4);

        $this->htmlInputFormulario[] = Html::submit('Registrar',$this->llaveFormulario,3);
    }

    public function modificar()
    {
        parent::modificar();
        $this->breadcrumb = true;

        $registro = $this->registro;
        Html::Debug($registro);exit;
        $this->htmlInputFormulario[] = Html::inputTextRequired(4,'Metodo',1,'name','',$registro['name']);
        $this->htmlInputFormulario[] = Html::inputText(4,'Etiqueta',1,'label','',$registro['label']);
        $this->htmlInputFormulario[] = Html::inputText(4,'Icono',1,'icon','',$registro['icon']);
        $this->htmlInputFormulario[] = Html::selectConBuscador(
            'id',
            'id',
            'Menu',
            'menu_id',
            3,
            $this->menus,
            'label',
            $registro['menu']['id'],
            1
        );
        $this->htmlInputFormulario[] = Html::selectActivo('Activo','activo',3,$registro['activo'],2);
        $this->htmlInputFormulario[] = Html::selectActivo('Activo Accion','is_action',3,$registro['is_action'],3);
        $this->htmlInputFormulario[] = Html::selectActivo('Activo Menu','is_menu',3,$registro['is_menu'],4);

        $this->htmlInputFormulario[] = Html::submit('Modificar',$this->llaveFormulario,4);
    }

}