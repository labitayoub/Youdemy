<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CareerLink - Inscription</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(135deg, #2C3E50 0%, #3498DB 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            padding: 40px 0;
        }

        .register-card {
            background: white;
            padding: 40px;
            border-radius: 10px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
            max-width: 500px;
            width: 90%;
            margin: auto;
        }

        .register-card .logo {
            font-size: 24px;
            color: #2C3E50;
            text-align: center;
            margin-bottom: 30px;
        }

        .form-control {
            padding: 12px;
            margin-bottom: 20px;
        }

        .btn-primary {
            background: #3498DB;
            border: none;
            padding: 12px;
            width: 100%;
        }

        .user-type-selector {
            display: flex;
            justify-content: center;
            gap: 20px;
            margin-bottom: 30px;
        }

        .user-type-btn {
            padding: 15px 30px;
            border: 2px solid #3498DB;
            border-radius: 5px;
            cursor: pointer;
            transition: all 0.3s;
        }

        .user-type-btn.active {
            background: #3498DB;
            color: white;
        }

        .upload-resume {
            border: 2px dashed #3498DB;
            padding: 20px;
            text-align: center;
            border-radius: 5px;
            margin-bottom: 20px;
            cursor: pointer;
        }
    </style>
</head>

<body>

    <?php
require_once "../../../vendor/autoload.php";

use App\Classes;
use App\Controllers\AuthController;

use App\Config;


    if (isset($_POST['submit'])) {

        $nom = ($_POST['nom']);
        $prenom = ($_POST['prenom']);
        $email = ($_POST['email']);
        $pass = ($_POST['pass']);
        $rolee = ($_POST['rolee']);

        if (!empty($nom)&&!empty($prenom)&&!empty($email)&&!empty($pass)&&!empty($rolee)) {
            
            $authController = new AuthController();
            $authController->register($nom,$prenom,$email, $pass,$rolee);

            header('location:login.php');
        }
      

    }
    ?>
    <div class="container">
        <div class="register-card">
            <div class="logo">
                <i class="fas fa-briefcase me-2"></i>Youdemy
            </div>
            <h4 class="text-center mb-4">Créer un compte</h4>

            <form id="registerForm" method="POST">
                <div class="row">
                    <div class="col-md-6">
                        <input type="text" class="form-control" placeholder="Prénom" name="prenom">
                    </div>
                    <div class="col-md-6">
                        <input type="text" class="form-control" placeholder="Nom" name="nom">
                    </div>
                </div>

                <input type="email" class="form-control" placeholder="Email" name="email">
                <input type="password" class="form-control" placeholder="Mot de passe" name="pass">
                <div class="mb-4">
                    <div class="mb-3">
                        <label for="role" class="form-label fw-bold">Rôle</label>
                        <select name="rolee" id="rolee" class="form-select" required>
                            <option value="" selected>Choisir un rôle</option>
                            <option value="Etudiant">Étudiant</option>
                            <option value="Enseignant">Enseignant</option>
                        </select>
                    </div>

                    <div class="mb-3 form-check">
                        <input type="checkbox" class="form-check-input" id="terms" required>
                        <label class="form-check-label" for="terms">
                            J'accepte les conditions d'utilisation et la politique de confidentialité
                        </label>
                    </div>

                    <button type="submit" name="submit" class="btn btn-primary">Créer mon compte</button>
            </form>

            <div class="text-center mt-4">
                <p>Déjà inscrit ? <a href="Login.php">Connectez-vous</a></p>
            </div>
        </div>
    </div>

   
</body>

</html>