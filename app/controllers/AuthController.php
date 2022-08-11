<?php

namespace App\Controllers;

use App\Models\User;
use Core\{Controller, Helper, Session, Router};

class AuthController extends Controller
{
    public function registerAction($id = 'new')
    {
        if($id == 'new') {
            $user = new User();
        } else {
            $user = User::findById($id);
        }

        if(! $user) {
            Session::message('Access denied: you don not have permissions for this action.');
            Router::redirect();
        }

        // if form is submitted and the method is POST
        if($this->request->isPost()) {
            Session::csrf();
            $fields = ['first_name', 'last_name', 'email', 'acl', 'password', 'confirm'];

            foreach($fields as $field) {
                $user->{$field} = $this->request->get($field);
            }

            if(! empty($user->password) && $id != 'new') {
                $user->resetPassword = true;
            }

            if($user->save()) {
                $message = ($id == 'new') ? 'New user created.' : 'User updated.';
                Session::message($message, 'success');
                Router::redirect();
            }
        }

        $pageTitle = $id == 'new' ? 'Add new user' : 'Update user';
        $this->view->setSiteTitle($pageTitle);
        $this->view->user = $user;
        $this->view->errors = $user->getErrors();
        $this->view->roleOptions = [
            User::USER_PERMISSION   => 'User', 
            User::AUTHOR_PERMISSION => 'Author', 
            User::ADMIN_PERMISSION  => 'Admin'
        ];

        $this->view->render();
    }
}