<?php

namespace Core;

class Router
{
    public static function route($url)
    {
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

        // instaciate controller class
        $controllerClass = new $controller($controllerName, $actionName);
        call_user_func_array([$controllerClass, $action], $ulrElements);
    }
}