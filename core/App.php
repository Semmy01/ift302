<?php

class App
{
    protected string $controller = 'HomeController';
    protected string $method = 'index';
    protected array $params = [];
    protected object $controllerInstance;

    public function __construct()
    {
        $url = $this->parseUrl();

        // Match Controller
        if (!empty($url[0])) {
            $controllerName = ucfirst(strtolower($url[0])) . 'Controller';
            $controllerFile = __DIR__ . '/../app/Controllers/' . $controllerName . '.php';

            if (file_exists($controllerFile)) {
                $this->controller = $controllerName;
                unset($url[0]);
            }
        }

        require_once __DIR__ . '/../app/Controllers/' . $this->controller . '.php';
        $this->controllerInstance = new $this->controller();

        // Match Method / Action
        if (!empty($url[1])) {
            $actionName = strtolower($url[1]);
            if (method_exists($this->controllerInstance, $actionName)) {
                $this->method = $actionName;
                unset($url[1]);
            }
        }

        $this->params = $url ? array_values($url) : [];

        call_user_func_array([$this->controllerInstance, $this->method], $this->params);
    }

    private function parseUrl(): array
    {
        if (isset($_GET['url'])) {
            return explode('/', filter_var(rtrim($_GET['url'], '/'), FILTER_SANITIZE_URL));
        }

        if (isset($_SERVER['PATH_INFO'])) {
            return explode('/', filter_var(trim($_SERVER['PATH_INFO'], '/'), FILTER_SANITIZE_URL));
        }

        return [];
    }
}
