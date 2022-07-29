<?php

namespace Core;

class Router
{
    public static function route($url)
    {
        // extract URL parts
        $ulrElements = explode('/', $url);

        // get controller name from the first index of URL
        $controller = !empty($ulrElements[0]) ? $ulrElements[0] : Config::get('default_controller');
        $controllerName = $controller;
        
        // get full namespaced controller
        $controller = 'App\Controllers\\' . ucwords($controller) . 'Controller';

        // get action name from the second index of URL
        array_shift($ulrElements);
        $action = !empty($ulrElements[0]) ? $ulrElements[0] : 'index';
        $actionName = $action;
        $action .= 'Action';

        // get params
        array_shift($ulrElements);

        // check if controller class exists
        if(!class_exists($controller)) {
            throw new \Exception("The controller [{$controller}] does not exist.");
        }

        // instaciate controller class
        $controllerClass = new $controller($controllerName, $actionName);

        // check if method exists
        if(!method_exists($controllerClass, $action)) {
            throw new \Exception("The method [{$action}] does not exist on [{$controller}] controller.");
        }

        call_user_func_array([$controllerClass, $action], $ulrElements);
    }
}