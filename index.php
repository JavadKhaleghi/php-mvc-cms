<?php

session_start();

use \Core\{Config, Router};
use App\Models\User;

// application constants
define('SITE_ROOT', __DIR__);
define('DS', DIRECTORY_SEPARATOR);

spl_autoload_register(function($className) {
    $parts = explode('\\', $className);
    $class = end($parts);

    array_pop($parts);

    $path = strtolower(implode(DS, $parts));
    $path = SITE_ROOT . DS . $path . DS . $class . '.php'; // full file path

    if(file_exists($path)) {
        include($path);
    }
});

// logged in user check
$currentLoggedInUser = User::getCurrentLoggedInUser();

$rootDirectory = Config::get('root_directory');
define('ROOT', $rootDirectory);

$url = $_SERVER['REQUEST_URI'];
$url = str_replace(ROOT, '', $url); // delete site root from URL
$url = preg_replace('/(\?.+)/', '', $url); // delete query strings from URL

Router::route($url);




