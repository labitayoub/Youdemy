<?php 

namespace App\Classes;

    class Enseignant extends Users {

        public function __construct($id,$nom,$prenom,$email,$password,$role){
            parent::__construct($id,$nom,$prenom,$email,$password,$role);
        }

    }