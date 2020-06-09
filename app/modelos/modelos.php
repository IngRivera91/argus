<?php
class modelos{ //PRUEBAS FINALIZADAS
    public string $tabla;
    public PDO $link;
    public int $registro_id=-1;
    public errores $errores;
    public array $sql_seguridad_por_cliente ;
    public array $sql_seguridad_por_ubicacion ;
    public array $campos_obligatorios=array('status');
    public array $campos_tabla = array();
    public array $extensiones_imagen = array('jpg','jpeg','png');
    public array $registro;
    public array $registro_upd;

    protected array $patterns;
    protected validacion $validaciones;

    private string  $campos;
    private array   $campos_modifica;
    private  string  $transaccion = '';
    private string  $valores;
    private array $columnas_extra;
    private array $tipo_campos;
    private array $columnas;
    private array $sub_querys;
    public bool $aplica_transaccion_inactivo;
    public int $usuario_id = -1;
    public string $campos_sql;
    public string $consulta;
    public array $filtro;
    public array $order = array();
    public int $limit = 0;
    public int $offset = 0;
    public array $hijo = array();

    public function __construct(PDO $link,string $tabla, array $columnas_extra = array(),
                                array $campos_obligatorios= array(), array $tipo_campos = array(),
                                $columnas = array(), $sub_querys = array(), bool $aplica_transaccion_inactivo = true){
        $this->errores = new errores();
        $this->validaciones = new validacion();
        $this->link = $link;
        $this->tabla = $tabla;
        $this->columnas_extra = $columnas_extra;
        $this->columnas = $columnas;

        if(isset($_SESSION['usuario_id'])){
            $this->usuario_id = (int)$_SESSION['usuario_id'];
        }
        if($tabla !=='') {
            $this->campos_tabla = $this->obten_columnas($tabla);
            if (isset($this->campos_tabla['error'])) {
                $error = $this->errores->datos(1, 'Error al obtener columnas', __CLASS__, __LINE__,
                    __FILE__, $this->campos_tabla, __FUNCTION__);
                print_r($error);
                die('Error');
            }
        }
        $campos_obligatorios_parciales = array('accion_id','codigo','descripcion','grupo_id','seccion_menu_id',
            'es_ubicacion','es_fisico');
        foreach($campos_obligatorios_parciales as $campo){
            if(in_array($campo, $this->campos_tabla)){
                $this->campos_obligatorios[]=$campo;
            }
        }

        $this->sub_querys = $sub_querys;
        $this->sql_seguridad_por_cliente = array();
        $this->sql_seguridad_por_ubicacion = array();
        $this->campos_obligatorios =array_merge($this->campos_obligatorios,$campos_obligatorios);
        $this->tipo_campos = $tipo_campos;
        $this->patterns['double'] = "/^[1-9]+[0-9]*.?[0-9]{0,2}$/";
        $this->patterns['double_con_cero'] = "/^[0-9]+[0-9]*.?[0-9]{0,2}$/";
        $this->patterns['nss'] = "/^[0-9]{11}$/";
        $this->patterns['telefono'] = "/^[0-9]{10}$/";
        $this->patterns['id'] = "/^[1-9]+[0-9]*$/";
        $this->patterns['producto_codigo'] = "/^[0-9]{9}$/";
        $this->patterns['clase_codigo'] = "/^[0-9]{3}$/";
        $this->patterns['sub_clase_codigo'] = "/^[0-9]{6}$/";

        $this->aplica_transaccion_inactivo = $aplica_transaccion_inactivo;



    }


    public function activa_bd(): array{ //PRUEBA COMPLETA PROTEO
        if($this->registro_id <= 0){
            return $this->errores->datos(1,'Error id debe ser mayor a 0',__CLASS__,
                __LINE__,__FILE__,$this->registro_id,__FUNCTION__);

        }

        $valida = $this->validaciones->valida_transaccion_activa($this);
        if(isset($valida['error'])){
            return $this->errores->datos(1,'Error al validar transaccion activa',
                __CLASS__,__LINE__,__FILE__,$valida,__FUNCTION__);
        }


        $this->consulta = "UPDATE $this->tabla SET status = 'activo' WHERE id = $this->registro_id";
        $this->transaccion = 'ACTIVA';


        $resultado = $this->ejecuta_sql();
        if(is_array($resultado)&&isset($resultado['error'])){
            return $this->errores->datos(1,'Error al ejecutar sql',__CLASS__,
                __LINE__,__FILE__,$resultado,__FUNCTION__);
        }

        return array('mensaje'=>'Registro activado con éxito', 'registro_id'=>$this->registro_id);
    }

    public function activa_todo(){ //PRUEBA COMPLETA PROTEO
        $this->transaccion = 'UPDATE';
        $this->consulta = "UPDATE $this->tabla SET status = 'activo'  ";

        $resultado = $this->ejecuta_sql();
        if(is_array($resultado)&&isset($resultado['error'])){
            return $this->errores->datos(1,'Error al ejecutar sql',__CLASS__,
                __LINE__,__FILE__,$resultado,__FUNCTION__);
        }

        return array('mensaje'=>'Registros activados con éxito','sql'=>$this->consulta);
    }

    public function agrega_usuario_session(){ //PRUEBA COMPLETA PROTEO
        if($this->usuario_id <=0){
            return $this->errores->datos(1,'Error usuario invalido',__CLASS__,__LINE__,
                __FILE__,array($this->usuario_id),__FUNCTION__);
        }

        if($this->campos_sql === ''){
            return $this->errores->datos(1,'campos no puede venir vacio',__CLASS__,
                __LINE__,__FILE__,$this->campos_sql,__FUNCTION__);
        }
        $existe_user = $this->usuario_existente();
        if(isset($existe_user['error'])){
            return $this->errores->datos(1,'Error validar existencia de usuario',__CLASS__,
                __LINE__,__FILE__,array($existe_user,$this->campos_sql, $this->usuario_id),__FUNCTION__);
        }
        if(!$existe_user){
            return $this->errores->datos(1,'Error no existe usuario',__CLASS__,
                __LINE__,__FILE__,array($existe_user,$this->campos_sql, $this->usuario_id),__FUNCTION__);
        }

        $this->campos_sql = $this->campos_sql.',usuario_update_id='.$this->usuario_id;

        return $this->campos_sql;
    }

    public function alta_bd(): array{ //PRUEBA COMPLETA PROTEO
        if(count($this->registro) === 0){
            return $this->errores->datos(1,'Error registro no puede venir vacio',
                __CLASS__,__LINE__,__FILE__,$this->registro,__FUNCTION__);
        }

        $valida_campo_obligatorio = $this->valida_campo_obligatorio();
        if(isset($valida_campo_obligatorio['error'])){
            return $this->errores->datos(1,'Error el campo al validar campos obligatorios ',
                __CLASS__,__LINE__,__FILE__,array($valida_campo_obligatorio, $this->tabla),__FUNCTION__);
        }
        $valida_estructura = $this->valida_estructura_campos();
        if(isset($valida_estructura['error'])){
            return $this->errores->datos(1,'Error el campo al validar estructura ',
                __CLASS__,__LINE__,__FILE__,array($valida_estructura),__FUNCTION__);
        }
        $campos = '';
        $valores = '';
        foreach ($this->registro as $campo => $value) {
            if(is_numeric($campo)){
                return $this->errores->datos(1,'Error el campo no es valido',
                    __CLASS__,__LINE__,__FILE__,$campo,__FUNCTION__);
            }
            $campo = addslashes($campo);
            $value = addslashes($value);
            $campos .= $campos === '' ? $campo : ",$campo";
            $valores .= $valores === '' ? "'$value'" : ",'$value'";

        }
        $existe_alta_id = "SELECT count(usuario_alta_id) FROM $this->tabla";
        $existe_update_id = "SELECT count(usuario_alta_id) FROM $this->tabla";

        $alta_valido = $this->link->query($existe_alta_id);
        $update_valido = $this->link->query($existe_update_id);

        if($alta_valido &&  $update_valido ){
            $data_asignacion = $this->asigna_data_user_transaccion();
            if(isset($data_asignacion['error'])){
                return $this->errores->datos(1,'Error al asignar datos de transaccion',__CLASS__,
                    __LINE__,__FILE__,$data_asignacion,__FUNCTION__);
            }
            $campos .= $data_asignacion['campos'];
            $valores .= $data_asignacion['valores'];
        }

        $this->campos = $campos;
        $this->valores = $valores;
        $this->transaccion = 'INSERT';
        $this->consulta = 'INSERT INTO '. $this->tabla.' ('.$campos.') VALUES ('.$valores.')';

        $resultado = $this->ejecuta_sql();

        if(is_array($resultado)&&isset($resultado['error'])){
            return $this->errores->datos(1,'Error al ejecutar sql',__CLASS__,
                __LINE__,__FILE__,array($resultado,$this->tabla),__FUNCTION__);
        }

        return array('mensaje'=>'Registro insertado con éxito', 'registro_id'=>$this->registro_id);

    }

