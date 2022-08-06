<?php

namespace App\Controllers;

use Core\{Controller, Helper, Session, Router};
use App\Models\User;

class AuthController extends Controller
{
    public function registerAction($id = 'new')
    {
        if($id = 'new') {
            $user = new User();
        } else {
            $user = User::findById($id);
        }

        // if form is submitted and the method is POST
        if($this->request->isPost()) {
            
        }

        $this->view->setSiteTitle('Register');
        $this->view->errors = $user->getErrors();
        $this->view->roleOptions = ['' => '', User::AUTHOR_PERMISSION => 'Author', User::ADMIN_PERMISSION => 'Admin'];
        $this->view->user = $user;
        $this->view->render();
    }
}