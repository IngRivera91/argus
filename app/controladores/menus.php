<?php 

namespace Controlador;

use Ayuda\Html;
use Clase\Controlador;
use Interfas\Database;
use Interfas\GeneraConsultas;
use Modelo\Menus AS ModeloMenus;

class menus extends Controlador
{
    public function __construct(Database $coneccion, GeneraConsultas $generaConsulta)
    {
        $modelo = new ModeloMenus($coneccion,$generaConsulta);
        $nombreMenu = 'menus';
        $this->breadcrumb = false;

        $camposLista = [
            'Id' => 'menus_id',
            'Menu' => 'menus_nombre',
            'Etiqueta' => 'menus_etiqueta',
            'Icono' => 'menus_icono',
            'Activo' => 'menus_activo'
        ];

        $camposFiltrosLista = [
            'Menu' => 'menus.nombre'
        ];

        parent::__construct($modelo, $nombreMenu, $camposLista, $camposFiltrosLista);
    }

    public function registrar()
    {
        $this->breadcrumb = true;
        
        $this->htmlInputFormulario[] = Html::input('Menu','nombre',4);
        $this->htmlInputFormulario[] = Html::input('Etiqueta','etiqueta',4);
        $this->htmlInputFormulario[] = Html::input('Icon','icono',4);

        $this->htmlInputFormulario[] = Html::submit('Registrar',$this->llaveFormulario,4);
    }

    public function modificar()
    {
        parent::modificar();
        $this->breadcrumb = true;

        $nombreMenu = $this->nombreMenu;
        $registro = $this->registro;

        $this->htmlInputFormulario[] = Html::input('Menu','nombre',4,$registro["{$nombreMenu}_nombre"]);
        $this->htmlInputFormulario[] = Html::input('Etiqueta','etiqueta',4,$registro["{$nombreMenu}_etiqueta"]);
        $this->htmlInputFormulario[] = Html::input('Icon','icono',4,$registro["{$nombreMenu}_icono"]);

        $this->htmlInputFormulario[] = Html::submit('Modificar',$this->llaveFormulario,4);
    }

}