    public function array_sort_by(array $array_ini, string $col,  $order = SORT_ASC){ //PRUEBA COMPLETA PROTEO
        $arrAux = array();
        foreach ($array_ini as $key=> $row) {
            if(!isset($row[$col])){
                return $this->errores->datos(1,'Error no existe el $key '.$col,
                    __CLASS__,__LINE__,__FILE__,$row,__FUNCTION__);
            }
            $arrAux[$key] = is_object($row) ? $arrAux[$key] = $row->$col : $row[$col];
            $arrAux[$key] = strtolower($arrAux[$key]);
        }
        array_multisort($arrAux, $order, $array_ini);
        return $array_ini;
    }

    public function asigna_data_user_transaccion(){ //PRUEBA COMPLETA PROTEO
        if(!isset($_SESSION['usuario_id'])){
            return $this->errores->datos(1,'Error no existe usuario',__CLASS__,
                __LINE__,__FILE__,$_SESSION,__FUNCTION__);
        }
        $usuario_alta_id = $_SESSION['usuario_id'];
        $usuario_upd_id = $_SESSION['usuario_id'];
        $campos = ',usuario_alta_id,usuario_update_id';
        $valores = ','.$usuario_alta_id.','.$usuario_upd_id;

        return array('campos'=>$campos,'valores'=>$valores);
    }

    public function asigna_cero_codigo(int $longitud, int $total_cadena){ //PRUEBA COMPLETA PROTEO
        if($longitud<0){
            return $this->errores->datos(1,'Error $longitud debe ser mayor a 0',
                __CLASS__,__LINE__,__FILE__,$longitud,__FUNCTION__);
        }
        if($total_cadena<0){
            return $this->errores->datos(1,'Error $total_cadena debe ser mayor a 0',
                __CLASS__,__LINE__,__FILE__,$total_cadena,__FUNCTION__);
        }
        $ceros = '';
        for($i = $longitud; $i<$total_cadena; $i++){
            $ceros.='0';
        }
        return $ceros;
    }

    public function asigna_registros_hijo(string $name_modelo, array $filtro, array $row){  //FIN

        $valida = $this->valida_data_modelo($name_modelo);
        if(isset($valida['error'])){
            return $this->errores->datos(1,'Error al validar entrada para modelo',__CLASS__,
                __LINE__,__FILE__,$valida,__FUNCTION__);
        }

        $modelo = $this->genera_modelo($name_modelo);
        $data = $modelo->filtro_and($filtro);
        if(isset($data['error'])){
            return $this->errores->datos(1,'Error al generar registro hijos',__CLASS__,
                __LINE__,__FILE__,$data,__FUNCTION__);
        }
        $row[$name_modelo] = $data['registros'];

        return $row;
    }

    public function desactiva_bd(): array{ //PRUEBA COMPLETA PROTEO
        if($this->registro_id<=0){
            return $this->errores->datos(1,'Error $this->registro_id debe ser mayor a 0',__CLASS__,
                __LINE__,__FILE__,$this->registro_id,__FUNCTION__);
        }
        $valida = $this->validaciones->valida_transaccion_activa($this);
        if(isset($valida['error'])){
            return $this->errores->datos(1,'Error al validar transaccion activa',
                __CLASS__,__LINE__,__FILE__,$valida,__FUNCTION__);
        }
        $tabla = $this->tabla;
        $this->consulta = "UPDATE $tabla SET status = 'inactivo' WHERE id = $this->registro_id";
        $this->transaccion = 'DESACTIVA';

        $resultado = $this->ejecuta_sql();
        if(is_array($resultado)&&isset($resultado['error'])){
            return $this->errores->datos(1,'Error al ejecutar sql',__CLASS__,
                __LINE__,__FILE__,$resultado,__FUNCTION__);
        }

        return array('mensaje'=>'Registro desactivado con éxito', 'registro_id'=>$this->registro_id);

    }

    public function desactiva_todo(){ //PRUEBA COMPLETA PROTEO

        $consulta = "UPDATE  $this->tabla SET status='inactivo'";

        $this->link->query($consulta);
        if($this->link->errorInfo()[1]){
            return array('mensaje'=>$this->link->errorInfo(), 'error'=>1);
        }
        else{
            return array('mensaje'=>'Registros desactivados con éxito');
        }
    }

    public function ejecuta_consulta(array $hijo = array()): array{ //PRUEBA COMPLETA PROTEO

        if($this->consulta === ''){
            return $this->errores->datos(1,'La consulta no puede venir vacia',
                __CLASS__,__LINE__, __FILE__,array($this->link->errorInfo(),$this->consulta),__FUNCTION__);
        }
        $this->transaccion = 'SELECT';
        $result = $this->ejecuta_sql();
        if(isset($result['error'])){
            return $this->errores->datos(1,'Error al ejecutar sql',__CLASS__,
                __LINE__,__FILE__,$result,__FUNCTION__);
        }
        $r_sql = $result['result'];

        $new_array = $this->parsea_registros_envio($hijo, $r_sql);
        if(isset($new_array['error'])){
            return $this->errores->datos(1,'Error al parsear arreglo con registros',__CLASS__,
                __LINE__,__FILE__,$new_array,__FUNCTION__);
        }

        $n_registros = $r_sql->rowCount();
        $r_sql->closeCursor();
        return array('registros' => $new_array, 'n_registros' => $n_registros, 'sql'=>$this->consulta);

    }

    public function ejecuta_sql(): array{ //PRUEBA COMPLETA PROTEO
        if($this->consulta === ''){
            return $this->errores->datos(1,'La consulta no puede venir vacia',__CLASS__,__LINE__,
                __FILE__,array($this->link->errorInfo(),$this->consulta),__FUNCTION__);
        }
        $result = $this->link->query($this->consulta);
        if($this->link->errorInfo()[1]){
            return $this->errores->datos(1,'Error al ejecutar sql',__CLASS__,__LINE__,
                __FILE__,array($this->link->errorInfo(),$this->consulta, $this->tabla),__FUNCTION__);
        }
        if($this->transaccion ==='INSERT'){
            $this->registro_id = $this->link->lastInsertId();
        }
        return array('mensaje'=>'Exito','sql'=>$this->consulta,'result'=>$result);
    }

    public function elimina_bd(int $id): array{ //PRUEBA COMPLETA PROTEO
        if($id < 0){
            return $this->errores->datos(1,'El id no puede ser menor a 0',__CLASS__,
                __LINE__,__FILE__,$id,__FUNCTION__);
        }
        $valida = $this->validaciones->valida_transaccion_activa($this);
        if(isset($valida['error'])){
            return $this->errores->datos(1,'Error al validar transaccion activa',
                __CLASS__,__LINE__,__FILE__,$valida,__FUNCTION__);

        }
        $tabla = $this->tabla;

        $this->consulta = 'DELETE FROM '.$tabla. ' WHERE id = '.$id;

        $this->transaccion = 'DELETE';
        $this->registro_id = $id;
        $resultado = $this->ejecuta_sql();

        if(is_array($resultado)&&isset($resultado['error'])){
            return $this->errores->datos(1,'Error al ejecutar sql',__CLASS__,
                __LINE__,__FILE__,$resultado,__FUNCTION__);
        }

        return array('mensaje'=>'Registro eliminado con éxito', 'registro_id'=>$id);

    }

