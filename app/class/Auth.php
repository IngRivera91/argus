<?php

namespace App\class;

use App\models\User;
use Carbon\Carbon;
use App\errors\Base AS ErrorBase;

class Auth
{
    /**
     * @throws ErrorBase
     */
    public static function login()
    {
        self::checkUserAndPassword($_POST);

        $user = $_POST['usuario'];
        $password = self::encryptPassword($_POST['password']);
        $User = User::where('user',$user)->where('password',$password)->get()->first();

        $sessionId = self::generateSessionId($user, $password);

        dd($User);
    }

    public static function encryptPassword (string $password) : String
    {
        return md5(md5($password.APP_KEY));
    }

    protected static function insertSessionId(string $sessionId, int $userId) : void
    {

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