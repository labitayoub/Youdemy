<?php 

namespace App\Classes;

    class Admin extends Users {

        public function __construct($id,$nom,$prenom,$email,$password,$role){
            parent::__construct($id,$nom,$prenom,$email,$password,$role);
        }

    }