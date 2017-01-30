<?php

// Serve static files as-is and let everything else fall through to our web
// application. This serves as a "front-controller" for the built-in PHP
// development web server.
if (preg_match('/\.(?:png|css|js|html)$/', $_SERVER['REQUEST_URI']) || $_SERVER['REQUEST_URI'] === '/') {
    return false;
}

$app = require_once __DIR__ . '/../app/bootstrap.php';

$request = $app->createRequestFromGlobals();

$response = $app->handle($request);

$response->send();
