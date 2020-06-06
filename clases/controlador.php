<?php

    namespace Clase;
    use Ayuda\Redirect;
    use Ayuda\Creador;

    class Controlador{

        public $link; // instacia de la coneccion a la base de datos
        public $errores; // instancia de la clase para mostrar los errores
        public $HTML; // insstancia de la clase que se encarga de crear elementos html comunes
        public $breadcrumb = true; // variable para ver si se muestra o no los breadcrumb
        public $registro; // array en donde se almacena el registro obtenido por el id
        public $registros; // array en donde se almacenas los registros de la lista

        // variables para las listas
        public $lista_usar_filtro = false;
        public $inputs_filtro_lista_cols = 3;
        public $filtro_lista_campos = array();
        public $inputs_filtro_lista = array();
        public $reg_x_pag = 10; // numero de registros a mostrar por pagina
        public $paginador;
        public $order_lista = ''; // sirve para agregar ORDER BY campos ASC a la consulta sql de la lista
        public $filtro_lista = array(); // sirve para agregar un filtros a la consulta de la lista
        public $filtro_custom_lista = ''; // sirve para agregar filtros especiales a la lista
        public $nombre_columnas_lista = array('ID'); // almacena los campos que se mostraran en la lista
        public $columnas_lista = array(); // almacena el titulo del campo en la lista
        public $joins_lista = ''; // sirve para hacer joins a cuando la tabla tiene foreng keys

        public $valida_campos_unicos = array(); // campos que no se pueden repetir en el alta y la modificion
        public $inputs = array(); // almacena los objetos html que se muestra en el alta y la modificacion
        public $tabla; // variable que define la tabla qu se va a ocupar
        public $tabla_modelo; // modelo de de la tabla que se esta ocupoando


        public function __construct(database $link,string $nombre_tabla=null){

            $this->link = $link;
            $this->errores = new Errores();
            $this->HTML = new Html();

            if (!is_null($nombre_tabla)){

                $this->set_tabla($nombre_tabla);

            }

            $this->columnas_lista = array($this->tabla.'.id');
        }


        /*
         *   FUNCIONES PUBLICAS
        */

        public function activa_bd(bool $header = true){
            if (!isset($_GET['registro_id'])){
                $error = $this->errores->datos(1,'Error, registro_id debe existir',
                    __CLASS__,__LINE__,__FILE__,$_GET,__FUNCTION__);
                print_r($error);
                exit;
            }
            $registro_id = $_GET['registro_id'];
            $_POST = array();

            $_POST['usuario_update_id'] = USUARIO_ID;
            $_POST['status'] = 'activo';

            $resultado = $this->tabla_modelo->modifica_por_id($registro_id,$_POST);
            if (isset($resultado['error'])){
                $error = $this->errores->datos(1,'Error, al activar registro',
                    __CLASS__,__LINE__,__FILE__,$resultado,__FUNCTION__);
                print_r($error);
                exit;
            }
            if ($header){
                Redirect::header_url($this->tabla,'lista',SESSION_ID,'');
                exit;
            }
            return $resultado;
        }

        public function alta_bd(bool $header = true){

            if (!isset($_POST[$this->tabla.'_alta_bd'])){
                /*
                 *  se valida que los datos que vienen por POST vengan del formulario adecuado
                */
                Redirect::header_url($this->tabla,'lista',SESSION_ID,
                    'Error, '.$this->tabla.'_alta_bd no encontrado');
            }

            unset($_POST[$this->tabla.'_alta_bd']);

            // se validan los campos que no se deven repetir buscandolos en la tabla
            $this->valida_campos('alta');


            if (!isset($_POST['status'])){
                // si no viene el estatus se le pone como activo por defecto
                $_POST['status'] = 'activo';
            }

            $_POST['usuario_alta_id'] = USUARIO_ID;  // se agrega el id del usuario que esta haciendo el alta
            $_POST['usuario_update_id'] = USUARIO_ID; // al que es un alta se agrega el mismo id de usuario al update

            $resultado = $this->tabla_modelo->alta_bd($_POST); // se inserta los datos a la base

            if (isset($resultado['error'])){
                // si llega a obtenerce algun error se muestra en pantalla
                $error = $this->errores->datos(1,'Error, al registrar',
                    __CLASS__,__LINE__,__FILE__,$resultado,__FUNCTION__);
                print_r($error);
                exit;
            }
            // si no existe algu error se redireciona a la lista de la tabla y se muestra un mensaje
            if ($header){
                Redirect::header_url($this->tabla,'lista',SESSION_ID,'registro exitoso');
                exit;
            }
            return $resultado;

        }// end alta_bd

        public function desactiva_bd(){
            if (!isset($_GET['registro_id'])){
                $error = $this->errores->datos(1,'Error, registro_id debe existir',
                    __CLASS__,__LINE__,__FILE__,$_GET,__FUNCTION__);
                print_r($error);
                exit;
            }
            $registro_id = $_GET['registro_id'];
            $_POST = array();

            $_POST['usuario_update_id'] = USUARIO_ID;
            $_POST['status'] = 'inactivo';

            $resultado = $this->tabla_modelo->modifica_por_id($registro_id,$_POST);
            if (isset($resultado['error'])){
                $error = $this->errores->datos(1,'Error, al desactivar registro',
                    __CLASS__,__LINE__,__FILE__,$resultado,__FUNCTION__);
                print_r($error);
                exit;
            }
            Redirect::header_url($this->tabla,'lista',SESSION_ID,'');
        }

        public function elimina_bd(){
            if (!isset($_GET['registro_id'])){
                $error = $this->errores->datos(1,'Error, registro_id debe existir',
                    __CLASS__,__LINE__,__FILE__,$_GET,__FUNCTION__);
                print_r($error);
                exit;
            }

            $registro_id = $_GET['registro_id'];

            $resultado = $this->tabla_modelo->elimina_por_id($registro_id);
            if (isset($resultado['error'])){
                $error = $this->errores->datos(1,'Error, al eliminar registro',
                    __CLASS__,__LINE__,__FILE__,$resultado,__FUNCTION__);
                print_r($error);
                exit;
            }
            Redirect::header_url($this->tabla,'lista',SESSION_ID,'registro eliminado');
        }// end elimina_bd

        public function lista (){
            $this->breadcrumb = false;

            if ($this->lista_usar_filtro){

                $this->genera_inputs_filtro_lista();

            }

            $limit = $this->obtene_limit_paginador();

            $r_consulta = $this->tabla_modelo->filtro_and($this->filtro_lista,
                $this->columnas_lista,$this->filtro_custom_lista,$this->joins_lista,$limit,$this->order_lista);

            if (isset($r_consulta['error'])){
                $error = $this->errores->datos(1,
                    'Error, al obtener datos de '.$this->tabla,
                    __CLASS__,__LINE__,__FILE__,$r_consulta,__FUNCTION__);
                print_r($error);
                exit;
            }

            $this->registros = $r_consulta['registros'];
        }

        public function modifica(){

            if (!isset($_GET['registro_id'])){
                // valida que se tenga el id del registro a modificar de lo contrario se muestra un error
                $error = $this->errores->datos(1,'Error, registro_id debe existir',
                    __CLASS__,__LINE__,__FILE__,$_GET,__FUNCTION__);
                print_r($error);
                exit;
            }

            $registro_id = $_GET['registro_id']; // se obtine el id del registro por GET

            // se hace la consulta para obtener el registro y se almacena el la variable gobal
            $this->registro = $this->tabla_modelo->obten_data($registro_id);

            if (isset($this->registros['error'])){
                // si existe algun error al hacer la consulta se muestra en un error
                $error = $this->errores->datos(1,'Error, al obtener datos del registro',
                    __CLASS__,__LINE__,__FILE__,$this->registros,__FUNCTION__);
                print_r($error);
                exit;
            }
        }// end modifica

        public function modifica_bd(){

            if (!isset($_GET['registro_id'])){
                $error = $this->errores->datos(1,'Error, registro_id debe existir',
                    __CLASS__,__LINE__,__FILE__,$_GET,__FUNCTION__);
                print_r($error);
                exit;
            }

            $registro_id = $_GET['registro_id'];

            if (!isset($_POST[$this->tabla.'_modifica_bd'])){
                Redirect::header_url($this->tabla,'lista',SESSION_ID,'Error, al modificar registro');
            }

            unset($_POST[$this->tabla.'_modifica_bd']);

            $this->valida_campos('modifica',$registro_id);
            $_POST['usuario_update_id'] = USUARIO_ID;

            $resultado = $this->tabla_modelo->modifica_por_id($registro_id,$_POST);
            if (isset($resultado['error'])){
                $error = $this->errores->datos(1,'Error, al modificar registro',
                    __CLASS__,__LINE__,__FILE__,$resultado,__FUNCTION__);
                print_r($error);
                exit;
            }
            Redirect::header_url($this->tabla,'lista',SESSION_ID,'registro modificado');

        }// end modifica_bd

        public function set_tabla(string $nombre_tabla){
            $this->tabla = $nombre_tabla;
            $this->tabla_modelo = Creador::modelo($this->tabla,$this->link);
        }

        /*
         *   FUNCIONES PRIVADAS
        */

        private function genera_inputs_filtro_lista(){

            if (isset($_COOKIE[$this->tabla.'_lista']) && !isset($_POST[$this->tabla.'_lista'])){
                $_POST = unserialize($_COOKIE[$this->tabla.'_lista']);
            }
            
            if (isset($_POST[$this->tabla.'_lista'])){
                setcookie($this->tabla.'_lista',serialize($_POST));
                foreach ($this->filtro_lista_campos as $label => $name){
                    $value = '';
                    $real_name = $name;
                    $name = str_replace('.','_',$name);
                    if (isset($_POST[$name])){
                        $value = $_POST[$name];
                        $this->filtro_custom_lista .= ' AND '.$real_name.' like \'%'.$value.'%\'';
                    }
                    $this->inputs_filtro_lista[] = $this->HTML->input($label,$name,$this->inputs_filtro_lista_cols,
                        $label,$value,'text','');
                }

            }else{

                foreach ($this->filtro_lista_campos as $label => $name){
                    $name = str_replace('.','_',$name);
                    $this->inputs_filtro_lista[] = $this->HTML->input($label,$name,$this->inputs_filtro_lista_cols,
                        $label,'','text','');
                }

            }

            $this->inputs_filtro_lista[] = $this->HTML->submit('Filtrar',$this->tabla.'_lista',
                $this->inputs_filtro_lista_cols);
        }

        private function obtene_limit_paginador(){
            $n_registros = $this->tabla_modelo->obten_numero_registros($this->filtro_lista,$this->filtro_custom_lista,
                $this->joins_lista);
            $pags = (int) (($n_registros-1) / (int)$this->reg_x_pag );
            $pags++;
            $num_pagina = (int)$this->obtene_numero_pagina();

            if ($num_pagina > $pags){
                Redirect::header_url($this->tabla,'lista',SESSION_ID,'');
                exit;
            }

            $limit = ' LIMIT '.( ( ($num_pagina-1) * (int)$this->reg_x_pag ) ).','.$this->reg_x_pag.' ';

            if ($pags > 1){
                $this->paginador = $this->HTML->paginador($pags,$num_pagina,$this->tabla);
            }

            return $limit;
        }

        private function obtene_numero_pagina(){
            $num_pagina = 1;
            if (isset($_GET['pag'])){
                $num_pagina = (int) $_GET['pag'];
            }
            return (int)$num_pagina;
        }

        private function valida_campos(string $metodo, int $registro_id = -1){
            foreach ($this->valida_campos_unicos as $descripcion => $campo){

                $filtro = array( $this->tabla.'.'.$campo => $_POST[$campo] );

                $r_consulta = $this->tabla_modelo->filtro_and($filtro,array(),
                    ' AND '.$this->tabla.'.id != '.$registro_id);
                if (isset($r_consulta['error'])){
                    $error = $this->errores->datos(1,
                        'Error, al comprobar el campo: '.$campo.' de la tabla: '.$this->tabla,
                        __CLASS__,__LINE__,__FILE__,$r_consulta,__FUNCTION__);
                    print_r($error);
                    exit;
                }

                if ((int)$r_consulta['n_registros'] != 0){
                    if ($registro_id < 0){
                        Redirect::header_url($this->tabla,$metodo,SESSION_ID,
                            'Error, '.$descripcion.' ya registrad@');
                        exit;
                    }
                    Redirect::header_url($this->tabla,$metodo,SESSION_ID,
                        'Error, '.$descripcion.' ya registrad@',$registro_id);
                    exit;

                }

            }// end foreach
        }

    }// end class controlador