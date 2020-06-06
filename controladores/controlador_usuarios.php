<?php

namespace Controlador;
use Clase\Controlador;
use Clase\Database;

use Modelo\Grupos;
use Modelo\Usuarios;

/*** controlador core ***/

class Controlador_Usuarios extends Controlador{

    public $grupos = array();
    public $grupo_modelo;
    public $sexo = array();

    public function __construct(database $link){

        parent::__construct();
        $this->link = $link;
        $this->tabla = 'usuarios';
        $this->tabla_modelo = new Usuarios($this->link);

        $this->configuracion();
    }

    private function configuracion(){

        $this->sexo[] = array('id' => 'masculino','descripcion' => 'Masculino');
        $this->sexo[] = array('id' => 'femenino','descripcion' => 'Femenino');

        $this->grupo_modelo = new Grupos($this->link);

        $this->grupos = $this->grupo_modelo->filtro_and(array('status'=>'activo'),
            array('id','descripcion_grupo'))['registros'];

        $this->valida_campos_unicos = array(
            'nombre' => 'nombre_completo',
            'correo' => 'email',
            'usuario' => 'user'
        );

    }// end configuracion

    public function alta(){

        $this->inputs[] = $this->HTML->input('Nombre','nombre_completo',4,
            'Nombre');

        $this->inputs[] = $this->HTML->input('Correo','email',4,'Correo');

        $this->inputs[] = $this->HTML->input('Usuario','user',4,'Usuario');

        $this->inputs[] = $this->HTML->select('Sexo','sexo',
        4,$this->sexo,'descripcion');

        $this->inputs[] = $this->HTML->input('Contraseña','password',4,
            'Contraseña');

        $this->inputs[] = $this->HTML->select('Grupo','grupo_id',
            4,$this->grupos,'descripcion_grupo');

        $this->inputs[] = $this->HTML->submit('Registrar','usuarios_alta_bd',4);

    }// end alta

    public function modifica(){
        parent::modifica();
        $this->inputs[] = $this->HTML->input('Nombre','nombre_completo',4,
            'Nombre',$this->registro['nombre_completo']);

        $this->inputs[] = $this->HTML->input('Correo','email',4,'Correo',
            $this->registro['email']);

        $this->inputs[] = $this->HTML->input('Usuario','user',4,'Usuario',
            $this->registro['user']);

        $this->inputs[] = $this->HTML->select('Sexo','sexo',
            4,$this->sexo,'descripcion',$this->registro['sexo']);

        $this->inputs[] = $this->HTML->input('Contraseña','password',4,
            'Contraseña',$this->registro['password']);

        $this->inputs[] = $this->HTML->select('Grupo','grupo_id',
            4,$this->grupos,'descripcion_grupo',$this->registro['grupo_id']);

        $this->inputs[] = $this->HTML->submit('Modificar','usuarios_modifica_bd',4);
    }// end modifica

    public function lista(){
        // configuracion de el filtro para la lista
        $this->lista_usar_filtro = true;
        $this->inputs_filtro_lista_cols = 3;
        $this->filtro_lista_campos = array(
            'Nombre' => 'usuarios.nombre_completo',
            'Usuario' => 'usuarios.user',
            'Correo' => 'usuarios.email',
            'Grupo' => 'grupos.descripcion_grupo'

        );
        // termina configuracion de el filtro para la lista

        $this->nombre_columnas_lista = array('ID','Nombre','Usuario','Correo','Grupo','Estatus');
        $this->columnas_lista = array('usuarios.id','nombre_completo','user','email','grupos.descripcion_grupo',
            'usuarios.status');
        $this->joins_lista = ' LEFT JOIN grupos ON usuarios.grupo_id = grupos.id ';

        parent::lista();

    }// end lista


}