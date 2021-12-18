<?php

namespace app\Core;

use app\Core\Router;

class Application
{

    public static string $ROOT_DIR;
    public static Application $app;

    public $userClass;
    // public $userObj;
    public Router $router;
    public Request $request;
    public Database $db;
    public Database0 $dbs;
    public Response $response;
    public Session $session;
    public Controller $controller;
    public ?DbModel $user; // use ? maybe the current user = null

    public function __construct($rootPath, array $config)
    {
        // $this->userClass = $config['userClass'];
        self::$ROOT_DIR = $rootPath;
        // var_dump();die;
        self::$app = $this;
        $this->response = new Response;
        $this->request = new Request();
        $this->session = new Session();
        $this->router = new Router($this->request, $this->response);
        $this->controller = new Controller();
        // Database
        $this->db = new Database($config['db']);
        $this->dbs = new Database0($config['db']);

        $userInfo = $this->session->get('user');
        if ($userInfo) {
            $this->user = $userInfo;
        } else {
            $this->user = null;
        }
        // else{
        // return ;
        // }
        // $this->session->get('user');

    }

    public function run()
    {
        echo $this->router->resolve();
    }

    public function getController()
    {
        return $this->controller;
    }

    public function setController(Controller $controller)
    {
        $this->controller = $controller;
    }

    public function login(DbModel $user)
    {
        $this->user = $user;
        $userInfo = $user;
        // echo '<br>';
        // print_r($userInfo);die;
        // echo '<br/>';
        // die;
        if (!$userInfo) {
            return false;
        }
        $this->session->set('user', $userInfo);
        return true;
    }

    public function logOut()
    {
        $this->user = null;
        $this->session->remove('user');
    }

    public static function is_Gest()
    {
        return !self::$app->user;
    }
}
