<?php

namespace App;

use Controllers\ArticleController;
use Controllers\PageController;
use Controllers\AuthController;
use Middlewares\AuthMiddleware;
use Buki\Router\Router;

class App
{
    private Router $router;

    public function __construct($router)
    {
        $this->router = $router;
    }

    public function run()
    {
        $this->router->get('/', [PageController::class, 'index'], ['before' => AuthMiddleware::class]);
        $this->router->get('/board', [PageController::class, 'board'], ['before' => AuthMiddleware::class]);
        $this->router->get('/board/:number', [PageController::class, 'edit'], ['before' => AuthMiddleware::class]);
        $this->router->get('/about', [PageController::class, 'index'], ['before' => AuthMiddleware::class]);
        $this->router->get('/login', [PageController::class, 'login']);
        $this->router->get('/register', [PageController::class, 'register']);

        $this->router->group('/actions/article', function () {
            $this->router->post('delete', [ArticleController::class, 'delete'], ['before' => AuthMiddleware::class]);
            $this->router->post('add', [ArticleController::class, 'create'], ['before' => AuthMiddleware::class]);
            $this->router->post('update', [ArticleController::class, 'update'], ['before' => AuthMiddleware::class]);
        });

        $this->router->group('/actions/auth', function () {
            $this->router->post('login', [AuthController::class, 'login']);
            $this->router->post('register', [AuthController::class, 'register']);
            $this->router->post('logout', [AuthController::class, 'logout']);
        });

        $this->router->run();
    }
}