<?php

namespace app\Models;

use app\Core\Application;
use app\Core\Model;
use app\Models\User;

class LoginForm extends Model
{
    public string $email           = '';
    public string $password        = '';

    public function rules(): array
    {
        return [
            'email' => [self::RULES_REQUIRED, self::RULES_EMAIL],
            'password' => [self::RULES_REQUIRED],
        ];
    }

    public function login()
    {

        $user = new User();
        $user = $user::findOne(['email' => $this->email]);
        if (!$user) {
            $this->addError('email', 'User Dose not Exist');
            return false;
        }

        // check to the password is exist
        if (!password_verify($this->password, $user->password)) {
            $this->addError('password', 'Password is incorrect!');
            return false;
        }

        // print_r($user);die;

        return Application::$app->login($user);
        // die;
        // return true;
        // return $user;
    }
}
