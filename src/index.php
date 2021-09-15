<?php

require 'vendor/autoload.php';
require 'models/Article.php';
require 'classes/DBSingleton.php';
require 'classes/EngineSingleton.php';
require 'middlewares/AuthMiddleware.php';
require 'App.php';

use App\App;
use Buki\Router\Router;
use Dotenv\Dotenv;

$dotenv = Dotenv::createImmutable(__DIR__);
$dotenv->load();

$router = new Router([
    'paths' => [
        'controllers' => 'controllers',
        'middlewares' => 'middlewares',
    ],
    'namespaces' => [
        'controllers' => 'App\Controllers',
        'middlewares' => 'App\Middlewares',
    ],
]);

(new App($router))->run();