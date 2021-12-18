<?php

namespace app\Core;

use app\Core\DbModel;


abstract class ModleUser extends DbModel {


    abstract public function getDisplayName(): string;
}


?>