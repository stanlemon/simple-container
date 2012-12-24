<?php
namespace Lemon\Mock;

class Bar
{
    protected $foo;
    protected $hello;

    public function __construct(Foo $foo, $hello = null)
    {
        $this->foo = $foo;
        $this->hello = $hello;
    }

    public function getFoo()
    {
        return $this->foo;
    }
}
