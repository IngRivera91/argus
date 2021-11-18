<?php

namespace App\Class;

use App\Errors\Base;
use App\Models\Method;
use App\models\Session;
use App\models\User;
use Carbon\Carbon;
use App\Errors\Base AS ErrorBase;
use JetBrains\PhpStorm\ArrayShape;
use Symfony\Component\VarDumper\Dumper\DataDumperInterface;

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

        $User = User::query()->where('user',$user)->where('password',$password)->first();

        $sessionId = self::generateSessionId($user, $password);
        self::insertSessionId($sessionId, $User->id);

        return ['sessionId' => $sessionId];
    }

    public static function logout(string $sessionId) : void
    {
        $Session = Session::query()->where('session_id', $sessionId)->first();
        $Session->delete();
    }

    public static function encryptPassword (string $password) : String
    {
        return md5(md5($password.APP_KEY));
    }

    /**
     * @throws ErrorBase
     */
    public static function checkSessionId(string $sessionId)
    {
        $Session = Session::with('user')->where('session_id', $sessionId)->first();

        if (!$Session) throw new ErrorBase('sessionId no encontrado');

        define('USUARIO_ID',$Session->user_id);
        define('SESSION_ID',$sessionId);
        define('NOMBRE_USUARIO',strtoupper($Session->user->name.$Session->user->last_name));
        define('GRUPO_ID',$Session->user->group_id);
        define('GRUPO',strtoupper($Session->user->group->name));
    }

    protected static function insertSessionId(string $sessionId, int $userId): void
    {
       Session::query()->create(['session_id' => $sessionId, 'user_id' => $userId]);
    }

    public  static function generateSessionId(string $usuario, string $password) : String
    {
        return md5(md5($usuario.$password.Carbon::now()));
    }

    public static function hasPermission(int $groupId, string $currentController, string $currentMethod) : bool
    {
        $result = Method::query()
            ->whereRelation('groups', 'groups.id', $groupId)
            ->whereRelation('menu', 'menus.name', $currentController)
            ->where('methods.name',$currentMethod)
            ->where('activo', 1)
            ->get()->count();

        if ($result == 1) {
            return true;
        }

        if ($result > 1 && DEBUG_MODE) {
            $e = new ErrorBase('La consulta esta obteniendo mas de dos registros');
            $e->muestraError();
            exit;
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