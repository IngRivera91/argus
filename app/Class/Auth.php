<?php

namespace App\Class;

use App\models\Group;
use App\models\Menu;
use App\models\Session;
use App\models\User;
use Carbon\Carbon;
use App\Errors\Base AS ErrorBase;
use JetBrains\PhpStorm\ArrayShape;

class Auth
{
    /**
     * @throws ErrorBase
     */
    #[ArrayShape(
        ['sessionId' => "String"])
    ]
    public static function login() : array
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

    public static function hasPermission(string $currentController, string $currentMethod) : bool
    {
        $menuId = Menu::where('name',$currentController)->first()->id;

        $result = Group::find(GRUPO_ID)->methods()
            ->where('name',$currentMethod)
            ->where('menu_id',$menuId)
            ->where('activo',1)
            ->get()->toArray();

        if (count($result) == 1) {
            return true;
        }

        return false;
    }

    /**
     * @throws ErrorBase
     */
    private static function checkUserAndPassword(array $dataPost) : void
    {
        if ( !isset($dataPost['usuario']) )
        {
            throw new ErrorBase('Debe existir $_POST[\'usuario\']');
        }
        if ( $dataPost['usuario'] == '')
        {
            throw new ErrorBase('$_POST[\'usuarios\'] no puede estar vacio');
        }
        if ( !isset($dataPost['password']) )
        {
            throw new ErrorBase('Debe existir $_POST[\'password\']');
        }
        if ( $dataPost['password'] == '')
        {
            throw new ErrorBase('$_POST[\'password\'] no puede estar vacio');
        }
        if  ( count($dataPost) !== 2 )
        {
            throw new ErrorBase('En la variable $_POST solo debe venir el usuario y el password');
        }
    }
}