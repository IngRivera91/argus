<?php

namespace Clase;

use Clase\Database;
use Modelo\Usuarios;
use Modelo\Sessiones;
use Error\Base AS ErrorBase;
use Error\Esperado AS ErrorEsperado;

class Autentificacion 
{
    private $modeloUsuarios;
    private $modeloSessiones;
    public function __construct(Database $coneccion)
    {
        $this->modeloSessiones = new Sessiones($coneccion);
        $this->modeloUsuarios = new Usuarios($coneccion);
    }

    public function login()
    {
        $this->validaUsuarioYPassword_Post();

        $filtros = [
            ['campo' => "usuarios.usuario" , 'valor' =>  $_POST['usuario'] , 'signoComparacion' => '=' , 'conectivaLogica' => '' ],
            ['campo' => "usuarios.password", 'valor' =>  md5($_POST['password']) , 'signoComparacion' => '=' , 'conectivaLogica' => 'AND']
        ];
        $columnas  = ['id'];
        $orderBy = []; 
        $limit = '';
        $noUsarRelaciones = true;
        $resultado = $this->modeloUsuarios->buscarConFiltros($filtros);
        
        if ( $resultado['n_registros'] !== 1){
            throw new ErrorEsperado('usuario o contraseña incorrecto');
        }

        $usuario = $resultado['registros'][0];
        $fechaHora = date('Y-m-d h:m:s');
        $session_id = md5( md5( $_POST['usuario'].$_POST['password'].$fechaHora ) );

        $datos['session_id'] = $session_id;
        $datos['usuario_id'] = $usuario['usuarios_id'];
        $datos['grupo_id'] = $usuario['usuarios_grupo_id'];
        $datos['fecha_registro'] = $fechaHora;

        $resultado = $this->modeloSessiones->registrar($datos);
        return ['session_id' => $session_id , 'usuario' => $usuario , 'fechaHora' => $fechaHora];
    }

    private function validaUsuarioYPassword_Post(){
        if ( !isset($_POST['usuario']) ){
            throw new ErrorBase('Debe existir $_POST[\'usuarios\']');
        }
        if ( $_POST['usuario'] == ''){
            throw new ErrorBase('$_POST[\'usuarios\'] no pude estar vacio');
        }
        if ( !isset($_POST['password']) ){
            throw new ErrorBase('Debe existir $_POST[\'password\']');
        }
        if ( $_POST['password'] == ''){
            throw new ErrorBase('$_POST[\'password\'] no pude estar vacio');
        }
    }
}