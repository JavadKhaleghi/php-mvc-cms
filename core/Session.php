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

    // message type can be:
    // success, danger, warning, primary, secondary, info. light, dark
    public static function message($message, $type = 'danger')
    {
        $alerts = self::exists('session_alerts') ? self::get('session_alerts') : [];
        $alerts[$type][] = $message;
        self::set('session_alerts', $alerts);
    }

    public static function displaySessionAlerts()
    {
        $alerts = self::exists('session_alerts') ? self::get('session_alerts') : [];
        $html = '';

        foreach($alerts as $type => $messages) {
            foreach($messages as $message) {
                $html .= "<div class='alert alert-dismissable alert-{$type}'>{$message}<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>"; 
            }
        }

        self::delete('session_alerts');

        return $html;
    }
}