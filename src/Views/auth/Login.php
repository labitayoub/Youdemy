<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Form</title>
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
            <a href="../auth/Login.php" class="border border-blue-600 text-blue-600 px-4 py-2 rounded">Login</a>
            <a href="../auth/Register.php" class="bg-blue-600 text-white px-4 py-2 rounded">Sign Up</a>
        </nav>
        <button class="md:hidden">☰</button>
    </div>
</header>

<?php
require_once "../../../vendor/autoload.php";
use App\Controllers\AuthController;

if(isset($_POST["submit"])) {
    if(empty($_POST["email"]) || empty($_POST["password"])) {
        echo "<div class='message bg-red-500 text-white p-4 rounded-md text-center font-bold ' style='z-index: 1; position: absolute; top:0; left: 38%; width: auto; '>
                L'email ou le mot de passe est vide
              </div>";

    } else {
        $email = $_POST["email"];
        $password = $_POST["password"];
        
        $authController = new AuthController();
        $authController->Login($email, $password);
    }
}
?>
<div class="bg-gradient-custom min-h-screen py-20">
<div class="container mx-auto px-4">
    <div class="flex justify-center">
        <div class="w-full max-w-md">
            <div class="bg-white rounded-lg shadow-2xl">
                <div class="bg-custom-light text-center p-8 rounded-t-lg">
                    <h2 class="text-white font-bold text-2xl">Bienvenue</h2>
                    <p class="text-gray-100">Veuillez vous connecter à votre compte</p>
                </div>

                <div class="p-8">
                    <form method="POST">
                        <div class="mb-6">
                            <label class="block text-blue-600 mb-2">Email Address</label>
                            <div class="flex">
                                <span class="inline-flex items-center px-3 bg-gray-50 border border-r-0 border-gray-300 rounded-l-md">
                                    <i class="fas fa-envelope text-gray-500"></i>
                                </span>
                                <input type="email" name="email" 
                                    class="flex-1 p-2.5 border border-gray-300 rounded-r-md focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none" 
                                    placeholder="email">
                            </div>
                        </div>

                        <div class="mb-6">
                            <label class="block text-blue-600 mb-2">Mot de passe</label>
                            <div class="flex">
                                <span class="inline-flex items-center px-3 bg-gray-50 border border-r-0 border-gray-300 rounded-l-md">
                                    <i class="fas fa-lock text-gray-500"></i>
                                </span>
                                <input type="password" name="password" 
                                    class="flex-1 p-2.5 border border-gray-300 rounded-r-md focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none" 
                                    placeholder="********" >
                            </div>
                        </div>

                        <button type="submit" name="submit" 
                            class="btn-gradient-custom text-white w-full py-2.5 rounded-md mb-6 transition duration-300 hover:opacity-90">
                            Connexion
                        </button>
                    </form>

                    <div class="text-center">
                        <p class="text-gray-600">Ne pas avoir de compte? 
                            <a href="Register.php" class="text-blue-600 hover:text-blue-800 transition duration-300">
                                S'inscrire ici
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