    public function elimina_con_filtro_and(): array{ //PRUEBA COMPLETA PROTEO
        if(count($this->filtro) === 0){
            return $this->errores->datos(1,'Error no existe filtro',__CLASS__,
                __LINE__,__FILE__,$this->filtro,__FUNCTION__);
        }
        $tabla = $this->tabla;
        $sentencia = $this->genera_and();
        if(isset($sentencia['error'])){
            return $this->errores->datos(1,'Error al generar and',__CLASS__,__LINE__,
                __FILE__,$sentencia,__FUNCTION__);
        }
        $consulta = "DELETE FROM $tabla WHERE $sentencia";
        $this->link->query($consulta);
        if($this->link->errorInfo()[1]){
            return $this->errores->datos(1,'Error al ejecutar query',__CLASS__,__LINE__,
                __FILE__,array($this->link->errorInfo(),$consulta),__FUNCTION__);
        }

        return array('mensaje'=>'Registro eliminado con éxito');

    }

    public function elimina_todo(){ //PRUEBA COMPLETA PROTEO
        $tabla = $this->tabla;
        $this->transaccion = 'DELETE';
        $this->consulta = 'DELETE FROM '.$tabla;

        $resultado = $this->ejecuta_sql();

        if(is_array($resultado)&&isset($resultado['error'])){
            return $this->errores->datos(1,'Error al ejecutar sql',__CLASS__,
                __LINE__,__FILE__,$resultado,__FUNCTION__);
        }

        return array('mensaje'=>'Registros eliminados con éxito');
    }

    public function filtro_and(array $filtro=array(),string $tipo_filtro='numeros', array $filtro_especial= array(),
                               array $order = array(), int $limit=0,int $offset=0, array $group_by=array(),
                               array $columnas =array(), array $filtro_rango = array(), array $hijo = array(),
                               string $sql_where =''): array{ //PRUEBA COMPLETA PROTEO

        $this->filtro = $filtro;

        if($limit < 0){
            return $this->errores->datos(1,
                'Error limit debe ser mayor o igual a 0  con 0 no aplica limit',__CLASS__,__LINE__,
                __FILE__,$limit,__FUNCTION__);
        }

        $sentencia = '';
        if($tipo_filtro === 'numeros') {
            $sentencia = $this->genera_and();
            if(isset($sentencia['error'])){
                return $this->errores->datos(1,'Error al generar and',__CLASS__,
                    __LINE__,__FILE__,$sentencia,__FUNCTION__);
            }
        }
        elseif ($tipo_filtro==='textos'){
            $sentencia = $this->genera_and_textos($this->filtro);
            if(isset($sentencia['error'])){
                return $this->errores->datos(1,'Error al generar and',__CLASS__,
                    __LINE__,__FILE__,$sentencia,__FUNCTION__);
            }
        }

        $filtro_especial_sql = '';
        foreach ($filtro_especial as $campo=>$filtro){
            if($filtro_especial_sql === ''){
                if(isset($filtro['valor_es_campo']) && $filtro['valor_es_campo']){
                    $filtro_especial_sql.= "'".$campo."'".$filtro['operador'].$filtro['valor'];
                }
                else {
                    $filtro_especial_sql .= $campo . $filtro['operador'] . "'" . $filtro['valor'] . "'";
                }
            }
            else {
                if(isset($filtro['valor_es_campo']) && $filtro['valor_es_campo']) {
                    $filtro_especial_sql .= ' AND ' ."'". $campo."'" . $filtro['operador']  . $filtro['valor'] ;
                }
                else{
                    $filtro_especial_sql .= ' AND ' . $campo . $filtro['operador'] . "'" . $filtro['valor'] . "'";
                }
            }
        }

        $filtro_rango_sql = '';
        foreach ($filtro_rango as $campo=>$filtro){
            $condicion = $campo . ' BETWEEN ' ."'" .$filtro['valor1'] . "'"." AND "."'".$filtro['valor2'] . "'";
            if($filtro_rango_sql === ''){
                $filtro_rango_sql .= $condicion;
            }
            else {
                $filtro_rango_sql .= ' AND ' . $condicion;
            }
        }

        $consulta = $this->genera_consulta_base($columnas);
        if(isset($consulta['error'])){
            return $this->errores->datos(1,'Error al generar sql',__CLASS__,
                __LINE__,__FILE__,$consulta,__FUNCTION__);
        }

        $group_by_sql = '';
        foreach ($group_by as $campo){
            if($group_by_sql === ''){
                $group_by_sql.=' GROUP BY '.$campo;
            }
            else {
                $group_by_sql .= ',' . $campo;
            }

        }

        $order_sql = '';
        foreach ($order as $campo=>$tipo_order){
            if(is_numeric($campo)){
                return $this->errores->datos(1,'Error $campo debe ser txt',__CLASS__,
                    __LINE__,__FILE__,array('order'=>$order),__FUNCTION__);
            }
            if($order_sql === ''){
                $order_sql.=' ORDER BY '.$campo.' '.$tipo_order;
            }
            else {
                $order_sql .= ',' . $campo.' '.$tipo_order;
            }
        }

        $limit_sql = '';
        if($limit > 0){
            $limit_sql.=' LIMIT '.$limit;
        }


        $offset_sql = '';

        if($offset >0){
            $offset_sql.=' OFFSET '.$offset;
        }
        $where='';
        if($sentencia!=='') {
            $where = " WHERE $sentencia";
        }

        if($filtro_especial_sql !=='') {
            if ($where === '') {
                $filtro_especial_sql = " WHERE $filtro_especial_sql";
            } else {
                $filtro_especial_sql = " AND ( $filtro_especial_sql )";
            }
        }

        if($filtro_rango_sql !=='') {
            if ($where === '') {
                $filtro_rango_sql = " WHERE $filtro_rango_sql";
            } else {
                $filtro_rango_sql = " AND ( $filtro_rango_sql )";
            }
        }

        if($sql_where !==''){
            if ($where === '') {
                $sql_where = " WHERE $filtro_rango_sql";
            }
        }



        $this->consulta = $consulta.$where.$filtro_especial_sql.' '.$filtro_rango_sql.' '.$sql_where.' '.$group_by_sql.' '.$order_sql.' '.$limit_sql.' '.$offset_sql;

        $result = $this->ejecuta_consulta($hijo);
        if(isset($result['error'])){
            return $this->errores->datos(1,'Error al ejecutar sql',__CLASS__,
                __LINE__,__FILE__,$result,__FUNCTION__);
        }


        return $result;
    }

    public function genera_and(){  //PRUEBA COMPLETA PROTEO

        $sentencia = '';
        foreach ($this->filtro as $key => $value) {
            if(is_numeric($key)){
                return $this->errores->datos(1,
                    'Los key deben de ser campos asociativos con referencia a tabla.campo',__CLASS__,
                    __LINE__,__FILE__,$this->filtro,__FUNCTION__);
            }
            $key = addslashes($key);
            $value = addslashes($value);
            $sentencia .= $sentencia === ''?"$key = '$value'":" AND $key = '$value'";
        }

        return $sentencia;

    }

    public function genera_and_textos(array $filtros){ //PRUEBA COMPLETA PROTEO
        $sentencia = '';
        foreach ($filtros as $key => $value) {

            if(is_numeric($key)){
                return array('error'=>'1','mensaje'=>'Los key deben de ser campos asociativos con referencia a tabla.campo' ,
                    'FILE'=> __FILE__ , 'LINE' => __LINE__);
            }

            $key = addslashes($key);
            $value = addslashes($value);
            $sentencia .= $sentencia == ""?"$key LIKE '%$value%'":" AND $key LIKE '%$value%'";
        }

        return $sentencia;

    }

    public function genera_campos_update(){ //PRUEBA COMPLETA PROTEO
        if(count($this->registro_upd) === 0){
            return $this->errores->datos(1,'El registro no puede venir vacio',__CLASS__,
                __LINE__,__FILE__,$this->registro_upd,__FUNCTION__);
        }
        $consultas_base = new consultas_base();
        $campos = $consultas_base->obten_campos($this->tabla,'modifica', $this->link);
        if(isset($campos['error'])){
            return $this->errores->datos(1,'Error al obtener campos',__CLASS__,__LINE__,
                __FILE__,$campos,__FUNCTION__);
        }

        $campos = $this->obten_campos_update();

        if(isset($campos['error'])){
            return $this->errores->datos(1,'Error al obtener campos',__CLASS__,__LINE__,
                __FILE__,$campos,__FUNCTION__);
        }


        return $campos;
    }

