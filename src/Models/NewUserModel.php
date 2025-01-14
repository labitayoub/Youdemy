<?php
namespace App\Models;

use App\Classes\Users;
use App\Config\Database;


use PDOException;
use PDO;

class NewUserModel {
    private $connexion;

    public function __construct() {
        $db = new Database();
        $this->connexion = $db->connect();
    }

    public function addMember($nom,$prenom, $email,$password,$role) {

            $query = "INSERT INTO users (nom, prenom,email, password,role )
                        VALUES (:nom, :prenom,:email, :password, :role );";
            
            $stmt = $this->connexion->prepare($query);
            $stmt->bindParam(':nom', $nom);
            $stmt->bindParam(':prenom', $prenom);
            $stmt->bindParam(':email', $email);
            $stmt->bindParam(':password', $password);
            $stmt->bindParam(':role', $role);

            try{

            $stmt->execute();

        } catch (PDOException $e) {
            return null; 
        }
    }
}