<?php
namespace Lemon;

class SimpleContainerTest extends \PHPUnit_Framework_TestCase
{
    public function testNewContainer()
    {
        $container = new SimpleContainer();

        $this->assertTrue($container instanceof \Lemon\SimpleContainer);
    }

    public function testSetGetObject()
    {
        $container = new SimpleContainer();

        $foo1 = new \Lemon\Mock\Foo();

        $container->set('foo', $foo1);

        $foo2 = $container->get('foo');

        $this->assertEquals($foo1, $foo2);
    }

    public function testGetNonExistingObject()
    {
        try {
            $container = new SimpleContainer();

            $container->get('madeUp');
        } catch (\InvalidArgumentException $e) {
            return;
        }

        $this->fail('An expected exception has not been raised.');
    }

    public function testSetGetClosure()
    {
        $container = new SimpleContainer();

        $container->set(
            'foo',
            function () {
                return new \Lemon\Mock\Foo();
            }
        );

        $foo = $container->get('foo');
        $this->assertTrue($foo instanceof \Lemon\Mock\Foo);
    }

    public function testHasObject()
    {
        $container = new SimpleContainer();

        $container->set(
            'foo',
            function () {
                return new \Lemon\Mock\Foo();
            }
        );

        $this->assertTrue($container->has('foo'));
        $this->assertFalse($container->has('fakse'));
    }

    public function testArrayAccessObject()
    {
        $container = new SimpleContainer();

        $container['foo'] = new \Lemon\Mock\Foo();

        $this->assertTrue($container['foo'] instanceof \Lemon\Mock\Foo);

        $isset = isset($container['foo']);
        $isntset = isset($container['fake']);

        $this->assertTrue($isset);
        $this->assertFalse($isntset);
    }

    public function testArrayAccessClosure()
    {
        $container = new SimpleContainer();

        $container['foo'] = function () {
            return new \Lemon\Mock\Foo();
        };

        $this->assertTrue($container['foo'] instanceof \Lemon\Mock\Foo);
    }

    public function testArrayAccessUnset()
    {
        try {
            $container = new SimpleContainer();

            $container['foo'] = function () {
                return new \Lemon\Mock\Foo();
            };

            unset($container['foo']);
        } catch(\BadFunctionCallException $e) {
            return;
        }
 
        $this->fail('An expected exception has not been raised.');
    }

    /**
     * @covers Lemon\SimpleContainer::identifyConstructorParams()
     */
    public function testNewInstanceConstructor()
    {
        $container = new SimpleContainer();
        $container->set(
            'foo',
            function () {
                return new \Lemon\Mock\Foo();
            }
        );

        $bar = $container->newInstance('\Lemon\Mock\Bar');
        
        $this->assertTrue($bar->getFoo() instanceof \Lemon\Mock\Foo);
    }

    public function testNewInstanceNothing()
    {
        $container = new SimpleContainer();
        $foo = $container->newInstance('\Lemon\Mock\Foo');

        $this->assertTrue($foo instanceof \Lemon\Mock\Foo);
    }

    public function testNoInstance()
    {
        try {
            $container = new SimpleContainer();
            $fake = $container->newInstance('fake');
        } catch (\ReflectionException $e) {
            return;
        }

        $this->fail('An expected exception has not been raised.');
    }

    public function testNewInstanceCustomParams()
    {
        $container = new SimpleContainer();

        $bar = $container->newInstance('\Lemon\Mock\Bar', array(new \Lemon\Mock\Foo()));

        $this->assertTrue($bar instanceof \Lemon\Mock\Bar);
        $this->assertTrue($bar->getFoo() instanceof \Lemon\Mock\Foo);
    }

    /**
     * @covers Lemon\SimpleContainer::injectSetters()
     */
    public function testNewInstanceSetters()
    {
        $container = new SimpleContainer();
        $container->set(
            'foo',
            function () {
                return new \Lemon\Mock\Foo();
            }
        );

        $baz = $container->newInstance('\Lemon\Mock\Baz', array('World'));
        
        $this->assertTrue($baz->getFoo() instanceof \Lemon\Mock\Foo);

        $this->assertEquals($baz->sayHello(), 'World');
    }
}
