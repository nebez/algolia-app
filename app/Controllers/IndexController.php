<?php

namespace App\Controllers;

use App\Contracts\ItemIndexer;
use Mvc\Application;
use Mvc\Exceptions\BadRequestHttpException;
use Symfony\Component\HttpFoundation\Request;

class IndexController {

    private $app;

    private $indexer;

    public function __construct(Application $app, ItemIndexer $indexer)
    {
        $this->app = $app;
        $this->indexer = $indexer;
    }

    public function batch(Request $request)
    {
        $this->indexer->clear();

        $apps = json_decode(file_get_contents(__DIR__ . '/../../data/apps.json'), true);

        $response = $this->indexer->add($apps);

        return $this->app->json(['ids' => $response]);
    }

    public function create(Request $request)
    {
        $ids = $this->indexer->add([$request->request->all()]);

        return $this->app->json(['id' => $ids[0]]);
    }

    public function search(Request $request)
    {
        $term = $request->query->get('q');

        if ($term === null) {
            throw new BadRequestHttpException('Missing search "q" parameter');
        }

        return $this->app->json($this->indexer->search($term));
    }

    public function delete(Request $request, $id)
    {
        $this->indexer->delete($id);

        return $this->app->json(['action' => 'delete', 'id' => $id]);
    }

}
