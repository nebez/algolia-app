<?php

namespace Mvc;

use Interop\Container\ContainerInterface;

class Binding {
    private $container;

    private $abstract;

    public function __construct(ContainerInterface $container, $abstract)
    {
        $this->container = $container;
        $this->abstract = $abstract;
    }

    public function to($concrete)
    {
        $this->container->set($this->abstract, \DI\object($concrete));
    }
}
