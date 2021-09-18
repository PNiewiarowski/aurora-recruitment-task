<?php

require_once 'vendor/autoload.php';
spl_autoload_register(function ($className) {
    require_once $className . '.php';
});
require_once 'App.php';

use App\App;
use Dotenv\Dotenv;
use Routes\Routes;

$dotenv = Dotenv::createImmutable(__DIR__);
$dotenv->load();

session_start();

(new App(new Routes()))->run();