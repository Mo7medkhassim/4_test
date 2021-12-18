<?php

namespace app\Models;

use app\Core\ModleUser;

class User extends ModleUser
{
    const STATUS_ACTIVE = 1;
    const STATUS_INACTIVE = 0;
    const STATUS_DELET = 2;

    public string $username        = '';
    public string $email           = '';
    public string $password        = '';
    public int    $status          = self::STATUS_INACTIVE;
    public string $confirmPassword = '';

    public function rules(): array
    {
        return [
            'username' =>                 [self::RULES_REQUIRED],
            'email' => [self::RULES_REQUIRED, self::RULES_EMAIL, 
            [self::RULES_UNIQUE, 'class' => self::class]],
            'password' => [self::RULES_REQUIRED, [self::RULES_MIN, 'min' => 8], [self::RULES_MAX, 'max' => 20]],
            'confirmPassword' => [self::RULES_REQUIRED, [self::RULES_MATCH, 'match' => 'password']]
        ];
    }

    public static function tableName(): string {
        return 'users';
    }

    public function attribute(): array
    {
        return ['username' => $this->username,'email' => $this->email,'password' => $this->password , 'status' => $this->status];
    }

    public static function primaryKey(): string
    {
        return 'id';
    }

    
    public function save()
    {
        $this->status = self::STATUS_INACTIVE;
        $this->password = password_hash($this->password, PASSWORD_DEFAULT);
        return parent::save();
    }

    public function getDisplayName(): string
    {
        return $this->username;
    }
}
