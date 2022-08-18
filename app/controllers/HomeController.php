<?php

namespace App\Controllers;

use App\Models\{Article, Category};
use Core\{Controller, Router, Session};

class HomeController extends Controller
{
    public function indexAction()
    {
        $categoryParams = [
            'order' => 'name',
            'limit' => 6
        ];
        
        $articleParams = [
            'columns' => 'articles.*, users.first_name, users.last_name, categories.name AS category, categories.id AS category_id',
            'conditions' => "articles.status = :status",
            'bind' => ['status' => 'public'],
            'joins' => [
                ['users', 'articles.user_id = users.id'],
                ['categories', 'articles.category_id = categories.id', 'categories', 'LEFT']
            ],
            'order' => 'articles.created_at DESC',
            'limit' => 5
        ];
        
        $this->view->categories = Category::find($categoryParams);
        $this->view->articles = Article::find($articleParams);
        $this->view->setSiteTitle('Home :: PHP MVC');
        $this->view->render();
    }
}
