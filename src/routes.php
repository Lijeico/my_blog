<?php

use MyProject\Controllers\MainController;
use MyProject\Controllers\ArticlesController;
use MyProject\Controllers\UsersController;
use MyProject\Controllers\CommentsController;

return [
    '~^hello/(.*)$~' => [MainController::class, 'sayHello'],
    '~^$~' => [MainController::class, 'main'], //Main page
    '~^bye/(.*)$~' => [MainController::class, 'sayBye'],
    '~^articles/(\d+)$~' => [ArticlesController::class, 'view'], //Article page
    '~^articles/(\d+)/edit$~' => [ArticlesController::class, 'edit'], //Article edit
    '~^articles/add$~' => [ArticlesController::class, 'add'], //Article insert
    '~^articles/(\d+)/delete$~' => [ArticlesController::class, 'delete'], //Article delete
    '~^users/register$~' => [UsersController::class, 'signUp'], //User registration
    '~^users/(\d+)/activate/(.+)$~' => [UsersController::class, 'activate'], //User account activating by email
    '~^users/login~' => [UsersController::class, 'login'], //User authentication
    '~^users/logout~' => [UsersController::class, 'logout'], //User logout
    '~^articles/(\d+)/comments$~' => [CommentsController::class, 'addComment'], //Add comments to article
    '~^articles/(\d+)/comments/(\d+)/edit$~' => [CommentsController::class, 'edit'], //Comment edit


];