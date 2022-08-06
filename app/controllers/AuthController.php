<?php

namespace App\Controllers;

use Core\{Controller, Helper, Session, Router};

class AuthController extends Controller
{
    public function registerAction($id = 'new')
    {
        $this->view->setSiteTitle('Register');
        $this->view->errors = [];
        $this->view->render();
    }
}