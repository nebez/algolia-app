<?php

namespace Mvc;

use Exception;
use Invoker\Invoker;
use Invoker\ParameterResolver\Container\TypeHintContainerResolver;
use Mvc\Router\Router;
use Mvc\Exceptions\HttpException;
use Mvc\Exceptions\ClientHttpException;
use Mvc\Exceptions\ServerHttpException;
use Mvc\Exceptions\NotFoundHttpException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;

class Application {

    private $router;

    private $container;

    public function __construct(Router $router)
    {
        $this->router = $router;
    }

    public function setContainer($container)
    {
        $this->container = $container;
    }

    public function get($path, $handler)
    {
        $this->router->add('GET', $path, $handler);
    }

    public function post($path, $handler)
    {
        $this->router->add('POST', $path, $handler);
    }

    public function put($path, $handler)
    {
        $this->router->add('PUT', $path, $handler);
    }

    public function delete($path, $handler)
    {
        $this->router->add('DELETE', $path, $handler);
    }

    public function json($data, $status = 200)
    {
        return new JsonResponse($data, $status);
    }

    public function createRequestFromGlobals()
    {
        return Request::createFromGlobals();
    }

    public function handle(Request $request)
    {
        // Bind the request being handled to the container so it can be
        // resolved later on when we're dispatching to a controller.
        $this->container->set(Request::class, $request);

        // Attempt to match the route and dispatch it to a controller. Since
        // this is where things will most likely go wrong, we'll bind our
        // exception handling here and respond appropriately.
        $method = $request->getMethod();
        $path = $request->getPathInfo();

        try {
            $matchedRoute = $this->router->match($method, $path);

            if ($matchedRoute === null) {
                throw new NotFoundHttpException('No route matched');
            }

            $response = $this->dispatch($matchedRoute);

            return $response;
        } catch (HttpException $e) {
            return $this->json([
                'error' => get_class($e),
                'message' => $e->getMessage(),
                'code' => $e->getHttpCode()
            ]);
        } catch (Exception $e) {
            return $this->json([
                'error' => get_class($e),
                'message' => 'Unhandled exception: ' . $e->getMessage(),
                'code' => 500
            ]);
        }
    }

    private function dispatch($route)
    {
        list($controller, $method) = split('@', $route->getHandler());

        $controller = $this->container->get($controller);

        if (!method_exists($controller, $method)) {
            throw new ServerHttpException(500, 'Controller method does not exist');
        }

        // Create a method invoker so our controllers can resolve dependencies
        // out of the container through type-hints. This makes it a breeze to
        // access the Application and Request in each controller method.
        $resolver = new TypeHintContainerResolver($this->container);
        $invoker = new Invoker;
        $invoker->getParameterResolver()->prependResolver($resolver);

        // By adding an array to the invoker as a second argument, we can take
        // advantage of automatically injecting named parameters into the
        // controller method. /path/:id will inject $id into the method.
        $response = $invoker->call([$controller, $method], $route->getNamedParameterValues());

        if (!$response instanceof Response) {
            if (method_exists($response, '__toString')) {
                $response = new Response($response->__toString(), 200);
            } else if (is_string($response)) {
                $response = new Response($response, 200);
            } else {
                throw new ServerHttpException(500, 'Controllers must return a Response or implement __toString');
            }
        }

        return $response;
    }
}
