<?php

namespace Classes;

use Exception;
use PDO;

class DBSingleton
{
    private static ?DBSingleton $instance = null;
    public PDO $pdoObj;

    public static function getInstance(): DBSingleton
    {
        if (DBSingleton::$instance === null) {
            $instance = new DBSingleton();
            $instance->connect();

            DBSingleton::$instance = $instance;
        }

        return DBSingleton::$instance;
    }

    private function connect()
    {
        $this->pdoObj = new PDO(
            $_ENV['APP_DATABASE_DSN'],
            $_ENV['APP_DATABASE_USER'],
            $_ENV['APP_DATABASE_PASSWORD']
        );
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