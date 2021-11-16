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

        $this->camposLista = [
            'Id' => 'id',
            'Metodo' => 'name',
            'Activo' => 'activo'
        ];

//        $this->filtrosBaseLista = [
//            ['campo' => 'menus.id', 'valor' => 1, 'signoComparacion' => '='],
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