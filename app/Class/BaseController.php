<?php

namespace App\Class;

use Illuminate\Database\Eloquent\Collection;

class BaseController
{

    public array  $camposLista;
    public int $registrosPorPagina = 10;
    public $breadcrumb = true;
    public $registro;
    public $registros;


}