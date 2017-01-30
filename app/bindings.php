<?php

/**
 * Here we'll bind some contracts to concrete classes using a fluent api so that
 * our container can resolve abstractions later on. This is useful for testing
 * as it means we can easily stub out our dependencies where necessary!
 */
$app->bind(App\Contracts\ItemIndexer::class)
    ->to(App\Indexers\AlgoliaItemIndexer::class);
