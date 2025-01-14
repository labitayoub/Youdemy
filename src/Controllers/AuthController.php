<?php

namespace App\Controllers;

use App\Classes\Users;
use App\Config\Database;
use App\Models\UserModel;
use App\Models\NewUserModel;
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
                header('Location: ../users/dashboard.php');
                exit();
            }
            else if($member->getRole() == "Etudiant")
            {
              header("Location: ../users/Etudiant.php");
              exit();
            }
            else if($member->getRole() == "Enseignant")
            {
              header("Location: ../users/Enseignant.php");
              exit();
            }
        }
    }
    public function register($nom, $prenom, $email, $password, $role) {
        $NewUserModel = new NewUserModel();
        $NewUserModel->addMember($nom, $prenom, $email, $password, $role);
    }

}


?>
<script>
var messages = document.getElementsByClassName('message');
setTimeout(function() {
    for (var i = 0; i < messages.length; i++) {
        messages[i].style.display = 'none';
    }
}, 4000);
</script>
