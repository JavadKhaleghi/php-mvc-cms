<?php

namespace App\Controllers;

use Core\Controller;
use App\Models\{User};
use Core\{Router, Session};

class AdminController extends Controller
{
    public function onConstruct()
    {
        $this->view->setLayout('admin');
        $this->currentUser = User::getCurrentLoggedInUser();
    }

    public function articlesAction()
    {
        $this->view->setSiteTitle('Articles');
        $this->view->render();
    }

    public function usersAction()
    {
        $hasPermission = $this->currentUser->hasPermission('admin');

        if(! $hasPermission) {
            Session::message('Access denied: 403');
            Router::redirect('admin/articles');
        }

        $params = [
            'order' => 'last_name, first_name'
        ];

        $this->view->setSiteTitle('Users');
        $this->view->users = User::find($params);
        $this->view->total = User::findTotal($params);
        $this->view->render();
    }
}