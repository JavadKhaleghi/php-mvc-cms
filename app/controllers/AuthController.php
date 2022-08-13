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
                Router::redirect('admin/users');
            }
        }

        $pageTitle = $id == 'new' ? 'Add new user' : 'Update user';
        $this->view->setLayout('admin');
        $this->view->setSiteTitle('Add User');
        $this->view->user = $user;
        $this->view->errors = $user->getErrors();
        $this->view->roleOptions = [
            User::USER_PERMISSION   => 'User', 
            User::AUTHOR_PERMISSION => 'Author', 
            User::ADMIN_PERMISSION  => 'Admin'
        ];

        $this->view->render();
    }

    public function loginAction()
    {
        $user = new User();
        $hasError = true;

        if($this->request->isPost()) {
            Session::csrf();
            $user->email = $this->request->get('email');
            $user->password = $this->request->get('password');
            $user->remember = $this->request->get('remember');
            $user->validateLogin();

            if(empty($user->getErrors())) {
                // check user credentials
                $requestedUser = User::findFirst([
                    'conditions' => "email = :email",
                    'bind' => ['email' => $this->request->get('email')]
                ]);

                if($requestedUser) {
                    $verifiedPassword = password_verify($this->request->get('password'), $requestedUser->password);

                    if($verifiedPassword) {
                        // login process
                        $hasError = false;
                        $remember = $this->request->get('remember') == 'on';
                        $requestedUser->login($remember);
                        Router::redirect();
                    }
                }
            }

            if($hasError) {
                $user->setError('email', 'Email or password is not correct.');
                $user->setError('password', '');
            }
        }

        $this->view->setSiteTitle('Login');
        $this->view->user = $user;
        $this->view->errors = $user->getErrors();
        $this->view->render();
    }

    public function logoutAction()
    {
        global $currentLoggedInUser;

        if($currentLoggedInUser) {
            $currentLoggedInUser->logout();
        }

        Router::redirect('auth/login');
    }
}