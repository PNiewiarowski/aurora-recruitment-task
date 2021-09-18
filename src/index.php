<?php

require_once 'vendor/autoload.php';
spl_autoload_register(function ($className) {
    require_once $className . '.php';
});
require_once 'App.php';

use App\App;
use Buki\Router\Router;
use Dotenv\Dotenv;

$dotenv = Dotenv::createImmutable(__DIR__);
$dotenv->load();

session_start();
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