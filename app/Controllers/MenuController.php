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

    public function registrar()
    {
        $this->breadcrumb = true;

        $this->htmlInputFormulario[] = Html::inputTextRequired(4,'Menu',1,'name');
        $this->htmlInputFormulario[] = Html::inputTextRequired(4,'Etiqueta',1,'label');
        $this->htmlInputFormulario[] = Html::inputTextRequired(4,'Icono',1,'icon');
        $this->htmlInputFormulario[] = Html::selectActivo('Activo','activo',4,'-1',2);

        $this->htmlInputFormulario[] = Html::submit('Registrar',$this->llaveFormulario,4);
    }

    public function modificar()
    {
        parent::modificar();
        $this->breadcrumb = true;

        $registro = $this->registro;

        $this->htmlInputFormulario[] = Html::inputTextRequired(4,'Menu',1,'name','',$registro['name']);
        $this->htmlInputFormulario[] = Html::inputTextRequired(4,'Etiqueta',1,'label','',$registro['label']);
        $this->htmlInputFormulario[] = Html::inputTextRequired(4,'Icono',1,'icon','',$registro['icon']);
        $this->htmlInputFormulario[] = Html::selectActivo('Activo','activo',4,$registro['activo'],2);

        $this->htmlInputFormulario[] = Html::submit('Modificar',$this->llaveFormulario,4);
    }

}