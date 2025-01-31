<?php

class Router {
    private $routes = [];

    public function register($route, $controller, $action) {
        $this->routes[$route] = [
            'controller' => $controller,
            'action' => $action
        ];
    }


    public function resolve($requestUri) {
        
        $path = parse_url($requestUri)['path'];
        
        if (isset($this->routes[$path])) {
            $controller = $this->routes[$path]['controller'];
            $action = $this->routes[$path]['action'];
            $controllerPath = "app/controllers/{$controller}.php";
            // dd($controllerPath);
            require_once $controllerPath;
            $controller = new $controller();
            return $controller->$action();
        }else{
            return require_once "app/views/errors/404.php";
        }
        

    }
}
