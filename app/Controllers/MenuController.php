<?php 

namespace App\Controllers;

use App\class\BaseController;
use App\Models\Menu;

class MenuController extends BaseController
{
    public function lista()
    {
        $this->camposLista = [
            'Id' => 'id',
            'Menu' => 'name',
            'Etiqueta' => 'label',
            'Icono' => 'icon',
            'Activo' => 'activo'
        ];

        $this->registros = Menu::all()->toArray();
    }

}