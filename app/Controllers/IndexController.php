<?php

namespace App\Controllers;

use Mvc\Application;
use App\Contracts\ItemIndexer;
use Symfony\Component\HttpFoundation\Request;

class IndexController {

    private $app;

    private $indexer;

    public function __construct(Application $app, ItemIndexer $indexer)
    {
        $this->app = $app;
        $this->indexer = $indexer;
    }

    public function create(Request $request)
    {
        return $this->app->json(['action' => 'create', 'id' => 99999]);
    }

    public function display(Request $request, $id)
    {
        return $this->app->json(['action' => 'display', 'id' => $id]);
    }

    public function delete(Request $request, $id)
    {
        return $this->app->json(['action' => 'delete', 'id' => $id]);
    }

}
