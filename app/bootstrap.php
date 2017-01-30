<?php

require_once __DIR__ . '/../vendor/autoload.php';

$container = DI\ContainerBuilder::buildDevContainer();

$app = $container->get('Mvc\\Application');

$app->setContainer($container);

require_once __DIR__ . '/routes.php';

return $app;
