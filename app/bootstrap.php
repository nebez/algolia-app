<?php

require_once __DIR__ . '/../vendor/autoload.php';

$container = DI\ContainerBuilder::buildDevContainer();

$app = $container->get('Mvc\\Application');

$app->setContainer($container);

$app->get('/api/1/apps', 'App\Controllers\TestController@test');
$app->get('/api/1/apps/:id', 'App\Controllers\TestController@test');

return $app;
