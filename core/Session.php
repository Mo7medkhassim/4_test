<?php 

namespace app\Core;

class Session {

    protected const FLASH_KEY  = 'flash_Messages';
    public function __construct()
    {
        session_start();
        $flashMessages[] = $_SESSION['self::FLASH_KEY'] ?? [];
        
        foreach ($flashMessages as $key => &$flashMessage) {
            $flashMessage['remove'] = true;
            // if (isset($flashMessage['remove'])) {
            //     # code...
            // }
        }
        
        $_SESSION[self::FLASH_KEY] = $flashMessages;
    }
    
    public function setFlashMessage($key,$message){

        $_SESSION[self::FLASH_KEY][$key] =
        [
            'remove' => false,
            'value' => $message
        ];
    }

    public function getFlashMessage($key){
        return $_SESSION[self::FLASH_KEY][$key]['value'] ?? false;
    }

    // get and set user
    public function set($key,$value){
        $_SESSION[$key] = $value;
    }

    public function get($key){
        return $_SESSION[$key] ?? false;
    }

    public function remove($key){
        unset($_SESSION[$key]);
    }
    

    // to clear
    public function __destruct()
    {
        $flashMessages = $_SESSION[self::FLASH_KEY] ?? [];
        // echo "<br>";
        // var_dump($flashMessages);die;
        
        foreach ($flashMessages as $key => &$flashMessage) {
            if ($flashMessage['remove']) {
                unset($flashMessage[$key]);
            }
            $_SESSION[self::FLASH_KEY] = $flashMessages;
        }
    }
}

?>