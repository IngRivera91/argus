<?php

namespace App\Controllers;

use App\Class\Auth;
use App\Class\Html;
use App\Class\Redireccion;
use App\Models\User;
use Illuminate\Database\Eloquent\Builder;

class PasswordController
{
    public array $htmlInputFormulario = [];
    public bool $breadcrumb = false;
    public string $llaveFormulario;

    public function cambiarPassword()
    {
        $this->llaveFormulario = md5(SESSION_ID);
        $this->htmlInputFormulario[] = Html::inputPassword(4,'Contraseña Actual','passwordActual','passwordActual','','',true);
        $this->htmlInputFormulario[] = Html::inputPassword(4,'Nueva Contraseña','password','passwordNueva','','',true);
    }

    public function cambiarPasswordBd()
    {
        $datos = $_POST;
        $nombreLlaveFormulario = md5(SESSION_ID);
        if (!isset($datos[$nombreLlaveFormulario])) {
            Redireccion::enviar('Password','cambiarPassword',SESSION_ID);
        }

        $result = User::query()
            ->where('users.id',USUARIO_ID)
            ->where('users.password',Auth::encryptPassword($datos['passwordActual']))
            ->get();

        if ($result->count() != 1) {
            Redireccion::enviar('Password','cambiarPassword',SESSION_ID,'Contraseña incorrecta');
        }

        $User = $result[0];

        $User->password = Auth::encryptPassword($datos['passwordNueva']);
        $User->save();

        Redireccion::enviar('Inicio','index',SESSION_ID,'se cambio la contraseña');

    }
}
