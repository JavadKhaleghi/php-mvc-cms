<?php

namespace App\Controllers;

use Core\Controller;

class ArticlesController extends Controller
{
    public function indexAction($param1, $param2)
    {
        die('Index action!' . $param1 . ' ' . $param2);
    }

    public function fooAction()
    {
        die('Foo action');
    }
}