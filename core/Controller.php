<?php 

namespace app\Core;

use app\core\middleware\BaseMiddleware;

class Controller {

    /** @var app\core\middleware\BaseMiddleware [] */
    protected $actions = '';
    public array $Middleware = [];

    public string $layout = 'main';

    public function setLayout($layout){
        $this->layout = $layout;
    }

    public function render($view, $params = []){
        return Application::$app->router->renderView($view, $params);
    }

    public function registerMiddleware(BaseMiddleware $Middleware){
        $this->Middleware [] = $Middleware;
    }

    public function getMiddlewareActions() {
        return $this->actions;
    }
}
