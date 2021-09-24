<?php

require_once __DIR__ . '/vendor/autoload.php';
spl_autoload_register(function ($className) {
    require_once __DIR__ . '/' . $className . '.php';
});

use App\App;
use Dotenv\Dotenv;
use Routes\Routes;

Dotenv::createImmutable(__DIR__)->load();
session_start();

(new App(new Routes()))->run();
