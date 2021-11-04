<?php

namespace App\class;

class Auth
{
    public static function login()
    {

    }

    public static function encryptPassword (string $password) : String
    {
        return md5($password);
    }
}