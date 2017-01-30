<?php

namespace App\Indexers;

use App\Contracts\ItemIndexer;

class AlgoliaItemIndexer implements ItemIndexer {
    public function __construct()
    {
        // ... Create an API client
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
