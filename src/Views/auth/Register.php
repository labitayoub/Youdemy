<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Youdemy - Inscription</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <style>
        .bg-gradient-custom {
            background: linear-gradient(to bottom right, #1e3a8a, #2563eb);
        }
        .bg-custom-light {
            background-color: #3b82f6;
        }
        .btn-gradient-custom {
            background: linear-gradient(to right, #2563eb, #1e3a8a);
        }
    </style>
</head>

<body>
<header class="fixed w-full bg-white shadow">
    <div class="max-w-5xl mx-auto p-4 flex justify-between items-center">
        <a href="../../Views/index.php" class="text-2xl font-bold text-blue-600">Youdemy</a>
        <nav class="hidden md:flex gap-4">
            <a href="../../Views/index.php" class="hover:text-blue-600 mt-2">Accueil</a>
            <a href="#about" class="hover:text-blue-600 mt-2">A propos de</a>
            <a href="#courses" class="hover:text-blue-600 mt-2">Cours</a>
            <a href="../Views/auth/Login.php" class="rounded-full overflow-hidden w-10 h-10">
            <img src="../../../Image/icon.webp" alt="Login" class="w-full h-full object-cover">
            </a></nav>
        <button class="md:hidden">☰</button>
    </div>
</header>

<?php
require_once "../../../vendor/autoload.php";
use App\Classes;
use App\Controllers\AuthController;
use App\Config;

if (isset($_POST['submit'])) {
    $nom = ($_POST['nom']);
    $prenom = ($_POST['prenom']);
    $email = ($_POST['email']);
    $password = ($_POST['password']);
    $role = ($_POST['role']);

    if (!empty($nom) && !empty($prenom) && !empty($email) && !empty($password) && !empty($role)) {
        $authController = new AuthController();
        $authController->Register($nom, $prenom, $email, $password, $role);
        header('location:login.php');
    } else {
       echo "<div class='message bg-red-500 text-white p-4 rounded-md text-center font-bold ' style='z-index: 1; position: absolute; top:0; left: 38%; width: auto; '>
                Veuillez remplir tous les champs
              </div>";
    }
}
?>
<div class="bg-gradient-custom min-h-screen py-20">
<div class="container mx-auto px-4">
    <div class="flex justify-center">
        <div class="w-full max-w-2xl">
            <div class="bg-white rounded-lg shadow-2xl">
                <div class="bg-custom-light text-center p-8 rounded-t-lg">
                    <div class="text-white text-2xl font-bold mb-2">
                        <i class="fas fa-briefcase me-2"></i>Youdemy
                    </div>
                    <h4 class="text-white font-bold text-xl">Créer un compte</h4>
                </div>

                <div class="p-8">
                    <form method="POST" class="space-y-6">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <input type="text" name="prenom" 
                                    class="w-full p-2.5 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none" 
                                    placeholder="Prénom" >
                            </div>
                            <div>
                                <input type="text" name="nom" 
                                    class="w-full p-2.5 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none" 
                                    placeholder="Nom" >
                            </div>
                        </div>

                        <input type="email" name="email" 
                            class="w-full p-2.5 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none" 
                            placeholder="Email" >

                        <input type="password" name="password" 
                            class="w-full p-2.5 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none" 
                            placeholder="Mot de passe" >

                        <div>
                            <label class="block text-blue-600 font-medium mb-2">Rôle</label>
                            <select name="role" 
                                class="w-full p-2.5 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none" 
                                >
                                <option value="" selected>Choisir un rôle</option>
                                <option value="Etudiant">Étudiant</option>
                                <option value="Enseignant">Enseignant</option>
                            </select>
                        </div>

                        <div class="flex items-center">
                            <input type="checkbox" id="terms" 
                                class="w-4 h-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500">
                            <label for="terms" class="ml-2 text-gray-600">
                                J'accepte les conditions d'utilisation et la politique de confidentialité
                            </label>
                        </div>

                        <button type="submit" name="submit" 
                            class="btn-gradient-custom text-white w-full py-2.5 rounded-md transition duration-300 hover:opacity-90">
                            Créer mon compte
                        </button>
                    </form>

                    <div class="text-center mt-6">
                        <p class="text-gray-600">Déjà inscrit ? 
                            <a href="Login.php" class="text-blue-600 hover:text-blue-800 transition duration-300">
                                Connectez-vous
                            </a>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</div>
<script>
document.addEventListener('DOMContentLoaded', ()=>{
    var messages = document.getElementsByClassName('message');

    setTimeout(function() {
        for (var i = 0; i < messages.length; i++) {
            messages[i].style.display = 'none';
        }
    }, 4000);
})
</script>
</body>
</html>