<?php

use App\Config\Database;
use PDO;
use PDOException;

class CoursModel {
    private $connexion;

    public function __construct() {
        $db = new Database();
        $this->connexion = $db->connect();
    }

    public function getCoursList() {
        try {
            $query = "
                SELECT cours.id, cours.titre, cours.contenu, cours.description, 
                       categorie.nom AS categorie, 
                       GROUP_CONCAT(tag.nom SEPARATOR ', ') AS tags, 
                       CONCAT(users.nom, ' ', users.prenom) AS enseignant
                FROM cours
                JOIN categorie ON cours.categorie_id = categorie.id
                LEFT JOIN coursTag ON cours.id = coursTag.cours_id
                LEFT JOIN tag ON coursTag.tag_id = tag.id
                JOIN users ON cours.user_id = users.id
                GROUP BY cours.id
            ";
            return $this->connexion->query($query)->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            throw new \Exception("Erreur lors de la récupération des cours: " . $e->getMessage());
        }
    }

    public function ajouterCours(Cours $cours) {
        try {
            $query = "INSERT INTO cours (titre, description, contenu, categorie_id, user_id) 
                      VALUES (:titre, :description, :contenu, :categorie_id, :user_id)";
            $stmt = $this->connexion->prepare($query);
            $stmt->execute([
                ':titre' => $cours->getTitre(),
                ':description' => $cours->getDescription(),
                ':contenu' => $cours->getContenu(),
                ':categorie_id' => $cours->getCategorie_id(),
                ':user_id' => $cours->getUser_id()
            ]);
            return $this->connexion->lastInsertId();
        } catch (PDOException $e) {
            throw new \Exception("Erreur lors de l'ajout du cours: " . $e->getMessage());
        }
    }

    public function mettreAJourCours(Cours $cours) {
        try {
            $query = "UPDATE cours 
                      SET titre = :titre, description = :description, contenu = :contenu, 
                          categorie_id = :categorie_id, user_id = :user_id 
                      WHERE id = :id";
            $stmt = $this->connexion->prepare($query);
            $stmt->execute([
                ':titre' => $cours->getTitre(),
                ':description' => $cours->getDescription(),
                ':contenu' => $cours->getContenu(),
                ':categorie_id' => $cours->getCategorie_id(),
                ':user_id' => $cours->getUser_id(),
                ':id' => $cours->getId()
            ]);
            return true;
        } catch (PDOException $e) {
            throw new \Exception("Erreur lors de la mise à jour du cours: " . $e->getMessage());
        }
    }

    public function supprimerCours($id) {
        try {
            $query = "DELETE FROM cours WHERE id = :id";
            $stmt = $this->connexion->prepare($query);
            $stmt->execute([':id' => $id]);
            return true;
        } catch (PDOException $e) {
            throw new \Exception("Erreur lors de la suppression du cours: " . $e->getMessage());
        }
    }
}