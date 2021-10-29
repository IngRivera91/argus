<?php 

namespace App\models;

use Illuminate\Database\Eloquent\Model;

class Sessiones extends Model
{

    public function buscarPorSessionId(string $sessionId):array
    {
        return  [];
    }

    public function eliminarConSessionId(string $sessionId):void
    {
        return; $this;
    }
}