<?php

namespace App\Controllers;

use App\Models\Article;
use App\Utils\DBSingleton;
use App\Utils\EngineSingleton;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class PageController
{
    private EngineSingleton $engine;
    private DBSingleton $db;

    public function __construct()
    {
        $this->db = DBSingleton::getInstance();
        $this->engine = EngineSingleton::getInstance();
    }

    private function render(
        Request $request, Response $response, string $template, array $payload = []
    ): Response
    {
        $html = $this->engine->pugEngine->renderFile(
            $template,
            $payload,
        );
        $response->setContent($html);

        return $response;
    }

    public function index(Request $request, Response $response): Response
    {
        return $this->render($request, $response, 'home.pug');
    }

    public function login(Request  $request, Response $response): Response
    {
        return $this->render($request, $response, 'login.pug');
    }

    public function register(Request  $request, Response $response): Response
    {
        return $this->render($request, $response, 'register.pug');
    }

    public function board(Request $request, Response $response): Response
    {
        if (isset($_GET['error'])) {
            $error = $_GET['error'];
        }

        if (isset($_GET['tag'])) {
            $tag = $_GET['tag'];
            $articles = Article::readByTag($this->db->pdoObj, $tag);
        } else {
            $articles = Article::readAll($this->db->pdoObj);
        }

        return $this->render($request, $response, 'board.pug', [
            'articles' => $articles,
            'error' => $error ?? null,
            'tag' => $tag ?? null,
        ]);
    }

    public function edit(Request $request, Response $response, $id): Response
    {
        $article = Article::readById($this->db->pdoObj, $id);

        if (isset($_GET['error'])) {
            $error = $_GET['error'];
        }

        if ($article->id === null) {
            return $this->render($request, $response, 'error.pug', [
                'title' => ':C',
                'message' => 'article with that ID does not exists',
            ]);
        }

        return $this->render($request, $response, 'edit.pug', [
            'article' => $article,
            'error' => $error ?? null,
        ]);
    }
}