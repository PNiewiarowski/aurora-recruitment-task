<?php

namespace Middlewares;

use Buki\Router\Http\Middleware;

class AuthMiddleware extends Middleware
{
    public function handle(): bool
    {
        if (!isset($_SESSION['logged'])) {
            header('Location: /login');
            die();
        }

        return true;
    }
}