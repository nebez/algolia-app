<?php

namespace Mvc;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class Application {

    public function __construct(Router $router)
    {
        $this->router = $router;
    }

    public function createRequestFromGlobals()
    {
        return Request::createFromGlobals();
    }

    public function handle(Request $request)
    {
        return new Response('test', 200);
    }

}
