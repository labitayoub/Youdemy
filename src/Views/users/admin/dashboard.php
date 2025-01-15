<?php
require_once("../../../../vendor/autoload.php");
use App\Config\Database;
$db = new Database();
$conn = $db->connect();

$totalEtudiants = $conn->query("SELECT COUNT(*) FROM users WHERE role = 'Etudiant'")->fetchColumn();
$totalEnseignants = $conn->query("SELECT COUNT(*) FROM users WHERE role = 'Enseignant'")->fetchColumn();
$totalCours = $conn->query("SELECT COUNT(*) FROM cours")->fetchColumn();

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

    <div class="ml-64 p-8">

        <h2 class="text-2xl font-bold mb-6 mt-11">Statistique Globale</h2>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-8">
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
                    <div class="p-3 rounded-full bg-green-100 text-green-500">
                        <i class="fas fa-chalkboard-teacher text-2xl"></i>
                    </div>
                    <div class="ml-3">
                        <h4 class="text-gray-500 text-sm">Total des Enseignants</h4>
                        <h3 class="text-2xl font-bold"><?php echo $totalEnseignants ?></h3>
                    </div>
                </div>
            </div>
            <div class="bg-white rounded-lg shadow p-6">
                <div class="flex items-center">
                    <div class="p-3 rounded-full bg-yellow-100 text-yellow-500">
                        <i class="fas fa-book text-2xl"></i>
                    </div>
                    <div class="ml-3">
                        <h4 class="text-gray-500 text-sm">Total des des Cours </h4>
                        <h3 class="text-2xl font-bold"><?php echo $totalCours ?></h3>
                    </div>
                </div>
            </div>
      
        </div>
                </div>
            </div>
        </main>
    </div>


</body>
</html>