<?php

use PHPUnit\Framework\TestCase;

use Mvc\Router\Route;

class RouteTest extends TestCase {

    public function testThatExactPathsMatch()
    {
        $route = new Route('/', 'NullHandler');

        $this->assertTrue($route->isMatch('/'));

        $route = new Route('/hello', 'NullHandler');

        $this->assertTrue($route->isMatch('/hello'));

        $route = new Route('/hello/world', 'NullHandler');

        $this->assertTrue($route->isMatch('/hello/world'));
    }

    public function testThatWrongPathsDontMatch()
    {
        $route = new Route('/', 'NullHandler');

        $this->assertFalse($route->isMatch('/test'));

        $route = new Route('/test', 'NullHandler');

        $this->assertFalse($route->isMatch('/'));
    }

    public function testThatPathsAreCaseSensitive()
    {
        $route = new Route('/HELLO/WORLD', 'NullHandler');

        $this->assertFalse($route->isMatch('/hello/world'));
    }

    public function testThatPathsDontMatchPartially()
    {
        $route = new Route('/hello/world', 'NullHandler');

        $this->assertFalse($route->isMatch('/hello/worldd'));

        $route = new Route('/hello/world', 'NullHandler');

        $this->assertFalse($route->isMatch('/hello/worl'));
    }

    public function testThatNamedParametersAreProperlyBound()
    {
        $route = new Route('/hello/:place', 'NullHandler');

        $route->setMatchedPath('/hello/world');

        $this->assertEquals($route->getNamedParameterValues(), ['place' => 'world']);
    }

    public function testThatMultipleNamedParametersAreProperlyBound()
    {
        $route = new Route('/:greeting/:place', 'NullHandler');

        $route->setMatchedPath('/hello/world');

        $this->assertEquals($route->getNamedParameterValues(), ['greeting' => 'hello', 'place' => 'world']);
    }

}
