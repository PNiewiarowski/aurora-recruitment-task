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
            header('Location: /login?error=' . urlencode('user not exists'));
            die();
        }

        if (!password_verify($request->get('password'), $user->hashedPassword)) {
            header('Location: /login?error=' . urlencode('wrong password'));
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
            header('Location: /register?error=' . urlencode('bad request'));
            die();
        }

        if ($request->get('password') !== $request->get('password-repeated')) {
            header('Location: /register?error=' . urlencode('passwords inputs are not the same'));
            die();
        }

        if (
            (User::readByUsername($this->db->pdoObj, $request->get('username')))->id !== null
        ) {
            header('Location: /register?error=' . urlencode('user with that username exists'));
            die();
        }

        $hashedPassword = password_hash($request->get('password'), PASSWORD_DEFAULT);
        (new User(
            null,
            $request->get('username'),
            $hashedPassword,
        ))->create($this->db->pdoObj);

        header('Location: /login?success=' . urlencode('user created'));
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