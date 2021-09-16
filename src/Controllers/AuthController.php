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

        if ($user->id === null) {
            header('Location: /login?error=user%20not%20exists');
            die();
        }

        if (!password_verify($request->get('password'), $user->hashedPassword)) {
            header('Location: /login?error=wrong%20password');
            die();
        }

        $_SESSION['logged'] = true;
        $_SESSION['username'] = $user->username;
        header('Location: /');
        die();
    }

    public function register(Request $request, Response $response): void
    {
        if (!User::validUser($request)) {
            header('Location: /register?error=bad%20request');
            die();
        }

        if (
            (User::readByUsername($this->db->pdoObj, $request->get('username')))->id !== null
        ) {
            header('Location: /register?error=user%20with%20that%20username%20exists');
            die();
        }

        $hashedPassword = password_hash($request->get('password'), PASSWORD_DEFAULT);
        (new User(
            null,
            $request->get('username'),
            $hashedPassword,
        ))->create($this->db->pdoObj);

        header('Location: /login?success=user%20create');
        die();
    }

    public function logout(Request $request, Response $response): void
    {
        session_destroy();
        $_SESSION = array();
        header('Location: /login');
        die();
    }
}