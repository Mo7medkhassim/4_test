<?php 

namespace app\Models;

use app\Core\DbModel;
use app\Core\Model;

class ContactForm extends DbModel{

    public string $subject = "";
    public string $email = "";
    public string $message = "";

    public static function tableName(): string
    {
        return 'contactuser';
    }

    public function attribute(): array
    {
        return ['subject' => $this->subject, 
                'email' => $this->email,
                'message' => $this->message];
    }

    public function rules(): array
    {
        return [
            'subject' => [self::RULES_REQUIRED],
            'email' => [self::RULES_REQUIRED,self::RULES_EMAIL],
            'message' => [self::RULES_REQUIRED],
        ];
    }

    public function send() {
        
        return parent::save();
    }
}




?>