    public function genera_columnas_consulta(string $tabla_original, string $tabla_renombrada, array $columnas = array()){ //PRUEBA COMPLETA PROTEO

        $columnas_sql = $this->genera_columnas_tabla($tabla_original,$tabla_renombrada, $columnas);
        if(isset($columnas_sql['error'])){
            return $this->errores->datos(1,'Error al generar columnas',__CLASS__,
                __LINE__,__FILE__,$columnas_sql,__FUNCTION__);
        }

        $columnas_extra_sql = $this->genera_columnas_extra();
        if(isset($columnas_extra_sql['error'])){
            return $this->errores->datos(1,'Error al generar columnas',__CLASS__,
                __LINE__,__FILE__,$columnas_extra_sql,__FUNCTION__);
        }

        $columnas_envio = $columnas_sql;
        if($columnas_extra_sql!==''){
            $columnas_envio.=','.$columnas_extra_sql;
        }

        return $columnas_envio;
    }

    public function genera_columnas_extra(){ //PRUEBA COMPLETA PROTEO
        $columnas_sql = '';
        $columnas_extra = $this->columnas_extra;
        foreach ($columnas_extra as $sub_query => $sql) {
            if(is_numeric($sub_query)){
                return $this->errores->datos(1,'Error el key debe ser el nombre de la subquery',
                    __CLASS__,__LINE__,__FILE__,$columnas_extra,__FUNCTION__);
            }
            if((string)$sub_query === ''){
                return $this->errores->datos(1,'Error el key no puede venir vacio',
                    __CLASS__,__LINE__,__FILE__,$columnas_extra,__FUNCTION__);
            }
            if((string)$sql === ''){
                return $this->errores->datos(1,'Error el sql no puede venir vacio',
                    __CLASS__,__LINE__,__FILE__,$columnas_extra,__FUNCTION__);
            }
            $columnas_sql .= $columnas_sql === ''?"$sql AS $sub_query":",$sql AS $sub_query";
        }
        return $columnas_sql;
    }

    public function genera_columnas_tabla(string $tabla_original, string $tabla_renombrada, array $columnas = array()){ //PRUEBA COMPLETA PROTEO
        if($tabla_original === ''){
            return $this->errores->datos(1,'Error tabla original no puede venir vacia',__CLASS__,
                __LINE__,__FILE__,$tabla_original,__FUNCTION__);
        }
        if(!class_exists($tabla_original)){
            return $this->errores->datos(1,'Error no existe el modelo'.$tabla_original,__CLASS__,
                __LINE__,__FILE__,$tabla_original,__FUNCTION__);
        }

        $columnas_parseadas = $this->obten_columnas($tabla_original);
        if(isset($columnas_parseadas['error'])){
            return $this->errores->datos(1,'Error al obtener columnas',__CLASS__,
                __LINE__,__FILE__,$columnas_parseadas,__FUNCTION__);
        }
        $tabla_nombre = $this->obten_nombre_tabla($tabla_renombrada,$tabla_original);
        if(isset($tabla_nombre['error'])){
            return $this->errores->datos(1,'Error al obtener nombre de tabla',__CLASS__,
                __LINE__,__FILE__,$tabla_nombre,__FUNCTION__);
        }
        $columnas_sql = '';
        foreach($columnas_parseadas as $columna_parseada){
            $alias_columnas = $tabla_nombre.'_'.$columna_parseada;

            if(count($columnas)>0){
                if(!in_array($alias_columnas,$columnas)){
                    continue;
                }
            }
            if($columnas_sql === ''){
                $columnas_sql.= $tabla_nombre.'.'.$columna_parseada.' AS '.$alias_columnas;
            }
            else{
                $columnas_sql.=', '.$tabla_nombre.'.'.$columna_parseada.' AS '.$alias_columnas;
            }
        }

        return $columnas_sql;
    }

    public function genera_consulta_base(array $columnas = array()){ //PRUEBA COMPLETA PROTEO

        $columnas = $this->obten_columnas_completas($columnas);
        if(isset($columnas['error'])){
            return $this->errores->datos(1,'Error al obtener columnas',__CLASS__,
                __LINE__,__FILE__,$columnas,__FUNCTION__);
        }

        $consulta_base = new consultas_base();
        $tabla = $this->tabla;
        $tablas = $consulta_base->obten_tablas_completas($tabla, $this->columnas);
        if(isset($tablas['error'])){
            return $this->errores->datos(1,'Error al obtener tablas',__CLASS__,
                __LINE__,__FILE__,$tablas,__FUNCTION__);
        }

        $sub_querys_sql = '';
        foreach($this->sub_querys as $alias => $sub_query){
            if($sub_querys_sql==='' && $columnas === ''){
                $sub_querys_sql.=$sub_query.' AS '.$alias;
            }
            else{
                $sub_querys_sql = ' , '.$sub_query.' AS '.$alias;
            }
        }

        return "SELECT $columnas $sub_querys_sql FROM $tablas";
    }

    public function genera_modelo(string $modelo):modelos{ //PRUEBA COMPLETA PROTEO
        $valida = $this->valida_data_modelo($modelo);
        if(isset($valida['error'])){
            $error = $this->errores->datos(1,'Error al validar entrada para generacion de modelo',__CLASS__,
                __LINE__,__FILE__,$valida,__FUNCTION__);
            print_r($error);
            die('Error');
        }
        return new $modelo($this->link);
    }

    public function genera_modelos_hijos(){ //fin
        $modelos_hijos = array() ;
        foreach($this->hijo as $key=>$modelo){
            if(is_numeric($key)){
                return $this->errores->datos(1,'Error $key debe ser un string',__CLASS__,
                    __LINE__,__FILE__,$this->hijo,__FUNCTION__);
            }
            if(!isset($modelo['filtros'])){
                return $this->errores->datos(1,'Error debe existir filtros ',__CLASS__,
                    __LINE__,__FILE__,$this->hijo,__FUNCTION__);
            }
            if(!isset($modelo['filtros_con_valor'])){
                return $this->errores->datos(1,'Error debe existir filtros_con_valor ',__CLASS__,
                    __LINE__,__FILE__,$this->hijo,__FUNCTION__);
            }
            if(!is_array($modelo['filtros'])){
                return $this->errores->datos(1,'Error debe ser array filtros ',__CLASS__,
                    __LINE__,__FILE__,$this->hijo,__FUNCTION__);
            }
            if(!is_array($modelo['filtros_con_valor'])){
                return $this->errores->datos(1,'Error debe ser array filtros_con_valor ',__CLASS__,
                    __LINE__,__FILE__,$this->hijo,__FUNCTION__);
            }

            $modelos_hijos[$key]['filtros']= $modelo['filtros'];
            $modelos_hijos[$key]['filtros_con_valor']= $modelo['filtros_con_valor'];
        }

        return $modelos_hijos;
    }

    public function genera_registro_hijo(array $data_modelo, array $row, string $name_modelo){ //fin
        $filtro = $this->obten_filtro_para_hijo($data_modelo,$row);
        if(isset($filtro['error'])){
            return $this->errores->datos(1,'Error al generar filtro hijos',__CLASS__,
                __LINE__,__FILE__,$filtro,__FUNCTION__);
        }
        $row = $this->asigna_registros_hijo($name_modelo,$filtro,$row);
        if(isset($row['error'])){
            return $this->errores->datos(1,'Error al asignar registros de hijo',__CLASS__,
                __LINE__,__FILE__,$row,__FUNCTION__);
        }

        return $row;
    }

