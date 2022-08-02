<?php

namespace App\Controllers;

use Core\{Controller, Database, Helper};

class HomeController extends Controller
{
    public function indexAction()
    {
        $db = Database::getInstance();

        $this->view->setSiteTitle('Home :: PHP MVC');
        $this->view->render();
    }
}
