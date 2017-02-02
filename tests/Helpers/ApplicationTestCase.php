<?php

namespace Tests\Helpers;

use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpFoundation\Request;

abstract class ApplicationTestCase extends TestCase {
    protected $app;

    public function setUp()
    {
        $this->app = require __DIR__ . '/../../app/bootstrap.php';
    }

    protected function visit($path)
    {
        $request = Request::create($path, 'GET');

        $response = $this->app->handle($request);

        return new ResponseAssertions($response);
    }
}
