<?php


namespace MyProject\Controllers;

use MyProject\Models\ActiveRecordEntity;
use MyProject\Services\Db;
use MyProject\Views\View;
use MyProject\Models\Articles\Article;
use MyProject\Models\Users\User;
use MyProject\Exceptions\NotFoundException;
use MyProject\Services\UsersAuthService;

class ArticlesController extends AbstractController
{

//    /** @var View */
//    private $view;

    /** @var Db */
    private $db;

//    public function __construct()
//    {
//        $this->user = UsersAuthService::getUserByToken();
//        $this->view = new View(__DIR__ . '/../../../templates');
//        $this->view->setVar('user', $this->user);
//    }

    public function view(int $articleId)
    {
        $article = Article::getById($articleId);
        //$nickname = Article::getById($articleId)->getAuthor()->getNickname();

        if ($article === null) {
            //$this->view->renderHtml('errors/404.php', [], 404);
            //return;
            throw new NotFoundException('Page not found!');
        }

        $this->view->renderHtml('articles/view.php', [
            'article' => $article
        ]);
    }

    public function edit(int $articleId): void //edit the records in the Data Base
    {
        $article = Article::getById($articleId);

        if ($article === null) {
//            $this->view->renderHtml('errors/404.php', [], 404);
//            return;
            throw new NotFoundException('Page not found!');
        }
        $article->setName('New name is Ilie');
        $article->setText('This is a new test 1');

        $article->save(); //saving current data and calling method for update
    }

    public function add(): void //insert new record in our Data Base
    {
        $author = User::getById(1);

        $article = new Article();
        $article->setAuthor($author);
        $article->setName('Новое название статьи');
        $article->setText('Новый текст статьи');

        $article->save(); //saving current data and calling method for insert

        var_dump($article);
    }

    public function delete(int $articleId): void //delete a record from Data Base
    {
        $article = Article::getById($articleId);

        if ($article === null) {
//            $this->view->renderHtml('errors/404.php', [], 404);
//            return;
            throw new NotFoundException('Page not found!'); //new error exception instead the above old-format
        }
        $article->delete();
        var_dump($article);
    }


}