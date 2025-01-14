<?php
namespace App\Models;

use App\Classes\Users;
use App\Config\Database;
use PDO;

class UserModel{

    private $connexion;


    public function __construct() {
            $db = new Database();
            $this->connexion = $db->connect();
    }

    public function findMember($email, $password) {
        $query = "SELECT id, nom , prenom ,email, password, role, compte_statut
                  FROM users 
                  WHERE email = :email AND password = :password";
 
            $stmt = $this->connexion->prepare($query);
            $stmt->bindParam(':email', $email);
            $stmt->bindParam(':password', $password);
            $stmt->execute();
    
            $row = $stmt->fetch(PDO::FETCH_ASSOC);

            if(!$row){

                return null;
            }
            else{
                return new users($row['id'],$row["nom"],$row["prenom"],$row["email"],$row["password"],$row["role"],$row["compte_statut"]);

            }
    }
    
}