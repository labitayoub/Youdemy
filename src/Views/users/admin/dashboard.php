<?php
session_start();

if (!isset($_SESSION['users'])) {
    header('Location: ../../../../auth/Login.php');
    exit();
}

require_once("../../../../vendor/autoload.php");

use App\Config\Database;

$db = new Database();
$conn = $db->connect();

$totalEtudiants = $conn->query("SELECT COUNT(*) FROM users WHERE role = 'Etudiant'")->fetchColumn();
$totalEnseignants = $conn->query("SELECT COUNT(*) FROM users WHERE role = 'Enseignant'")->fetchColumn();
$totalCours = $conn->query("SELECT COUNT(*) FROM cours")->fetchColumn();

$cours = $conn->query("
    SELECT cours.id, cours.titre, cours.contenu, cours.description, 
           categorie.nom AS categorie, 
           GROUP_CONCAT(tag.nom SEPARATOR ', ') AS tags, 
           CONCAT(users.nom, ' ', users.prenom) AS enseignant
    FROM cours
    JOIN categorie ON cours.categorie_id = categorie.id
    LEFT JOIN coursTag ON cours.id = coursTag.cours_id
    LEFT JOIN tag ON coursTag.tag_id = tag.id
    JOIN users ON cours.user_id = users.id
    GROUP BY cours.id
")->fetchAll(PDO::FETCH_ASSOC);
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

    <div class="main-content">
        <h2 class="text-2xl font-bold mb-6 mt-11">Statistiques Globales</h2>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
            <div class="bg-white rounded-lg shadow p-6">
                <div class="flex items-center">
                    <div class="p-3 rounded-full bg-blue-100 text-blue-500">
                        <i class="fas fa-users text-2xl"></i>
                    </div>
                    <div class="ml-3">
                        <h4 class="text-gray-500 text-sm">Étudiants</h4>
                        <h3 class="text-2xl font-bold"><?php echo $totalEtudiants; ?></h3>
                    </div>
                </div>
            </div>
            <div class="bg-white rounded-lg shadow p-6">
                <div class="flex items-center">
                    <div class="p-3 rounded-full bg-green-100 text-green-500">
                        <i class="fas fa-chalkboard-teacher text-2xl"></i>
                    </div>
                    <div class="ml-3">
                        <h4 class="text-gray-500 text-sm">Enseignants</h4>
                        <h3 class="text-2xl font-bold"><?php echo $totalEnseignants; ?></h3>
                    </div>
                </div>
            </div>
            <div class="bg-white rounded-lg shadow p-6">
                <div class="flex items-center">
                    <div class="p-3 rounded-full bg-yellow-100 text-yellow-500">
                        <i class="fas fa-book text-2xl"></i>
                    </div>
                    <div class="ml-3">
                        <h4 class="text-gray-500 text-sm">Cours</h4>
                        <h3 class="text-2xl font-bold"><?php echo $totalCours; ?></h3>
                    </div>
                </div>
            </div>
        </div>

        <h2 class="text-2xl font-semibold mb-6">Liste des Cours</h2>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            <?php if (!empty($cours)): ?>
                <?php foreach ($cours as $cour): ?>
                    <div class="bg-white rounded-lg shadow-md flex flex-col">
                        <div class="relative w-full h-48">
                            <?php if (!empty($cour['contenu'])): ?>
                                <iframe src="<?php echo htmlspecialchars($cour['contenu']); ?>" frameborder="0" allowfullscreen class="w-full h-full"></iframe>
                            <?php else: ?>
                                <div class="w-full h-full flex items-center justify-center bg-gray-300 text-gray-500">Pas de vidéo</div>
                            <?php endif; ?>
                        </div>
                        <div class="p-4 flex-1">
                            <h3 class="text-lg font-semibold"><?php echo htmlspecialchars($cour['titre']); ?></h3>
                            <p class="text-sm text-gray-500"><?php echo htmlspecialchars($cour['enseignant']); ?> | Catégorie: <?php echo htmlspecialchars($cour['categorie']); ?></p>
                            <p class="text-gray-600 mt-2 line-clamp-3"><?php echo htmlspecialchars($cour['description']); ?></p>
                        </div>
                        <div class="px-4 pb-4">
                            <p class="text-sm text-gray-500">Tags: <?php echo htmlspecialchars($cour['tags']); ?></p>
                        </div>
                        <div class="px-4 py-4 bg-gray-50">
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <p class="text-gray-500 text-center col-span-3">Aucun cours disponible.</p>
            <?php endif; ?>
        </div>
    </div>
</body>
</html>