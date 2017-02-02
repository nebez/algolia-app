<?php

use PHPUnit\Framework\TestCase;

use Mvc\Router\Router;

class RouterTest extends TestCase {

    public function testThatRoutesMatch()
    {
        $router = new Router();

        $router->add('GET', '/', 'NullHandler');
        $router->add('GET', '/test', 'NullHandler');

        $this->assertNotNull($router->match('GET', '/'));
        $this->assertNotNull($router->match('GET', '/test'));
    }

    public function testThatVerbsWithSamePathHaveDifferentHandlers()
    {
        $router = new Router();

        $router->add('GET', '/', 'NullGetHandler');
        $router->add('POST', '/', 'NullPostHandler');

        $getMatch = $router->match('GET', '/');
        $postMatch = $router->match('POST', '/');

        $this->assertEquals($getMatch->getHandler(), 'NullGetHandler');
        $this->assertEquals($postMatch->getHandler(), 'NullPostHandler');
    }

    public function testThatWrongRoutesDontMatch()
    {
        $router = new Router();

        $router->add('GET', '/', 'NullHandler');
        $router->add('GET', '/test/:123', 'NullHandler');

        $this->assertNull($router->match('GET', '/abc'));
        $this->assertNull($router->match('GET', '/test123'));
    }

    public function testThatOnlyTheFirstMatchingRegisteredRouteIsMatched()
    {
        $router = new Router();

        $router->add('GET', '/apps/test', 'TestAppHandler');
        $router->add('GET', '/apps/:name', 'WildcardAppHandler');

        $testMatch = $router->match('GET', '/apps/test');
        $wildMatch = $router->match('GET', '/apps/testtt');

        $this->assertEquals($testMatch->getHandler(), 'TestAppHandler');
        $this->assertEquals($wildMatch->getHandler(), 'WildcardAppHandler');
    }

    public function testThatMatchingUnknownMethodsDoesntThrow()
    {
        $router = new Router();

        $router->add('GET', '/', 'NullHandler');

        $match = $router->match('POST', '/');

        $this->assertNull($match);
    }

}
