<?php

namespace core\router;

/**
 * @class Route
 * @method Routing as($param)
 */
class Routing
{
    public static $routes = [];
    private $group;
    private static $groupname = [];
    private $route = [];

    public function __construct($name, $arguments)
    {
        $route = $arguments[0];
        if ($name=='group') {
            $this->group = true;
            self::$groupname[] = trim($arguments[0], '/');
            $arguments[1]();
        } elseif (isset($arguments[1]) && $arguments[1] instanceof \Closure) {
            $this->route['params'] = $arguments[1];
        }
        $this->route['method'] = strtoupper($name);
        $this->route['route'] = trim($route, '/');
        if (!empty(self::$groupname)) {
            $this->route['route'] = implode('/', self::$groupname).'/'.$this->route['route'];
        }
        $this->route['as'] = uniqid('route_');
        return $this;
    }

    public function __call($name, $args)
    {
        $this->route[$name] = $args[0];
        return $this;
    }

    /**
     * @return void
     */
    public function to($to)
    {
        $this->route['to'] = $to;
        $this->add();
    }

    private function add()
    {
        self::$routes[$this->route['as']] = $this->route;
    }

    public function __destruct()
    {
        if ($this->group) {
            self::$groupname = null;
        }
    }
}