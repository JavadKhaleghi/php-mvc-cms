<?php

namespace App\Controllers;

use Core\Controller;
use App\Models\{Category, User};
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

    public function categoriesAction()
    {
        Router::checkPermission('admin', 'admin/articles');
        $params = ['order' => 'name'];
        $params = Category::mergeWithPagination($params);

        $this->view->setSiteTitle('Categories');
        $this->view->categories = Category::find($params);
        $this->view->total = Category::findTotal($params);
        $this->view->render();
    }

    public function categoryAction($id = 'new')
    {
        Router::checkPermission('admin', 'admin/articles');
        $category = $id == 'new' ? new Category() : Category::findById($id);

        if(! $category) {
            Session::message('Category does not exist.');
            Router::redirect('admin/categories');
        }

        if($this->request->isPost()) {
            Session::csrf();
            $category->name = $this->request->get('name');

            if($category->save()) {
                Session::message('Category saved.', 'success');
                Router::redirect('admin/categories');
            }
        }

        $pageTitle = $id == 'new' ? 'Add category' : 'Edit category';
        $this->view->setLayout('admin');
        $this->view->setSiteTitle($pageTitle);
        $this->view->category = $category;
        $this->view->errors = $category->getErrors();
        $this->view->render();
    }

    public function deleteCategoryAction($id)
    {
        Router::checkPermission('admin', 'admin/articles');
        $category = Category::findById($id);

        if(! $category) {
            Session::message('Category does not exist.');
            Router::redirect('admin/categories');
        } else {
            $category->delete();
            Session::message('Category deleted.', 'success');
            Router::redirect('admin/categories');
        }
    }
}