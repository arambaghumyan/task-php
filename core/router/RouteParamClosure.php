<?php

namespace core\router;

class RouteParamClosure extends RouteParam
{
    private $data = [];

    public function __call($name, $args)
    {
        $data = array_shift($args);
        $this->data[$name] = $data ? $data : true;
        return $this;
    }

    public function __get($key)
    {
        if (array_key_exists($key, $this->data)) {
            return $this->data[$key];
        }
        return null;
    }
}