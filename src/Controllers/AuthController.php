<?php

namespace App\Controllers;

use App\Classes\Users;
use App\Config\Database;
use App\Models\UserModel;
use PDO;

class AuthController{
    
    public function login($email, $password){


        $memberModel = new UserModel();
        $member = $memberModel->findMember($email, $password);
        if($member == null)
        {
            echo "membre non trouvé veuillez vérifier ...";
        }
        else{


            if($member->getRolee() == "Administrateur")
            {
                header('Location: ../users/dashboard.php');
                exit();
            }
            else if($member->getRolee() == "Etudiant")
            {
              header("Location: ../users/Etudiant.php");
              exit();
            }
            else if($member->getRolee() == "Enseignant")
            {
              header("Location: ../users/Enseignant.php");
              exit();
            }
        }
    }

}