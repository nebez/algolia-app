<?php

use Mvc\Binding;
use PHPUnit\Framework\TestCase;

class BindingTest extends TestCase {

    protected $container;

    public function setUp()
    {
        $this->container = DI\ContainerBuilder::buildDevContainer();
    }

    public function testThatInterfacesDontResolve()
    {
        $this->expectException('DI\Definition\Exception\DefinitionException');
        $this->container->get('FakeObjectInterface');
    }

    public function testThatInterfacesResolveWhenBoundToClasses()
    {
        $bind = new Binding($this->container, 'FakeObjectInterface');
        $bind->to('FakeObject');

        $concrete = $this->container->get('FakeObjectInterface');
        $this->assertTrue($concrete instanceof FakeObject);
    }

}

interface FakeObjectInterface {}
class FakeObject implements FakeObjectInterface {}
