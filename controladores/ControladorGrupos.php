<?php

namespace Controlador;

use Ayuda\Redirect;

use Clase\Controlador;
use Clase\Database;

use Modelo\Grupos;
use Modelo\MetodoGrupo;


/*** controlador core ***/

class ControladorGrupos extends Controlador {
    public $grupo_modelo;
    public $metodos_menu;
    public $nombre_grupo;
    public function __construct(Database $link){

        parent::__construct();
        $this->link = $link;
        $this->tabla = 'grupos';
        $this->tabla_modelo = new Grupos($this->link);

        $this->configuracion();
        $this->grupo_modelo = new Grupos($this->link);
    }

    private function configuracion(){

        $this->valida_campos_unicos = array(
            'grupo' => 'descripcion_grupo'
        );

    }// end configuracion

    public function alta(){
        $this->inputs[] = $this->HTML->input('Grupo','descripcion_grupo',4,
            'Grupo');
        $this->inputs[] = $this->HTML->submit('Registrar','grupos_alta_bd',4);
    }

    public function asigna_permisos(){
        if (!isset($_GET['registro_id'])){
            $error = $this->errores->datos(1,'Error, registro_id debe existir',__CLASS__,__LINE__,__FILE__,$_GET,__FUNCTION__);

            if ($this->IsTest){
                return $error;
            }
            if (EN_PRODUCCION){
                $error = $this->errores->limpia_html_error($error);
                Redirect::header_url($this->tabla,'lista',SESSION_ID,$error['mensaje']);
            }

            print_r($error);
            exit;
        }

        if ($_GET['registro_id'] < 1){
            $error = $this->errores->datos(1,'Error, registro_id debe ser un numero entero positivo',__CLASS__,__LINE__,__FILE__,$_GET,__FUNCTION__);

            if ($this->IsTest){
                return $error;
            }
            if (EN_PRODUCCION){
                $error = $this->errores->limpia_html_error($error);
                Redirect::header_url($this->tabla,'lista',SESSION_ID,$error['mensaje']);
            }

            print_r($error);
            exit;
        }

        $this->breadcrumb = true;
        $this->metodos_menu = $this->grupo_modelo->obten_metodos();
        $this->nombre_grupo = $this->grupo_modelo->obten_nombre_grupo();
    }

    public function alta_permiso(){
        $respuesta = true;
        $error = '';
        if (!isset($_GET['metodo_id'])){
            $error = $this->errores->datos(1,'Error, metodo_id debe existir',__CLASS__,__LINE__,__FILE__,$_GET,__FUNCTION__);
            $respuesta = false;
        }
        $metodo_id = $_GET['metodo_id'];

        if (!isset($_GET['grupo_id'])){
            $error = $this->errores->datos(1,'Error, grupo_id debe existir',__CLASS__,__LINE__,__FILE__,$_GET,__FUNCTION__);
            $respuesta = false;
        }
        $grupo_id = $_GET['grupo_id'];

        $metodo_grupo_modelo = new MetodoGrupo($this->link);
        $registro = array( 'grupo_id' => $grupo_id , 'metodo_id' => $metodo_id , 'status' => 'activo',
            'usuario_alta_id' => USUARIO_ID ,'usuario_update_id' => USUARIO_ID);
        $resultado = $metodo_grupo_modelo->alta_bd($registro);

        if (isset($resultado['error'])){
            $error = $this->errores->datos(1,'Error, al eliminar permiso',__CLASS__,__LINE__,__FILE__,$resultado,__FUNCTION__);
            $respuesta = false;
        }

        header('Content-Type: application/json');
        $json = json_encode(array('respuesta' => $respuesta,'error' => $error));
        echo $json;
        exit;
    }

    public  function baja_permiso(){
        $respuesta = true;
        $error = '';
        if (!isset($_GET['metodo_id'])){
            $error = $this->errores->datos(1,'Error, metodo_id debe existir',__CLASS__,__LINE__,__FILE__,$_GET,__FUNCTION__);
            $respuesta = false;
        }
        $metodo_id = $_GET['metodo_id'];

        if (!isset($_GET['grupo_id'])){
            $error = $this->errores->datos(1,'Error, grupo_id debe existir',__CLASS__,__LINE__,__FILE__,$_GET,__FUNCTION__);
            $respuesta = false;
        }
        $grupo_id = $_GET['grupo_id'];

        $metodo_grupo_modelo = new MetodoGrupo($this->link);
        $filtro = array( 'metodo_id' => $metodo_id , 'grupo_id' => $grupo_id );
        $resultado = $metodo_grupo_modelo->elimina_con_filtro_and($filtro);

        if (isset($resultado['error'])){
            $error = $this->errores->datos(1,'Error, al eliminar permiso',__CLASS__,__LINE__,__FILE__,$resultado,__FUNCTION__);
            $respuesta = false;
        }

        header('Content-Type: application/json');
        $json = json_encode(array('respuesta' => $respuesta,'error' => $error));
        echo $json;
        exit;
    }

    public function modifica(){
        parent::modifica();
        $this->inputs[] = $this->HTML->input('Grupo','descripcion_grupo',4,
            'Grupo',$this->registro['descripcion_grupo']);

        $this->inputs[] = $this->HTML->submit('Modificar','grupos_modifica_bd',4);

    }// end modifica

    public function lista(){
        // configuracion de el filtro para la lista
        $this->lista_usar_filtro = true;
        $this->inputs_filtro_lista_cols = 4;
        $this->filtro_lista_campos = array(
            'Grupo' => 'grupos.descripcion_grupo'
        );
        // termina configuracion de el filtro para la lista

        $this->nombre_columnas_lista = array('ID','Grupo','Estatus');
        $this->columnas_lista = array('grupos.id','grupos.descripcion_grupo','grupos.status');
        $this->joins_lista = '';

        parent::lista();

    }// end lista

}