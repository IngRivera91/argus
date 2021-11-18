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
        parent::__construct();
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

        parent::lista();
    }

    public function generaInputFiltros (array $datosFiltros): void
    {
        $col = 3;
        $this->sizeColumnasInputsFiltros = $col;

        $datos['Menu+label'] = '';

        foreach ($datosFiltros as $key => $filtro) {
            $datos[$key] = $filtro;
        }

        $tablaCampo = 'Menu+label';
        $placeholder = '';

        $this->htmlInputFiltros[$tablaCampo] = Html::inputText($col,'Menu',1,$tablaCampo,$placeholder,$datos[$tablaCampo]);
    }

}