<?php

namespace App\Class;

use Illuminate\Database\Eloquent\Model;

class BaseController
{

    public array  $camposLista;
    public int $registrosPorPagina = 10;
    public $breadcrumb = true;
    public $registro;
    public $registros;
    public $model;

    public function lista()
    {
        $this->registros = $this->model::all()->toArray();
    }


}