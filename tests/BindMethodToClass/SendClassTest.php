<?php


namespace Minbaby\ExtraDemo\Blog\Test\BindMethodToClass;


use Minbaby\ExtraDemo\Blog\BindMethodToClass\FirstClass;
use Minbaby\ExtraDemo\Blog\BindMethodToClass\SecondClass;
use PHPUnit\Framework\Error\Notice;
use PHPUnit\Framework\TestCase;
use PHPUnit\Framework\Warning;

class SendClassTest extends TestCase
{

    public function testCallEcho()
    {
        SecondClass::macro('echo', function () {
            return 'hello world!';
        });

        $obj = new SecondClass();
        $this->assertSame('hello world!', $obj->echo());
    }

    public function testCallEchoWithArgs()
    {
        SecondClass::macro('echo', function (...$args) {
            $arg = implode("|", $args);
            return "hello world!\nargs: {$arg}";
        });

        $args = [];
        foreach (range(0, 100) as $y) {
            $args[] = rand(0, 100);
        }

        $obj = new SecondClass();
        $this->assertSame(
            "hello world!\nargs: " . implode("|", $args),
            $obj->echo(...$args)
        );
    }

    /**
     * @throws \Exception
     */
    public function testCallEchoAndUseThisInFunc()
    {
        SecondClass::macro('echo', function () {
            $current = date("Y-m-d H:i:s", $this->current);
            return "hello world! now: $current";
        });

        $obj = new SecondClass();
        $this->expectException(Notice::class);
        // 注意，这里报错的类是本测试类， SendClassTest, 也是就 this 绑定异常 了
        $this->expectExceptionMessage('Undefined property: Minbaby\ExtraDemo\Blog\Test\BindMethodToClass\SendClassTest::$current');
        $obj->echo();
    }
}