<?php
/*** controlador core ***/

class controlador_menus extends controlador {

    public function __construct(database $link){

        parent::__construct($link,'menus');

        $this->configuracion();
    }

    private function configuracion(){

        $this->valida_campos_unicos = array(
            'grupo' => 'descripcion_menu'
        );

    }// end configuracion

    public function alta(){
        $this->inputs[] = $this->HTML->input('Menu','descripcion_menu',4,
            'Menu');

        $this->inputs[] = $this->HTML->input('Etiqueta','label_menu',4,
            'Etiqueta');

        $this->inputs[] = $this->HTML->input('Icon','icon_menu',4,
            'Icon');


        $this->inputs[] = $this->HTML->submit('Registrar','menus_alta_bd',4);
    }

    public function modifica(){
        parent::modifica();
        $this->inputs[] = $this->HTML->input('Menu','descripcion_menu',4,
            'Menu',$this->registro['descripcion_menu']);

        $this->inputs[] = $this->HTML->input('Etiqueta','label_menu',4,
            'Etiqueta',$this->registro['label_menu']);

        $this->inputs[] = $this->HTML->input('Icon','icon_menu',4,
            'Icon',$this->registro['icon_menu']);

        $this->inputs[] = $this->HTML->submit('Modificar','menus_modifica_bd',4);

    }// end modifica

    public function lista(){
        // configuracion de el filtro para la lista
        $this->lista_usar_filtro = true;
        $this->inputs_filtro_lista_cols = 4;
        $this->filtro_lista_campos = array(
            'Menu' => 'menus.descripcion_menu'
        );
        // termina configuracion de el filtro para la lista

        $this->nombre_columnas_lista = array('ID','Menu','Etiqueta','Icono','Estatus');
        $this->columnas_lista = array('menus.id','menus.descripcion_menu','menus.label_menu','icon_menu','menus.status');
        $this->joins_lista = '';

        parent::lista();

    }// end lista

}