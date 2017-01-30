<?php

namespace App\Contracts;

interface ItemIndexer {
    public function add(array $items);

    public function delete($id);

    public function clear();

    public function search($term);
}
