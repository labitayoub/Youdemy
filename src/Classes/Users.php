<?php
namespace App\Classes;


class Users {
    private $id;
    private $nom;
    private $prenom;
    private $email;
    private $password;
    private $role;

    public function __construct($id, $nom, $prenom, $email, $password, $role) {
        $this->id = $id;
        $this->nom = $nom;
        $this->prenom = $prenom;
        $this->email = $email;
        $this->password = $password;
        $this->role = $role;
    }

    public function getId() {
        return $this->id;
    }

    public function getNom() {
        return $this->nom;
    }

    public function setNom($nom) {
        $this->nom = $nom;
    }

    public function getPrenom() {
        return $this->prenom;
    }

    public function setPrenom($prenom) {
        $this->prenom = $prenom;
    }

    public function getEmail() {
        return $this->email;
    }

    public function setEmail($email) {
        $this->email = $email;
    }

    public function getPass() {
        return $this->password;
    }

    public function setPass($password) {
        $this->password = $password;
    }

    public function getRolee() {
        return $this->role;
    }

    public function setRolee($role) {
        $this->role = $role;
    }
}