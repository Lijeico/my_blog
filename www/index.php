<?php

//require __DIR__ . '/../src/MyProject/Models/Users/User.php';
//require __DIR__ . '/../src/MyProject/Models/Articles/Article.php';

use MyProject\Models\Articles\Article;
use MyProject\Models\Users\User;
use MyProject\Controllers\MainController;
use MyProject\Exceptions\DbException;
use MyProject\Views\View;
use MyProject\Exceptions\NotFoundException;
use MyProject\Exceptions\AuthException;
use MyProject\Exceptions\AccessForbidden;
use MyProject\Models\Articles\Comment;

function myAutoLoader(string $className)
{
//    echo '<pre>';
//    var_dump($className);
//    echo '</pre>';
    require_once __DIR__ . '/../src/' . $className . '.php';
}

try {
    spl_autoload_register('myAutoLoader');

    $author = new User('Иван');
    $article = new Article('Заголовок', 'Текст', $author);

    //$controller = new MainController();
//$controller->main();

    $route = $_GET['route'] ?? '';

//$pattern = '~^hello/(.*)$~';
//preg_match($pattern, $route, $matches);
//
//if (!empty($matches)) {
//    $controller = new MainController();
//    $controller->sayHello($matches[1]);
//    return;
//}
//
//$pattern = '~^$~';
//preg_match($pattern, $route, $matches);
//
//if (!empty($matches)) {
//    $controller = new MainController();
//    $controller->main();
//    return;
//}

    $routes = require __DIR__ . '/../src/routes.php';

    $isRouteFound = false;
    foreach ($routes as $pattern => $controllerAndAction) {
        preg_match($pattern, $route, $matches);
        if (!empty($matches)) {
            $isRouteFound = true;
            break;
        }
    }

    if (!$isRouteFound) {
        //echo 'Страница не найдена!';
        throw new NotFoundException('Page not found!');
    }

    $controllerName = $controllerAndAction[0];
    $actionName = $controllerAndAction[1];

    unset($matches[0]);

    $controller = new $controllerName();
    $controller->$actionName(...$matches);

} catch (DbException $e) {
    $view = new View(__DIR__ . '/../templates/errors');
    $view->renderHtml('500.php', ['error' => $e->getMessage()], 500);
} catch (NotFoundException $e) {
    $view = new View(__DIR__ . '/../templates/errors');
    $view->renderHtml('404.php', ['error' => $e->getMessage()], 404);
} catch (AuthException $e) {
    $view = new View(__DIR__ . '/../templates/errors');
    $view->renderHtml('401.php', ['error' => $e->getMessage()], 401);
} catch (AccessForbidden $e) {
    $view = new View(__DIR__ . '/../templates/errors');
    $view->renderHtml('403.php', ['error' => $e->getMessage()], 403);
}