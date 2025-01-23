<?php

namespace App\Controllers;

use App\Models\CoursModel;
use App\Classes\Cours;

class CoursController {
    private $coursModel; 

    public function __construct() {
        $this->coursModel = new CoursModel();
    }

    public function getCoursByEnseignant($enseignantId) {
        return $this->coursModel->getCoursByEnseignant($enseignantId);
    }

    public function getStatistiquesByEnseignant($enseignantId) {
        return $this->coursModel->getStatistiquesByEnseignant($enseignantId);
    }

    public function AjouteCours($titre, $description, $contenu, $categorie_id, $user_id, $selectedTags = []) {
        $cours = new Cours(null, $titre, $description, $contenu, $categorie_id, $user_id);
        $coursId = $this->coursModel->ajouterCours($cours);

        if (!empty($selectedTags)) {
            foreach ($selectedTags as $tagId) {
                $this->coursModel->ajouterTagAuCours($coursId, $tagId);
            }
        }

        return $coursId;
    }

    
    public function mettreAJourCours($id, $titre, $description, $contenu, $categorie_id, $user_id, $selectedTags = []) {
        $cours = new Cours($id, $titre, $description, $contenu, $categorie_id, $user_id);
        $this->coursModel->mettreAJourCours($cours);

        $this->coursModel->supprimerTagsDuCours($id);
        if (!empty($selectedTags)) {
            foreach ($selectedTags as $tagId) {
                $this->coursModel->ajouterTagAuCours($id, $tagId);
            }
        }

        return true;
    }

   
    public function supprimerCours($id) {
        return $this->coursModel->supprimerCours($id);
    }

    public function getCoursById($id) {
        return $this->coursModel->getCoursById($id);
    }
}