<?php

namespace Models;

use Symfony\Component\HttpFoundation\Request;

class User
{
    public ?int $id = null;
    public string $username;
    public string $hashedPassword;

    public function __construct($id, $username, $hashedPassword)
    {
        $this->id = $id;
        $this->username = $username;
        $this->hashedPassword = $hashedPassword;
    }

    public static function validUser(Request $request): bool
    {
        return
            strlen($request->get('username')) > 4 &&
            strlen($request->get('password')) > 6;
    }

    private static function createUser(mixed $row): User
    {
        return new User(
            $row['ID'] ?? null,
            $row['USERNAME'] ?? '',
            $row['HASHED_PASSWORD'] ?? '',
        );
    }

    public static function readById($pdo_obj, $id)
    {
        $stmt = $pdo_obj->prepare(
            'SELECT * FROM users WHERE ID = ?'
        );
        $stmt->execute([$id]);
        $row = $stmt->fetch();

        return User::createUser($row);
    }

    public function create($pdo_obj)
    {
        $stmt = $pdo_obj->prepare(
            'INSERT INTO users(USERNAME, HASHED_PASSWORD) VALUES(?, ?)'
        );
        $stmt->execute([
            $this->username,
            $this->hashedPassword,
        ]);
    }
}