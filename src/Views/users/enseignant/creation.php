<?php
session_start();

if (!isset($_SESSION['users'])) {
    header('Location: ../../../../auth/Login.php');
    exit();
}

require_once("../../../../vendor/autoload.php");
use App\Classes;
use App\Controllers\AuthController;
use App\Config;
use App\Config\Database;
use App\Controllers\CoursController;

$db = new Database();
$conn = $db->connect();

$categories = $conn->query("SELECT id, nom FROM categorie ORDER BY nom")->fetchAll(PDO::FETCH_ASSOC);
$tags = $conn->query("SELECT id, nom FROM tag ORDER BY nom")->fetchAll(PDO::FETCH_ASSOC);

if (isset($_POST['submit'])) {
    $titre = $_POST['titre'];
    $description = $_POST['description'];
    $contenu = isset($_POST['contenu_course']) ? $_POST['contenu_course'] : null;
    $user_id = $_SESSION['users']['id'];
    $categorie_id = $_POST['categorie_id'];
    $selectedTags = isset($_POST['tags']) ? $_POST['tags'] : [];

    $coursController = new CoursController();
    $result = $coursController->AjouteCours($titre, $description, $contenu, $categorie_id, $user_id, $selectedTags);
    if ($result) {
        header('location:gestion.php');
        exit();
    } else {
        echo "Erreur lors de l'ajout du cours.";
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>YouDemy Admin - Création de cours</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        .tag-container {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(150px, 1fr));
            gap: 0.5rem;
            margin-top: 0.5rem;
        }
        .tag-checkbox {
            display: flex;
            align-items: center;
            padding: 0.5rem;
            border: 1px solid #e2e8f0;
            border-radius: 0.375rem;
            cursor: pointer;
            transition: all 0.2s;
        }
        .tag-checkbox:hover {
            background-color: #f3f4f6;
        }
        .tag-checkbox input[type="checkbox"] {
            margin-right: 0.5rem;
        }
        .tag-label {
            font-size: 0.875rem;
            color: #4b5563;
        }
        .navbar {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            z-index: 1000;
            height: 64px;
            background-color: white;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }
        .sidebar {
            position: fixed;
            top: 64px;
            left: 0;
            bottom: 0;
            width: 256px;
            z-index: 999;
            background-color: #1f2937;
            color: white;
        }
        .main-content {
            margin-top: 64px;
            margin-left: 256px;
            padding: 1rem;
        }
    </style>
</head>
<body class="bg-gray-100">
    <header class="navbar">
        <div class="max-w-full mx-auto px-4 py-3 flex justify-between items-center">
            <a href="../../Views/index.php" class="text-2xl font-bold text-blue-600">Youdemy</a>
            <nav class="hidden md:flex items-center gap-6">
                <a href="../../index.php" class="hover:text-blue-600">Accueil</a>
                <a href="../../index.php" class="hover:text-blue-600">À propos</a>
                <a href="../../cours.php" class="hover:text-blue-600">Cours</a>
                <a href="#admin" class="hover:text-blue-600">
                    <i class="fas fa-user-circle"></i>
                    <span class="ml-2">Admin</span>
                </a>
                <a href="../../auth/logout.php" class="bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded">
                    Déconnexion
                </a>
            </nav>
            <label for="mobile-menu" class="md:hidden cursor-pointer">
                <i class="fas fa-bars text-2xl"></i>
            </label>
        </div>
    </header>
    <aside class="sidebar">
    <nav class="mt-5 px-2">
            <a href="dashboard.php" class="group flex items-center px-4 py-3 text-gray-300 hover:bg-gray-700 rounded-md">
                <i class="fas fa-home mr-3"></i> Tableau de bord
            </a>
            <a href="creation.php" class="group flex items-center px-4 py-3 text-gray-300 hover:bg-gray-700 rounded-md">
                <i class="fas fa-chalkboard-teacher mr-3"></i> Creation
            </a>
            <a href="Gestion.php" class="group flex items-center px-4 py-3 text-gray-300 hover:bg-gray-700 rounded-md">
                <i class="fas fa-user-graduate mr-3"></i> Gestion
            </a>
            
        </nav>
    </aside>
    <div class="main-content">
        <div class="container mx-auto px-4">
            <div class="flex justify-center">
                <div class="w-full max-w-2xl">
                    <div class="bg-white rounded-lg shadow-2xl">
                        <div class="bg-blue-600 text-center p-8 rounded-t-lg">
                            <div class="text-white text-2xl font-bold mb-2">
                                <i class="fas fa-book-open me-2"></i>Youdemy
                            </div>
                            <h4 class="text-white font-bold text-xl">Créer un cours</h4>
                        </div>

                        <div class="p-8">
                            <form method="POST" class="space-y-6">
                                <div>
                                    <label class="block text-blue-600 font-medium mb-2">Titre du cours</label>
                                    <input type="text" name="titre" 
                                        class="w-full p-2.5 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none" 
                                        placeholder="Titre du cours" required>
                                </div>

                                <div>
                                    <label class="block text-blue-600 font-medium mb-2">Description</label>
                                    <textarea name="description" 
                                        class="w-full p-2.5 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none" 
                                        placeholder="Description du cours" 
                                        rows="4" required></textarea>
                                </div>

                                <div>
                                    <label class="block text-blue-600 font-medium mb-2">URL de la vidéo du cours</label>
                                    <input type="url" name="contenu_course" 
                                        class="w-full p-2.5 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none" 
                                        placeholder="Entrer le lien url (Youtube)" 
                                        required>
                                </div>

                                <div>
                                    <label class="block text-blue-600 font-medium mb-2">Catégorie</label>
                                    <select name="categorie_id"
                                        class="w-full p-2.5 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none" 
                                        required>
                                        <option value="">Choisir la catégorie</option>
                                        <?php foreach ($categories as $categorie): ?>
                                            <option value="<?= htmlspecialchars($categorie['id']) ?>">
                                                <?= htmlspecialchars($categorie['nom']) ?>
                                            </option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>

                                <div>
                                    <label class="block text-blue-600 font-medium mb-2">Tags</label>
                                    <div class="tag-container">
                                        <?php foreach ($tags as $tag): ?>
                                            <label class="tag-checkbox">
                                                <input type="checkbox" name="tags[]" value="<?= htmlspecialchars($tag['id']) ?>">
                                                <span class="tag-label"><?= htmlspecialchars($tag['nom']) ?></span>
                                            </label>
                                        <?php endforeach; ?>
                                    </div>
                                </div>

                                <button type="submit" name="submit"
                                    class="w-full bg-blue-600 text-white py-2.5 rounded-md transition duration-300 hover:bg-blue-700">
                                    Créer le cours
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>