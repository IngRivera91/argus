<?php 

namespace Controlador;

use Ayuda\Html;
use Clase\Modelo;
use Clase\Controlador;
use Interfas\Database;
use Error\Base AS ErrorBase;
use Modelo\Menus AS ModeloMenus;
use Modelo\Metodos AS ModeloMetodos;

class metodos extends Controlador
{
    private array $menuRegistros;
    private Modelo $Metodos;
    private Modelo $Menus;

    public function __construct(Database $coneccion)
    {
        $this->Metodos = new ModeloMetodos($coneccion);
        $this->Menus = new ModeloMenus($coneccion);

        try {
            $columas = ['menus_id','menus_nombre'];
            $this->menuRegistros = $this->Menus->buscarTodo($columas,[],'',true)['registros'];
        } catch (ErrorBase $e) {
            $error = new ErrorBase('Error al obtner los menus');
            $error->muestraError();
        }

        $nombreMenu = 'metodos';
        $this->breadcrumb = false;

        $camposLista = [
            'Id' => 'metodos_id',
            'Menu' => 'menus_nombre',
            'Metodo' => 'metodos_nombre',
            'Etiqueta' => 'metodos_etiqueta',
            'Icono' => 'metodos_icono',
            'Activo' => 'metodos_activo',
            'Activo Accion' => 'metodos_activo_accion',
            'Activo Menu' => 'metodos_activo_menu'
        ];

        $camposFiltrosLista = [
            'Menu' => 'menus.nombre',
            'Metodo' => 'metodos.nombre'
        ];

        parent::__construct($this->Metodos, $nombreMenu, $camposLista, $camposFiltrosLista);
    }

    public function registrar()
    {
        $this->breadcrumb = true;

        $this->htmlInputFormulario[] = Html::inputTextRequired(4,'Metodo',1,'nombre');
        $this->htmlInputFormulario[] = Html::inputText(4,'Etiqueta',1,'etiqueta');
        $this->htmlInputFormulario[] = Html::inputText(4,'Icono',1,'icono');
        $this->htmlInputFormulario[] = Html::selectConBuscador('menus','Menu', 'menu_id', 3,$this->menuRegistros,'menus_nombre','-1',1);
        $this->htmlInputFormulario[] = Html::selectActivo('Activo','activo',3,'-1',2);
        $this->htmlInputFormulario[] = Html::selectActivo('Activo Accion','activo_accion',3,'-1',3);
        $this->htmlInputFormulario[] = Html::selectActivo('Activo Menu','activo_menu',3,'-1',4);

        $this->htmlInputFormulario[] = Html::submit('Registrar',$this->llaveFormulario,4);
    }

    public function modificar()
    {
        parent::modificar();
        $this->breadcrumb = true;

        $nombreMenu = $this->nombreMenu;
        $registro = $this->registro;

        $this->htmlInputFormulario[] = Html::inputTextRequired(4,'Metodo',1,'nombre','',$registro["{$nombreMenu}_nombre"]);
        $this->htmlInputFormulario[] = Html::inputText(4,'Etiqueta',1,'etiqueta','',$registro["{$nombreMenu}_etiqueta"]);
        $this->htmlInputFormulario[] = Html::inputText(4,'Icono',1,'icono','',$registro["{$nombreMenu}_icono"]);
        $this->htmlInputFormulario[] = Html::selectConBuscador(
            'menus',
            'Menu', 
            'menu_id', 
            3,
            $this->menuRegistros,
            'menus_nombre',
            $registro["{$nombreMenu}_menu_id"],
            1
        );
        $this->htmlInputFormulario[] = Html::selectActivo('Activo','activo',3,$registro["{$nombreMenu}_activo"],2);
        $this->htmlInputFormulario[] = Html::selectActivo('Activo Accion','activo_accion',3,$registro["{$nombreMenu}_activo_accion"],3);
        $this->htmlInputFormulario[] = Html::selectActivo('Activo Menu','activo_menu',3,$registro["{$nombreMenu}_activo_menu"],4);

        $this->htmlInputFormulario[] = Html::submit('Modificar',$this->llaveFormulario,4);
    }

}