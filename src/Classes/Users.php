<?php
namespace App\Classes;


class Users {
    protected $id;
    protected $nom;
    protected $prenom;
    protected $email;
    protected $password;
    protected $role;
    protected $compte_statut;

    public function __construct($id, $nom, $prenom, $email, $password, $role, $compte_statut) {
        $this->id = $id;
        $this->nom = $nom;
        $this->prenom = $prenom;
        $this->email = $email;
        $this->password = $password;
        $this->role = $role;
        $this->compte_statut = $compte_statut;
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

    public function getPassword() {
        return $this->password;
    }

    public function setPassword($password) {
        $this->password = $password;
    }

    public function getRole() {
        return $this->role;
    }

    public function setRole($role) {
        $this->role = $role;
    }
    public function getcompte_statut() {
        return $this->compte_statut;
    }

    public function setcompte_statut($compte_statut) {
        $this->role = $compte_statut;
    }
}