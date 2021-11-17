<?php

namespace App\Controllers;

use App\class\BaseController;
use App\Class\Html;
use App\Models\Method;

class MethodController extends BaseController
{
    public function __construct()
    {
        $this->model = Method::class;
        $this->nameController = 'Method';
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

        $datos['Method+label'] = '';

        foreach ($datosFiltros as $key => $filtro) {
            $datos[$key] = $filtro;
        }

        $tablaCampo = 'Method+label';
        $placeholder = '';

        $this->htmlInputFiltros[$tablaCampo] = Html::inputText($col,'Metodo',1,$tablaCampo,$placeholder,$datos[$tablaCampo]);
    }

}