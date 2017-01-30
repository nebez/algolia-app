<?php

namespace Mvc\Router;

class Route {

    private $path;

    private $handler;

    private $pathRegex;

    private $parameterNames;

    private $parameterValues;

    public function __construct($path, $handler)
    {
        $this->path = $path;
        $this->handler = $handler;
        $this->pathRegex = $this->initializePathAsRegex($path);
        $this->parameterNames = $this->initializeNamedParameters($path);
        $this->parameterValues = [];
    }

    /**
     * Converts a human-readable path to a regular expression, encapsulating
     * named parameters in capture groups for later reference
     *
     * @param  string $path
     * @return string
     */
    private function initializePathAsRegex($path)
    {
        $regex = preg_replace('/:[a-z-_]+/', '([a-zA-Z0-9-_]+)', $path);
        $regex = '/^' . str_replace('/', '\\/', $regex) . '$/';

        return $regex;
    }

    private function initializeNamedParameters($path)
    {
        preg_match_all('/:[a-z-_]+/', $path, $params);

        // Remove the leading colon from each parameter name
        $cleanParams = array_map(function ($param) {
            return trim(str_replace(':', '', $param));
        }, $params[0]);

        return $cleanParams;
    }

    public function isMatch($path)
    {
        if (preg_match_all($this->pathRegex, $path)) {
            return true;
        }

        return false;
    }

    public function setMatchedPath($path)
    {
        if (sizeof($this->parameterNames) >= 1) {
            preg_match_all($this->pathRegex, $path, $match);

            $this->parameterValues = $match[1];
        }
    }

    public function getNamedParameterValues()
    {
        return array_combine($this->parameterNames, $this->parameterValues);
    }

    public function getHandler()
    {
        return $this->handler;
    }

}
