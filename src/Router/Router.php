<?php

namespace Mvc\Router;

class Router {

    private $routes = [];

    public function add($method, $path, $handler)
    {
        if (!isset($this->routes[$method])) {
            $this->routes[$method] = [];
        }

        $this->routes[$method][] = new Route($path, $handler);
    }

    public function match($method, $path)
    {
        if (!isset($this->routes[$method])) {
            return null;
        }

        foreach ($this->routes[$method] as $route) {
            if ($route->isMatch($path)) {
                return $route->getNamedParameterValues($path);
            }
        }

        return null;
    }

}
