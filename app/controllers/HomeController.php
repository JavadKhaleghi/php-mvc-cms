<?php

namespace App\Controllers;

use Core\{Controller, Database, Helper};

class HomeController extends Controller
{
    public function indexAction()
    {
        $db = Database::getInstance();
        //$sql = "INSERT INTO articles (`title`, `body`) VALUES (:title, :body)";
        //$bind = ['title' => 'Article one', 'body' => 'Body 1 is here'];
        //$db->execute($sql, $bind);

        $sql = "SELECT * FROM articles";
        $articles = $db->query($sql)->results();

        Helper::dd($articles);

        $this->view->setSiteTitle('Home :: PHP MVC');
        $this->view->render();
    }
}
