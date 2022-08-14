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
        Router::checkPermission(['author', 'admin'], '');
        $this->view->setSiteTitle('Articles');
        $this->view->render();
    }

    public function usersAction()
    {
        Router::checkPermission('admin', 'admin/articles');

        $params = [
            'order' => 'last_name, first_name'
        ];

        $params = User::mergeWithPagination($params);

        $this->view->setSiteTitle('Users');
        $this->view->users = User::find($params);
        $this->view->total = User::findTotal($params);
        $this->view->render();
    }

    public function toggleUserStatusAction($id)
    {
        Router::checkPermission('admin', 'admin/articles');
        $user = User::findById($id);

        if($user) {
            $user->banned = $user->banned ? 0 : 1;
            $user->save();
            $message = $user->banned ? 'User blocked.' : 'User unblocked.';
        }

        Session::message($message, 'success');
        Router::redirect('admin/users');
    }

    public function deleteUserAction($id)
    {
        Router::checkPermission('admin', 'admin/articles');
        $user = User::findById($id);
        $messageType = 'danger';
        $message = 'User cannot be deleted.';

        if ($user && $user->id !== User::getCurrentLoggedInUser()->id) {
            $user->delete();
            $messageType = 'success';
            $message = 'User deleted.';
        }

        Session::message($message, $messageType);
        Router::redirect('admin/users');
    }
}