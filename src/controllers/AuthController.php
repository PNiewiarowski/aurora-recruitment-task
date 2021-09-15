<?php

use App\Utils\DBSingleton;

class AuthController
{
    private DBSingleton $db;

    public function __construct()
    {
        $this->db = DBSingleton::getInstance();
    }
}