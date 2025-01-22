<?php
namespace App\Models;

use App\Config\Database;
use PDO;
use PDOException;

class CategorieModels {
    private $connexion;

    public function __construct() {
        $db = new Database();
        $this->connexion = $db->connect();
    }


    public function addCategory($categoryName) {
        try {
            $query = "INSERT INTO Categorie (nom) VALUES (:nom)";
            $stmt = $this->connexion->prepare($query);
            $stmt->bindParam(':nom', $categoryName);
            $stmt->execute();
        } catch (PDOException $e) {
            error_log("Erreur lors de l'ajout de la catégorie : " . $e->getMessage());
             false;
        }
    }


    public function removeCategory($categoryId) {
        try {
            $query = "DELETE FROM Categorie WHERE id = :id";
            $stmt = $this->connexion->prepare($query);
            $stmt->bindParam(':id', $categoryId, PDO::PARAM_INT);
            $stmt->execute();
        } catch (PDOException $e) {
            error_log("Erreur lors de la suppression de la catégorie : " . $e->getMessage());
           
        }
    }


    public function editCategory($categoryId, $newCategoryName) {
        try {
            $query = "UPDATE Categorie SET nom = :nom WHERE id = :id";
            $stmt = $this->connexion->prepare($query);
            $stmt->bindParam(':nom', $newCategoryName);
            $stmt->bindParam(':id', $categoryId, PDO::PARAM_INT);
            $stmt->execute();
        } catch (PDOException $e) {
            error_log("Erreur lors de la modification de la catégorie : " . $e->getMessage());
           
        }
    }


    public function getAllCategories() {
        try {
            $query = "SELECT * FROM Categorie";
            $stmt = $this->connexion->query($query);
             $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Erreur lors de la récupération des catégories : " . $e->getMessage());
            
        }
    }


    public function getCategoryById($categoryId) {
        try {
            $query = "SELECT * FROM Categorie WHERE id = :id";
            $stmt = $this->connexion->prepare($query);
            $stmt->bindParam(':id', $categoryId, PDO::PARAM_INT);
            $stmt->execute();
          $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Erreur lors de la récupération de la catégorie : " . $e->getMessage());
          
        }
    }
}