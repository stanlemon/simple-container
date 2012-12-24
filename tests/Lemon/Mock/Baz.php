<?php
namespace Lemon\Mock;

class Baz
{
    protected $foo;
    protected $hello;

    public function __construct($world)
    {
        $this->hello = $world;
    }

    public function setFoo(Foo $foo)
    {
        $this->foo = $foo;
        return $this;
    }

    public function getFoo()
    {
        return $this->foo;
    }

    public function sayHello()
    {
        return $this->hello;
    }
}
