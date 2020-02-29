<?php

namespace core\router;

/**
 * @class Route
 * @method static Routing post($name, \Closure $func=null)
 * @method static Routing get($name, \Closure $func=null)
 * @method static Routing put($name, \Closure $func=null)
 * @method static Routing delete($name, \Closure $func=null)
 * @method static Routing when(array $codes)
 * @method static void group($name, \Closure $func)
 */
class Route
{
    public static function __callStatic($name, $arguments)
    {
        return new Routing($name, $arguments);
    }
}