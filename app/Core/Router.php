<?php

namespace App\Core;

use App\Route;

class Router
{
    private $request;
    private $controller;
    private $action;


    public function __construct($request)
    {
        $this->request = $request;
        $route = explode('@', $this->getRoute(), 2);
        $this->controller = $route[0];
        $this->action = $route[1];
    }


    public function getRoute()
    {
        return Route::rules()[$this->request->path] ?? null;
    }


    public function getController()
    {
        $controller = 'App\Controllers\\' . $this->controller;

        if ($this->controller && class_exists($controller)) {
            return $controller;
        } else {
            throw new \Exception();
        }
    }


    public function getAction()
    {
        if ($this->action && method_exists($this->getController(), $this->action)) {
            return $this->action;
        } else {
            throw new \Exception();
        }
    }
}