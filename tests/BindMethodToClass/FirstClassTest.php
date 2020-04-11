<?php

namespace Minbaby\ExtraDemo\Blog\Test\BindMethodToClass;

use Minbaby\ExtraDemo\Blog\BindMethodToClass\FirstClass;
use PHPUnit\Framework\TestCase;

class FirstClassTest extends TestCase
{
    /**
     * @var FirstClass
     */
    private $obj;

    protected function setUp(): void
    {
        $this->obj = new FirstClass();
        $this->obj->hello = function () {
            return '我是动态添加的';
        };
    }

    protected function tearDown(): void
    {
        $this->obj = null;
    }

    public function testMethodNotFound()
    {
        $this->expectExceptionMessage('Call to undefined method');
        $this->obj->hello();
    }

    public function testCallMethod()
    {
        $func = $this->obj->hello;
        $this->assertSame(true, is_callable($func));

        $this->assertSame('我是动态添加的', ($this->obj->hello)());
    }
}
