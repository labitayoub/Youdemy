<?php
session_start();

if (!isset($_SESSION['users'])) {
    header('Location: ../../../../auth/Login.php');
    exit();
}
require_once("../../../../vendor/autoload.php");

use App\Config\Database;
use App\Controllers\CategorieController;

$db = new Database();
$conn = $db->connect();

$categorieController = new CategorieController();

$categories = $conn->query("SELECT * FROM Categorie")->fetchAll(PDO::FETCH_ASSOC);

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_category'])) {
    $categoryName = $_POST['category_name'];
    $categorieController->createCategory($categoryName);
    header("Location: categories.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['edit_category'])) {
    $categoryId = $_POST['category_id'];
    $newCategoryName = $_POST['new_category_name'];
    $categorieController->updateCategory($categoryId, $newCategoryName);
    header("Location: categories.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete_category'])) {
    $categoryId = $_POST['category_id'];
    $categorieController->deleteCategory($categoryId);
    header("Location: categories.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>YouDemy Admin Dashboard</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        /* Navbar */
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

        /* Sidebar */
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

        /* Contenu principal */
        .main-content {
            margin-top: 64px;
            margin-left: 256px;
            padding: 1rem;
        }
    </style>
</head>
<body class="bg-gray-100">
    <!-- Navbar -->
    <header class="navbar">
        <div class="max-w-full mx-auto px-4 py-3 flex justify-between items-center">
            <!-- Logo -->
            <a href="../../Views/index.php" class="text-2xl font-bold text-blue-600">Youdemy</a>

            <!-- Liens de navigation -->
            <nav class="hidden md:flex items-center gap-6">
                <a href="../../index.php" class="hover:text-blue-600">Accueil</a>
                <a href="#about" class="hover:text-blue-600">À propos</a>
                <a href="#courses" class="hover:text-blue-600">Cours</a>
                <a href="#admin" class="hover:text-blue-600">
                    <i class="fas fa-user-circle"></i>
                    <span class="ml-2">Admin</span>
                </a>
                <a href="../../auth/logout.php" class="bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded">
                    Déconnexion
                </a>
            </nav>

            <!-- Menu mobile (optionnel) -->
            <label for="mobile-menu" class="md:hidden cursor-pointer">
                <i class="fas fa-bars text-2xl"></i>
            </label>
        </div>
    </header>

    <!-- Sidebar -->
    <aside class="sidebar">
        <nav class="mt-5 px-2">
            <a href="dashboard.php" class="group flex items-center px-4 py-3 text-gray-300 hover:bg-gray-700 rounded-md">
                <i class="fas fa-home mr-3"></i> Tableau de bord
            </a>
            <a href="Enseignant.php" class="group flex items-center px-4 py-3 text-gray-300 hover:bg-gray-700 rounded-md">
                <i class="fas fa-chalkboard-teacher mr-3"></i> Enseignants
            </a>
            <a href="Etudiant.php" class="group flex items-center px-4 py-3 text-gray-300 hover:bg-gray-700 rounded-md">
                <i class="fas fa-user-graduate mr-3"></i> Étudiants
            </a>
            <a href="categories.php" class="group flex items-center px-4 py-3 text-gray-300 hover:bg-gray-700 rounded-md">
                <i class="fas fa-folder mr-3"></i> Catégories
            </a>
            <a href="tags.php" class="group flex items-center px-4 py-3 text-gray-300 hover:bg-gray-700 rounded-md">
                <i class="fas fa-tags mr-3"></i> Tags
            </a>
            <a href="supprimer.php" class="group flex items-center px-4 py-3 text-gray-300 hover:bg-gray-700 rounded-md">
                <i class="fas fa-trash mr-3"></i> Supprimer
            </a>
        </nav>
    </aside>

    <!-- Contenu principal -->
    <div class="main-content">
        <h1 class="text-2xl font-bold mb-4">Gestion des Catégories</h1>

        <!-- Formulaire d'ajout de catégorie -->
        <form method="POST" class="mb-8">
            <div class="flex gap-4">
                <input type="text" name="category_name" placeholder="Nom de la catégorie" class="p-2 border rounded" required>
                <button type="submit" name="add_category" class="bg-blue-600 text-white px-4 py-2 rounded">Ajouter</button>
            </div>
        </form>

        <!-- Tableau des catégories -->
        <table class="w-full bg-white shadow rounded">
            <thead>
                <tr class="border-b">
                    <th class="p-4 text-left">ID</th>
                    <th class="p-4 text-left">Nom</th>
                    <th class="p-4 text-left">Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($categories as $categorie): ?>
                    <tr class="border-b">
                        <td class="p-4"><?php echo htmlspecialchars($categorie['id']); ?></td>
                        <td class="p-4"><?php echo htmlspecialchars($categorie['nom']); ?></td>
                        <td class="p-4 flex gap-2">
                            <!-- Formulaire de modification de catégorie -->
                            <form method="POST" class="flex gap-2">
                                <input type="hidden" name="category_id" value="<?php echo $categorie['id']; ?>">
                                <input type="text" name="new_category_name" placeholder="Nouveau nom" class="p-2 border rounded" required>
                                <button type="submit" name="edit_category" class="bg-yellow-600 text-white px-4 py-2 rounded">Modifier</button>
                            </form>
                            <!-- Formulaire de suppression de catégorie -->
                            <form method="POST" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer cette catégorie ?');">
                                <input type="hidden" name="category_id" value="<?php echo $categorie['id']; ?>">
                                <button type="submit" name="delete_category" class="bg-red-600 text-white px-4 py-2 rounded">Supprimer</button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</body>
</html>