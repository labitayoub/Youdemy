<?php
namespace App\Models;

use App\Config\Database;
use PDO;
use PDOException;

class TagModels {
    private $connexion;

    public function __construct() {
        $db = new Database();
        $this->connexion = $db->connect();
    }

 
    public function addTag($tagName) {
        try {
            $query = "INSERT INTO Tag (nom) VALUES (:nom)";
            $stmt = $this->connexion->prepare($query);
            $stmt->bindParam(':nom', $tagName);
            $stmt->execute();
            return $this->connexion->lastInsertId();
        } catch (PDOException $e) {
            error_log("Erreur lors de l'ajout du tag : " . $e->getMessage());
            
        }
    }


    public function removeTag($tagId) {
        try {
            $query = "DELETE FROM Tag WHERE id = :id";
            $stmt = $this->connexion->prepare($query);
            $stmt->bindParam(':id', $tagId, PDO::PARAM_INT);
            return $stmt->execute();
        } catch (PDOException $e) {
            error_log("Erreur lors de la suppression du tag : " . $e->getMessage());
            
        }
    }


    public function getAllTags() {
        try {
            $query = "SELECT * FROM Tag";
            $stmt = $this->connexion->query($query);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Erreur lors de la récupération des tags : " . $e->getMessage());
          
        }
    }
}