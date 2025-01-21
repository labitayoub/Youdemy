<?php 

namespace App\Classes;

    class Etudiant extends Users {

        public function __construct($id,$nom,$prenom,$email,$password,$role){
            parent::__construct($id,$nom,$prenom,$email,$password,$role);
        }

    }