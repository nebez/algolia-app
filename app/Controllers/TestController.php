<?php

namespace App\Controllers;

use Mvc\Application;
use Symfony\Component\HttpFoundation\Request;

class TestController {

    public function __construct(Application $app)
    {
        $this->app = $app;
    }

    public function test(Request $request, $id)
    {
        return 'TEST CONTROLLER RESPONSE FOR ID: ' . $id;
    }

}
