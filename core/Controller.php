<?php

namespace Core;

class Controller
{
    public $view;
    public $request;
    
    private $_controllerName;
    private $_actionName;

    public function __construct($controller, $action)
    {
        $this->_controllerName = $controller;
        $this->_actionName = $action;
    }
}