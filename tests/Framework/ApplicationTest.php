<?php

use Mvc\Application;
use Mvc\Router\Router;
use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class ApplicationTest extends TestCase {

    protected $app;

    protected $container;

    public function setUp()
    {
        $this->container = DI\ContainerBuilder::buildDevContainer();

        $this->app = $this->container->get(Application::class);

        $this->app->setContainer($this->container);
    }

    public function testThatMissingEnvironmentVariablesReturnDefaults()
    {
        $env = env('MISSING_ENV_VARIABLE_BLAH', '123456');

        $this->assertEquals($env, '123456');
    }

    public function testThatResponsesAreValid()
    {
        $response = $this->app->json(['response' => 'okay', 'hello' => 'world']);

        $this->assertTrue($response instanceof Response);

        $this->assertEquals($response->getContent(), json_encode(['response' => 'okay', 'hello' => 'world']));
    }

    public function testThatAbstractBindingsWork()
    {
        $this->app->bind(AbstractClassInterface::class)->to(AbstractClassImplementation::class);

        $concrete = $this->container->get(AbstractClassInterface::class);

        $this->assertTrue($concrete instanceof AbstractClassInterface);
    }

    public function testThatRoutesAreAddedToRouter()
    {
        $routerMock = $this->createMock(Router::class);
        $routerMock->expects($this->exactly(4))->method('add');

        $app = new Application($routerMock);

        $app->get('/', 'NullHandler');
        $app->post('/', 'NullHandler');
        $app->put('/', 'NullHandler');
        $app->delete('/', 'NullHandler');
    }

    public function testThatGlobalRequestsMatch()
    {
        // this isn't really a test... I just don't want to put annotations in
        // code to skip lines for code coverage.
        $this->assertEquals($this->app->createRequestFromGlobals(), Request::createFromGlobals());
    }
}

interface AbstractClassInterface {}
class AbstractClassImplementation implements AbstractClassInterface {}
