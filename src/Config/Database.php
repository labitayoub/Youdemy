<?php
namespace App\Config;


use PDO;
use PDOException;

class Database{
    private $host="localhost";
    private $dbname="Youdemy";
    private $user="root";
    private $password="";
    private $connexion;


    public function connect()
    {
 
        try {
            $this->connexion = new PDO("mysql:host=$this->host;dbname=$this->dbname",$this->user,$this->password );            
            return $this->connexion;
        } catch (PDOException $th) {
            die("connexion faild".$th->getMessage());
        }
    }
}