<?php

namespace app\Core;

use app\Core\Model;
use PDO;

abstract class DbModel extends Model
{
  abstract static function tableName(): string;
  abstract function attribute(): array;
  // abstract static function primaryKey(): string;

  public function save()
  {
    $tableName = $this->tableName();
    $attribute = $this->attribute();

    $db = Application::$app->db::$database;
    $q =  $db->query('INSERT INTO ' . $tableName,  $attribute);

    if ($q->getRowCount() == 1) {
      return true;
    }
  }

  // check the email from db
  public static function findOne($where)
  {
    $tableName = static::tableName();
    $attribute = array_keys($where);
    $sql = implode("AND",array_map(fn($attr) => "$attr = :$attr",$attribute));
    $dbs = Application::$app->dbs::$pdo;
    $stat =$dbs->prepare("SELECT * FROM $tableName WHERE $sql");
    
    foreach ($where as $key => $value) {
      $stat->bindValue(":$key",$value,PDO::PARAM_STR);
    }
    $stat->execute();
    // print_r($value);
    return $stat->fetchObject(static::class);
  }

  // check the password from db


}
