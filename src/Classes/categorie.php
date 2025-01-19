<?php 

namespace App\Classes;

    class Categorie {
        private $id;
        private $nom;

    public function __construct($id,$nom){
        $this->id = $id;
        $this->nom = $nom;
    }
    

    public function getId(){
        return $this->id;
    }

    public function getCategorie(){
        return $this->nom;
    }

    public function setCategorie($nom){
        $this->nom = $nom;
    }

}