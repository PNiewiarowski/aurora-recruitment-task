<?php

namespace App\Middlewares;

use Buki\Router\Http\Middleware;

class AuthMiddleware extends Middleware
{
    public function handle(): bool
    {
        return true;
    }
}