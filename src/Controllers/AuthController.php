<?php

namespace Controllers;

use Classes\DBSingleton;
use Models\User;
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
        $user = User::readByUsername($this->db->pdoObj, $request->get('username'));

        if ($user->id != null) {
            header('Location /login?error=user-exists');
            die();
        }

        if (!password_verify($user->hashedPassword, $request->get('password'))) {
            header('Location /login?error=wrong-password');
            die();
        }

        $_SESSION['logged'] = true;
        $_SESSION['username'] = $user->username;
        header('Location /');
        die();
    }

    public function register(Request $request, Response $response): void
    {

    }

    public function logout(Request $request, Response $response): void
    {

    }
}