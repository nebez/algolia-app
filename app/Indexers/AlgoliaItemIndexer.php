<?php

namespace App\Indexers;

use App\Contracts\ItemIndexer;
use AlgoliaSearch\Client as ApiClient;

class AlgoliaItemIndexer implements ItemIndexer {
    private $apiClient;

    public function __construct()
    {
        $this->apiClient = new ApiClient(env('ALGOLIA_APP_ID'), env('ALGOLIA_API_KEY'));
        $this->apiClient->initIndex('apps');
    }

    public function addItemToIndex($index, $item)
    {
        // ...
    }

    public function removeItemFromIndex($index, $item)
    {
        // ...
    }
}
