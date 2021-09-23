<?php

namespace Routes;

use Controllers\ArticleController;
use Controllers\AuthController;
use Controllers\PageController;
use Middlewares\AuthMiddleware;
use Buki\Router\Router;

class Routes
{
    private Router $router;

    public function __construct()
    {
        $this->router = new Router([
            'paths' => [
                'controllers' => 'Controllers',
                'middlewares' => 'Middlewares',
            ],
            'namespaces' => [
                'controllers' => 'Controllers',
                'middlewares' => 'Middlewares',
            ],
        ]);
    }

    public function setup(): void
    {
        $this->router->get('/', [PageController::class, 'index'], ['before' => AuthMiddleware::class]);
        $this->router->get('/board', [PageController::class, 'board'], ['before' => AuthMiddleware::class]);
        $this->router->get('/board/:id', [PageController::class, 'edit'], ['before' => AuthMiddleware::class]);
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
    }

    public function run(): void
    {
        $this->router->run();
    }
}