<?php

namespace App;

use App\Controllers\ArticleController;
use App\Controllers\PageController;
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
        $this->router->get('/login', [PageController::class, 'login'], ['before' => AuthMiddleware::class]);
        $this->router->get('/register', [PageController::class, 'register'], ['before' => AuthMiddleware::class]);

        $this->router->post('/actions/article/delete', [ArticleController::class, 'delete']);
        $this->router->post('/actions/article/add', [ArticleController::class, 'create']);
        $this->router->post('/actions/article/update', [ArticleController::class, 'update']);

        $this->router->run();
    }
}