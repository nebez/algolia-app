<?php

use Mvc\Application;
use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class RequestHandlerTest extends TestCase {

    protected $app;

    protected $container;

    public function setUp()
    {
        $this->container = DI\ContainerBuilder::buildDevContainer();

        $this->app = $this->container->get(Application::class);

        $this->app->setContainer($this->container);
    }

    public function testThatRequestsReturnValidResponses()
    {
        $this->app->get('/test', 'TestController@index');

        $mockRequest = Request::create('/test', 'GET');

        $response = $this->app->handle($mockRequest);

        $this->assertTrue($response instanceof Response);
        $this->assertEquals($response->getStatusCode(), 200);
        $this->assertEquals($response->getContent(), 'test response');
    }

    public function testThatRequestsReturnValidStringResponses()
    {
        $this->app->get('/test', 'TestController@test');

        $mockRequest = Request::create('/test', 'GET');

        $response = $this->app->handle($mockRequest);

        $this->assertTrue($response instanceof Response);
        $this->assertEquals($response->getStatusCode(), 200);
        $this->assertEquals($response->getContent(), 'test string response');
    }

    public function testThatRequestsReturnValidStringableResponses()
    {
        $this->app->get('/test', 'TestController@stringableResponse');

        $mockRequest = Request::create('/test', 'GET');

        $response = $this->app->handle($mockRequest);

        $this->assertTrue($response instanceof Response);
        $this->assertEquals($response->getStatusCode(), 200);
        $this->assertEquals($response->getContent(), 'test stringable response');
    }

    public function testThatRequestsForMissingUrlsThrow404s()
    {
        $this->app->get('/test', 'TestController@index');

        $mockRequest = Request::create('/404', 'GET');

        $response = $this->app->handle($mockRequest);

        $this->assertEquals($response->getStatusCode(), 404);
    }

    public function testThatMissingControllerMethodsThrowErrors()
    {
        $this->app->get('/test', 'TestController@missing');

        $mockRequest = Request::create('/test', 'GET');

        $response = $this->app->handle($mockRequest);

        $this->assertEquals($response->getStatusCode(), 500);
        $this->assertContains('Controller method does not exist', $response->getContent());
    }

    public function testThatControllersReturningNothingThrowsErrors()
    {
        $this->app->get('/test', 'TestController@nada');

        $mockRequest = Request::create('/test', 'GET');

        $response = $this->app->handle($mockRequest);

        $this->assertEquals($response->getStatusCode(), 500);
        $this->assertContains('Controllers must return a Response', $response->getContent());
    }

    public function testThatUnhandledExceptionsAreCaught()
    {
        $this->app->get('/test', 'TestController@boom');

        $mockRequest = Request::create('/test', 'GET');

        $response = $this->app->handle($mockRequest);

        $this->assertEquals($response->getStatusCode(), 500);
        $this->assertContains('Unhandled exception:', $response->getContent());
    }
}

class TestController {
    public function test()
    {
        return 'test string response';
    }

    public function index()
    {
        return new Response('test response');
    }

    public function stringableResponse()
    {
        return new StringableResponse('test stringable response');
    }

    public function nada()
    {
        // ... ???
    }

    public function boom()
    {
        throw new Exception('whoa');
    }
}

class StringableResponse {
    protected $val;

    public function __construct($val)
    {
        $this->val = $val;
    }

    public function __toString()
    {
        return $this->val;
    }
}
