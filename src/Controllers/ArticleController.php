<?php

namespace Controllers;

use Models\Article;
use Classes\DBSingleton;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class ArticleController
{
    private DBSingleton $db;

    public function __construct()
    {
        $this->db = DBSingleton::getInstance();
    }

    private static function validRequestArticle(Request $request): bool
    {
        return
            empty($request->get('title')) ||
            empty($request->get('description')) ||
            empty($request->get('tags')) ||
            empty($request->get('status'));
    }

    public function delete(Request $request, Response $response): void
    {
        $id = $request->get('id');
        Article::delete($this->db->pdoObj, $id);

        header('Location: /board');
        die();
    }

    public function create(Request $request, Response $response): void
    {
        if ($this->validRequestArticle($request)) {
            header('Location: /board?error=true');
            die();
        }

        (new Article(
            null,
            $request->get('title'),
            $request->get('description'),
            $request->get('status'),
            $request->get('tags'),
        ))->create($this->db->pdoObj);

        header('Location: /board');
        die();
    }

    public function update(Request $request, Response $response): void
    {
        if ($this->validRequestArticle($request)) {
            header('Location: /board/' . $request->get('id') . '?error=true');
            die();
        }

        (new Article(
            $request->get('id'),
            $request->get('title'),
            $request->get('description'),
            $request->get('status'),
            $request->get('tags')
        ))->update($this->db->pdoObj);

        header('Location: /board');
        die();
    }
}