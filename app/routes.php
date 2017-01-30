<?php

$app->get('/api/1/info', 'App\Controllers\InfoController@info');

$app->post('/api/1/apps', 'App\Controllers\IndexController@create');
$app->get('/api/1/apps/:id', 'App\Controllers\IndexController@display');
$app->delete('/api/1/apps/:id', 'App\Controllers\TestController@delete');
