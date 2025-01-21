<?php
session_start(); // Démarrez la session

require_once("../../../vendor/autoload.php");

use App\Controllers\AuthController;

$authController = new AuthController();
$authController->logout();
?>