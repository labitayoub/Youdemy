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
$cours = $conn->query(" SELECT cours.id,cours.titre, cours.description, categorie.nom AS categorie, 
        GROUP_CONCAT(tag.nom SEPARATOR ', ') AS tags, 
        CONCAT(users.nom, ' ', users.prenom) AS enseignant
    FROM cours
    JOIN categorie ON cours.categorie_id = categorie.id
    JOIN coursTag ON cours.id = coursTag.cours_id
    JOIN tag ON coursTag.tag_id = tag.id
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
</head>
<body class="bg-gray-100">

<header class="fixed w-full bg-white shadow">
    <div class="max-w-5xl mx-auto p-4 flex justify-between items-center">
        <a href="../../Views/index.php" class="text-2xl font-bold text-blue-600">Youdemy</a>
        <nav class="hidden md:flex gap-4">
            <a href="../../index.php" class="hover:text-blue-600">Accueil</a>
            <a href="#about" class="hover:text-blue-600">A propos de</a>
            <a href="#courses" class="hover:text-blue-600 mr-5">Cours</a>
            <a href="#courses" class="hover:text-blue-600 ml-5"><i class="fas fa-user-circle text-xl mr-1"></i>
            Admin</a>

            <a href="../Views/auth/Logout.php" class="bg-red-600 text-white px-4 py-2 rounded">Logout</a>
            </nav>
        <button class="md:hidden">☰</button>
    </div>
</header>

    <div class="fixed inset-y-0 left-0 w-64 bg-gray-900 text-white transform transition-transform duration-200 ease-in-out z-40">
        <div class="flex items-center justify-center h-16 bg-gray-800">
            <h1 class="text-xl font-bold">Tableau de bord</h1>
        </div>
        <nav class="mt-5 px-2">
            <a href="dashboard.php" class="group flex items-center px-4 py-3 text-gray-300 hover:bg-gray-700 hover:text-white rounded-md transition-colors duration-200">
                <i class="fas fa-home mr-3"></i>
                Statistiques Globales
            </a>
            <a href="Enseignant.php" class="group flex items-center px-4 py-3 text-gray-300 hover:bg-gray-700 hover:text-white rounded-md transition-colors duration-200">
                <i class="fas fa-users mr-3"></i>
                Enseignants
            </a>
            <a href="Etudiant.php" class="group flex items-center px-4 py-3 text-gray-300 hover:bg-gray-700 hover:text-white rounded-md transition-colors duration-200">
                <i class="fas fa-users mr-3"></i>
                Etudiants
            </a>
            <a href="categories.php" class="group flex items-center px-4 py-3 text-gray-300 hover:bg-gray-700 hover:text-white rounded-md transition-colors duration-200">
                <i class="fas fa-users mr-3"></i>
                Catégories
            </a>
            <a href="tags.php" class="group flex items-center px-4 py-3 text-gray-300 hover:bg-gray-700 hover:text-white rounded-md transition-colors duration-200">
                <i class="fas fa-users mr-3"></i>
                Tags
            </a>
        </nav>
    </div>

    <div class="ml-64 p-8">

        <h2 class="text-2xl font-bold mb-6 mt-11">Statistique Globale</h2>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-2 gap-6 mb-8">
            <div class="bg-white rounded-lg shadow p-6">
                <div class="flex items-center">
                    <div class="p-3 rounded-full bg-blue-100 text-blue-500">
                        <i class="fas fa-users text-2xl"></i>
                    </div>
                    <div class="ml-3">
                        <h4 class="text-gray-500 text-sm"> Total des Etudiants</h4>
                        <h3 class="text-2xl font-bold"><?php echo $totalEtudiants ?></h3>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-lg shadow p-6">
                <div class="flex items-center">
                    <div class="p-3 rounded-full bg-yellow-100 text-yellow-500">
                        <i class="fas fa-book text-2xl"></i>
                    </div>
                    <div class="ml-3">
                        <h4 class="text-gray-500 text-sm">Total des Cours </h4>
                        <h3 class="text-2xl font-bold"><?php echo $totalCours ?></h3>
                    </div>
                </div>
            </div>
      
        </div>
                </div>
            </div>
        </main>
        <div class="md:pl-64 flex flex-col flex-1">
        <main class="flex-1 pt-24 pb-6 px-4 sm:px-6 lg:px-8">
        <div class="bg-white rounded-lg shadow p-6">
                <h2 class="text-2xl font-semibold text-gray-800 mb-6">Liste des Cours</h2>
                
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left font-medium text-gray-500 tracking-wider">Titre</th>
                                <th class="px-6 py-3 text-left font-medium text-gray-500 tracking-wider">Description</th>
                                <th class="px-6 py-3 text-left font-medium text-gray-500 tracking-wider">Categorie</th>
                                <th class="px-6 py-3 text-left font-medium text-gray-500 tracking-wider">Tags</th>
                                <th class="px-6 py-3 text-left font-medium text-gray-500 tracking-wider">Enseignant</th>
                                <th class="px-6 py-3 text-left font-medium text-gray-500 tracking-wider">Action</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            <?php if (count($cours) > 0): ?>
                                <?php foreach ($cours as $cour): ?>
                                    <tr class="hover:bg-gray-50">
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900"><?php echo ($cour['titre']); ?></td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900"><?php echo ($cour['description']); ?></td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900"><?php echo ($cour['categorie']); ?></td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900"><?php echo ($cour['tags']); ?></td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900"><?php echo ($cour['enseignant']); ?></td>
                                        
                                    </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="6" class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 text-center">Aucun utilisateur trouvé</td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
            </div>
            </main>
    </div>

</body>
</html>