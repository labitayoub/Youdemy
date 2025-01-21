<?php

class Cours {

    private $id;
    private $titre;
    private $description;
    private $contenu;
    private $categorie_id;
    private $user_id;


    public function __construct( $id, $titre, $description, $contenu, $categorie_id, $user_id)
    {
        $this->id =$id;
        $this->titre =$titre;
        $this->description =$description;
        $this->contenu =$contenu;
        $this->categorie_id =$categorie_id;
        $this->user_id =$user_id;
    }

    public function getId(){
        return $this->id;
    }
public function getTitre(){
return $this->titre;
}
public function getDescription(){
    return $this->description;
}
public function getContenu(){
    return $this->contenu;
}
public function getCategorie_id(){
    return $this->categorie_id;
}
public function getUser_id(){
    return $this->user_id;
}
public function setTitre($titre){
    $this->titre =$titre;
}
public function setDescription($description){
$this->description =$description;
}
public function setContenu($contenu){
    $this->contenu =$contenu;
}
public function setCategorie_id($categorie_id){
    $this->categorie_id =$categorie_id;
}
public function setUser_id($user_id){
    $this->user_id =$user_id;
}

public function AjouteCours() {
    $coursModel = new CoursModel();
    return $coursModel->ajouterCours($this);
}

public function mettreAJourCours() {
    $coursModel = new CoursModel();
    return $coursModel->mettreAJourCours($this);
}

public function supprimerCours() {
    $coursModel = new CoursModel();
    return $coursModel->supprimerCours($this->id);
}
}



?>