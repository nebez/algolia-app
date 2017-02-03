<?php

/**
 * This is pretty critical... :)
 */
require_once __DIR__ . '/../vendor/autoload.php';

/**
 * Our env.php file takes care of ensuring the .env file is loaded, required
 * variables are set, and exposing a handy env() function for easily accessing
 * the variables.
 */
require_once __DIR__ . '/env.php';

/**
 * We'll resolve the application out of our DI container so that it can take
 * care of dependencies. In reality, the only dependency is a router that we can
 * construct ourselves but that can change in the future!
 */
$container = DI\ContainerBuilder::buildDevContainer();

$app = $container->get('Mvc\Application');

$app->setContainer($container);

/**
 * Here we'll bind some contracts to concrete classes using a fluent api so that
 * our container can resolve abstractions later on. This is useful for testing
 * as it means we can easily stub out our dependencies where necessary!
 */
$app->bind(App\Contracts\ItemIndexer::class)
    ->to(App\Indexers\AlgoliaItemIndexer::class);

/**
 * We're ready to register our routes. The application exposes 4 handy shortcuts
 * for registering routes: get(), post(), put() and delete().
 */
$app->get('/api/1/info', 'App\Controllers\InfoController@info');
$app->get('/api/1/apps/search', 'App\Controllers\IndexController@search');
$app->post('/api/1/apps', 'App\Controllers\IndexController@create');
$app->post('/api/1/apps/batch', 'App\Controllers\IndexController@batch');
$app->delete('/api/1/apps/:id', 'App\Controllers\IndexController@delete');


return $app;
