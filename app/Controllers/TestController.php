<?php

namespace App\Controllers;

use Mvc\Application;
use Symfony\Component\HttpFoundation\Request;

class TestController {

    public function __construct(Application $app)
    {
        $this->app = $app;
    }

    public function test(Request $request)
    {
        return $this->app->json('Test');
    }

    public function testId(Request $request, $id)
    {
        return $this->app->json(['id' => $id]);
    }

}
