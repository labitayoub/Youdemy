<?php
session_start();

if (!isset($_SESSION['users'])) {
    header('Location: ../../../../auth/Login.php');
    exit();
}
require_once("../../../../vendor/autoload.php");

use App\Config\Database;
use App\Controllers\TagController;

$db = new Database();
$conn = $db->connect();

$tagController = new TagController();

$tags = $conn->query("SELECT * FROM Tag")->fetchAll(PDO::FETCH_ASSOC);

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_tags'])) {
    $tagsInput = $_POST['tags'];
    $tagsArray = explode(',', $tagsInput);

    foreach ($tagsArray as $tagName) {
        $tagName = trim($tagName);
        if (!empty($tagName)) {
            $tagController->createTag($tagName);
        }
    }

    header("Location: tags.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete_tag'])) {
    $tagId = $_POST['tag_id'];
    $tagController->deleteTag($tagId);
    header("Location: tags.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>YouDemy Admin Dashboard - Gestion des Tags</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
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

        .main-content {
            margin-top: 64px;
            margin-left: 256px;
            padding: 1rem;
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
        <h1 class="text-2xl font-bold mb-4">Gestion des Tags</h1>

        <form method="POST" class="mb-8">
            <div class="flex flex-col gap-4">
                <label for="tags" class="text-gray-700">Ajouter des tags (séparés par des virgules) :</label>
                <textarea name="tags" id="tags" placeholder="Ex: PHP, JavaScript, HTML" class="p-2 border rounded" required></textarea>
                <button type="submit" name="add_tags" class="bg-blue-600 text-white px-4 py-2 rounded w-fit">
                    Ajouter les tags
                </button>
            </div>
        </form>

        <table class="w-full bg-white shadow rounded">
            <thead>
                <tr class="border-b">
                    <th class="p-4 text-left">ID</th>
                    <th class="p-4 text-left">Nom</th>
                    <th class="p-4 text-left">Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($tags as $tag): ?>
                    <tr class="border-b">
                        <td class="p-4"><?php echo htmlspecialchars($tag['id']); ?></td>
                        <td class="p-4"><?php echo htmlspecialchars($tag['nom']); ?></td>
                        <td class="p-4">
                            <!-- Formulaire de suppression de tag -->
                            <form method="POST" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer ce tag ?');">
                                <input type="hidden" name="tag_id" value="<?php echo $tag['id']; ?>">
                                <button type="submit" name="delete_tag" class="bg-red-600 text-white px-4 py-2 rounded">
                                    Supprimer
                                </button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</body>
</html>