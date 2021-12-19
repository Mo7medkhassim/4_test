<?php

namespace app\Core;

use app\Core\Request;
use app\Core\Application;
use app\Core\Controller;

class Router
{
    public string $title = '';
    public Request $request;
    public Response $response;
    public Controller $controller;
    protected array $routes = [];

    public function __construct(Request $request, Response $response)
    {
        $this->request = $request;
        $this->response = $response;
    }
    // get 
    public function get($path, $callback)
    {
        $this->routes['get'][$path] = $callback;
    }

    // 
    public function post($path, $callback)
    {
        $this->routes['post'][$path] = $callback;
    }

    public function resolve()
    {
        $path =  $this->request->getPath();
        $method = $this->request->Method();

        $callback = $this->routes[$method][$path] ?? false;

        if ($callback === false) {
            // status response
            $this->response->setStatusCode(404);
            return $this->renderView("_404");
        }

        if (is_string($callback)) {
            return $this->renderView($callback);
        }

        if (is_array($callback)) {
            // $a = new $callback[1]();
            // echo '<br>';
            var_dump($callback);die;
            // /** @var \app\Core\Controller $controller */
            Application::$app->controller =  new $callback[0]();
            $controller = Application::$app->controller;
            // $controller->actions = $callback[1];
            $callback[0] = $controller;
        }


        return call_user_func($callback, $this->request, $this->response);
    }

    // The function responsible of all the view of pages
    public function renderView($views, $params = [])
    {
        // var_dump($views);die;
        $layoutContent = $this->layoutContent();
        $viewContent = $this->renderOnlyView($views, $params);
        return str_replace("{{content}}", $viewContent, $layoutContent);
        // include_once Application::$ROOT_DIR."/views/$views.php";
    }

    // This responsible of the content of pages 
    public function renderContent($viewsContent)
    {
        $layoutContent = $this->layoutContent();
        return str_replace("{{content}}", $viewsContent, $layoutContent);
        // include_once Application::$ROOT_DIR."/views/$views.php";
    }

    protected function layoutContent()
    {
        $layout = Application::$app->controller->layout;
        ob_start();
        include_once Application::$ROOT_DIR . "/views/layout/$layout.php";
        return ob_get_clean();
    }

    protected function renderOnlyView($views, $params)
    {
        foreach ($params as $key => $value) {
            $$key = $value;
        }
        ob_start();
        include_once Application::$ROOT_DIR . "/views/$views.php";
        return ob_get_clean();
    }
}
