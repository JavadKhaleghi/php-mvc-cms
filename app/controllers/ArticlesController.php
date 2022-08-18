<?php

namespace App\Controllers;

use App\Models\{Article, Category, User};
use Core\{Controller, Router, Session};

class ArticlesController extends Controller
{
    public function indexAction()
    {
        $params = [
            'columns' => 'articles.*, users.first_name, users.last_name, categories.name AS category, categories.id AS category_id',
            'conditions' => "articles.status = :status",
            'bind' => ['status' => 'public'],
            'joins' => [
                ['users', 'articles.user_id = users.id'],
                ['categories', 'articles.category_id = categories.id', 'categories', 'LEFT']
            ],
            'order' => 'articles.created_at DESC'
        ];
        
        $params = Article::mergeWithPagination($params);
        
        $this->view->articles = Article::find($params);;
        $this->view->total = Article::findTotal($params);
        $this->view->setSiteTitle('Articles');
        $this->view->render();
    }
    
    public function categoryAction($categoryId)
    {
        $params = [
            'columns' => 'articles.*, users.first_name, users.last_name, categories.name AS category, categories.id AS category_id',
            'conditions' => "articles.category_id = :categoryId AND articles.status = :status",
            'bind' => ['status' => 'public', 'categoryId' => $categoryId],
            'joins' => [
                ['users', 'articles.user_id = users.id'],
                ['categories', 'articles.category_id = categories.id', 'categories', 'LEFT']
            ],
            'order' => 'articles.created_at DESC'
        ];
    
        $params = Article::mergeWithPagination($params);
        
        if ($categoryId == 0) {
            $category = new Category();
            $categoryId = 0;
            $category->name = 'Uncategorized';
        } else {
            $category = Category::findById($categoryId);
        }
        
        // check if category exists
        if (! $category) {
            Session::message('Category does not exist.', 'warning');
            Router::redirect();
        }
    
        $this->view->articles = Article::find($params);;
        $this->view->total = Article::findTotal($params);
        $this->view->setSiteTitle('Category: ' . $category->name);
        $this->view->render('articles/index');
    }
    
    public function authorAction($authorId)
    {
        $params = [
            'columns' => 'articles.*, users.first_name, users.last_name, categories.name AS category, categories.id AS category_id',
            'conditions' => "user_id = :authorId AND articles.status = :status",
            'bind' => ['status' => 'public', 'authorId' => $authorId],
            'joins' => [
                ['users', 'articles.user_id = users.id'],
                ['categories', 'articles.category_id = categories.id', 'categories', 'LEFT']
            ],
            'order' => 'articles.created_at DESC'
        ];
    
        $params = Article::mergeWithPagination($params);
        $author = User::findById($authorId);
    
        // check if author exists
        if (! $author) {
            Session::message('Author does not exist.', 'warning');
            Router::redirect();
        }
    
        $this->view->articles = Article::find($params);;
        $this->view->total = Article::findTotal($params);
        $this->view->setSiteTitle('Author: ' . $author->displayFullName());
        $this->view->render('articles/index');
    }
}