<?php

namespace Minbaby\ExtraDemo\Blog\BindMethodToClass;

use Exception;

class SecondClass
{
    protected static $macros = [];

    protected $current;

    public function __construct($current = null)
    {
        $this->current = $current ?? time();
    }

    /**
     * @param string $name
     * @param callable $callable
     * @throws Exception
     */
    public static function macro(string $name, $callable)
    {
        static::$macros[$name] = $callable;
    }

    public function __call($name, $arguments)
    {
        if (!isset(static::$macros[$name])) {
            throw new Exception("method $name not found");
        }

        /** @var Closure $macro */

        $macro = static::$macros[$name];

        if ($macro instanceof Closure) {
            return call_user_func($macro, ...$arguments);
        }


        return $macro(...$arguments);
    }
}