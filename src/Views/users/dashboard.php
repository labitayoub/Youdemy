<?php
require_once("../../../vendor/autoload.php");
use App\Config\Database;
$db = new Database();
$conn = $db->connect();

    $totalEtudiants = $conn->query("SELECT COUNT(*) FROM users WHERE role = 'Etudiant'")->fetchColumn();
    $totalEnseignants = $conn->query("SELECT COUNT(*) FROM users WHERE role = 'Enseignant'")->fetchColumn();
    $totalCours = $conn->query("SELECT COUNT(*) FROM cours")->fetchColumn();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>YouDemy</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body class="bg-gray-100">
    <!-- Sidebar -->
    <div class="fixed inset-y-0 left-0 w-64 bg-gray-900 text-white">
        <div class="p-6">
            <h1 class="text-2xl font-bold">YouDemy Admin</h1>
        </div>
        <nav class="mt-6">
            <a href="?page=dashboard" class="flex items-center px-6 py-3 text-gray-100 ">
                <i class="fas fa-home mr-3"></i>
                Dashboard
            </a>
            
        </nav>
    </div>

    <!-- Main Content -->
    <div class="ml-64 p-8">

        <h2 class="text-2xl font-bold mb-6">Dashboard</h2>
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
                        <i class="fas fa-book text-2xl"></i>
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
                        <i class="fas fa-chalkboard-teacher text-2xl"></i>
                    </div>
                    <div class="ml-3">
                        <h4 class="text-gray-500 text-sm">Total des des Cours </h4>
                        <h3 class="text-2xl font-bold"><?php echo $totalCours ?></h3>
                    </div>
                </div>
            </div>
      
        </div>
        
</body>
</html>