<?php 

namespace app\Core;

use PDO;
use Dibi;

class Database{

    public static $database;
    public function __construct(array $config){

        self::$database = new Dibi\Connection([
            'driver'   => $config['driver'],
            'host'     => $config['host'],
            'username' => $config['username'],
            'password' => $config['password'],
            'database' => $config['database'],
        ]);
        
    }

}







class Database0 {
    public static \PDO $pdo;

    public function __construct(array $config)
    {
        $dsn = $config['dsn'] ?? '';
        $username = $config['username'] ?? '';
        $password = $config['password'] ?? '';
        self::$pdo = new PDO($dsn,$username,$password);
        self::$pdo->setAttribute(\PDO::ATTR_ERRMODE,\PDO::ERRMODE_EXCEPTION);
        
    }
    
}


