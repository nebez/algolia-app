<?php

$app->get('/api/1/info', 'App\Controllers\InfoController@info');

$app->get('/api/1/apps/search', 'App\Controllers\IndexController@search');
$app->post('/api/1/apps', 'App\Controllers\IndexController@create');
$app->post('/api/1/apps/batch', 'App\Controllers\IndexController@batch');
$app->delete('/api/1/apps/:id', 'App\Controllers\TestController@delete');
