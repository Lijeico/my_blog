<?php

namespace MyProject\Controllers;

use MyProject\Exceptions\AccessForbidden;
use MyProject\Exceptions\AuthException;
use MyProject\Exceptions\NotFoundException;
use MyProject\Models\Articles\Article;
use MyProject\Models\Articles\Comment;
use MyProject\Exceptions\InvalidArgumentException;

class CommentsController extends AbstractController
{

    public function addComment(int $articleId): void //Add comments only if user is authorized
    {
        $article = Article::getById($articleId);

        if ($article === null) {
            throw new NotFoundException('Page not found!');
        }

        if ($this->user === null) {
            throw new AuthException('Вы не авторизованы', 401);
        }

        if (!empty($_POST)) {
            try {
                $comment = Comment::createFromArray($_POST, $this->user, $articleId);
            } catch (InvalidArgumentException $e) {
                $this->view->renderHtml('articles/add.php', ['error' => $e->getMessage()]);
                return;
            }
            header('Location: /articles/' . $article->getId() . '#comment' . $comment->getId(), true, 302);
            exit();
        }

    }

    public function edit(int $articleId, int $commentId): void
    {
        $article = Article::getById($articleId);

        if ($article === null) {
            throw new NotFoundException('Page not found!');
        }

        if ($this->user === null) {
            throw new AuthException('Вы не авторизованы', 401);
        }

        $comment = Comment::getById($commentId);

        if ($comment === null) {
            throw new NotFoundException('Page not found!');
        }

        if (!$this->isEditable() && $this->user->getId() !== $comment->getAuthor()->getId()) {
            throw new AccessForbidden();
        }

        if (!empty($_POST)) {
            try {
                $comment->updateFromArray($_POST);
            } catch (InvalidArgumentException $e) {
                $this->view->renderHtml('articles/comments/edit.php', ['error' => $e->getMessage(), 'comment' => $comment]);
                return;
            }

            header('Location: /articles/' . $article->getId(), true, 302);
            exit();
        }
        $this->view->renderHtml('articles/comments/edit.php', ['comment' => $comment, 'article' => $article]);
    }

}