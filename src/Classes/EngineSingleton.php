<?php

namespace Classes;

use Exception;
use Pug;

class EngineSingleton
{
    private static ?EngineSingleton $instance = null;
    public Pug $pugEngine;

    public static function getInstance(): EngineSingleton
    {
        if (EngineSingleton::$instance === null) {
            $instance = new EngineSingleton();
            $instance->create();

            EngineSingleton::$instance = $instance;
        }

        return EngineSingleton::$instance;
    }

    private function create()
    {
        $this->pugEngine = new Pug([
            'cache' => 'weirdos/cache/pug',
            'basedir' => 'Views',
            'upToDateCheck' => false,
            'expressionLanguage' => 'php',
        ]);
    }

    private function __construct()
    {
    }

    private function __clone()
    {
    }


    public function __wakeup()
    {
        throw new Exception("cannot unserialize singleton");
    }
}