<?php

namespace app\controllers;

use app\Core\Request;
use app\Core\Controller;
use app\Core\Application;
use app\Core\Response;
use app\Models\ContactForm;

class SiteController extends Controller
{
    public $params = [];
    
    public function home()
    {
        $params = [
            'title' => 'home',
            'content' => 'creative for web',
        ];
        Application::$app->router->title = 'Home';
        
        return $this->render('home', $params);
    }
    
    public function contact(Request $request, Response $response)
    {
        Application::$app->router->title = 'Contact';
        $params = [];
        
        $contactData = new ContactForm();

        // var_dump(array_key_exists('csrf-token', $_POST));
        if ($request->isPost() && array_key_exists('csrf-token', $_POST)) {
            
            $contactData->loudData($request->getBody());

            if ($contactData->validate() && $contactData->send()) {
                
                
                Application::$app->response->redirect('/contact');
                // exit;        
            }
            
            
            return $this->render('contact', ['model' => $contactData]);
        }
        // $body = $request->getBody();
        // var_dump('failed222');
    
        return $this->render('contact', ['model' => $contactData]);

    }
}
