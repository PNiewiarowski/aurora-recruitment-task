<?php

require_once __DIR__ . '/vendor/autoload.php';
spl_autoload_register(function ($className) {
    require_once __DIR__ . '/' . $className . '.php';
});

use App\App;
use Dotenv\Dotenv;
use Routes\Routes;

$dotenv = Dotenv::createImmutable(__DIR__);
$dotenv->load();

session_start();

(new App(new Routes()))->run();
