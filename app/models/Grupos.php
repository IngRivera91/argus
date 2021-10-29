<?php 

namespace App\models;

use Illuminate\Database\Eloquent\Model;

class Grupos extends Model
{

    public function obtenerNombreGrupo(int $grupoId):string
    {
        return  '';
    }

    public function obtenerMetodosAgrupadosPorMenu(int $grupoId):array
    {
        return  [];
    }

    public function obtenerIdsMetodosGrupos(int $grupoId):array
    {
        return  [];
    }
}