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
    }

    public function lista()
    {
        $this->breadcrumb = false;

        $this->withs = ['menu'];

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

//        $this->filtrosBaseLista = [
//            ['campo' => 'tabla.compo', 'valor' => valor_campo, 'signoComparacion' => '=', 'relacion' => 'relacion'],
//        ];

        parent::lista();
    }

    public function generaInputFiltros (array $datosFiltros): void
    {
        $col = 3;
        $this->sizeColumnasInputsFiltros = $col;

        $datos['Method+name'] = '';
        $datos['Menu+label'] = '';

        foreach ($datosFiltros as $key => $filtro) {
            $datos[$key] = $filtro;
        }

        $placeholder = '';

        $tablaCampo = 'Menu+label';
        $this->htmlInputFiltros[$tablaCampo] = Html::selectConBuscador(
            'selectMenu',
            'label',
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

}