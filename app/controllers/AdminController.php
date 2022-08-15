<?php

namespace App\Controllers;

use Core\Controller;
use App\Models\{Article, Category, User};
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

    public function articleAction($id = 'new')
    {
        Router::checkPermission('admin', 'admin/articles');
        $params = [
            'conditions' => "id = :id AND user_id = :user_id",
            'bind' => ['id' => $id, 'user_id' => $this->currentUser->id]
        ];
        $article = $id == 'new' ? new Article() : Article::findFirst($params);

        if (! $article) {
            Session::message('Article does not exist or you do not have permission to edit this.');
            Router::redirect('admin/articles');
        }

        if ($this->request->isPost()) {
            Session::csrf();
            $article->title = $this->request->get('title');
            $article->body = $this->request->get('body');
            $article->category_id = $this->request->get('category_id');
            $article->status = $this->request->get('status');
            $article->user_id = $this->currentUser->id;

            if ($article->save()) {
                Session::message('Article saved.', 'success');
                Router::redirect('admin/articles');
            }
        }

        $categories = Category::find(['order' => 'name']);
        $categoryOptions = [0 => 'Uncategorized'];

        foreach($categories as $category) {
            $categoryOptions[$category->id] = $category->name;
        }

        $pageTitle = $id == 'new' ? 'Add article' : 'Edit article';
        $this->view->statusOptions = ['private' => 'Private', 'public' => 'Public'];
        $this->view->categoryOptions = $categoryOptions;
        $this->view->setLayout('admin');
        $this->view->setSiteTitle($pageTitle);
        $this->view->article = $article;
        $this->view->errors = $article->getErrors();
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