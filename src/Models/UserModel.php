<?php

namespace App\Models;

use App\Classes\Users;
use App\Config\Database;
use PDOException;
use PDO;

class UserModel
{

    private $connexion;


    public function __construct()
    {
        $db = new Database();
        $this->connexion = $db->connect();
    }

    public function findMember($email, $password)
    {
        $query = "SELECT id, nom , prenom ,email, password, role, compte_statut
                  FROM users 
                  WHERE email = :email AND password = :password";

        $stmt = $this->connexion->prepare($query);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':password', $password);
        $stmt->execute();

        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$row) {

            return null;
        } else {
            return new users($row['id'], $row["nom"], $row["prenom"], $row["email"], $row["password"], $row["role"], $row["compte_statut"]);
        }
    }

    public function addMember($nom, $prenom, $email, $password, $role)
    {

        $query = "INSERT INTO users (nom, prenom,email, password,role )
                    VALUES (:nom, :prenom,:email, :password, :role );";

        $stmt = $this->connexion->prepare($query);
        $stmt->bindParam(':nom', $nom);
        $stmt->bindParam(':prenom', $prenom);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':password', $password);
        $stmt->bindParam(':role', $role);

        try {

            $stmt->execute();
        } catch (PDOException $e) {
            return $e->getMessage();
        }
    }
    public function supprimerUser($userId)
    {

        $sql = "DELETE FROM Users WHERE id = :userId";
        $stmt = $this->connexion->prepare($sql);
        $stmt->bindParam(':userId', $userId, PDO::PARAM_INT);

        return $stmt->execute();
      

    }
}
