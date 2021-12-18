<?php

namespace app\controllers;

use app\Core\Request;
use app\Core\Response;
use app\Core\Controller;
use app\Core\Application;
use app\core\middleware\AuthMiddleware;
use app\Models\User;
use app\Models\LoginForm;
use app\Core\Session;

class AuthController extends Controller
{
    
    public $params = [];

    public function __construct()
    {
        
    }

    public function login(Request $request, Response $response)
    {
        // use difference layout 
        $this->setLayout('auth');

        Application::$app->router->title = 'SignIn';

        $loginForm = new LoginForm();
        if ($request->isPost()) {
            $loginForm->loudData($request->getBody());

            if ($loginForm->validate() && $loginForm->login()) {
                // echo "user login";die;
                Application::$app->response->redirect('/');
                // $response->redirect('/');
                return;
            }
        }
        // handdling submit data 
        return $this->render('login', ['model' => $loginForm]);
    }

    public function register(Request $request)
    {
        // use difference layout 
        $this->setLayout('auth');
        
        Application::$app->router->title = 'Register';
        $user = new User();

        // handdling submit data 
        if ($request->isPost()) {
            $user->loudData($request->getBody());
            
            // check is data validate 
            if ($user->validate() && $user->save()) {

                // print('done');die;
                Application::$app->session->setFlashMessage('success', 'Thanks for register killua');
                Application::$app->response->redirect('/');
                return;
            }

            return $this->render('register', ['model' => $user]);

            // return "handel submit data";
        }

        
        return $this->render('register', ['model' => $user]);
    }

    public function profile()
    {
        Application::$app->router->title = 'Profile';
        
        if(empty(Application::$app->session->get('user'))){
            exit("this method not allowed");
        }

        return $this->render('profile');
    }

    public function logout(Request $request, Response $response)
    {
        Application::$app->logout();
        $response->redirect('/');
    }
}
