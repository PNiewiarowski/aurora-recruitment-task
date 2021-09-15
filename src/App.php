<?php

namespace App;

use App\Controllers\ArticleController;
use App\Controllers\PageController;
use App\Controllers\AuthController;
use App\Middlewares\AuthMiddleware;
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

        $this->router->post('/actions/article/delete', [ArticleController::class, 'delete']);
        $this->router->post('/actions/article/add', [ArticleController::class, 'create']);
        $this->router->post('/actions/article/update', [ArticleController::class, 'update']);

        $this->router->post('/actions/auth/login', [AuthController::class, 'login']);
        $this->router->post('/actions/auth/register', [AuthController::class, 'register']);
        $this->router->post('/actions/auth/logout', [AuthController::class, 'logout']);

        $this->router->run();
    }
}