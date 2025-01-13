<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Form</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.2/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <style>
        .bg-custom {
            background: linear-gradient(to bottom right, #0A2647, #144272);
        }
        .bg-custom-light {
            background-color: #2C74B3;
        }
        .btn-custom {
            background: linear-gradient(to right, #144272, #0A2647);
        }
    </style>
</head>
<body class="bg-custom min-vh-100 py-5">

<?php

require_once "../../../vendor/autoload.php";

use App\Controllers\AuthController;


if(isset($_POST["submit"]))
{

    if(empty($_POST["email"]) && empty($_POST["password"]))
    {
        echo "l'email ou le mot de passe est vide";
    }
    else{
        $email = $_POST["email"];
        $password = $_POST["password"];

        $authController = new AuthController();
        $authController->Login($email, $password);

    }
}
?>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card shadow-lg">
                    <div class="bg-custom-light text-center p-4 rounded-top">
                        <h2 class="text-white fw-bold fs-2">Bienvenue</h2>
                        <p class="text-white-50">Veuillez vous connecter à votre compte</p>
                    </div>

                    <div class="card-body p-4">
                        <form method="POST">
                            <div class="mb-3">
                                <label class="form-label text-primary">Email Address</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fas fa-envelope"></i></span>
                                    <input type="email" name="email" class="form-control" placeholder="email" required>
                                </div>
                            </div>

                            <div class="mb-3">
                                <label class="form-label text-primary">Mot de pass</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fas fa-lock"></i></span>
                                    <input type="password" name="password" class="form-control" placeholder="••••••••" required>
                                </div>
                            </div>

                            <button type="submit" name="submit" class="btn btn-custom text-white w-100 mb-3">Connexion</button>
                        </form>

                        <div class="text-center mb-3">
                            <p class="text-muted">Ne pas avoir de compte? 
                                <a href="Register.php" class="text-primary">S'inscrire ici</a>
                            </p>
                        </div>



                     
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.2/js/bootstrap.bundle.min.js"></script>
</body>
</html>