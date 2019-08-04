<?php


namespace MyProject\Controllers;


use MyProject\Models\Users\User;
use MyProject\Services\UsersAuthService;
use MyProject\Views\View;

abstract class AbstractController
{
    /** @var View */
    protected $view;

    /** @var User|null */
    protected $user;

    public function __construct()
    {
        $this->user = UsersAuthService::getUserByToken();
        $this->view = new View(__DIR__ . '/../../../templates');
        $this->view->setVar('user', $this->user);
    }

    public function isEditable(): bool
    {
        if ($this->user === null || $this->user->getRole() !== 'admin') {
            return false;
        }
        return true;
    }
}