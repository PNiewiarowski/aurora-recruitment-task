<?php

namespace App\Controllers;

use App\Utils\DBSingleton;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class AuthController
{
    private DBSingleton $db;

    public function __construct()
    {
        $this->db = DBSingleton::getInstance();
    }

    public function login(Request $request, Response $response): void
    {

    }

    public function register(Request $request, Response $response): void
    {

    }

    public function logout(Request $request, Response $response): void
    {

    }
}