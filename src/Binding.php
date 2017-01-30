<?php

namespace Mvc;

class Binding {
    private $container;

    private $abstract;

    public function __construct($container, $abstract)
    {
        $this->container = $container;
        $this->abstract = $abstract;
    }

    public function to($concrete)
    {
        $this->container->set($this->abstract, \DI\object($concrete));
    }
}
