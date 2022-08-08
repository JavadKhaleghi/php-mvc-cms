<?php

namespace Core;

class Router
{
    public static function route($url)
    {
        // extract URL parts
        $urlElements = explode('/', $url);

        // get controller name from the first index of URL
        $controller = ! empty($urlElements[0]) ? $urlElements[0] : Config::get('default_controller');
        $controllerName = $controller;
        
        // get full namespaced controller
        $controller = 'App\Controllers\\' . ucwords($controller) . 'Controller';

        // get action name from the second index of URL
        array_shift($urlElements);
        $action = ! empty($urlElements[0]) ? $urlElements[0] : 'index';
        $actionName = $action;
        $action .= 'Action';

        // get params
        array_shift($urlElements);

        // check if controller class exists
        if(! class_exists($controller)) {
            throw new \Exception("The controller [{$controller}] does not exist.");
        }

        // instaciate controller class
        $controllerClass = new $controller($controllerName, $actionName);

        // check if method exists
        if(! method_exists($controllerClass, $action)) {
            throw new \Exception("The method [{$action}] does not exist on [{$controller}] controller.");
        }

        call_user_func_array([$controllerClass, $action], $urlElements);
    }

    public static function redirect($path)
    {
        if (!headers_sent()) {
            header('Location: ' . ROOT . $path);
        } else {
            echo '<script type="text/javascript">';
            echo 'window.location.href = "' . ROOT . $path . '"';
            echo '</script>';
            echo '<nosript>';
            echo '<meta http-equiv="refresh" content="0;url=' . ROOT . $path . '" />';
            echo '</nosript>';
        }

        exit();
    }
}