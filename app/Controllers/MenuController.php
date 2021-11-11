<?php 

namespace App\Controllers;

use App\class\BaseController;
use App\Models\Menu;

class MenuController extends BaseController
{
    public function __construct()
    {
        $this->model = Menu::class;
    }

    public function lista()
    {
        $this->camposLista = [
            'Id' => 'id',
            'Menu' => 'name',
            'Etiqueta' => 'label',
            'Icono' => 'icon',
            'Activo' => 'activo'
        ];

        parent::lista();
    }

}