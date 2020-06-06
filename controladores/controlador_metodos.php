<?php

namespace Controlador;
use Clase\Controlador;
use Clase\Database;
use Modelo\Menus;

/*** controlador core ***/

class Controlador_Metodos extends Controlador {

    public $menu_modelo;
    public $menus = array();

    public function __construct(database $link){

        parent::__construct($link,'metodos');

        $this->configuracion();
    }

    private function configuracion(){

        $this->menu_modelo = new Menus($this->link);

        $this->menus = $this->menu_modelo->filtro_and(array('status'=>'activo'),
            array('id','descripcion_menu'))['registros'];

        $this->valida_campos_unicos = array();

    }// end configuracion

    public function alta(){

        $this->inputs[] = $this->HTML->select('Menu','menu_id',
            3,$this->menus,'descripcion_menu');

        $this->inputs[] = $this->HTML->input('Descripcion','descripcion_metodo',3,
            'Descripcion');

        $this->inputs[] = $this->HTML->input('Label Menu','label_metodo',3,
            'Label Menu');

        $this->inputs[] = $this->HTML->input('Label Accion','label_accion',3,
            'Label Accion');

        $this->inputs[] = $this->HTML->input('Icon Accion','icon_accion',3,
            'glyphicon glyphicon');

        $this->inputs[] = $this->HTML->select_status('Estatus Menu','status_menu',3,'inactivo');

        $this->inputs[] = $this->HTML->select_status('Estatus Accion','status_accion',3,'inactivo');

        $this->inputs[] = $this->HTML->submit('Registrar','metodos_alta_bd',3);
    }

    public function modifica(){
        parent::modifica();
        $this->inputs[] = $this->HTML->select('Menu','menu_id',
            3,$this->menus,'descripcion_menu',$this->registro['menu_id']);

        $this->inputs[] = $this->HTML->input('Descripcion','descripcion_metodo',3,
            'Descripcion',$this->registro['descripcion_metodo']);

        $this->inputs[] = $this->HTML->input('Label Menu','label_metodo',3,
            'Label Menu',$this->registro['label_metodo']);

        $this->inputs[] = $this->HTML->input('Label Accion','label_accion',3,
            'Label Accion',$this->registro['label_accion']);

        $this->inputs[] = $this->HTML->input('Icon Accion','icon_accion',3,
            'glyphicon glyphicon',$this->registro['icon_accion']);

        $this->inputs[] = $this->HTML->select_status('Estatus Menu','status_menu',3,
            $this->registro['status_menu']);

        $this->inputs[] = $this->HTML->select_status('Estatus Accion','status_accion',3,
            $this->registro['status_accion']);

        $this->inputs[] = $this->HTML->submit('Modificar','metodos_modifica_bd',3);

    }// end modifica

    public function lista(){
        // configuracion de el filtro para la lista
        $this->lista_usar_filtro = true;
        $this->inputs_filtro_lista_cols = 3;
        $this->filtro_lista_campos = array(
            'Menu' => 'menus.descripcion_menu',
            'Descripcion' => 'descripcion_metodo',
            'Label Menu' => 'label_metodo',

        );
        // termina configuracion de el filtro para la lista

        $this->nombre_columnas_lista = array('ID','Menu','Descripcion','Label Menu','Label Accion','Icon Accion',
            'Estatus Menu','Estatus Accion','Estatus');

        $this->columnas_lista = array('metodos.id','menus.descripcion_menu','metodos.descripcion_metodo',
            'metodos.label_metodo','metodos.label_accion','metodos.icon_accion','metodos.status_menu',
            'metodos.status_accion','metodos.status');

        $this->joins_lista = ' LEFT JOIN menus ON menus.id = metodos.menu_id ';

        parent::lista();

    }// end lista

}