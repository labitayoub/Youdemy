<?php
session_start();

if (!isset($_SESSION['users'])) {
    header('Location: ../../../../auth/Login.php');
    exit();
}

require_once("../../../../vendor/autoload.php");
use App\Controllers\CoursController;

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $user_id = $_SESSION['users']['id'];
    
    $coursController = new CoursController();
    $cour = $coursController->getCoursById($id);
    if ($user_id) {
        $result = $coursController->supprimerCours($id);
        if ($result) {
            header('Location: ../../../views/users/enseignant/gestion.php');
            exit();
        } else {
            echo "Erreur lors de la suppression du cours.";
        }
    } else {
        echo "Vous n'êtes pas autorisé à supprimer ce cours.";
    }
}
?>