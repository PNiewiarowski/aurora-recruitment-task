<?php

require 'vendor/autoload.php';
spl_autoload_register(function ($className) {
    require $className . '.php';
});
require 'App.php';

use App\App;
use Buki\Router\Router;
use Dotenv\Dotenv;

$dotenv = Dotenv::createImmutable(__DIR__);
$dotenv->load();

$router = new Router([
    'paths' => [
        'controllers' => 'Controllers',
        'middlewares' => 'Middlewares',
    ],
    'namespaces' => [
        'controllers' => 'Controllers',
        'middlewares' => 'Middlewares',
    ],
]);

(new App($router))->run();