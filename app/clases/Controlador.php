<?php 

namespace Clase;

class Controlador
{
    public Database $coneccion; // instacia de la coneccion a la base de datos
    public $HTML; // insstancia de la clase que se encarga de crear elementos html comunes
    public $breadcrumb = true; // variable para ver si se muestra o no los breadcrumb
    public $registro; // array en donde se almacena el registro obtenido por el id
    public $registros; // array en donde se almacenas los registros de la lista

    // variables para las listas
    public $lista_usar_filtro = false;
    public $inputs_filtro_lista_cols = 3;
    public $filtro_lista_campos = array();
    public $inputs_filtro_lista = array();
    public $reg_x_pag = 7; // numero de registros a mostrar por pagina
    public $paginador;

    public $nombre_columnas_lista = array('ID'); // almacena los campos que se mostraran en la lista
    public $columnas_lista = array(); // almacena el titulo del campo en la lista
   
    public $inputs = array(); // almacena los objetos html que se muestra en el alta y la modificacion
    public $tabla; 
    public $modelo; 

    public function __construct()
    {
        
    }
}