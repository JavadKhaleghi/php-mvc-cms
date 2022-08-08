<?php

namespace Core;

use Core\{Router, Request};

class Session
{
    public static function exists($name)
    {
        return isset($_SESSION[$name]);
    }

    public static function get($name)
    {
        if(self::exists($name) && ! empty($_SESSION[$name])) {
            return $_SESSION[$name];
        }

        return false;
    }

    public static function set($name, $value)
    {
        $_SESSION[$name] = $value;
    }

    public static function delete($name)
    {
        unset($_SESSION[$name]);
    }

    public static function csrf()
    {
        $request = new Request();
        $check = $request->get('csrf_token');

        if(self::exists('csrf_token') && self::get('csrf_token') == $check) {
            return true;
        }

        Router::redirect('auth/token');
    }

    public static function createCsrfToken()
    {
        $token = md5('csrf' . time());
        self::set('csrf_token', $token);

        return $token;
    }
}