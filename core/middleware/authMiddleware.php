<?php

namespace app\core\middleware;

use app\Core\Application;
use app\core\exception\ForBiddenException;
use app\core\middleware\BaseMiddleware;


class AuthMiddleware extends BaseMiddleware{

    public array $actions = [];

    public function __construct(array $actions = [])
    {
        $this->actions = $actions;
    }

    public function excute()
    {
        if (Application::is_Gest()) {
            if (empty($this->actions) || in_array(Application::$app->controller->actions,$this->actions)) {
                throw new ForBiddenException();
            }
        }
    }
}


?>