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
        $this->validaUsuarioYPassword($_POST);

        $filtros = [
            ['campo' => "usuarios.usuario" , 'valor' =>  $_POST['usuario'] , 'signoComparacion' => '=' , 'conectivaLogica' => '' ],
            ['campo' => "usuarios.password", 'valor' =>  md5($_POST['password']) , 'signoComparacion' => '=' , 'conectivaLogica' => 'AND']
        ];
        
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

    private function validaUsuarioYPassword($datosPost){
        if ( !isset($datosPost['usuario']) ){
            throw new ErrorBase('Debe existir $_POST[\'usuarios\']');
        }
        if ( $datosPost['usuario'] == ''){
            throw new ErrorBase('$_POST[\'usuarios\'] no pude estar vacio');
        }
        if ( !isset($datosPost['password']) ){
            throw new ErrorBase('Debe existir $_POST[\'password\']');
        }
        if ( $datosPost['password'] == ''){
            throw new ErrorBase('$_POST[\'password\'] no pude estar vacio');
        }
    }
}