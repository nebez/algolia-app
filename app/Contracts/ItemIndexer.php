<?php

namespace App\Contracts;

interface ItemIndexer {
    public function addItemToIndex($index, $item);

    public function removeItemFromIndex($index, $item);
}
