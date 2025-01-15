<?php
require_once("../../../../vendor/autoload.php");
use App\Config\Database;
$db = new Database();
$conn = $db->connect();

$users = $conn->query("SELECT * FROM Users where role = 'Enseignant'")->fetchAll(PDO::FETCH_ASSOC);
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
            <a href="#courses" class="hover:text-blue-600 ml-5"><i class="fas fa-user-circle text-xl mr-2"></i>
            Admin</a>

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
        </nav>
    </div>

    <div class="md:pl-64 flex flex-col flex-1">
        <main class="flex-1 pt-24 pb-6 px-4 sm:px-6 lg:px-8">
            <div class="bg-white rounded-lg shadow p-6">
                <h2 class="text-2xl font-semibold text-gray-800 mb-6">Liste des Enseignants</h2>
                
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left font-medium text-gray-500 tracking-wider">Nom</th>
                                <th class="px-6 py-3 text-left font-medium text-gray-500 tracking-wider">Prenom</th>
                                <th class="px-6 py-3 text-left font-medium text-gray-500 tracking-wider">Email</th>
                                <th class="px-6 py-3 text-left font-medium text-gray-500 tracking-wider">Role</th>
                                <th class="px-6 py-3 text-left font-medium text-gray-500 tracking-wider">Statut</th>
                                <th class="px-6 py-3 text-left font-medium text-gray-500 tracking-wider">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            <?php if (count($users) > 0): ?>
                                <?php foreach ($users as $user): ?>
                                    <tr class="hover:bg-gray-50">
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900"><?php echo ($user['nom']); ?></td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900"><?php echo ($user['prenom']); ?></td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900"><?php echo ($user['email']); ?></td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900"><?php echo ($user['role']); ?></td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900"><?php echo ($user['compte_statut']); ?></td>
                                        
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
        </main>
    </div>


</body>
</html>