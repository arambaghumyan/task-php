<?php

namespace core\router;

class Router
{
    private $url;
    private $controller;
    private $action;
    private $params = [];

    public function __construct($url='')
    {
        $this->url = $url;
        $this->find();
    }

    private function stringToRoutStr(&$str)
    {
        preg_match('/[a-z0-9.]*/i', $str, $m);
        if (isset($m[0])) {
            $str = $m[0];
        }
    }

    private function find()
    {
        $data = $this->explode($this->url);

        if (isset($data[0])) {
            $this->stringToRoutStr($data[0]);
        }

        if (isset($data[1])) {
            $this->stringToRoutStr($data[1]);
        }

        if (isset($data[0]) && trim($data[0]) == '') {
            unset($data[0]);
        }

        foreach (Routing::$routes as $route) {
            $routeData = $this->explode($route['route']);
            $params = $this->compire($routeData, $data, $route);
            if (isset($params)) {
                $this->params = $params;
                list($this->controller, $this->action) = explode('::', $route['to']);
                break;
            }
        }
    }

    private function explode($url='')
    {
        return array_values(array_filter(explode('/',$url), function($v) {
					return $v!=='';
				}));
    }

    private function compire($data1, $data2, $route)
    {
        $paramsFound = [];
        $params = [];
        $replaced = 0;
        if ((empty($data1) && !empty($data2)) || $route['method'] != $_SERVER['REQUEST_METHOD']) {
        	return null;
				}
        $diff = array_diff($data1, $data2);
        foreach ($diff as $key => $param) {
            if (substr($param, 0, 1) == '{' && substr($param, -1) == '}') {
                $paramsFound[$key] = trim($param, '{}');
            }
        }
        if (count($diff) != count($paramsFound)) {
        	return null;
        }
        foreach ($paramsFound as $key => $param) {
            $rule = $this->getRules($route, $param);

            if ($rule->optional) {
                $params[$param] = strval($rule->optional);
                $replaced++;
            } else {
                if (empty($data2[$key-$replaced])) {
                    return null;
                }
                $params[$param] = $data2[$key-$replaced];
            }
            if ($rule->numeric) {
                if (!(ctype_digit($params[$param]) || is_int($params[$param]))) {
                    return null;
                }
            }
        }
        if (empty(array_diff($paramsFound, array_keys($params)))) {
            return $params;
        }
        return null;
    }

    public function getRules($route, $key)
    {
        $params = [];
        if(!empty($route['params']) && $route['params'] instanceof \Closure)
        {
            $closure = $route['params'];
            $reflection = new \ReflectionFunction($closure);
            foreach($reflection->getParameters() as $arg)
            {
                $params[$arg->name] = new RouteParamClosure();
            }
            call_user_func_array($closure, $params);
        }
        return isset($params[$key]) ? $params[$key] : new RouteParamClosure;
    }

    public function getParams()
    {
        return $this->params;
    }

    public function getController()
    {
        return $this->controller;
    }

    public function getAction()
    {
        return $this->action;
    }

    public function isRouteFound()
    {
        return $this->controller && $this->action;
    }
}