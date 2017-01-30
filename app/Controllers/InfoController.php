<?php

namespace App\Controllers;

use Mvc\Application;
use Symfony\Component\HttpFoundation\Request;

class InfoController {

    private $app;

    public function __construct(Application $app)
    {
        $this->app = $app;
    }

    public function info(Request $request)
    {
        return $this->app->json([
            'appId' => env('ALGOLIA_APP_ID'),
            'apiKey' => env('ALGOLIA_API_KEY')
        ]);
    }

}
