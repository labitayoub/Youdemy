<?php

namespace App\Controllers;

use App\Classes\Users;
use App\Config\Database;
use App\Models\UserModel;
use PDO;

class UserController
{

  public function deleteUser($userId)
  {

    $deleteUser = new UserModel();

    $result = $deleteUser->supprimerUser($userId);

    return $result;
  }
}
