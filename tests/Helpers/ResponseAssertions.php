<?php

namespace Tests\Helpers;

use PHPUnit_Framework_Assert;
use Symfony\Component\HttpFoundation\Response;

class ResponseAssertions extends PHPUnit_Framework_Assert {

    protected $response;

    public function __construct(Response $response)
    {
        $this->response = $response;
    }

    public function status($statusCode)
    {
        $this->assertEquals($this->response->getStatusCode(), $statusCode);

        return $this;
    }

    public function ok()
    {
        return $this->status(200);
    }

    public function seeJson($json)
    {
        $this->assertEquals($this->response->getContent(), json_encode($json));

        return $this;
    }

    public function containsString($needle)
    {
        $this->assertContains($needle, $this->response->getContent());

        return $this;
    }

}