    public function genera_registros_hijos(array $modelos_hijos, array $row){ //PRUEBA COMPLETA PROTEO
        foreach($modelos_hijos as $name_modelo=>$data_modelo){
            if(!is_array($data_modelo)){
                return $this->errores->datos(1,'Error $data_modelo debe ser un array',__CLASS__,
                    __LINE__,__FILE__,$modelos_hijos,__FUNCTION__);

            }

            $row = $this->genera_registro_hijo($data_modelo,$row,$name_modelo);
            if(isset($row['error'])){
                return $this->errores->datos(1,'Error al generar registros de hijo',__CLASS__,
                    __LINE__,__FILE__,$row,__FUNCTION__);
            }
        }

        return $row;
    }

    public function genera_ultimo_codigo_base_numero(array $registros, string $key,int $longitud_maxima){ //PRUEBA COMPLETA PROTEO

        $valida_base = $this->valida_base_ultimo_codigo($registros,$key);
        if(isset($valida_base['error'])){
            return $this->errores->datos(1,'Error al validar',__CLASS__,__LINE__,
                __FILE__,$valida_base,__FUNCTION__);
        }
        if($longitud_maxima < 0){
            return $this->errores->datos(1,'Error $longitud_maxima debe ser mayor a 0',__CLASS__,__LINE__,
                __FILE__,$longitud_maxima,__FUNCTION__);
        }

        $ultimo_codigo_upd = $this->obten_ultimo_codigo_insert($registros,$key);
        if(isset($ultimo_codigo_upd['error'])){
            return $this->errores->datos(1,'Error al generar ultimo codigo',__CLASS__,__LINE__,
                __FILE__,$ultimo_codigo_upd,__FUNCTION__);
        }
        $longitud_codigo = strlen($ultimo_codigo_upd);

        $ceros = $this->asigna_cero_codigo($longitud_codigo,$longitud_maxima);
        if(isset($ceros['error'])){
            return $this->errores->datos(1,'Error al asignar ceros',__CLASS__,__LINE__,
                __FILE__,$ceros,__FUNCTION__);
        }

        $ultimo_codigo_envio = $ceros.$ultimo_codigo_upd;

        return $ultimo_codigo_envio;
    }

    public function genera_ultimo_codigo_int(int $ultimo_codigo){ //PRUEBA COMPLETA PROTEO
        if($ultimo_codigo<0){
            return $this->errores->datos(1,'Error $ultimo_codigo debe ser mayor a 0',__CLASS__,__LINE__,
                __FILE__,$ultimo_codigo,__FUNCTION__);
        }
        $ultimo_codigo_int = (int)$ultimo_codigo;
        $ultimo_codigo_upd = $ultimo_codigo_int+1;

        return $ultimo_codigo_upd;
    }

    public function maqueta_arreglo_registros(PDOStatement $r_sql, array $modelos_hijos){ //FIN
        $new_array = array();
        while( $row = $r_sql->fetchObject()){
            $row = (array) $row;
            $row = $this->genera_registros_hijos($modelos_hijos,$row);
            if(isset($row['error'])){
                return $this->errores->datos(1,'Error al generar registros de hijo',__CLASS__,
                    __LINE__,__FILE__,$row,__FUNCTION__);
            }
            $new_array[] = $row;
        }

        return $new_array;
    }

    public function modifica_bd(array $registro, int $id){ //PRUEBA COMPLETA PROTEO
        $this->registro_upd = $registro;
        $this->registro_id = $id;
        if($id <=0){
            return $this->errores->datos(1,'Error el id debe ser mayor a 0',__CLASS__,__LINE__,
                __FILE__,$id,__FUNCTION__);
        }
        if(count($this->registro_upd) === 0){
            return $this->errores->datos(1,'El registro no puede venir vacio',__CLASS__,
                __LINE__,__FILE__,$this->registro_upd,__FUNCTION__);
        }
        $valida = $this->validaciones->valida_transaccion_activa($this);
        if(isset($valida['error'])){
            return  $this->errores->datos(1,'Error al validar transaccion activa',
                __CLASS__,__LINE__,__FILE__,$valida,__FUNCTION__);
        }
        $campos_sql = $this->genera_campos_update();
        if(isset($campos_sql['error'])){
            return $this->errores->datos(1,'Error al obtener campos',__CLASS__,__LINE__,
                __FILE__,$campos_sql,__FUNCTION__);
        }
        $this->campos_sql = $campos_sql;
        $campos_sql = $this->agrega_usuario_session();
        if(isset($campos_sql['error'])){
            return $this->errores->datos(1,'Error al AGREGAR USER',__CLASS__,__LINE__,
                __FILE__,$campos_sql,__FUNCTION__);
        }
        $this->campos_sql .= ','.$campos_sql;
        $this->consulta = 'UPDATE '. $this->tabla.' SET '.$this->campos_sql."  WHERE id = $id";
        $this->campos_modifica = $this->registro_upd;
        $this->transaccion = 'UPDATE';
        $this->registro_id = $id;
        $resultado = $this->ejecuta_sql();

        if(is_array($resultado)&&isset($resultado['error'])){
            return $this->errores->datos(1,'Error al ejecutar sql',__CLASS__,
                __LINE__,__FILE__,array($resultado,'sql'=>$this->consulta),__FUNCTION__);
        }

        return $resultado;
    }

    public function modifica_con_filtro_and(array $filtro, array $registro){ //PRUEBA COMPLETA PROTEO
        $this->filtro = $filtro;
        $this->registro_upd = $registro;
        if(count($this->registro_upd) === 0){
            return $this->errores->datos(1,'El registro no puede venir vacio',__CLASS__,
                __LINE__,__FILE__,$this->registro_upd,__FUNCTION__);
        }
        if(count($this->filtro) === 0){
            return $this->errores->datos(1,'El filtro no puede venir vacio',__CLASS__,
                __LINE__,__FILE__,$this->registro_upd,__FUNCTION__);
        }

        $campos = $this->genera_campos_update();
        if(isset($campos['error'])){
            return $this->errores->datos(1,'Error al obtener campos',__CLASS__,__LINE__,
                __FILE__,$campos,__FUNCTION__);
        }

        $sentencia = $this->genera_and();
        if(isset($sentencia['error'])){
            return $this->errores->datos(1,'Error al obtener SENTENCIA',__CLASS__,
                __LINE__,__FILE__,$sentencia,__FUNCTION__);
        }

        $consulta = "UPDATE ". $this->tabla." SET ".$campos."  WHERE  $sentencia";

        $this->link->query($consulta);
        if($this->link->errorInfo()[1]){
            return $this->errores->datos(1,'Error al ejecutar sql',__CLASS__,
                __LINE__,__FILE__,array($this->link->errorInfo(), $consulta),__FUNCTION__);
        }
        else{
            return array('mensaje'=>'Registro modificado con éxito');
        }
    }

    public function modifica_por_id(array $registro,int $id) { //PRUEBA COMPLETA PROTEO
        $this->registro_id = $id;
        if($this->registro_id <= 0){
            return $this->errores->datos(1,'Error el id debe ser mayor a 0',__CLASS__,
                __LINE__,__FILE__,$this->registro_id,__FUNCTION__);
        }

        $valida = $this->validaciones->valida_transaccion_activa($this);
        if(isset($valida['error'])){
            return $this->errores->datos(1,'Error al validar transaccion activa',
                __CLASS__,__LINE__,__FILE__,$valida,__FUNCTION__);
        }
        $this->registro_upd = $registro;
        $campos = $this->obten_campos_update();
        if(isset($campos['error'])){
            return $this->errores->datos(1,'Error al obtener campos',__CLASS__,__LINE__,
                __FILE__,$campos,__FUNCTION__);
        }
        $this->campos_sql = $campos;

        $campos = $this->agrega_usuario_session();
        if(isset($campos['error'])){
            return $this->errores->datos(1,'Error al obtener campos',__CLASS__,__LINE__,
                __FILE__,$campos,__FUNCTION__);
        }
        $this->campos_sql = $campos;
        $consulta = "UPDATE ". $this->tabla." SET ".$campos." WHERE id = $id";

        $this->link->query($consulta);
        if($this->link->errorInfo()[1]){
            return $this->errores->datos(1,'Error al ejecutar sql',__CLASS__,
                __LINE__,__FILE__,array($this->link->errorInfo(), $consulta),__FUNCTION__);
        }
        else{
            return array('mensaje'=>'Registro modificado con éxito');
        }
    }

