<?php 

namespace Controlador;

use Ayuda\Html;
use Clase\Modelo;
use Modelo\Usuarios;
use Ayuda\Redireccion;
use Interfas\Database;
use Error\Base AS ErrorBase;

class password
{
    private Modelo $Usuarios;
    public bool   $breadcrumb = false;
    private string $llaveFormulario; 

    public function __construct(Database $coneccion)
    {
        $this->llaveFormulario = md5(SESSION_ID);
        $this->Usuarios = new Usuarios($coneccion);
    }

    public function cambiarPassword()
    {
        $this->htmlInputFormulario[] = Html::inputPassword(4,'Contraseña Actual',1,'passwordActual','','',true);
        $this->htmlInputFormulario[] = Html::inputPassword(4,'Nueva Contraseña',1,'passwordNueva','','',true);
        $this->htmlInputFormulario[] = Html::inputPassword(4,' Confirmar Contraseña',1,'confirmaPasswordNueva','','',true);
        $this->htmlInputFormulario[] = Html::submit('cambiar contraseña',$this->llaveFormulario,4);
    }

    public function cambiarPasswordBd()
    {
        $this->htmlInputFormulario[] = Html::inputPassword(4,'Contraseña Actual',1,'passwordActual','','',true);
        $this->htmlInputFormulario[] = Html::inputPassword(4,'Nueva Contraseña',1,'passwordNueva','','',true);
        $this->htmlInputFormulario[] = Html::inputPassword(4,' Confirmar Contraseña',1,'confirmaPasswordNueva','','',true);
        $this->htmlInputFormulario[] = Html::submit('cambiar contraseña',$this->llaveFormulario,4);
    }
}