<?php
/*** modelo core ***/

class Grupos extends Modelo {
    private $metodo_modelo;
    public function __construct(database $link){
        $tabla = 'grupos';
        parent::__construct($link, $tabla);
        $this->metodo_modelo = new Metodos($this->link);
    }

    public function obten_metodos(){
        $ids_metodos_grupo = $this->ids_metodos_grupo();
        $columnas = array('metodos.id AS id','metodos.descripcion_metodo AS metodo','menus.descripcion_menu AS menu');
        $joins = ' LEFT JOIN menus ON menus.id = metodos.menu_id ';
        $resultado = $this->metodo_modelo->filtro_and(array(),$columnas,'',$joins,'',
            ' ORDER BY menus.descripcion_menu ASC');

        if (isset($resultado['error'])){
            return $this->errores->datos(1,'Error, al obtener los metodos',__CLASS__,
                __LINE__,__FILE__,$resultado,__FUNCTION__);
        }
        $resultado = $resultado['registros'];

        $menus = array();

        foreach ( $resultado as $item){
            if (!isset($menus[$item['menu']])){
                $menus[$item['menu']] = array();
            }
            $estado = 0;
            if (in_array($item['id'],$ids_metodos_grupo)){
                $estado = 1;
            }
            $menus[$item['menu']][] = array( 'id' => $item['id'] , 'metodo' => $item['metodo'] , 'estado' => $estado);
        }
        return $menus;
    }

    public function obten_nombre_grupo(){
        $grupo_id = $_GET['registro_id'];
        $resultado = $this->filtro_and(array('grupos.id' => $grupo_id),
            array('grupos.descripcion_grupo AS nombre'))['registros'][0]['nombre'];
        return $resultado;
    }

    private function ids_metodos_grupo(){
        $metodos_grupo_modelo = new metodo_grupo($this->link);
        $grupo_id = $_GET['registro_id'];
        $filtro = array( 'grupo_id' => $grupo_id);
        $resultado = $metodos_grupo_modelo->filtro_and($filtro,array('metodo_id AS id'))['registros'];
        $ids =array();
        foreach ($resultado as $item){
            $ids[] = $item['id'];
        }
        return $ids;
    }

}