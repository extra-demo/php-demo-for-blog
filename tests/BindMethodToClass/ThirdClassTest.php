<?php


namespace Minbaby\ExtraDemo\Blog\Test\BindMethodToClass;


use Minbaby\ExtraDemo\Blog\BindMethodToClass\SecondClass;
use Minbaby\ExtraDemo\Blog\BindMethodToClass\ThirdClass;
use PHPUnit\Framework\Error\Notice;
use PHPUnit\Framework\TestCase;

class ThirdClassTest extends TestCase
{
    public function testCallEcho()
    {
        ThirdClass::macro('echo', function () {
            return 'hello world!';
        });

        $obj = new ThirdClass();
        $this->assertSame(
            "hello world!",
            $obj->echo()
        );
    }

    public function testCallEchoWithArgs()
    {
        ThirdClass::macro('echo', function (...$args) {
            $arg = implode(" | ", $args);
            return "hello world!\nargs: {$arg}";
        });

        $args = [];
        foreach (range(0, 100) as $y) {
            $args[] = rand(0, 100);
        }

        $obj = new ThirdClass();
        $this->assertSame(
            "hello world!\nargs: " . implode(" | ", $args),
            $obj->echo(...$args)
        );
    }

    /**
     * @throws \Exception
     */
    public function testCallEchoAndUseThisInFunc()
    {
        ThirdClass::macro('echo', function () {
            $current = date("Y-m-d H:i:s", $this->current);
            return "hello world!now: {$current}";
        });

        $current = time();

        $obj = new ThirdClass($current);
        $current = date("Y-m-d H:i:s", $current);
        $this->assertSame("hello world!now: $current", $obj->echo());
    }
}