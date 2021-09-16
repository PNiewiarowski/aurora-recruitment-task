<?php

namespace Models;

use PDO;

class Article
{
    public ?int $id = null;
    public string $title;
    public string $description;
    public string $status;
    public string $tags;

    public function __construct(
        $id = null, $title = '', $description = '', $status = '', $tags = ''
    )
    {
        $this->id = $id;
        $this->title = $title;
        $this->description = $description;
        $this->status = $status;
        $this->tags = $tags;
    }

    private static function createArticle(mixed $row): Article
    {
        return new Article(
            $row['ID'] ?? null,
            $row['TITLE'] ?? '',
            $row['DESCRIPTION'] ?? '',
            $row['STATUS'] ?? '',
            $row['TAGS'] ?? ''
        );
    }

    public static function readAll(PDO $pdo_obj): array
    {
        $stmt = $pdo_obj->prepare(
            'SELECT * FROM articles'
        );
        $stmt->execute();
        $data = [];

        while ($row = $stmt->fetch()) {
            array_push($data, Article::createArticle($row));
        }

        return $data;
    }

    public static function readById(PDO $pdo_obj, int $id): Article
    {
        $stmt = $pdo_obj->prepare(
            'SELECT * FROM articles WHERE ID = ?'
        );
        $stmt->execute([$id]);
        $row = $stmt->fetch();

        return Article::createArticle($row);
    }

    public static function readByTag(PDO $pdo_obj, mixed $tag): array
    {
        $stmt = $pdo_obj->prepare(
            'SELECT * FROM articles WHERE TAGS LIKE ?'
        );
        $stmt->execute(['%' . str_replace('#', '', $tag) . '%']);
        $data = [];

        while ($row = $stmt->fetch()) {
            array_push($data, Article::createArticle($row));
        }

        return $data;
    }

    public function create(PDO $pdo_obj): void
    {
        $stmt = $pdo_obj->prepare(
            'INSERT INTO articles(TITLE, DESCRIPTION, STATUS, TAGS) VALUES(?, ?, ?, ?)'
        );
        $stmt->execute([
            $this->title,
            $this->description,
            $this->status,
            $this->tags
        ]);
    }

    public static function delete(PDO $pdo_obj, int $id): void
    {
        $stmt = $pdo_obj->prepare(
            'DELETE FROM articles WHERE ID = ?'
        );
        $stmt->execute([$id]);
    }

    public function update(PDO $pdo_obj): void
    {
        $stmt = $pdo_obj->prepare(
            'UPDATE articles SET TITLE = ?, DESCRIPTION = ?, TAGS = ?, STATUS = ? WHERE ID = ?'
        );
        $stmt->execute([
            $this->title,
            $this->description,
            $this->tags,
            $this->status,
            $this->id,
        ]);
    }
}