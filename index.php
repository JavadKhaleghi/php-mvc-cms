<?php

session_start();

use \Core\Config;

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


