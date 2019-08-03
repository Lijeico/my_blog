<?php


namespace MyProject\Controllers;

use MyProject\Exceptions\AuthException;
use MyProject\Exceptions\UserNotFoundException;
use MyProject\Views\View;
use MyProject\Models\Users\User;
use MyProject\Exceptions\InvalidArgumentException;
use MyProject\Services\EmailSender;
use MyProject\Models\Users\UserActivationService;
use MyProject\Exceptions\IncorrectUserActivationCode;
use MyProject\Services\UsersAuthService;

class UsersController extends AbstractController
{
//    /** @var View */
//    private $view;

//    public function __construct()
//    {
//        $this->view = new View(__DIR__ . '/../../../templates');
//    }

    public function signUp()
    {
        if (!empty($_POST)) {
            try {
                $user = User::signUp($_POST);
            } catch (InvalidArgumentException $e) {
                $this->view->renderHtml('users/signUp.php', ['error' => $e->getMessage()]);
                return;
            }

            if ($user instanceof User) {
                $code = UserActivationService::createActivationCode($user);

                EmailSender::send($user, 'Активация', 'userActivation.php', [
                    'userId' => $user->getId(),
                    'code' => $code
                ]);

                $this->view->renderHtml('users/signUpSuccessful.php');
                return;
            }
        }

        $this->view->renderHtml('users/signUp.php');
    }

    public function activate(int $userId, string $activationCode)
    {
        try {
            $user = User::getById($userId);

            if ($user === null) {
                throw new UserNotFoundException('Пользователь не найден');
            }

            $isCodeValid = UserActivationService::checkActivationCode($user, $activationCode);

            if (!$isCodeValid) {
                throw new IncorrectUserActivationCode('Некорректный код активации');
            }
            $user->activate();
            echo 'OK!';
            return;

        } catch (UserNotFoundException $e) {
            $this->view->renderHtml('errors/404.php', ['error' => $e->getMessage()], 404);
        } catch (IncorrectUserActivationCode $e) {
            $this->view->renderHtml('errors/404.php', ['error' => $e->getMessage()], 404);
        }
    }

    public function login()
    {
        if (!empty($_POST)) {
            try {
                $user = User::login($_POST);
                UsersAuthService::createToken($user);
                header('Location: /');
                exit();
            } catch (InvalidArgumentException $e) {
                $this->view->renderHtml('users/login.php', ['error' => $e->getMessage()]);
                return;
            }
        }

        $this->view->renderHtml('users/login.php');
    }

    public function logout()
    {
        try {
            if ($this->user !== null) {
                if (isset($_COOKIE['token'])) {
                    setcookie("token", "", time() - 1000, "/");
                    header('Location: /');
                    exit();
                }
            }
            throw new AuthException('Вы не зарегистрированы', 401);
        } catch (AuthException $e) {
            $this->view->renderHtml('/errors/401.php', ['error' => $e->getMessage()], 403);
        }
    }
}