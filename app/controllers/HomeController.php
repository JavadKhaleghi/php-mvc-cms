<?php

namespace App\Controllers;

use Core\{Controller, Database, Session};

class HomeController extends Controller
{
    public function indexAction()
    {
        $this->view->setSiteTitle('Home :: PHP MVC');
        $this->view->render();
    }
}
