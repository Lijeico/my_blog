<?php

namespace MyProject\Controllers;

use MyProject\Views\View;
use MyProject\Services\Db;
use MyProject\Models\Articles\Article;
use MyProject\Services\UsersAuthService;

class MainController extends AbstractController
{

//    private $view;
//
//    public function __construct()
//    {
//        $this->view = new View(__DIR__ . '/../../../templates');
//    }
//
//    public function main()
//    {
//
//        $title = [ 'title' => 'Мой блог' ];
//
//        $articles = [
//            ['name' => 'Статья 1', 'text' => 'Текст статьи 1'],
//            ['name' => 'Статья 2', 'text' => 'Текст статьи 2'],
//        ];
//
//        $this->view->renderHtml('main/main.php', ['articles' => $articles, 'page_title' => $title]);
//    }
//
//    public function sayHello(string $name)
//    {
//        $title = [ 'title' => 'Страница приветствия' ];
//        $this->view->renderHtml('main/hello.php', ['name' => $name, 'page_title' => $title]);
//    }
//
//    public function sayBye(string $name)
//    {
//        echo 'Пока, ' . $name;
//    }

//    /** @var View */
//    protected $view;

    /** @var Db */
    private $db;

//    public function __construct()
//    {
//        $this->user = UsersAuthService::getUserByToken();
//        $this->view = new View(__DIR__ . '/../../../templates');
//        $this->view->setVar('user', $this->user);
//    }

    public function main()
    {
        $articles = Article::findAll();
        $this->view->renderHtml('main/main.php', [
            'articles' => $articles,
            'user' => UsersAuthService::getUserByToken()
        ]);
    }

    public function sayHello($text){

        $this->view->renderHtml('main/hello.php',['introducing' => $text]);
    }

}