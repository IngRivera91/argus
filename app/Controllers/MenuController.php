<?php 

namespace App\Controllers;

use App\class\BaseController;
use App\Class\Html;
use App\Models\Menu;

class MenuController extends BaseController
{
    public function __construct()
    {
        $this->model = Menu::class;
        $this->nameController = 'Menu';
    }

    public function lista()
    {
        $this->breadcrumb = false;

        $this->camposLista = [
            'Id' => 'id',
            'Menu' => 'name',
            'Etiqueta' => 'label',
            'Icono' => 'icon',
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

        $datos['menus+label'] = '';

        foreach ($datosFiltros as $key => $filtro) {
            $datos[$key] = $filtro;
        }

        $tablaCampo = 'menus+label';
        $placeholder = '';

        $this->htmlInputFiltros[$tablaCampo] = Html::inputText($col,'Menu',1,$tablaCampo,$placeholder,$datos[$tablaCampo]);
    }

}