<?php

$app->get('/api/1/apps', 'App\Controllers\TestController@test');
$app->get('/api/1/apps/:id', 'App\Controllers\TestController@testId');
