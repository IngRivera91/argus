<?php 

namespace Controlador;

use Ayuda\Html;
use Clase\Controlador;
use Interfas\Database;
use Interfas\GeneraConsultas;
use Error\Base AS ErrorBase;
use Modelo\Metodos AS ModeloMetodos;
use Modelo\Menus AS ModeloMenus;

class metodos extends Controlador
{
    private array $menuRegistros;

    public function __construct(Database $coneccion, GeneraConsultas $generaConsulta)
    {
        $modelo = new ModeloMetodos($coneccion,$generaConsulta);
        $modeloMenus = new ModeloMenus($coneccion,$generaConsulta);

        try {
            $columas = ['menus_id','menus_nombre'];
            $this->menuRegistros = $modeloMenus->buscarTodo($columas,[],'',true)['registros'];
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

        parent::__construct($modelo, $nombreMenu, $camposLista, $camposFiltrosLista);
    }

    public function registrar()
    {
        $this->breadcrumb = true;
        
        $this->htmlInputFormulario[] = Html::input('Metodo','nombre',4,'Metodo');
        $this->htmlInputFormulario[] = Html::input('Etiqueta','etiqueta',4,'Etiqueta');
        $this->htmlInputFormulario[] = Html::input('Icon','icono',4,'Icon');
        $this->htmlInputFormulario[] = Html::selectConBuscador('menus','Menu', 'menu_id', 4,$this->menuRegistros,'menus_nombre');

        $this->htmlInputFormulario[] = Html::submit('Registrar',$this->llaveFormulario,4);
    }

}