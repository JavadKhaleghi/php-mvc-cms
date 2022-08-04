<?php

namespace App\Controllers;

use Core\{Controller, Database, Helper};

class HomeController extends Controller
{
    public function indexAction()
    {
        $db = Database::getInstance();

        // $db->insert('articles', ['title' => 'Article 2', 'body' => 'Article two is here!']);

        // $db->update('articles', ['title' => 'Article two', 'body' => 'Article 2 is here'], ['id' => 2]);

        $this->view->setSiteTitle('Home :: PHP MVC');
        $this->view->render();
    }
}