    public function obten_campos_update(){ //PRUEBA COMPLETA PROTEO

        if(count($this->registro_upd) === 0){
            return $this->errores->datos(1,'El registro no puede venir vacio',__CLASS__,
                __LINE__,__FILE__,$this->registro_upd,__FUNCTION__);
        }
        $campos = '';

        foreach ($this->registro_upd as $campo => $value) {
            if(is_numeric($campo)){
                return $this->errores->datos(1,'Error ingrese un campo valido',__CLASS__,
                    __LINE__,__FILE__,$this->registro_upd,__FUNCTION__);
            }
            if($campo === ''){
                return $this->errores->datos(1,'Error ingrese un campo valido',__CLASS__,
                    __LINE__,__FILE__,$this->registro_upd,__FUNCTION__);
            }
            $campo = addslashes($campo);
            $value = addslashes($value);
            if ($value == null) {
                $value = 'NULL';
            }
            else {
                $value = "'" . $value . "'";
            }
            $campos .= $campos == "" ? "$campo = $value" : ", $campo = $value";

        }
        return $campos;
    }

    public function obten_columnas($tabla_original){ //PRUEBA COMPLETA PROTEO

        if(isset($_SESSION['campos_tabla'][$tabla_original])){
            return $_SESSION['campos_tabla'][$tabla_original];
        }

        if($tabla_original === ''){
            return $this->errores->datos(1,'Error tabla original no puede venir vacia',__CLASS__,
                __LINE__,__FILE__,$tabla_original,__FUNCTION__);
        }
        if(!class_exists($tabla_original)){
            return $this->errores->datos(1,'Error no existe el modelo '.$tabla_original,__CLASS__,
                __LINE__,__FILE__,$tabla_original,__FUNCTION__);
        }

        $this->consulta = "DESCRIBE $tabla_original";

        $result = $this->ejecuta_consulta();

        if(isset($result['error'])){
            return $this->errores->datos(1,'Error al ejecutar sql',__CLASS__,__LINE__,
                __FILE__,$result,__FUNCTION__);
        }

        if((int)$result['n_registros'] === 0){
            return $this->errores->datos(1,'Error no existen columnas',__CLASS__,__LINE__,
                __FILE__,$result,__FUNCTION__);
        }

        $columnas = $result['registros'];
        $columnas_parseadas = array();

        foreach($columnas as $columna ){
            foreach($columna as $campo=>$atributo){
                if($campo === 'Field'){
                    $columnas_parseadas[] = $atributo;
                }
            }
        }
        $_SESSION['campos_tabla'][$tabla_original] = $columnas_parseadas;
        return $columnas_parseadas;
    }

    public function obten_columnas_completas(array $columnas_sql = array()){  //PRUEBA COMPLETA PROTEO
        $columnas = '';
        $consulta_base = new consultas_base();
        $consulta_base->estructura_bd[$this->tabla]['columnas'] = $this->columnas;

        if(!isset($consulta_base->estructura_bd[$this->tabla]['columnas'])){
            return $this->errores->datos(1,'No existen columnas para la tabla '.$this->tabla,__CLASS__,
                __LINE__,__FILE__,$this->tabla,__FUNCTION__);
        }
        $tablas_select = $consulta_base->estructura_bd[$this->tabla]['columnas'];


        foreach ($tablas_select as $key=>$tabla_select){
            $resultado_columnas = $this->genera_columnas_consulta($key,'',$columnas_sql);
            if(isset($resultado_columnas['error'])){
                return $this->errores->datos(1,'Error al generar columnas',__CLASS__,__LINE__,
                    __FILE__,$resultado_columnas,__FUNCTION__);
            }
            if($columnas === ''){
                $columnas.=$resultado_columnas;
            }
            else{
                if($resultado_columnas === ''){
                    continue;
                }
                $columnas.=', '.$resultado_columnas;
            }
        }
        $columnas = $columnas.' ';
        return $columnas;
    }

    public function obten_data(array $hijo= array()): array{ //PRUEBA COMPLETA PROTEO
        if($this->registro_id < 0){
            return $this->errores->datos(1,'Error el id debe ser mayor a 0',__CLASS__,
                __LINE__,__FILE__,$this->registro_id,__FUNCTION__);
        }
        $resultado = $this->obten_por_id($hijo);

        if(isset($resultado['error'])){
            return $this->errores->datos(1,'Error al obtener por id',__CLASS__,__LINE__,
                __FILE__,$resultado,__FUNCTION__);
        }
        if((int)$resultado['n_registros'] === 0){
            return $this->errores->datos(1,'Error no existe registro',__CLASS__,__LINE__,
                __FILE__,$resultado,__FUNCTION__);
        }
        return $resultado['registros'][0];
    }

    public function obten_datos_ultimo_registro(){ //fin
        $this->order = array($this->tabla.'.id'=>'DESC');
        $this->limit = 1;
        $resultado = $this->obten_registros();
        if(isset($resultado['error'])){
            return $this->errores->datos(1,'Error al obtener datos',__CLASS__,
                __LINE__,__FILE__,$resultado,__FUNCTION__);
        }
        if((int)$resultado['n_registros'] === 0){
            return array();
        }

        return $resultado['registros'][0];

    }

    public function obten_filtro_para_hijo(array $data_modelo, array $row){ //PRUEBA COMPLETA PROTEO
        if(!isset($data_modelo['filtros'])){
            return $this->errores->datos(1,'Error data_modelo[filtros] no existe',__CLASS__,
                __LINE__,__FILE__,$data_modelo,__FUNCTION__);
        }
        if(!isset($data_modelo['filtros_con_valor'])){
            return $this->errores->datos(1,'Error data_modelo[filtros_con_valor] no existe',__CLASS__,
                __LINE__,__FILE__,$data_modelo,__FUNCTION__);
        }

        if(!is_array($data_modelo['filtros'])){
            return $this->errores->datos(1,'Error data_modelo[filtros] debe ser array',__CLASS__,
                __LINE__,__FILE__,$data_modelo,__FUNCTION__);
        }
        if(!is_array($data_modelo['filtros_con_valor'])){
            return $this->errores->datos(1,'Error data_modelo[filtros_con_valor] debe ser array',__CLASS__,
                __LINE__,__FILE__,$data_modelo,__FUNCTION__);
        }

        $filtros = $data_modelo['filtros'];
        $filtros_con_valor = $data_modelo['filtros_con_valor'];
        $filtro = array();
        foreach($filtros as $campo_filtro=>$campo_row){
            if($campo_row===''){
                return $this->errores->datos(1,'Error no $campo_row no puede venir vacio',__CLASS__,
                    __LINE__,__FILE__,$filtros,__FUNCTION__);
            }
            if(!isset($row[$campo_row])){
                return $this->errores->datos(1,'Error no existe $row['.$campo_row.']',__CLASS__,
                    __LINE__,__FILE__,$filtros,__FUNCTION__);
            }

            $filtro[$campo_filtro] = $row[$campo_row];
        }
        foreach($filtros_con_valor as $campo_filtro=>$value){
            $filtro[$campo_filtro] = $value;
        }

        return $filtro;
    }

    public function obten_nombre_tabla(string $tabla_renombrada, string $tabla_original){//PRUEBA COMPLETA PROTEO
        if(trim($tabla_original)==='' && trim($tabla_renombrada) === ''){
            return $this->errores->datos(1,'Error no pueden venir vacios todos los parametroS',
                __CLASS__,__LINE__,__FILE__,$tabla_renombrada,__FUNCTION__);
        }
        if($tabla_renombrada!==''){
            $tabla_nombre = $tabla_renombrada;
        }
        else{
            $tabla_nombre = $tabla_original;
        }

        return $tabla_nombre;
    }

