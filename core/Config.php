<?php

namespace Core;

class Config
{
    private static $config = [
        'version'            => '1.0.0',
        'root_directory'     => '/php-mvc-cms/', /* change to "/" on a live server */
        'default_controller' => 'Home', /* default application controller */
        'default_layout'     => 'site', /* default application layout */
        'default_site_title' => 'PHP MVC CMS', /* default site title */
        'db_host'            => '127.0.0.1', /* database host, just use IP address */
        'db_name'            => 'php_mvc_cms', /* database name */
        'db_user'            => 'root', /* database username */
        'db_password'        => '', /* database password */
        'login_cookie_name'  => 'dTnkA34oRs76xZ01sQb81', /* login cookie name, a random complex string */
    ];

    public static function get($key)
    {
        return array_key_exists($key, self::$config) ? self::$config[$key] : null;
    }
}