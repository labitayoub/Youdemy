// App/Models/CoursModel.php
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


}