    public function obten_por_id(array $hijo = array()){ //PRUEBA COMPLETA PROTEO
        if($this->registro_id < 0){
            return $this->errores->datos(1,'Error el $this->registro_id debe ser mayor a 0',__CLASS__,
                __LINE__,__FILE__,$this->registro_id,__FUNCTION__);
        }
        $tabla = $this->tabla;

        $consulta = $this->genera_consulta_base();

        if(isset($consulta['error'])){
            return $this->errores->datos(1,'Error al generar consulta base',__CLASS__,
                __LINE__,__FILE__,$consulta,__FUNCTION__);
        }

        $where = " WHERE $tabla".".id = $this->registro_id ";
        $this->consulta = $consulta.$where;

        $result = $this->ejecuta_consulta($hijo);


        if(isset($result['error'])){
            return $this->errores->datos(1,'Error al ejecutar sql',__CLASS__,
                __LINE__,__FILE__,$result,__FUNCTION__);
        }

        return $result;
    }

    public function obten_registros(string $sql_extra='', string $group_by = '', array $columnas = array()): array{//PRUEBA COMPLETA PROTEO
        if($group_by !== ''){
            $group_by =" GROUP BY $group_by ";
        }
        $limit_sql = '';
        if($this->limit > 0){
            $limit_sql =" LIMIT $this->limit ";
        }

        $offset_sql = '';
        if($this->offset > 0){
            $offset_sql =" OFFSET $this->offset ";
        }

        $order_sql = '';
        foreach ($this->order as $campo=>$tipo_orden){
            if($order_sql === ''){
                $order_sql = " ORDER BY  $campo $tipo_orden ";
            }
            else {
                $order_sql .= " ,  $campo $tipo_orden  ";
            }
        }

        $consulta_base = $this->genera_consulta_base($columnas);

        if(isset($consulta_base['error'])){
            return $this->errores->datos(1,'Error al generar consulta',__CLASS__,
                __LINE__,__FILE__,$consulta_base,__FUNCTION__);
        }

        $this->consulta = $consulta_base.' '.$sql_extra.' '.$group_by.' '.$order_sql.' '.$limit_sql.' '.$offset_sql;


        $this->transaccion = 'SELECT';
        $result = $this->ejecuta_consulta();
        $this->transaccion = '';


        return $result;
    }

    public function obten_registros_activos(array $order = array(), array $filtro= array(), $hijo = array()):array{ //PRUEBA COMPLETA PROTEO
        $this->filtro = $filtro;
        $consulta = $this->genera_consulta_base();
        if(isset($consulta['error'])){
            return $this->errores->datos(1,'Error al generar consulta basica',__CLASS__,
                __LINE__,__FILE__,$consulta,__FUNCTION__);
        }
        $filtro_sql = $this->genera_and();
        $and = '';
        if($filtro_sql !== ''){
            $and = ' AND ';
        }

        $where = " WHERE $this->tabla.status='activo' $and $filtro_sql";

        $order_sql = '';
        foreach($order as $campo=>$tipo_orden){
            if($order_sql === ''){
                $order_sql.= ' ORDER BY '.$campo.' '.$tipo_orden;
            }
        }

        $this->consulta = $consulta.$where.' '.$order_sql;

        $result = $this->ejecuta_consulta($hijo);
        if(isset($result['error'])){
            return $this->errores->datos(1,'Error al ejecutar sql',
                __CLASS__,__LINE__,__FILE__,$result,__FUNCTION__);
        }

        return $result;
    }

    public function obten_registros_filtro_and_ordenado(array $filtros,string $campo, string $orden){//PRUEBA COMPLETA PROTEO
        $this->filtro = $filtros;
        if(count($this->filtro) === 0){
            return $this->errores->datos(1,'Error los filtros no pueden venir vacios',
                __CLASS__,__LINE__,__FILE__,$this->filtro,__FUNCTION__);
        }
        if($campo === ''){
            return $this->errores->datos(1,'Error campo no pueden venir vacios',
                __CLASS__,__LINE__,__FILE__,$this->filtro,__FUNCTION__);
        }

        $sentencia = $this->genera_and();
        if(isset($sentencia['error'])){
            return $this->errores->datos(1,'Error al generar and',
                __CLASS__,__LINE__,__FILE__,$sentencia,__FUNCTION__);
        }
        $consulta = $this->genera_consulta_base();

        if(isset($consulta['error'])){
            return $this->errores->datos(1,'Error al generar consulta',
                __CLASS__,__LINE__,__FILE__,$consulta,__FUNCTION__);
        }

        $where = " WHERE $sentencia";
        $order_by = " ORDER BY $campo $orden";
        $this->consulta = $consulta.$where.$order_by;

        $result = $this->ejecuta_consulta();

        if(isset($result['error'])){
            return $this->errores->datos(1,'Error al ejecutar sql',
                __CLASS__,__LINE__,__FILE__,$result,__FUNCTION__);
        }

        return $result;
    }

    public function obten_ultimo_codigo_insert(array $registros, string $key){//PRUEBA COMPLETA PROTEO

        $valida_base = $this->valida_base_ultimo_codigo($registros,$key);
        if(isset($valida_base['error'])){
            return $this->errores->datos(1,'Error al validar',__CLASS__,__LINE__,
                __FILE__,$valida_base,__FUNCTION__);
        }

        $registro  = $registros['registros'][0];

        if(!isset($registro[$key])){
            return $this->errores->datos(1,'Error no existe $registro['.$key.']',__CLASS__,__LINE__,
                __FILE__,$registro,__FUNCTION__);
        }


        $ultimo_codigo = (int)$registro[$key];

        $ultimo_codigo_upd = $this->genera_ultimo_codigo_int($ultimo_codigo);
        if(isset($ultimo_codigo_upd['error'])){
            return $this->errores->datos(1,'Error al generar ultimo codigo',__CLASS__,__LINE__,
                __FILE__,$ultimo_codigo_upd,__FUNCTION__);
        }

        return $ultimo_codigo_upd;
    }

    public function obten_ultimo_registro(){//PRUEBA COMPLETA PROTEO
        $this->order = array($this->tabla.'.id'=>'DESC');
        $this->limit = 1;
        $resultado = $this->obten_registros();
        if(isset($resultado['error'])){
            return $this->errores->datos(1,'Error al obtener registros',
                __CLASS__,__LINE__,__FILE__,$resultado,__FUNCTION__);
        }

        if((int)$resultado['n_registros'] === 0){
            return 1;
        }

        return $resultado['registros'][0][$this->tabla.'_id'] + 1;
    }

    public function parsea_registros_envio(array $hijo, PDOStatement $r_sql){//fin
        $this->hijo = $hijo;
        $modelos_hijos = $this->genera_modelos_hijos();
        if(isset($modelos_hijos['error'])){
            return $this->errores->datos(1,'Error al generar $modelos_hijos',__CLASS__,
                __LINE__,__FILE__,$modelos_hijos,__FUNCTION__);
        }
        $new_array = $this->maqueta_arreglo_registros($r_sql,$modelos_hijos);
        if(isset($new_array['error'])){
            return $this->errores->datos(1,'Error al generar arreglo con registros',__CLASS__,
                __LINE__,__FILE__,$new_array,__FUNCTION__);
        }

        return $new_array;
    }

    public function str_replace_first($from, $to, $content){ //PRUEBA COMPLETA PROTEO
        if($content === ''){
            return $this->errores->datos(1,'Error al content esta vacio',
                __CLASS__,__LINE__,__FILE__,$content,__FUNCTION__);
        }
        if($from === ''){
            return $this->errores->datos(1,'Error from esta vacio',
                __CLASS__,__LINE__,__FILE__,$from,__FUNCTION__);
        }
        $from = '/'.preg_quote($from, '/').'/';
        return preg_replace($from, $to, $content, 1);
    }

