<?php

namespace App\class;

use App\models\Session;
use App\models\User;
use Carbon\Carbon;
use App\errors\Base AS ErrorBase;
use JetBrains\PhpStorm\ArrayShape;

class Auth
{
    /**
     * @throws ErrorBase
     */
    #[ArrayShape(
        ['sessionId' => "String"])
    ]
    public static function login() : Array
    {
        self::checkUserAndPassword($_POST);

        $user = $_POST['usuario'];
        $password = self::encryptPassword($_POST['password']);

        $User = User::where('user',$user)->where('password',$password)->first();

        $sessionId = self::generateSessionId($user, $password);
        $Session = self::insertSessionId($sessionId, $User->id);

        return ['sessionId' => $sessionId];
    }

    public static function logout(string $sessionId) : void
    {
        $Session = Session::where('session_id', $sessionId)->first();
        $Session->delete();
    }

    public static function encryptPassword (string $password) : String
    {
        return md5(md5($password.APP_KEY));
    }

    public static function checkSessionId(string $sessionId)
    {
        $Session = Session::where('session_id', $sessionId)->first();

        define('USUARIO_ID',$Session->user_id);
        define('SESSION_ID',$sessionId);
        define('NOMBRE_USUARIO',strtoupper($Session->user->name.$Session->user->last_name));
        define('GRUPO_ID',$Session->user->group_id);
        define('GRUPO',strtoupper($Session->user->group->name));
    }

    protected static function insertSessionId(string $sessionId, int $userId)
    {
       return Session::create(['session_id' => $sessionId, 'user_id' => $userId]);
    }

    public  static function generateSessionId(string $usuario, string $password) : String
    {
        return md5(md5($usuario.$password.Carbon::now()));
    }

    private static function checkUserAndPassword(array $dataPost) : void
    {
        if ( !isset($dataPost['usuario']) )
        {
            throw new ErrorBase('Debe existir $_POST[\'usuario\']');
        }
        if ( $dataPost['usuario'] == '')
        {
            throw new ErrorBase('$_POST[\'usuarios\'] no pude estar vacio');
        }
        if ( !isset($dataPost['password']) )
        {
            throw new ErrorBase('Debe existir $_POST[\'password\']');
        }
        if ( $dataPost['password'] == '')
        {
            throw new ErrorBase('$_POST[\'password\'] no pude estar vacio');
        }
        if  ( count($dataPost) !== 2 )
        {
            throw new ErrorBase('En la variable $_POST solo debe venir el usuario y el password');
        }
    }
}