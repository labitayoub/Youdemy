<?php

namespace App\Models;

use App\Config\Database;
use App\Classes\Cours;
use PDO;
use PDOException;

class CoursModel {
    private $connexion;

    public function __construct() {
        $db = new Database();
        $this->connexion = $db->connect();
    }

    // Récupérer les cours liés à un enseignant spécifique
    public function getCoursByEnseignant($enseignantId) {
        try {
            $query = "
                SELECT cours.id, cours.titre, cours.description, cours.contenu, 
                       categorie.nom AS categorie, 
                       GROUP_CONCAT(tag.nom SEPARATOR ', ') AS tags
                FROM cours
                JOIN categorie ON cours.categorie_id = categorie.id
                LEFT JOIN coursTag ON cours.id = coursTag.cours_id
                LEFT JOIN tag ON coursTag.tag_id = tag.id
                WHERE cours.user_id = :enseignantId
                GROUP BY cours.id
            ";
            $stmt = $this->connexion->prepare($query);
            $stmt->execute([':enseignantId' => $enseignantId]);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            throw new \Exception("Erreur lors de la récupération des cours: " . $e->getMessage());
        }
    }

    // Récupérer les statistiques pour l'enseignant connecté
    public function getStatistiquesByEnseignant($enseignantId) {
        try {
            $statistiques = [
                'totalEtudiants' => $this->connexion->query("SELECT COUNT(*) FROM users WHERE role = 'Etudiant'")->fetchColumn(),
                'totalCours' => $this->connexion->query("SELECT COUNT(*) FROM cours WHERE user_id = $enseignantId")->fetchColumn(),
                'totalInscriptions' => $this->connexion->query("SELECT COUNT(*) FROM inscriptions")->fetchColumn()
            ];
            return $statistiques;
        } catch (PDOException $e) {
            throw new \Exception("Erreur lors de la récupération des statistiques: " . $e->getMessage());
        }
    }

    // Ajouter un cours
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

    // Mettre à jour un cours
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

    // Supprimer un cours
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

    // Ajouter un tag à un cours
    public function ajouterTagAuCours($coursId, $tagId) {
        try {
            $query = "INSERT INTO coursTag (cours_id, tag_id) VALUES (:cours_id, :tag_id)";
            $stmt = $this->connexion->prepare($query);
            $stmt->execute([
                ':cours_id' => $coursId,
                ':tag_id' => $tagId
            ]);
            return true;
        } catch (PDOException $e) {
            throw new \Exception("Erreur lors de l'ajout du tag au cours: " . $e->getMessage());
        }
    }

    // Supprimer les tags d'un cours
    public function supprimerTagsDuCours($coursId) {
        try {
            $query = "DELETE FROM coursTag WHERE cours_id = :cours_id";
            $stmt = $this->connexion->prepare($query);
            $stmt->execute([':cours_id' => $coursId]);
            return true;
        } catch (PDOException $e) {
            throw new \Exception("Erreur lors de la suppression des tags du cours: " . $e->getMessage());
        }
    }

    public function getCoursById($id) {
        try {
            $query = "SELECT cours.id, cours.titre, cours.description, cours.contenu, cours.categorie_id, 
                             GROUP_CONCAT(coursTag.tag_id) AS tags
                      FROM cours
                      LEFT JOIN coursTag ON cours.id = coursTag.cours_id
                      WHERE cours.id = :id
                      GROUP BY cours.id";
            $stmt = $this->connexion->prepare($query);
            $stmt->execute([':id' => $id]);
            $cour = $stmt->fetch(PDO::FETCH_ASSOC);
    
            if ($cour) {
                $cour['tags'] = explode(',', $cour['tags']);
            }
    
            return $cour;
        } catch (PDOException $e) {
            throw new \Exception("Erreur lors de la récupération du cours: " . $e->getMessage());
        }
    }
}