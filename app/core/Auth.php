<?php

namespace App\Core;
use App\Core\Settings;

class Auth {
    private static bool $auth = false;

    public static function login($password) : bool
    {
        if ( md5($password) === Settings::get('admin_password') )
        {
            $_SESSION["admin_password"] = $password;
            return true;
        }

        if ( isset($_SESSION["admin_password"]) ) unset($_SESSION["admin_password"]);
        return false;
    }

    public static function check() : void 
    {
        if ( isset($_SESSION["admin_password"]) )
        {
            if ( md5($_SESSION["admin_password"]) === Settings::get('admin_password') )
            {
                static::$auth = true;
                return;
            }

            unset($_SESSION["admin_password"]);
        }
    }

    public static function is_auth() : bool 
    {
        return static::$auth;
    }

    public static function is_quest() : bool 
    {
        return !static::$auth;
    }
}