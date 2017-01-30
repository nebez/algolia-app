<?php

namespace App\Indexers;

use App\Contracts\ItemIndexer;
use AlgoliaSearch\Client as ApiClient;

class AlgoliaItemIndexer implements ItemIndexer {
    private $apiClient;

    public function __construct()
    {
        $this->apiClient = new ApiClient(env('ALGOLIA_APP_ID'), env('ALGOLIA_API_KEY'));
    }

    public function add(array $items)
    {
        $index = $this->apiClient->initIndex('apps');

        $response = $index->addObjects($items);

        return array_map('intval', $response['objectIDs']);
    }

    public function delete($id)
    {
        $index = $this->apiClient->initIndex('apps');

        return $index->deleteObject($id);
    }

    public function clear()
    {
        $index = $this->apiClient->initIndex('apps');

        $index->clearIndex();
    }

    public function search($term)
    {
        $index = $this->apiClient->initIndex('apps');

        return $index->search($term);
    }
}
