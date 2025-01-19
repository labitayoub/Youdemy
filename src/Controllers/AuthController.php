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
            echo "<div class='message bg-red-500 text-white p-4 rounded-md text-center font-bold' style='z-index: 1; position: absolute; top:0; left: 38%; width: auto; '>Membre non trouvé veuillez vérifier</div>";
        }
        else if($member->getcompte_statut() !== 'Actif'){

           echo "<div class='message bg-red-500 text-white p-4 rounded-md text-center font-bold' style='z-index: 1; position: absolute; top:0; left: 27%; width: auto; '> Votre compte n'est pas encore activé Veuillez contacter l'administrateur </div>";
        }
        else{


            if($member->getRole() == "Administrateur")
            {
                header('Location: ../users/admin/dashboard.php');
                exit();
            }
            else if($member->getRole() == "Etudiant")
            {
              header("Location: ../users/etudiant/dashboard.php");
              exit();
            }
            else if($member->getRole() == "Enseignant")
            {
              header("Location: ../users/enseignant/dashboard.php");
              exit();
            }
        }
    }
    
    public function register($nom, $prenom, $email, $password, $role) {
        $NewUserModel = new UserModel();
        $NewUserModel->addMember($nom, $prenom, $email, $password, $role);
    }



}


?>