    public function suma(array $campos, array $filtro = array()){ //PRUEBA COMPLETA PROTEO
        $this->filtro = $filtro;
        if(count($campos)===0){
            return $this->errores->datos(1,'Error campos no puede venir vacio',__CLASS__,
                __LINE__,__FILE__,$campos,__FUNCTION__);
        }

        $columnas = '';
        foreach($campos as $alias =>$campo){
            if(is_numeric($alias)){
                return $this->errores->datos(1,'Error $alias no es txt $campos[alias]=campo',__CLASS__,
                    __LINE__,__FILE__,$campos,__FUNCTION__);
            }
            if($campo === ''){
                return $this->errores->datos(1,'Error $campo esta vacio $campos[alias]=campo',__CLASS__,
                    __LINE__,__FILE__,$campos,__FUNCTION__);
            }
            if($columnas === '') {
                $columnas .= 'IFNULL( SUM('. $campo .') ,0)AS ' . $alias;
            }

            else{
                $columnas .= ', IFNULL( SUM('. $campo .'),0) AS ' . $alias;
            }
        }

        $filtro_sql = $this->genera_and();
        if(isset($filtro_sql['error'])){
            return $this->errores->datos(1,'Error al generar filtro',__CLASS__,
                __LINE__,__FILE__,$filtro_sql,__FUNCTION__);
        }

        $where = '';
        if(trim($filtro_sql) !== '' ){
            $where = ' WHERE '. $filtro_sql;
        }

        $consulta_base = new consultas_base();
        $tabla = $this->tabla;
        $tablas = $consulta_base->obten_tablas_completas($tabla, $this->columnas);
        if(isset($tablas['error'])){
            return $this->errores->datos(1,'Error al obtener tablas',__CLASS__,
                __LINE__,__FILE__,$tablas,__FUNCTION__);
        }

        $this->consulta = 'SELECT '.$columnas.' FROM '.$tablas.$where;

        $resultado = $this->ejecuta_consulta();
        if(isset($resultado['error'])){
            return $this->errores->datos(1,'Error al ejecutar sql',__CLASS__,
                __LINE__,__FILE__,$resultado,__FUNCTION__);
        }


        return $resultado['registros'][0];
    }

    public function usuario_existente(){ //PRUEBA COMPLETA PROTEO
        if($this->usuario_id <=0){
            return $this->errores->datos(1,'Error usuario invalido',__CLASS__,__LINE__,
                __FILE__,array($this->usuario_id),__FUNCTION__);
        }

        $this->consulta = 'SELECT count(*) AS existe FROM usuario WHERE usuario.id = '.$this->usuario_id;
        $r_usuario_existente = $this->ejecuta_consulta();

        if(isset($r_usuario_existente['error'])){
            return $this->errores->datos(1,'Error al ejecutar sql',__CLASS__,__LINE__,
                __FILE__,array($r_usuario_existente),__FUNCTION__);
        }

        $usuario_existente = $r_usuario_existente['registros'][0];

        $update_valido = false;
        if((int)$usuario_existente['existe'] === 1){
            $update_valido = true;
        }
        return $update_valido;

    }

    public function valida_base_ultimo_codigo(array $registros, string $key){ //PRUEBA COMPLETA PROTEO
        if(!isset($registros['registros'])){
            return $this->errores->datos(1,'Error no existe registros en registro',__CLASS__,__LINE__,
                __FILE__,$registros,__FUNCTION__);
        }
        if(!isset($registros['registros'][0])){
            return $this->errores->datos(1,'Error no existe registros[registro][0]',__CLASS__,__LINE__,
                __FILE__,$registros,__FUNCTION__);
        }
        if($key === ''){
            return $this->errores->datos(1,'Error no existe key no puede venir vacio',__CLASS__,__LINE__,
                __FILE__,$key,__FUNCTION__);
        }
        return $registros;
    }

    public function valida_campo_obligatorio(){ //PRUEBA COMPLETA PROTEO

        foreach($this->campos_obligatorios as $campo_obligatorio){
            $campo_obligatorio = trim($campo_obligatorio);
            if(!key_exists($campo_obligatorio,$this->registro)){
                return $this->errores->datos(1,'Error el campo '.$campo_obligatorio.' debe existir',
                    __CLASS__,__LINE__,__FILE__,array($this->registro,$this->campos_obligatorios),__FUNCTION__);
            }
            if((string)$this->registro[$campo_obligatorio] === ''){
                return $this->errores->datos(1,'Error el campo '.$campo_obligatorio.' no puede venir vacio',
                    __CLASS__,__LINE__,__FILE__,array($this->registro,$this->campos_obligatorios),__FUNCTION__);
            }
        }

        return $this->campos_obligatorios;

    }

    public function valida_data_modelo(string $name_modelo){ //FIN
        if($name_modelo ===''){
            return $this->errores->datos(1,'Error modelo no puede venir vacio',__CLASS__,
                __LINE__,__FILE__,$name_modelo,__FUNCTION__);
        }
        if(is_numeric($name_modelo)){
            return $this->errores->datos(1,'Error modelo debe ser un txt',__CLASS__,
                __LINE__,__FILE__,$name_modelo,__FUNCTION__);
        }
        if(!class_exists($name_modelo)){
            return $this->errores->datos(1,'Error modelo no existe',__CLASS__,
                __LINE__,__FILE__,$name_modelo,__FUNCTION__);
        }

        return $name_modelo;

    }

    public function valida_estructura_campos(array $keys_obligatorios = array(), array $keys_ids = array(),
                                             array $keys_checked = array()){ //PRUEBA COMPLETA PROTEO

        foreach($this->tipo_campos as $key =>$tipo_campo){
            $valida_campos = $this->valida_pattern_campo($key,$tipo_campo);
            if(isset($valida_campos['error'])){
                return $this->errores->datos(1,'Error al validar campos',
                    __CLASS__,__LINE__,__FILE__,$valida_campos,__FUNCTION__);
            }
        }

        foreach($keys_obligatorios as $campo){
            if(!isset($this->registro[$campo])){
                return $this->errores->datos(1,'Error $registro['.$campo.'] debe existir',
                    __CLASS__,__LINE__,__FILE__,$this->registro,__FUNCTION__);
            }
        }
        foreach($keys_obligatorios as $campo){
            if((string)$this->registro[$campo] === ''){
                return $this->errores->datos(1,'Error $registro['.$campo.'] debe tener datos',
                    __CLASS__,__LINE__,__FILE__,$this->registro,__FUNCTION__);
            }
        }
        foreach($keys_ids as $campo){
            if(!preg_match($this->patterns['id'], $this->registro[$campo])){
                return $this->errores->datos(1,'Error $registro['.$campo.'] es invalido',
                    __CLASS__,__LINE__,__FILE__,array($this->registro[$campo],$this->patterns['id']),
                    __FUNCTION__);
            }
        }
        foreach($keys_checked as $campo){
            if((string)$this->registro[$campo] !== 'activo' && (string)$this->registro[$campo]!=='inactivo' ){
                return $this->errores->datos(1,'Error $registro['.$campo.'] debe ser activo o inactivo',
                    __CLASS__,__LINE__,__FILE__,$this->registro,__FUNCTION__);
            }
        }

        return $this->registro;
    }

    public function valida_pattern(string $key, string $tipo_campo){ //PRUEBA COMPLETA PROTEO
        if(!isset($this->registro[$key])){
            return $this->errores->datos(1,'Error no existe el campo '.$key,__CLASS__,__LINE__,__FILE__,
                $this->registro,__FUNCTION__);
        }
        if(!isset($this->patterns[$tipo_campo])){
            return $this->errores->datos(1,'Error no existe el pattern '.$tipo_campo,__CLASS__,__LINE__,__FILE__,
                $this->registro,__FUNCTION__);
        }
        $value = trim($this->registro[$key]);
        $pattern = trim($this->patterns[$tipo_campo]);

        if(!preg_match($pattern, $value)){
            return $this->errores->datos(1,'Error el campo '.$key.' es invalido',
                __CLASS__,__LINE__,__FILE__,array($this->registro[$key],$pattern),__FUNCTION__);
        }
        return array($this->registro[$key]);
    }

    public function valida_pattern_campo(string $key, string $tipo_campo){ //PRUEBA COMPLETA PROTEO
        if(count($this->registro) === 0){
            return $this->errores->datos(1,'Error el registro no no puede venir vacio',
                __CLASS__,__LINE__,__FILE__,$this->registro,__FUNCTION__);
        }
        if(isset($this->registro[$key])&&(string)$this->registro[$key] !==''){
            $valida_data = $this->valida_pattern($key,$tipo_campo);
            if(isset($valida_data['error'])){
                return $this->errores->datos(1,'Error al validar',
                    __CLASS__,__LINE__,__FILE__,$valida_data,__FUNCTION__);
            }
        }
        return $this->registro;
    }

}
