<?php 

namespace Controlador;

use Ayuda\Html;
use Clase\Controlador;
use Interfas\Database;
use Modelo\Grupos AS ModeloGrupos;

class grupos extends Controlador
{
    public function __construct(Database $coneccion)
    {
        $modelo = new ModeloGrupos($coneccion);
        $nombreMenu = 'grupos';
        $this->breadcrumb = false;

        $camposLista = [
            'Id' => 'grupos_id',
            'Grupo' => 'grupos_nombre',
            'Activo' => 'grupos_activo'
        ];

        $camposFiltrosLista = [
            'Grupo' => 'grupos.nombre'
        ];

        parent::__construct($modelo, $nombreMenu, $camposLista, $camposFiltrosLista);
    }

    public function registrar()
    {
        $this->breadcrumb = true;
        
        $this->htmlInputFormulario[] = Html::input('Grupo','nombre',4);

        $this->htmlInputFormulario[] = Html::submit('Registrar',$this->llaveFormulario,4);
    }

    public function modificar()
    {
        parent::modificar();
        $this->breadcrumb = true;

        $nombreMenu = $this->nombreMenu;
        $registro = $this->registro;

        $this->htmlInputFormulario[] = Html::input('Grupo','nombre',4,$registro["{$nombreMenu}_nombre"]);

        $this->htmlInputFormulario[] = Html::submit('Modificar',$this->llaveFormulario,4);
    }

}