<?php

namespace Controllers;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Models\Article;
use Classes\DBSingleton;
use Classes\EngineSingleton;

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
        $response->setContent($this->engine->pugEngine->renderFile(
            $template,
            $payload,
        ));

        return $response;
    }

    public function index(Request $request, Response $response): Response
    {
        return $this->render($request, $response, 'home.pug');
    }

    public function login(Request $request, Response $response): Response
    {
        return $this->render($request, $response, 'login.pug', [
            'error' => $_GET['error'] ?? null,
            'success' => $_GET['success'] ?? null,
        ]);
    }

    public function register(Request $request, Response $response): Response
    {
        return $this->render($request, $response, 'register.pug', [
            'error' => $_GET['error'] ?? null,
        ]);
    }

    public function board(Request $request, Response $response): Response
    {
        if (isset($_GET['tag'])) {
            $articles = Article::readByTag($this->db->pdoObj, $_GET['tag']);
        } else {
            $articles = Article::readAll($this->db->pdoObj);
        }

        return $this->render($request, $response, 'board.pug', [
            'articles' => $articles,
            'error' => $_GET['error'] ?? null,
            'tag' => $_GET['tag'] ?? null,
        ]);
    }

    public function edit(Request $request, Response $response, $id): Response
    {
        $article = Article::readById($this->db->pdoObj, $id);

        if ($article->id === null) {
            return $this->render($request, $response, 'error.pug', [
                'title' => ':C',
                'message' => 'article with that ID does not exists',
            ]);
        }

        return $this->render($request, $response, 'edit.pug', [
            'article' => $article,
            'error' => $_GET['error'] ?? null,
        ]);
    }
}