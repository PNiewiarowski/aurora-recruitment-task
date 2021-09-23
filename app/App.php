<?php

namespace App;

use Routes\Routes;

class App
{
    private Routes $routes;

    public function __construct($routes)
    {
        $this->routes = $routes;
    }

    public function run()
    {
        $this->routes->setup();
        $this->routes->run();
    }
}